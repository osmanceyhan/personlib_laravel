<?php $__env->startSection('title'); ?>
    Çalışanlar
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/dropify/dropify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?> Çalışanlar <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($user->getCompany->name); ?> - Çalışanlar <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">

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
                    <div class="profile_contents">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if(\Illuminate\Support\Facades\Auth::user()->user_role != "EMPLOYEE"): ?>
                                <div class="d-flex justify-content-end">
                                    <a href="<?php echo e(route('employees.create')); ?>" class="btn btn-success new_btn"><i class="fas fa-plus"></i> Yeni Çalışan Ekle</a>
                                </div>
                                <?php endif; ?>
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
                                                <?php if(\Illuminate\Support\Facades\Auth::user()->user_role != "EMPLOYEE"): ?>
                                                <th></th>
                                                <?php endif; ?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($data->fullName()); ?></td>
                                                    <td><?php echo e($data->getUserInfo->title); ?></td>
                                                    <td><?php echo e($data->email); ?></td>
                                                    <td><?php echo e($data->phone); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($data->getUserInfo->start_date)->format('d.m.Y')); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($data->getUserInfo->end_date)->format('d.m.Y')); ?></td>
                                                    <td><?php echo getStatus($data->status); ?></td>
                                                    <?php if(\Illuminate\Support\Facades\Auth::user()->user_role != "EMPLOYEE"): ?>
                                                    <td>
                                                        <a href="<?php echo e(route('employees.edit',$data->id)); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                    </td>
                                                    <?php endif; ?>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/employees/index.blade.php ENDPATH**/ ?>