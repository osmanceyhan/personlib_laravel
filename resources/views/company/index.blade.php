@extends('layouts.master')
@section('title')
    {{$item->name}} - Şirket Düzenleme
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Şirket Düzenleme @endslot
        @slot('title') {{$item->name}} - Şirket Düzenleme @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">İçerik Alanları</h4>
                    @if(session()->has('alert'))
                        <div class="alert alert-{{ session()->get('alert')['status'] }} alert-dismissible fade show" role="alert">
                            <h5 class="text-success"> {{ session()->get('alert')['title'] }}</h5>
                            <p>  {{ session()->get('alert')['message'] }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                    <form  action="{{route('company.update')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row d-flex">
                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">İsim</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="name" type="text" value="{{$item->name}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">Ünvan</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="title" type="text" value="{{$item->title}}">
                                </div>
                            </div>
                            <div class="mb-3 dropzone">
                                <label class="form-label" for="name">Logo Ekleyin</label>
                                <input type="file" class="dropify" id="logo"  name="logo"
                                       data-default-file="{{getCdn($item->logo)}}"
                                       data-file-size-error="{{ __('Dosya boyutu çok büyük (:max) maksimum.',['max' => ':value']) }}"
                                       data-min-width-error="{{ __('Resim genişliği çok küçük (:min piksel minimum).',['min' => ':value']) }}"
                                       data-max-width-error="{{ __('Resim genişliği çok büyük (:max piksel maksimum).',['max' => ':value']) }}"
                                       data-min-height-error="{{ __('Resim yüksekliği çok küçük (:min piksel minimum).',['min' => ':value']) }}"
                                       data-max-height-error="{{ __('Resim yüksekliği çok büyük (:max piksel maksimum).',['max' => ':value']) }}"
                                       data-image-format-error="{{ __('Sadece :formats formatındaki resim dosyaları desteklenmektedir.', ['formats' => ':value']) }}"  />
                            </div>

                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">Adres</label>
                                <div class="col-md-10">
                                    <textarea class="form-control" name="address" type="text">{{$item->address}}</textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">Telefon</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="phone" type="text" value="{{$item->phone}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">Mesai Başlangıç Saati</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="start_time" type="text" value="{{$item->start_time}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">Mesai Bitiş Saati</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="end_time" type="text" value="{{$item->end_time}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="form-label col-md-2 col-form-label" for="name">Durum</label>
                                <div class="select2-full col-md-10">
                                    <select id="status" name="status" type="text" class="form-control form-select select2">
                                        <option value="ACTIVE" @if($item->status == 'ACTIVE') selected @endif> Aktif</option>
                                        <option value="PASSIVE" @if($item->status == 'PASSIVE') selected @endif>Pasif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex flex-reverse flex-wrap gap-2">
                                <button type="submit" class="btn btn-success"> <i class="uil uil-file-alt"></i> Kaydet </button>
                            </div>
                        </div>
                    </form>
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
