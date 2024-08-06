<?php $__env->startSection('title'); ?>
    Talepler
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/dropify/dropify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?> Talepler <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($user->getCompany->name); ?> - Talepler <?php $__env->endSlot(); ?>
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
                                        <?php $__currentLoopData = $datas['leave_requests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                <td></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <?php $__currentLoopData = $datas['payment_info']['expenditure']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($data->getUser->fullName()); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(getCdn($data->attachment)); ?>">
                                                            <?php echo e($data->receipt_date); ?>

                                                        </a>
                                                    </td>
                                                    <td><?php echo e($data->tax_rate); ?></td>
                                                    <td><?php echo getApprovalStatus($data->status); ?></td>
                                                    <td><?php echo e($data->amount); ?></td>
                                                    <td><?php echo e($data->comment); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')); ?></td>
                                                    <td><?php echo getApprovalStatus($data->payment_status); ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $datas['payment_info']['overtime']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($data->getUser->fullName()); ?></td>
                                                    <td><?php echo e($data->start_date); ?></td>
                                                    <td><?php echo e($data->start_time); ?></td>
                                                    <td><?php echo e($data->hour.' Saat '.$data->minute.' Dakika'); ?></td>
                                                    <td><?php echo e($data->comment); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')); ?></td>
                                                    <td><?php echo getApprovalStatus($data->status); ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                            <?php $__currentLoopData = $datas['payment_info']['advance_payments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($data->getCompany->name); ?></td>
                                                    <td><?php echo e($data->getUser->fullName()); ?></td>
                                                    <td>
                                                        <span class="badge badge-info bg-info">Avans</span>
                                                    </td>
                                                    <td><?php echo e($data->used_date); ?></td>
                                                    <td><?php echo e($data->amount); ?></td>
                                                    <td><?php echo e($data->comment); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i')); ?></td>
                                                    <td><?php echo getApprovalStatus($data->status); ?></td>
                                                    <td></td>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/requests/index.blade.php ENDPATH**/ ?>