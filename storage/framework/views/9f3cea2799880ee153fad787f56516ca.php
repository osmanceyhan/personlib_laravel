<?php $__env->startSection('title'); ?> Dashboard <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="dashboard_wrapper">
        <div class="row">
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
                                        <th>Şirket</th>
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
                                            <td><?php echo e($leave->getUser->getCompany->name); ?></td>
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
                                            <th>Şirket</th>
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
                                                <td><?php echo e($data->getUser->getCompany->name); ?></td>
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
                                            <th>Şirket</th>
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
                                                <td><?php echo e($data->getUser->getCompany->name); ?></td>
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
                                                <td><?php echo e($data->getUser->getCompany->name); ?></td>
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
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/dashboard/index.blade.php ENDPATH**/ ?>