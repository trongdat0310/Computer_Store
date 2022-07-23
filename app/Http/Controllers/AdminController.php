<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Models\Social; //sử dụng model Social
use Laravel\Socialite\Facades\Socialite; //sử dụng Socialite

class AdminController extends Controller
{
    public function AuthLogin(){
//        if (Session::get('login_normal')) {
            $admin_id = Session::get('admin_id');
//        }else  {
//            $admin_id = Auth::id();
//        }
        if($admin_id){
            return Redirect::to('dashboard');
        }else
            return Redirect::to('admin')->send();

    }
    public function index(){
        return view('admin_login');
    }
    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }
    public function dashboard(Request $request){
        $data = $request->all();
        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Admin::where('admin_email', $admin_email)
            ->where('admin_password', $admin_password)
            ->first();
        if ($login){
            Session::put('admin_name', $login->admin_name);
            Session::put('admin_id', $login->admin_id);
            return Redirect::to('/dashboard');
        }else {
            Session::put('message','Mật khẩu hoặc tài khoản bị sai');
            return Redirect::to('/admin');
        }
//        $admin_email = $request->admin_email;
//        $admin_password = md5($request->admin_password);
//
//        $result = Admin::query()
//            ->where('admin_email',$admin_email)
//            ->where('admin_password',$admin_password)
//            ->first();
//
//        if ($result) {
//            Session::put('admin_name',$result->admin_name);
//            Session::put('admin_id',$result->admin_id);
//            return Redirect::to('/dashboard');
//        }else {
//            Session::put('message','Mật khẩu hoặc tài khoản bị sai');
//            return Redirect::to('/admin');
//        }

    }
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }

    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')
            ->where('provider_user_id',$provider
            ->getId())
            ->first();
        if($account){
            //login in vao trang quan tri
            $account_name = Admin::where('admin_id',$account->user)
                ->first();

            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal', true);
            Session::put('admin_id',$account_name->admin_id);

            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');

        }else{

            $admin_login = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Admin::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Admin::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',
                ]);
            }
            $admin_login->login()->associate($orang);
            $admin_login->save();

            $account_name = Admin::where('admin_id',$admin_login->user)->first();

            Session::put('admin_name',$admin_login->admin_name);
            Session::put('login_normal', true);
            Session::put('admin_id',$admin_login->admin_id);

            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }
    }
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $admin_login = new Social([
                'provider_user_id' => $users->id,
                'provider' => strtoupper($provider),
            ]);

            $orang = Admin::where('admin_email',$users->email)->first();

            if(!$orang){
                $orang = Admin::create([
                    'admin_name' => $users->name,
                    'admin_email' => $users->email,
                    'admin_password' => '',
                    'admin_phone' => '',
                ]);
            }
            $admin_login->login()->associate($orang);
            $admin_login->save();
            return $admin_login;
        }

    }
    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateUser($users,'google');
        if ($authUser){
            $account_name = Admin::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
        }else{
            $account_name = Admin::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
        }

        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }




}
