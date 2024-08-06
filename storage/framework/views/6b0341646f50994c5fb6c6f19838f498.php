<?php $__env->startSection('title'); ?>
    Profilimi Düzenle
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/dropify/dropify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?> Şirket Düzenleme <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($user->fullName()); ?> - Profil Düzenleme <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="profile_navbar_menu">
                <ul class="nav nav-links">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo e(route('profile.index')); ?>" >Profilim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "  href="<?php echo e(route('profile.information')); ?>" >Kişisel Bilgilerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('profile.leave_requests')); ?>" >İzinlerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('profile.payment_requests')); ?>" >Ödemelerim</a>
                    </li>
                </ul>
            </div>
            <?php if(session()->has('alert')): ?>
                <div class="alert alert-<?php echo e(session()->get('alert')['status']); ?> alert-dismissible fade show" role="alert">
                    <h5 class="text-success"> <?php echo e(session()->get('alert')['title']); ?></h5>
                    <p>  <?php echo e(session()->get('alert')['message']); ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">


                    <!-- Profile Navbar Menu Links -->

                    <div class="profile_contents">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="profile_card">
                                    <div class="profile_card_body">
                                        <div class="pcard_summary">
                                            <div class="pcard_summary_start">
                                                <div class="pcard_summary_name">
                                                    <?php echo e($user->fullName()); ?>

                                                </div>
                                                <div class="pcard_summary_title">
                                                    <?php echo e($user->title ? $user->title : 'Unvan Yok'); ?>

                                                </div>
                                            </div>
                                            <div class="pcard_summary_end">
                                                <div class="pcard_summary_img">
                                                    <img src="<?php echo e(getAvatar()); ?>" alt="profile_img">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pcard_info">
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>İşe Başlama Tarihi</label>
                                                    <span><?php echo e(\Carbon\Carbon::parse($userInfo->start_date)->format('d.m.Y')); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Sözleşme Türü</label>
                                                    <span><?php echo e(\App\Enumerations\ContractTypeEnum::getStatus($userInfo->contract_type)); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Çalışma Süresi</label>
                                                    <span><?php echo e($userInfo->workTime()); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Sözleşme Bitiş Tarihi</label>
                                                    <span><?php echo e(\Carbon\Carbon::parse($userInfo->end_date)->format('d.m.Y')); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Çalışma Şekli</label>
                                                    <span><?php echo e(\App\Enumerations\WorkTypeEnum::getStatus($userInfo->work_type)); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Şirket</label>
                                                    <span><?php echo e($userInfo->getCompanyTitle()); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="pcard_info_item">
                                                    <label>Unvan</label>
                                                    <span><?php echo e($userInfo->title); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <?php if($user->user_role == "EMPLOYEE"): ?>
                                    <div class="profile_card">
                                        <div class="profile_card_body">
                                            <div class="profile_card_title">Yöneticim</div>
                                            <div class="pcard_summary">
                                                <div class="pcard_summary_start">
                                                    <div class="pcard_summary_name">
                                                        <?php echo e($userInfo->getCompanyManagerName()); ?>

                                                    </div>
                                                    <div class="pcard_summary_title">
                                                        <?php echo e($userInfo->getCompanyManagerTitle()); ?>

                                                    </div>
                                                </div>
                                                <div class="pcard_summary_end">
                                                    <div class="pcard_summary_img">
                                                        <img src=" <?php echo e($userInfo->getManagerAvatar()); ?>" alt="profile_img">
                                                    </div>
                                                </div>
                                        </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
                                                <span><?php echo e($user->email); ?></span>
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
                                                <span><?php echo e($user->phone); ?></span>
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



<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
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
    <script src="<?php echo e(URL::asset('/assets/libs/dropify/dropify.min.js')); ?>"></script>


    <!-- lazyload.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.plugins.min.js"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/select2/select2.min.js')); ?>"></script>

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
            var storageCdn = '<?php echo e(config('image.storage_asset_url')); ?>';
            var storageFolder = '<?php echo e(config('image.cdn_base_dir')); ?>';
            return storageCdn + storageFolder + image;
        }



        $(document).ready(function () {
            // Lazy loading özelliğini etkinleştirme
            $('img.lazyload').lazy();
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/accounts/profile.blade.php ENDPATH**/ ?>