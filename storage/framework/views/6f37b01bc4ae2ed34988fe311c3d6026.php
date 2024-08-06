<?php $__env->startSection('title'); ?> Sistem Tanımları <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('admin.common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?> Tanımlar <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> Tanımlar <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row-container">
        <div class="row">
            <?php $__currentLoopData = $definations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-xl-3" >
                    <div class="card card_gradient card_stats" style="height:calc(100% - 1.25rem);">
                        <div class="card-body">
                            <div>
                                <div class="card_header">
                                    <p class="text-muted mb-0"><?php echo e($result['title']); ?></p>
                                    <div class="card_stats_dropdown">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-70 hover:opacity-80">
                                            <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                            <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                            <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card_value d-flex justify-content-between align-items-center">
                                    <h4 class="mb-1 mt-1 "><span data-plugin="counterup"><?php echo e($result["count"]); ?></span></h4>
                                    <a href="<?php echo e($result['route']); ?>" class="btn btn-sm bg-white text-black">İncele</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>

    <!-- end row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/definations/index.blade.php ENDPATH**/ ?>