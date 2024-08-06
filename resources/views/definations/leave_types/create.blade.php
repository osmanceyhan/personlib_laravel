@extends('layouts.master')
@section('title')
Yeni İzin Türü
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
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
                    <form  action="{{route('leave_types.store')}}"  method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                         <div class="row d-flex">
                             <div class="mb-3 row">
                                 <label for="input_title" class="col-md-2 col-form-label">İzin Adı</label>
                                 <div class="col-md-10">
                                     <input class="form-control" name="name" type="text">
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label for="input_title" class="col-md-2 col-form-label">İzin Türü</label>
                                 <div class="col-md-10">
                                     <div class="select2-full">
                                     <select class="select2 form-control" name="type">
                                         @foreach(\App\Enumerations\LeaveTypeEnum::allStatus() as $key => $leaveType)
                                             <option value="{{$key}}">{{$leaveType}}</option>
                                        @endforeach
                                     </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label for="input_title" class="col-md-2 col-form-label">Ücret Türü</label>
                                 <div class="col-md-10">
                                     <div class="select2-full">
                                         <select class="select2 form-control" name="price_type">
                                             @foreach(\App\Enumerations\PriceTypeEnum::allStatus() as $key => $priceType)
                                                 <option value="{{$key}}">{{$priceType}}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="mb-3 row">
                                 <label for="input_title" class="col-md-2 col-form-label">Açıklama</label>
                                 <div class="col-md-10">
                                     <textarea class="form-control" name="description" type="text"></textarea>
                                 </div>
                             </div>
                            <div class="mb-3 row">
                                <label for="input_title" class="col-md-2 col-form-label">Gün</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="days" type="number">
                                </div>
                            </div>

                             <div class="mb-3 row">
                                 <label class="form-label col-md-2 col-form-label" for="name">Durum</label>
                                 <div class="select2-full col-md-10">
                                     <select id="status" name="status" type="text" class="form-control form-select select2">
                                         <option value="ACTIVE"> Aktif</option>
                                         <option value="PASSIVE">Pasif</option>
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

    <script src="{{ URL::asset('/assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/ckeditor/ckeditor.min.js') }}"></script>

    <!-- lazyload.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.plugins.min.js"></script>
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
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
    <script type="text/javascript">
        function removeModal(id){
            var modalToggle = new bootstrap.Modal(document.getElementById('removeModal'),{}); // relatedTarget

            var removeModalForm = $("#removeModalForm");
            var deleteEndpoint = removeModalForm.attr("action");
            removeModalForm.attr("action",deleteEndpoint+"/"+id);
            modalToggle.show()
        }
        $(".select2").select2();


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
