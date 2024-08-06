<?php
// app/Exports/DealsStatsExport.php
namespace App\Exports;

use App\Models\DealsStats;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DealsStatsExport implements FromCollection, WithHeadings
{
    protected $website_id;
    protected $startDate;
    protected $endDate;

    public function __construct($website_id, $startDate = null, $endDate = null)
    {
        $this->website_id = $website_id;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = DealsStats::where('website_id', $this->website_id);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->whereHas('postbackStats', function($query) {
            $query->where('type', 'registration')
                ->orWhere('type', 'first_deposit');
        })->get()->map(function ($item) {
            return [
                'gclid' => $item->gclid,
                'website' => $item->getWebsite ? $item->getWebsite->domain : '',
                'deal' => $item->getDeal ? $item->getBrand->name : '',
                'brand' => $item->getBrand ? $item->getBrand->name : '',
                'reg' => $item->reg() ? 'Yes' : 'No',
                'ftd' => $item->ftd() ? 'Yes' : 'No',
                'timezone' => $item->timezone . ' - ' . $item->timezone_client,
                'ip' => $item->ip,
                'google_date' => \Carbon\Carbon::parse($item->google_date)->format('d-m-Y H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'GClid',
            'Website',
            'Deal',
            'Brand',
            'Reg',
            'Ftd',
            'Timezone',
            'IP',
            'Date'
        ];
    }
}

