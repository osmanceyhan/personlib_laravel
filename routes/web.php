<?php

use App\Http\Controllers\Admin\Admins\AdminsController;
use App\Http\Controllers\Admin\Admins\RolesController;
use App\Http\Controllers\Admin\Dashboards\DashboardController;
use App\Http\Controllers\Admin\Moduls\Definations\CountryController;
use App\Http\Controllers\Admin\Moduls\Definations\GeoCodeController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\SortController;
use App\Http\Controllers\Admin\Users\UsersController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Definations\LeaveTypeController;
use App\Http\Controllers\Definations\DefinationsController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Definations\LeaveTypeCalculatorController;
use App\Http\Controllers\Managers\ManagerController;
use App\Http\Controllers\UserRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


    Auth::routes();

    Route::post('custom_login',[LoginController::class,'login'])->name('custom_login');
    Route::post('register',[LoginController::class,'register'])->name('register');
    Route::post('forget-password',[LoginController::class,'forgetPassword'])->name('forgetPassword');
    Route::post('forget-password-again',[LoginController::class,'forgetPasswordProcess'])->name('forgetPasswordProcess');
    Route::post('forget-password-reset',[LoginController::class,'forgetPasswordReset'])->name('forgetPasswordReset');
    Route::any('/logout', function(){
        Auth::logout();
        return redirect()->route('index');
    })->name('logout');

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth')->name('index');


    Route::get('403', function () {
        $message = 'Bu işlemi gerçekleştirmek için yetkiniz yok';
        return view('errors.permissions', compact('message'));
    })->name('403');


//'auth.admin', 'role'
    Route::prefix('moduls')->middleware('auth')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'root'])
            ->name('dashboard');


        Route::prefix('manager')->group(function(){

            Route::get('/requests', [ManagerController::class, 'requests'])
                ->name('requests.index');

            Route::get('/employees', [ManagerController::class, 'employees'])
                ->name('employees.index');
        });

        Route::get('/employees', [ManagerController::class, 'employees_create'])
            ->name('employees.create');
        Route::post('/employees', [ManagerController::class, 'employees_store'])
            ->name('employees.store');

        Route::get('/employees/{id}', [ManagerController::class, 'employees_edit'])
            ->name('employees.edit');


        Route::post('/employees/{id}', [ManagerController::class, 'employees_update'])
            ->name('employees.update');

        // Profil settings
        Route::prefix('accounts')->group(function(){
            Route::get('/profile', [\App\Http\Controllers\Accounts\ProfileController::class, 'index'])
                ->name('profile.index');
            Route::get('/personal-information', [\App\Http\Controllers\Accounts\ProfileController::class, 'information'])
                ->name('profile.information');


            Route::get('/payment-requests', [\App\Http\Controllers\Accounts\ProfileController::class, 'payment_requests'])
                ->name('profile.payment_requests');


            Route::get('/leave-requests', [\App\Http\Controllers\Accounts\ProfileController::class, 'leave_requests'])
                ->name('profile.leave_requests');

            Route::get('/profile/edit/{id}', [\App\Http\Controllers\Accounts\ProfileController::class, 'edit'])
                ->name('profile.edit');
            Route::get('/profile/show', [\App\Http\Controllers\Accounts\ProfileController::class, 'show'])
                ->name('profile.show');
        });


        Route::resource('defination',DefinationsController::class);
        Route::prefix("definations")->group(function () {
            Route::resource('leave_types',LeaveTypeController::class);
            Route::resource('leave_requests',LeaveTypeController::class);
            Route::post('/leave_requests/store', [LeaveTypeCalculatorController::class, 'store'])->name('leave_requests.store');
            Route::post('/payment_requests/store', [UserRequestController::class, 'store'])->name('payment_requests.store');

            Route::get('leave_requests_calc',[LeaveTypeCalculatorController::class,'leaveRequestsCalc'])->name('leave_requests_calc');
            Route::prefix("company")->group(function () {
                Route::get('/',[CompanyController::class,'show'])->name('company.show');
                Route::put('/',[CompanyController::class,'update'])->name('company.update');

            });
            Route::resource('geoCodes',GeoCodeController::class);
            Route::get('/countries', [CountryController::class,'index'])->name('countries');
        });


        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])
            ->name('settings.update');



    });