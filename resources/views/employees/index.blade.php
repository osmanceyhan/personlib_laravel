@extends('layouts.master')
@section('title')
    Çalışanlar
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Çalışanlar @endslot
        @slot('title') {{$user->getCompany->name}} - Çalışanlar @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">

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
                        <div class="row">
                            <div class="col-lg-12">
                                @if(\Illuminate\Support\Facades\Auth::user()->user_role != "EMPLOYEE")
                                <div class="d-flex justify-content-end">
                                    <a href="{{route('employees.create')}}" class="btn btn-success new_btn"><i class="fas fa-plus"></i> Yeni Çalışan Ekle</a>
                                </div>
                                @endif
                                <div class="leave_table">
                                    <div class="leave_table_body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Ad Soyad</th>
                                                <th>Unvan</th>
                                                <th>E-Posta</th>
                                                <th>Telefon</th>
                                                <th>Başlangıç Tarihi</th>
                                                <th>Bitiş Tarihi</th>
                                                <th>Durum</th>
                                                @if(\Illuminate\Support\Facades\Auth::user()->user_role != "EMPLOYEE")
                                                <th></th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($employees as $data)
                                                <tr>
                                                    <td>{{$data->fullName()}}</td>
                                                    <td>{{$data->getUserInfo->title}}</td>
                                                    <td>{{$data->email}}</td>
                                                    <td>{{$data->phone}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->getUserInfo->start_date)->format('d.m.Y')}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->getUserInfo->end_date)->format('d.m.Y')}}</td>
                                                    <td>{!! getStatus($data->status) !!}</td>
                                                    @if(\Illuminate\Support\Facades\Auth::user()->user_role != "EMPLOYEE")
                                                    <td>
                                                        <a href="{{route('employees.edit',$data->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    </td>
                                                    @endif
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
