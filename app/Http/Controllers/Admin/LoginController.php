<?php


namespace App\Http\Controllers\Admin;


use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 * @package App\Http\Controllers\Admin
 */
class LoginController extends Controller
{
    use ResponseTrait;
        /**
     * @var array
     */
    public static $data = [];
    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        self::$data['active_menu'] = 'login';
    }
    //////////////////////////

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view('admin.login.view', self::$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request)
    {
        $field = filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //////////////////////////////////////////
        $username = $request->get('username');
        $password = $request->get('password');
        $remember_token = $request->get('remember_token');

        $credentials[$field] = $username;
        $credentials['password'] = $password;
        $credentials['status'] = 1;
        ///////////////////////////////
        if (!Auth::guard('admin')->attempt($credentials, $remember_token))
        {
            return $this->generalResponse(false,500, trans('title.error'), trans('messages.login'), null);
        }
        return $this->generalResponse(true,200, trans('title.success'), trans('messages.success_login'), null);
    }
}
