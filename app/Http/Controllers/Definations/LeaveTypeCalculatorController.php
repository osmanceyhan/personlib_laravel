<?php

namespace App\Http\Controllers\Definations;

use App\Enumerations\ApprovalEnum;
use App\Enumerations\BasicEnum;
use App\Http\Controllers\Controller;
use App\Models\Company\Companies;
use App\Models\LeaveRequests;
use App\Models\LeaveTypes;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveTypeCalculatorController extends Controller
{
    //

    public function __construct()
    {
        $this->model = new LeaveTypes();
    }


    public function leaveRequestsCalc(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        $companyId = $user->company_id;

        // Şirketin mesai başlangıç ve bitiş saatlerini al
        $company = Companies::find($companyId);
        $startTime = Carbon::parse($company->start_time); // Örn: 09:00
        $endTime = Carbon::parse($company->end_time); // Örn: 18:00

        // Kullanıcıdan gelen tarih ve saatleri al
        $startDate = Carbon::parse($request->start_date . ' ' . $request->start_time);
        $endDate = Carbon::parse($request->end_date . ' ' . $request->end_time);

        // Mesai saatlerini hesapla
        $totalDays = $this->calculateWorkingDays($startDate, $endDate, $startTime, $endTime);

        // Leave type bilgilerini al
        $leaveType = LeaveTypes::find($request->leave_type_id);

        if (!$leaveType) {
            return response()->json([
                'success' => false,
                'total' => 0,
                'remaining_days' => 0,
                'message' => 'Geçersiz izin türü.'
            ]);
        }

        // Cinsiyet kontrolü
        if (($leaveType->gender == 'MAN' && $user->gender != 'MAN') ||
            ($leaveType->gender == 'WOMAN' && $user->gender != 'WOMAN')) {
            return response()->json([
                'success' => false,
                'total' => 0,
                'remaining_days' => 0,
                'message' => 'Bu izin türü sizin cinsiyetiniz için geçerli değildir.'
            ]);
        }

        // İzin tipi kontrolü
        switch ($leaveType->type) {
            case 'NONLIMIT':
                $success = true;
                $remainingDays = 'Sınırsız';
                $message = '';
                break;

            case 'REQUEST':
                $remainingDays = $leaveType->days - $totalDays;
                $success = $totalDays <= $leaveType->days;
                $message = $success ? '' : 'İzin gün sayısı limitini aşıyor.';
                break;

            case 'YEARLY':
                // Bu yıl içinde alınan toplam izin gününü hesapla
                $currentYear = now()->year;
                $usedDays = DB::table('leave_requests')
                    ->where('user_id', $user->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->whereYear('start_date', $currentYear)
                    ->sum('days');

                $remainingDays = $leaveType->days - $usedDays;
                $success = $totalDays <= $remainingDays;
                $message = $success ? '' : 'Yıllık izin gün sayısı limitini aşıyor.';
                break;

            default:
                return response()->json([
                    'success' => false,
                    'total' => 0,
                    'remaining_days' => 0,
                    'message' => 'Bilinmeyen izin türü.'
                ]);
        }

        return response()->json([
            'success' => $success,
            'start_date' => $startDate->toIso8601String(),
            'end_date' => $endDate->toIso8601String(),
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'company_start_time' => $startTime->format('H:i'),
            'company_end_time' => $endTime->format('H:i'),
            'total' => number_format($totalDays, 2), // İki ondalık hane ile sonucu döndür
            'remaining_days' => $remainingDays,
            'message' => $message
        ]);
    }
    private function calculateWorkingDays($startDate, $endDate, $startTime, $endTime)
    {
        $totalHours = 0;
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            // Haftasonları hariç tut
            if ($date->isWeekend()) {
                continue;
            }

            // Günü hesapla
            $currentStart = $date->copy()->setTimeFrom($startTime);
            $currentEnd = $date->copy()->setTimeFrom($endTime);

            if ($date->isSameDay($startDate)) {
                $currentStart = $startDate->max($currentStart);
            }

            if ($date->isSameDay($endDate)) {
                $currentEnd = $endDate->min($currentEnd);
            }

            // Tam gün mesai hesaplaması (örneğin 9:00 - 18:00 arasında öğle arası hariç 8 saat)
            $dailyWorkingMinutes = $currentStart->diffInMinutes($currentEnd);
            $dailyWorkingMinutes = ($dailyWorkingMinutes > 540) ? 540 : $dailyWorkingMinutes; // Günlük mesai süresi 540 dakikayı (9 saat) aşamaz

            $totalHours += $dailyWorkingMinutes / 60; // Dakikaları saate çevir
        }

        // Toplam gün sayısını hesapla (günlük 9 saat)
        $totalDays = $totalHours / 9;

        return $totalDays;
    }

    public function store(Request $request)
    {
        try{

            // İzni kontrol edelim

            $control = $this->leaveRequestsCalc($request);

            $control = json_decode($control->content(), true);

            if($control['success'] == false){
                return response()->json(['success' => false,
                    'message' => $calcResult['message'] ?? 'İzin talebi başarısız oldu.'
                ]);
            }

            $user = User::where('id',Auth::id())->first();
            $companyId = $user->company_id;

            $leaveRequest = LeaveRequests::create([
                "company_id" =>$companyId,
                'user_id' => Auth::id(),
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'end_date' => $request->end_date,
                'end_time' => $request->end_time,
                'comment' => $request->comment,
                'person_replace_id' => $request->person_replace_id,
                'return_date' => $request->return_date,
                'return_time' => $request->return_time,
                'total' => $control['total'],
                'status' => ApprovalEnum::WAITING->value,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'İzin talebi başarıyla oluşturuldu.',
            ]);
        }catch (QueryException $exception){
            dd($exception);
            return response()->json([
                'success' => false,
                'message' => 'Ödeme talebi oluşturulurken bir hata oluştu.'
            ]);
        }

    }



}
