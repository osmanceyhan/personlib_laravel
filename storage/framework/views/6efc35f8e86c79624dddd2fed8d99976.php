<?php $__env->startSection('title'); ?>
<?php echo e($item->name); ?> - İzin Türü Düzenleme
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/dropify/dropify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?>İzin Türü Düzenleme <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($item->name); ?> - İzin Türü Düzenleme <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">İçerik Alanları</h4>
                    <?php if(session()->has('alert')): ?>
                        <div class="alert alert-<?php echo e(session()->get('alert')['status']); ?> alert-dismissible fade show" role="alert">
                            <h5 class="text-success"> <?php echo e(session()->get('alert')['title']); ?></h5>
                            <p>  <?php echo e(session()->get('alert')['message']); ?></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    <?php endif; ?>
                    <form  action="<?php echo e(route('leave_types.update',$item->id)); ?>"  method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                             <div class="row d-flex">
                                <div class="mb-3 row">
                                    <label for="input_title" class="col-md-2 col-form-label">İsim</label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="name" type="text" value="<?php echo e($item->name); ?>">
                                    </div>
                                </div>
                                 <div class="mb-3 row">
                                     <label for="input_title" class="col-md-2 col-form-label">İzin Türü</label>
                                     <div class="col-md-10">
                                         <div class="select2-full">
                                             <select class="select2 form-control" name="type">
                                                 <?php $__currentLoopData = \App\Enumerations\LeaveTypeEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <option value="<?php echo e($key); ?>" <?php if($item->type == $key): ?> selected <?php endif; ?>><?php echo e($leaveType); ?></option>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </select>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="mb-3 row">
                                     <label for="input_title" class="col-md-2 col-form-label">Ücret Türü</label>
                                     <div class="col-md-10">
                                         <div class="select2-full">
                                             <select class="select2 form-control" name="price_type">
                                                 <?php $__currentLoopData = \App\Enumerations\PriceTypeEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $priceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <option value="<?php echo e($key); ?>" <?php if($item->price_type == $key): ?> selected <?php endif; ?>><?php echo e($priceType); ?></option>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </select>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="mb-3 row">
                                     <label for="input_title" class="col-md-2 col-form-label">Açıklama</label>
                                     <div class="col-md-10">
                                         <textarea class="form-control" name="description" type="text"><?php echo e($item->description); ?></textarea>
                                     </div>
                                 </div>
                                 <div class="mb-3 row">
                                     <label for="input_title" class="col-md-2 col-form-label">Gün</label>
                                     <div class="col-md-10">
                                         <input class="form-control" name="days" value="<?php echo e($item->days); ?>" type="number">
                                     </div>
                                 </div>

                            <div class="mb-3 row">
                                <label class="form-label col-md-2 col-form-label" for="name">Durum</label>
                                <div class="select2-full col-md-10">
                                    <select id="status" name="status" type="text" class="form-control form-select select2">
                                        <option value="ACTIVE" <?php if($item->status == 'ACTIVE'): ?> selected <?php endif; ?>> Aktif</option>
                                        <option value="PASSIVE" <?php if($item->status == 'PASSIVE'): ?> selected <?php endif; ?>>Pasif</option>
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
    <script src="<?php echo e(URL::asset('/assets/libs/ckeditor/ckeditor.min.js')); ?>"></script>

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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/definations/leave_types/edit.blade.php ENDPATH**/ ?>