@extends('layouts.master-without-nav')
@section('title') Giriş Yap @endsection
@section('css')
    <link href="{{ URL::asset('/assets/css/login_page.css')}}?time={{time()}}"   rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @include('auth.register_modal')
    <div class="login_page">
        <div class="row h-100">
            <div class="col-sm-12 col-md-5 ">
                <div class="row justify-content-center h-100">
                    <div class="col-9 align-self-center">
                        <div class="logo-container">
                            <img src="{{asset('assets/images/personlib.svg')}}" alt="{{config('name')}}">
                        </div>
                        <div class="login-form container-wrapper">
                            <form method="POST" @if(session()->has('forgetPassword')) action="{{ route('forgetPasswordReset') }}"  @else action="{{ route('custom_login') }}" @endif data-login-form>
                                @csrf
                                <div class="container">
                                    <div class="login_card">
                                        <div class="card-body p-4">
                                            <div class="text-center mt-2">
                                                <p class="text-muted">Yönetim paneline hoşgeldiniz, lütfen giriş yapınız.</p>
                                                @if(session()->has('alert'))
                                                    <div class="alert alert-{{ session()->get('alert')['status'] }} alert-dismissible fade show" role="alert">
                                                        <p>  {{ session()->get('alert')['message'] }}</p>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="p-2 mt-4">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="auth_email">E-posta Adresi</label>
                                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                                               name="auth_email"  value="{{old('auth_email')}}" id="auth_email">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                @if(session()->has('forgetPassword'))
                                                    <div class="form-group mb-3" data-only-forget>
                                                        <label class="form-label" for="userpassword">Sıfırlama Kodu</label>
                                                        <input type="text" class="form-control @error('token') is-invalid @enderror"
                                                               name="token" id="token" placeholder="Sıfırlama Kodunu Girin">
                                                    </div>
                                                    <div class="form-group mb-3" data-only-forget>
                                                        <label class="form-label" for="userpassword">Parola</label>
                                                        <div class="form-password-group" data-password-toggle>
                                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                                                   name="new_password" id="new_password" placeholder="Parola Girin">
                                                                <i class="fas fa-eye-slash"></i>
                                                        </div>
                                                        @error('new_password')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mb-0" data-only-forget>
                                                        <label class="form-label" for="new_password_again">Parola Tekrarı</label>
                                                        <div class="form-password-group" data-password-toggle>
                                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                                                   name="new_password_again" id="new_password_again" placeholder="Parola Tekrarı Girin">
                                                                <i class="fas fa-eye-slash"></i>
                                                        </div>
                                                        @error('new_password')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                @endif

                                                    <div class="form-group mb-3
                                                    @if(session()->has('forgetPasswordError') || session()->has('forgetPassword')) d-none @endif"
                                                         data-only-login>
                                                        <label class="form-label" for="userpassword">Parola</label>
                                                        <div class="form-password-group" data-password-toggle>
                                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                                   name="password" id="userpassword" placeholder="Parola Girin">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="row">
                                                        <div class="mt-1 col-md-12">
                                                            @if(session()->has('forgetPassword'))
                                                            <div class="float-end mb-2" data-only-forget>
                                                                <button type="button" data-forget-repeat class="auth_forget_link" >Sıfırlama kodunu tekrar gönder</button>
                                                            </div>
                                                            @endif
                                                            @if(session()->has('forgetPassword'))
                                                                <button class="btn btn-primary w-sm waves-effect waves-light col-12" data-form-button type="submit">Şifremi Sıfırla</button>
                                                            @else
                                                                <button class="btn btn-primary w-sm waves-effect waves-light col-12" data-form-button type="submit">Giriş Yap</button>
                                                            @endif
                                                        </div>
                                                        <div class="float-end">
                                                            <button type="button" data-login-button class="auth_forget_link @if(!session()->has('forgetPassword')) d-none @endif" >Girişe dön</button>
                                                            <button type="button" data-forgot-password class="auth_forget_link  @if(session()->has('forgetPassword')) d-none @endif " >Şifrenizi mi unuttunuz?</button>
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
                        <img src="{{asset('assets/images/signup_icon.svg')}}">
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

@endsection
@section('script')

    <script type="text/javascript">
        var forgetRoute = '{{route('forgetPassword')}}';
        var loginRoute = '{{route('custom_login')}}';
        var passwordResetRoute = '{{route('forgetPasswordReset')}}';
    </script>
    @if(session()->has('forgetPassword'))
        <script type="text/javascript">


            $("[data-forget-repeat]").click(function () {
                $(".loader_body").addClass("active");
                var email = $("[name='auth_email']").val();
                $.ajax({
                    url: '{{route('forgetPasswordProcess')}}',
                    type: 'POST',
                    data: {
                        auth_email: email,
                        _token: '{{csrf_token()}}'
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
    @endif
    @if(session()->has('modalAlert'))
       <script type="text/javascript">
           $(document).ready(function () {
               $("#registerModalBtn").click();
           });
         </script>
    @endif
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
@endsection