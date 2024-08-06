@extends('layouts.master')
@section('title')
    Ödemelerim
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Ödemelerim @endslot
        @slot('title') {{$user->fullName()}} - Ödemelerim @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="profile_navbar_menu">
                <ul class="nav nav-links">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('profile.index')}}" >Profilim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{route('profile.information')}}" >Kişisel Bilgilerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('profile.leave_requests')}}" >İzinlerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('profile.payment_requests')}}" >Ödemelerim</a>
                    </li>
                </ul>
            </div>
            @if(session()->has('alert'))
                <div class="alert alert-{{ session()->get('alert')['status'] }} alert-dismissible fade show" role="alert">
                    <h5 class="text-success"> {{ session()->get('alert')['title'] }}</h5>
                    <p>  {{ session()->get('alert')['message'] }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="profile_contents">
                        <div class="profile_navbar_menu">
                            <!-- Bootstrap Tab -->
                            <ul class="nav nav-links">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#expenditure" data-bs-toggle="tab">Harcama</a>
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
                            <div class="tab-pane show active" id="expenditure">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="leave_table ">
                                            <div class="leave_table_body">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>Kişi</th>
                                                        <th>Fiş/Fiş Tarihi</th>
                                                        <th>Vergi Oranı</th>
                                                        <th>Durum</th>
                                                        <th>Tutar</th>
                                                        <th>Açıklama</th>
                                                        <th>Oluşturulma Tarihi</th>
                                                        <th>Ödendi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($paymentInfo['expenditure'] as $data)
                                                        <tr>
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
                                                            <td>{!! getApprovalStatus($leave->payment_status) !!}</td>
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
                                                        <th>Kişi</th>
                                                        <th>Başlangıç Tarihi</th>
                                                        <th>Başlangıç Saati</th>
                                                        <th>Süre</th>
                                                        <th>Açıklama</th>
                                                        <th>Oluşturulma Tarihi</th>
                                                        <th>Durum</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($paymentInfo['overtime'] as $data)
                                                        <tr>
                                                            <td>{{$data->getUser->fullName()}}</td>
                                                            <td>{{$data->start_date}}</td>
                                                            <td>{{$data->start_time}}</td>
                                                            <td>{{$data->hour.' Saat '.$data->minute.' Dakika'}}</td>
                                                            <td>{{$data->comment}}</td>
                                                            <td>{{\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')}}</td>
                                                            <td>{!! getApprovalStatus($data->status) !!}</td>
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
                                                        <th>Kişi</th>
                                                        <th>Ödeme Türü</th>
                                                        <th>Geçerlilik Tarihi</th>
                                                        <th>Tutar</th>
                                                        <th>Açıklama</th>
                                                        <th>Oluşturulma Tarihi</th>
                                                        <th>Durum</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($paymentInfo['advance_payments'] as $data)
                                                        <tr>
                                                            <td>{{$data->getUser->fullName()}}</td>
                                                            <td>
                                                                <span class="badge badge-info">Avans</span>
                                                            </td>
                                                            <td>{{$data->used_date}}</td>
                                                            <td>{{$data->amount}}</td>
                                                            <td>{{$data->comment}}</td>
                                                            <td>{{\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')}}</td>
                                                            <td>{!! getApprovalStatus($data->status) !!}</td>
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
        </div> <!-- end col -->
    </div>
    <!-- end row -->



@endsection
@section('script')
    <script>
        function updateSlug() {
            const title = document.getElementById('input_title').value;
            const slug = slugify(title); // Bu fonksiyon slug'ı oluşturacak özel bir slugify fonksiyonudur.
            document.getElementById('input_slug').value = slug;
        }

        function slugify(text) {
            const turkishCharacters = {
                'ı': 'i',
                'ğ': 'g',
                'ü': 'u',
                'ş': 's',
                'ö': 'o',
                'ç': 'c',
                'İ': 'i',
                'Ğ': 'g',
                'Ü': 'u',
                'Ş': 's',
                'Ö': 'o',
                'Ç': 'c'
            };

            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Boşlukları tireye çevir
                .replace(/[ığüşöçİĞÜŞÖÇ]/g, char => turkishCharacters[char] || char)
                .replace(/[^\w\-]+/g, '') // Alfanümerik dışındaki karakterleri kaldır
                .replace(/\-\-+/g, '-') // Birden fazla tireyi tek bir tireye çevir
                .replace(/^-+/, '') // Başındaki tireleri kaldır
                .replace(/-+$/, ''); // Sonundaki tireleri kaldır
        }
    </script>
    <script src="{{ URL::asset('/assets/libs/dropify/dropify.min.js') }}"></script>


    <!-- lazyload.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.plugins.min.js"></script>
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>

    <script type="text/javascript">
        function removeModal(id){
            var modalToggle = new bootstrap.Modal(document.getElementById('removeModal'),{}); // relatedTarget

            var removeModalForm = $("#removeModalForm");
            var deleteEndpoint = removeModalForm.attr("action");
            removeModalForm.attr("action",deleteEndpoint+"/"+id);
            modalToggle.show()
        }
        $(".select2").select2();


        var imagenUrl = "";
        var dropifyEvent;
        var formAction = "https://rhouse.top/moduls/web_definations/web_section_types";
        // Dropify eklentisini bir kez oluşturun
        dropifyEvent = $('.dropify').dropify({
            defaultFile: imagenUrl,
            messages: {
                'default': 'Dosyanızı buraya sürükleyin veya tıklayın',
                'replace': 'Değiştirmek için sürükleyin veya tıklayın',
                'remove': 'Kaldır',
                'error': 'Üzgünüz, bir hata oluştu.'
            },
            error: {
                'fileSize': $('.dropify').data('file-size-error'),
                'minWidth': $('.dropify').data('min-width-error'),
                'maxWidth': $('.dropify').data('max-width-error'),
                'minHeight': $('.dropify').data('min-height-error'),
                'maxHeight': $('.dropify').data('max-height-error'),
                'imageFormat': $('.dropify').data('image-format-error')
            }
        });


        function getImage(image) {
            var storageCdn = '{{config('image.storage_asset_url')}}';
            var storageFolder = '{{config('image.cdn_base_dir')}}';
            return storageCdn + storageFolder + image;
        }



        $(document).ready(function () {
            // Lazy loading özelliğini etkinleştirme
            $('img.lazyload').lazy();
        });
    </script>

@endsection
