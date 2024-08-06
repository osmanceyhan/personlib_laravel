@extends('layouts.master')
@section('title')
    Kişisel Bilgilerim
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') Kişisel Bilgilerim @endslot
        @slot('title') {{$user->fullName()}} - Kişisel Bilgilerim @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="profile_navbar_menu">
                <ul class="nav nav-links">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('profile.index')}}" >Profilim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"  href="{{route('profile.information')}}" >Kişisel Bilgilerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('profile.leave_requests')}}" >İzinlerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('profile.payment_requests')}}" >Ödemelerim</a>
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


                    <!-- Profile Navbar Menu Links -->

                    <div class="profile_contents">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="profile_card">
                                    <div class="profile_card_body">
                                        <div class="profile_card_title">Vatandaşlık</div>
                                        <div class="pcard_info">
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Doğum Tarihi</label>
                                                        <span>{{$userInfo->birthdate ? \Carbon\Carbon::parse($userInfo->birthdate)->format('d.m.Y') : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Cinsiyet</label>
                                                    <span>{{$user->gender == "MALE" ? 'Erkek' : 'Kadın'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Kimlik Numarası</label>
                                                    <span>{{$userInfo->tc_number}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Askerlik Durumu</label>
                                                    <span>{{\App\Enumerations\MilitaryStatusEnum::getStatus($userInfo->military_status)}}</span>
                                                </div>
                                            </div>
                                            @if($userInfo->military_status == "DONE")
                                                <div class="col-6">
                                                    <div class="pcard_info_item">
                                                        <label>Askerlik Tamamlama Tarihi</label>
                                                        <span>{{$userInfo->military_done_date ? \Carbon\Carbon::parse($userInfo->military_done_date)->format('d.m.Y') : '-'}}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($userInfo->military_status == "POSTPONED")
                                                <div class="col-6">
                                                    <div class="pcard_info_item">
                                                        <label>Askerlik Tecil Tarihi</label>
                                                        <span>{{$userInfo->military_postponement_date ? \Carbon\Carbon::parse($userInfo->military_postponement_date)->format('d.m.Y') : '-'}}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="profile_card">
                                    <div class="profile_card_body">
                                        <div class="profile_card_title">Eğitim</div>
                                        <div class="pcard_info">
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Eğitim Durumu</label>
                                                    <span>{{\App\Enumerations\EducationStatusEnum::getStatus($userInfo->educational_status)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Tamamlanan En Yüksek Eğitim Seviyesi</label>
                                                    <span>{{\App\Enumerations\EducationCompleteStatusEnum::getStatus($userInfo->education_complete_status)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile_card">
                                    <div class="profile_card_body">
                                        <div class="profile_card_title">Aile</div>
                                        <div class="pcard_info">
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Medeni Hal</label>
                                                    <span>{{\App\Enumerations\MaritalStatusEnum::getStatus($userInfo->marital_status)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Çocuk Sayısı</label>
                                                    <span>{{$userInfo->children_count}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile_card">
                                    <div class="profile_card_body">
                                        <div class="profile_card_title">Adres</div>
                                        <div class="pcard_info">
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Adres</label>
                                                    <span>{{$userInfo->adress ? $userInfo->adress : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Adres (devam)</label>
                                                    <span>{{$userInfo->adress_two ? $userInfo->adress_two : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Şehir</label>
                                                    <span>{{$userInfo->city ? $userInfo->city : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Ülke</label>
                                                    <span>{{$userInfo->country ? $userInfo->country : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Posta Kodu</label>
                                                    <span>{{$userInfo->zip_code ? $userInfo->zip_code : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Telefon</label>
                                                    <span>{{$userInfo->address_phone ? $userInfo->address_phone : '-'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile_card">
                                    <div class="profile_card_body">
                                        <div class="profile_card_title">Banka Hesabı</div>
                                        <div class="pcard_info">
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Banka Adı</label>
                                                    <span>{{$userInfo->bank_name ? $userInfo->bank_name : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Hesap Tipi</label>
                                                    <span>{{$userInfo->bank_type ? $userInfo->bank_type : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Hesap Numarası</label>
                                                    <span>{{$userInfo->bank_number ? $userInfo->bank_number : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>IBAN</label>
                                                    <span>{{$userInfo->bank_iban ? $userInfo->bank_iban : '-'}}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Posta Kodu</label>
                                                    <span>{{$userInfo->zip_code ? $userInfo->zip_code : '-' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Telefon</label>
                                                    <span>{{$userInfo->address_phone ? $userInfo->address_phone : '-'}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-5">

                            <div class="profile_card">
                                <div class="profile_card_body">
                                    <div class="profile_card_title">İletişim</div>
                                    <div class="contact_card_item">
                                        <div class="contact_card_item_start">
                                            <div class="contact_card_icon">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="contact_card_text">
                                                <label>E-Posta (İş)</label>
                                                <span>{{$user->email}}</span>
                                            </div>
                                        </div>
                                        <div class="contact_card_copy">
                                            <button type="button"><i class="fas fa-copy"></i></button>
                                        </div>
                                    </div>
                                    <div class="contact_card_item">
                                        <div class="contact_card_item_start">
                                            <div class="contact_card_icon">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div class="contact_card_text">
                                                <label>Telefon (İş)</label>
                                                <span>{{$user->phone}}</span>
                                            </div>
                                        </div>
                                        <div class="contact_card_copy">
                                            <button type="button"><i class="fas fa-copy"></i></button>
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
