<?php echo $__env->make('components.leaveModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.advancePaymentModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.expenditureModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('components.overTimeModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="<?php echo e(route('index')); ?>" class="logo">
            <img src="<?php echo e(getCompanyLogo()); ?>" height="24" alt="logo">
        </a>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item dropdown">
                <button class="nav-link dropdown-toggle leave_btn" type="button" id="requestDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus-circle"></i>
                    <span class="item-name">Talep Oluştur</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="requestDropdown">
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#leaveModal">
                            İzin Talep Et
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#adavancePaymentModal">
                            Avans Talep Et
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#expenditureModal">
                            Harcama Talep Et
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#overTimeModal">
                            Fazla Mesai Talep Et
                        </button>
                    </li>
                </ul>
            </li>

            <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(in_array(\Illuminate\Support\Facades\Auth::user()->user_role, $menuItem['permission'])): ?>
                <li class="nav-item <?php echo e(Request::routeIs($menuItem['main_route']) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route($menuItem['url'])); ?>" class="nav-link">
                        <i class="fas fa-layer-group"></i>
                        <span class="item-name"><?php echo e($menuItem['title']); ?></span>
                    </a>
                </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Diğer menü öğelerini burada ekleyebilirsiniz -->
        </ul>
    </div>
</aside>

<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>