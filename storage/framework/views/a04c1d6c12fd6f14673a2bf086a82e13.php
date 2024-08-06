<?php $__env->startSection('title'); ?> Giriş Yap <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/css/login_page.css')); ?>?time=<?php echo e(time()); ?>"   rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('auth.register_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="login_page">
        <div class="row h-100">
            <div class="col-sm-12 col-md-5 ">
                <div class="row justify-content-center h-100">
                    <div class="col-9 align-self-center">
                        <div class="logo-container">
                            <img src="<?php echo e(asset('assets/images/personlib.svg')); ?>" alt="<?php echo e(config('name')); ?>">
                        </div>
                        <div class="login-form container-wrapper">
                            <form method="POST" <?php if(session()->has('forgetPassword')): ?> action="<?php echo e(route('forgetPasswordReset')); ?>"  <?php else: ?> action="<?php echo e(route('custom_login')); ?>" <?php endif; ?> data-login-form>
                                <?php echo csrf_field(); ?>
                                <div class="container">
                                    <div class="login_card">
                                        <div class="card-body p-4">
                                            <div class="text-center mt-2">
                                                <p class="text-muted">Yönetim paneline hoşgeldiniz, lütfen giriş yapınız.</p>
                                                <?php if(session()->has('alert')): ?>
                                                    <div class="alert alert-<?php echo e(session()->get('alert')['status']); ?> alert-dismissible fade show" role="alert">
                                                        <p>  <?php echo e(session()->get('alert')['message']); ?></p>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="p-2 mt-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="auth_email">E-posta Adresi</label>
                                                        <input type="text" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               name="auth_email"  value="<?php echo e(old('auth_email')); ?>" id="auth_email">
                                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                <?php if(session()->has('forgetPassword')): ?>
                                                    <div class="form-group mb-3" data-only-forget>
                                                        <label class="form-label" for="userpassword">Sıfırlama Kodu</label>
                                                        <input type="text" class="form-control <?php $__errorArgs = ['token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               name="token" id="token" placeholder="Sıfırlama Kodunu Girin">
                                                    </div>
                                                    <div class="form-group mb-3" data-only-forget>
                                                        <label class="form-label" for="userpassword">Parola</label>
                                                        <div class="form-password-group" data-password-toggle>
                                                            <input type="password" class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                   name="new_password" id="new_password" placeholder="Parola Girin">
                                                                <i class="fas fa-eye-slash"></i>
                                                        </div>
                                                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="form-group mb-0" data-only-forget>
                                                        <label class="form-label" for="new_password_again">Parola Tekrarı</label>
                                                        <div class="form-password-group" data-password-toggle>
                                                            <input type="password" class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                   name="new_password_again" id="new_password_again" placeholder="Parola Tekrarı Girin">
                                                                <i class="fas fa-eye-slash"></i>
                                                        </div>
                                                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                <?php endif; ?>

                                                    <div class="form-group mb-3
                                                    <?php if(session()->has('forgetPasswordError') || session()->has('forgetPassword')): ?> d-none <?php endif; ?>"
                                                         data-only-login>
                                                        <label class="form-label" for="userpassword">Parola</label>
                                                        <div class="form-password-group" data-password-toggle>
                                                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                   name="password" id="userpassword" placeholder="Parola Girin">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </div>
                                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mt-1 col-md-12">
                                                            <?php if(session()->has('forgetPassword')): ?>
                                                            <div class="float-end mb-2" data-only-forget>
                                                                <button type="button" data-forget-repeat class="auth_forget_link" >Sıfırlama kodunu tekrar gönder</button>
                                                            </div>
                                                            <?php endif; ?>
                                                            <?php if(session()->has('forgetPassword')): ?>
                                                                <button class="btn btn-primary w-sm waves-effect waves-light col-12" data-form-button type="submit">Şifremi Sıfırla</button>
                                                            <?php else: ?>
                                                                <button class="btn btn-primary w-sm waves-effect waves-light col-12" data-form-button type="submit">Giriş Yap</button>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="float-end">
                                                            <button type="button" data-login-button class="auth_forget_link <?php if(!session()->has('forgetPassword')): ?> d-none <?php endif; ?>" >Girişe dön</button>
                                                            <button type="button" data-forgot-password class="auth_forget_link  <?php if(session()->has('forgetPassword')): ?> d-none <?php endif; ?> " >Şifrenizi mi unuttunuz?</button>
                                                        </div>
                                                    </div>
                                             </div>

                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7 h-100 h-100 imageSection">
                <div class="row h-100 justify-content-center">
                    <div class="col-8 align-self-center center-content">
                        <img src="<?php echo e(asset('assets/images/signup_icon.svg')); ?>">
                        <div class="title">Personlib ile şirketinizi kolayca yönetin</div>
                        <div class="text">Personlib, şirket içi personel yönetimini kolaylaştıran ve iş süreçlerinizi optimize eden yenilikçi bir platformdur.</div>
                        <div class="button">
                            <button type="button" class="btn btn-primary" id="registerModalBtn" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Hemen Kayıt Olun
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script type="text/javascript">
        var forgetRoute = '<?php echo e(route('forgetPassword')); ?>';
        var loginRoute = '<?php echo e(route('custom_login')); ?>';
        var passwordResetRoute = '<?php echo e(route('forgetPasswordReset')); ?>';
    </script>
    <?php if(session()->has('forgetPassword')): ?>
        <script type="text/javascript">


            $("[data-forget-repeat]").click(function () {
                $(".loader_body").addClass("active");
                var email = $("[name='auth_email']").val();
                $.ajax({
                    url: '<?php echo e(route('forgetPasswordProcess')); ?>',
                    type: 'POST',
                    data: {
                        auth_email: email,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        if(response.status){
                            alert(response.message);
                        }else{
                            alert(response.message);
                        }
                        $(".loader_body").removeClass("active");
                    }
                });
            });
        </script>
    <?php endif; ?>
    <?php if(session()->has('modalAlert')): ?>
       <script type="text/javascript">
           $(document).ready(function () {
               $("#registerModalBtn").click();
           });
         </script>
    <?php endif; ?>
    <script type="text/javascript" >
        $("[data-forgot-password]").click(function () {
           $("[data-login-form] [data-only-login]").addClass('d-none');
           $("[data-form-button]").html("Şifremi Sıfırla");
           $("[data-forgot-password]").addClass('d-none');
            $("[data-login-button]").removeClass('d-none');
            $("[data-login-form]").attr('action',forgetRoute);
        });
        $("[data-login-button]").click(function () {
            $("[data-only-forget]").remove();
            $("[data-login-form] [data-only-login]").removeClass('d-none');
            $("[data-form-button]").html("Giriş Yap");
            $(this).addClass("d-none");
            $("[data-forgot-password]").removeClass("d-none");
            $("[data-login-form]").attr('action',loginRoute);

        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/auth/login.blade.php ENDPATH**/ ?>