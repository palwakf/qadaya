<?php


namespace App\Http\Controllers\Admin;

use App\Helpers\Common;
use App\Models\User;
use App\Traits\EncryptionTrait;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, EncryptionTrait, ResponseTrait;

    /**
     * @var array
     */
    public static $data = [];

    public function __construct()
    {
        self::$data['active_menu'] = '';
        self::$data['component_style'] = 1;
        self::$data['color'] = "grey";
        self::$data['fixed_sidebar'] = 0;
        self::$data['form_class'] = "blue-dark";
        self::$data['btn_class'] = "blue-dark";
        self::$data['btn_back_class'] = "grey";
        self::$data['enable_class'] = "success";
        self::$data['disable_class'] = "danger";
        self::$data['btn_red'] = "red";
        self::$data['btn_green'] = "green-meadow";
        self::$data['per_page'] = 20;
        $this->middleware(function (Request $request, $next) {
            if (!Auth::check()) {
                return redirect(route('login.view'));
            }
            self::$data['user'] = User::find(Auth::id());
//            $this->permissions = self::$data['user']->getAllPermissions();
            self::$data['user_permissions'] = Common::getMenu(self::$data['user']);

            return $next($request);
        });


    }
}
