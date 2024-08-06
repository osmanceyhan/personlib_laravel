<header class="topbar">
    <div class="container-fluid">
        <div class="topbar_row">
            <div class="topbar_start">

            </div>
            <div class="topbar_end">
                    <div class="profile_info">
                        <div class="profile_img">
                            <img src="<?php echo e(getAvatar()); ?>" alt="profile_img">
                            <span>Hesabım</span>
                        </div>
                        <div class="profile_data">
                            <div class="profile_data_head">
                                <img src="<?php echo e(getAvatar()); ?>" alt="profile_img">
                                <span class="profile_name"><?php echo e(\Illuminate\Support\Facades\Auth::user()->fullName()); ?></span>
                            </div>
                            <div class="profile_data_buttons">
                                <li>
                                    <a href="<?php echo e(route('profile.index')); ?>"><i class="fas fa-id-badge"></i>Profili Görüntüle</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('logout')); ?>"><i class="fas fa-sign-out-alt"></i>Çıkış Yap</a>
                                </li>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</header>


<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/layouts/topbar.blade.php ENDPATH**/ ?>