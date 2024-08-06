<?php $__env->startSection('title'); ?>
    İzinlerim
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/dropify/dropify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?> İzinlerim <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($user->fullName()); ?> - İzinlerim <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="profile_navbar_menu">
                <ul class="nav nav-links">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('profile.index')); ?>" >Profilim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="<?php echo e(route('profile.information')); ?>" >Kişisel Bilgilerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo e(route('profile.leave_requests')); ?>" >İzinlerim</a>
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
                            <div class="col-lg-12">
                                <div class="leave_info">
                                    <div class="leave_info_start">
                                        <h3>Kullanılabilir İzin Bakiyesi / Yıllık İzin</h3>
                                        <span>Güncel Hak Ediş Dönemi : <b>18 Oca 2024 – 17 Oca 2025</b></span>
                                    </div>
                                    <div class="leave_info_day <?php if($leaveInfo['available_leave'] <= 1): ?> text-danger <?php else: ?> text-success <?php endif; ?>">
                                        <?php echo e($leaveInfo['available_leave']); ?> Gün
                                    </div>
                                </div>
                                <div class="leave_table">
                                    <div class="leave_table_body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Kişi</th>
                                                <th>Başlangıç</th>
                                                <th>Bitiş</th>
                                                <th>Mesai Başlangıç</th>
                                                <th>Süre</th>
                                                <th>İzin Türü</th>
                                                <th>Açıklama</th>
                                                <th>Oluşturulma Tarihi</th>
                                                <th>Durum</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $leaveInfo['leave_requests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($leave->getUser->fullName()); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($leave->start_date)->format('d.m.Y')); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($leave->end_date)->format('d.m.Y')); ?></td>
                                                    <td><?php echo e($leave->return_date.' '.$leave->return_time); ?></td>
                                                    <td><?php echo e($leave->total); ?></td>
                                                    <td><?php echo e($leave->leaveType->name); ?></td>
                                                    <td><?php echo e($leave->comment); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($leave->created_at)->format('d.m.Y H:i')); ?></td>
                                                    <td><?php echo getApprovalStatus($leave->status); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/accounts/leave_request.blade.php ENDPATH**/ ?>