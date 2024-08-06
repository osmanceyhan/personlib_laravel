@extends('layouts.master')
@section('title') Dashboard @endsection
@section('css')
@endsection
@section('content')
    <div class="dashboard_wrapper">
        <div class="row">
            <div class="profile_navbar_menu">
                <!-- Bootstrap Tab -->
                <ul class="nav nav-links">

                    <li class="nav-item">
                        <a class="nav-link active" href="#leave_requests" data-bs-toggle="tab">İzinler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#expenditure" data-bs-toggle="tab">Harcama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#overtime" data-bs-toggle="tab">Fazla Mesai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#advance_payments" data-bs-toggle="tab">Ek Ödemeler</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane show active" id="leave_requests">
                    <div class="col-lg-12">

                        <div class="leave_table">
                            <div class="leave_table_body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Şirket</th>
                                        <th>Kişi</th>
                                        <th>Başlangıç</th>
                                        <th>Bitiş</th>
                                        <th>Mesai Başlangıç</th>
                                        <th>Süre</th>
                                        <th>İzin Türü</th>
                                        <th>Açıklama</th>
                                        <th>Oluşturulma Tarihi</th>
                                        <th>Durum</th>
                                        <th>İşlem</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($datas['leave_requests'] as $leave)
                                        <tr>
                                            <td>{{$leave->getUser->getCompany->name}}</td>
                                            <td>{{$leave->getUser->fullName()}}</td>
                                            <td>{{\Carbon\Carbon::parse($leave->start_date)->format('d.m.Y')}}</td>
                                            <td>{{\Carbon\Carbon::parse($leave->end_date)->format('d.m.Y')}}</td>
                                            <td>{{$leave->return_date.' '.$leave->return_time}}</td>
                                            <td>{{$leave->total}}</td>
                                            <td>{{$leave->leaveType->name}}</td>
                                            <td>{{$leave->comment}}</td>
                                            <td>{{\Carbon\Carbon::parse($leave->created_at)->format('d.m.Y H:i')}}</td>
                                            <td>{!! getApprovalStatus($leave->status) !!}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="expenditure">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="leave_table ">
                                <div class="leave_table_body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Şirket</th>
                                            <th>Kişi</th>
                                            <th>Fiş/Fiş Tarihi</th>
                                            <th>Vergi Oranı</th>
                                            <th>Durum</th>
                                            <th>Tutar</th>
                                            <th>Açıklama</th>
                                            <th>Oluşturulma Tarihi</th>
                                            <th>Ödendi</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas['payment_info']['expenditure'] as $data)
                                            <tr>
                                                <td>{{$data->getUser->getCompany->name}}</td>
                                                <td>{{$data->getUser->fullName()}}</td>
                                                <td>
                                                    <a href="{{getCdn($data->attachment)}}">
                                                        {{$data->receipt_date}}
                                                    </a>
                                                </td>
                                                <td>{{$data->tax_rate}}</td>
                                                <td>{!! getApprovalStatus($data->status) !!}</td>
                                                <td>{{$data->amount}}</td>
                                                <td>{{$data->comment}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')}}</td>
                                                <td>{!! getApprovalStatus($data->payment_status) !!}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="overtime">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="leave_table ">
                                <div class="leave_table_body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Şirket</th>
                                            <th>Kişi</th>
                                            <th>Başlangıç Tarihi</th>
                                            <th>Başlangıç Saati</th>
                                            <th>Süre</th>
                                            <th>Açıklama</th>
                                            <th>Oluşturulma Tarihi</th>
                                            <th>Durum</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas['payment_info']['overtime'] as $data)
                                            <tr>
                                                <td>{{$data->getUser->getCompany->name}}</td>
                                                <td>{{$data->getUser->fullName()}}</td>
                                                <td>{{$data->start_date}}</td>
                                                <td>{{$data->start_time}}</td>
                                                <td>{{$data->hour.' Saat '.$data->minute.' Dakika'}}</td>
                                                <td>{{$data->comment}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')}}</td>
                                                <td>{!! getApprovalStatus($data->status) !!}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="advance_payments">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="leave_table ">
                                <div class="leave_table_body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Şirket</th>
                                            <th>Kişi</th>
                                            <th>Ödeme Türü</th>
                                            <th>Geçerlilik Tarihi</th>
                                            <th>Tutar</th>
                                            <th>Açıklama</th>
                                            <th>Oluşturulma Tarihi</th>
                                            <th>Durum</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas['payment_info']['advance_payments'] as $data)
                                            <tr>
                                                <td>{{$data->getUser->getCompany->name}}</td>
                                                <td>{{$data->getUser->fullName()}}</td>
                                                <td>
                                                    <span class="badge badge-info bg-info">Avans</span>
                                                </td>
                                                <td>{{$data->used_date}}</td>
                                                <td>{{$data->amount}}</td>
                                                <td>{{$data->comment}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')}}</td>
                                                <td>{!! getApprovalStatus($data->status) !!}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('script')


@endsection
