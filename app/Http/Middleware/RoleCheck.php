<?php

namespace App\Http\Middleware;

use App\Models\Admins;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use function Livewire\str;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Mevcut route bilgisini al
        $route = $request->route();

        $controllerAction = $route->getAction('controller');

        $user = Admins::where('id', Auth::id())->first();


        // Kullanıcının rol ve izinlerini al
        $userRoles = $user->getRoleNames()->toArray();
        $rolePermissions = collect();
        $master = 0;
        foreach ($userRoles as $role) {
            $roleModel = Role::findByName($role);
            $rolePermissions = $rolePermissions->merge($roleModel->permissions);
            if($roleModel->name == "superadmin"){
                $master = 1;
            }
        }
        if($master == 1){
            return $response;
        }


        // Controller ve action isimlerini ekrana yazdır
        list($controller, $action) = explode('@', $controllerAction);
        $method = $action;
        $controllerName = class_basename($route->getController());
        $key = $controllerName."-".$method;



        $rolePermissions = $rolePermissions->pluck('name')->toArray();



        // Eğer kullanıcı roller veya izinler içinde $key yoksa işlemi durdur
        if (!in_array($key, $rolePermissions) && $master == 0) {

            $message = ['message' => 'Bu işlemi gerçekleştirmek için yetkiniz yok'];
            return  redirect()->route('403');
             //   abort(403, 'Bu işlemi gerçekleştirmek için yetkiniz yok.');
        }




        return $response;
    }
}
