<?php

/**
 * Dev: @Nogor Solutions Ltd
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\LoginTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    use LoginTrait;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout', 'loginCheck');
    }

    /**
     * Process the user login
     *
     * @return response
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            if ($this->validateCheck($request)) {
                $email = $request->email;
                $arr = [
                    'email' => $email,
                    'password' => $request->password,
                    'status' => 'active',
                ];

                $admin = Admin::where('email', $email)->first();
                if (! empty($admin)) {
                    if ($admin->block == 0) {
                        if (Auth::guard('admin')->attempt($arr, $request->remember)) {
                            Session::forget($email);
                            Artisan::call('cache:clear');

                            // Store the login details.
                            $userId = Auth::guard('admin')->user()->id;
                            $this->storeLoginDetails($userId, 'admin');

                            return response([
                                'message' => 'Login Successfully',
                                'user' => Auth::guard('admin')->user(),
                                'role' => Auth::guard('admin')->user()->role->name ?? '',
                            ], 200);
                        } else {
                            $attempt = $this->attemptAdmin($admin->id, $email);
                            if ($attempt <= 3 && $attempt != 0) {
                                $msg = 'There are '.$attempt.' attempts left';
                            } elseif ($attempt == 0) {
                                $msg = 'Your account is block, plese contact your administrator';
                            } else {
                                $msg = 'Your Login Information is Wrong';
                            }

                            return response([
                                'message' => $msg,
                            ], 201);
                        }
                    } else {
                        Session::forget($email);

                        return response([
                            'message' => 'Your account is block, plese contact your administrator',
                        ], 201);
                    }
                } else {
                    return response([
                        'message' => 'Email does not match our records!',
                    ], 201);
                }
            }
        } elseif ($request->isMethod('get')) {
            return view('admin.layouts.login_app');
        } else {
            return view('admin.layouts.login_app');
        }
    }

    /**
     * Attempt to login as admin
     *
     * @param [type] $id
     * @param [type] $email
     * @return response
     */
    private function attemptAdmin($id, $email)
    {
        $count = Session::get($email) ?? 0;
        $inc = $count + 1;
        Session::put($email, $inc);

        $attempt = 6 - $inc;
        if ($attempt == 0) {
            Session::forget($email);
            Admin::where('id', $id)->update(['block' => 1]);
        }

        return $attempt;
    }

    /**
     * Validation on login request
     *
     * @param [type] $request
     * @return bool
     */
    public function validateCheck($request)
    {
        return $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    }

    /**
     * Logout the authenticated user
     *
     * @return response
     */
    public function logout()
    {
        Artisan::call('cache:clear');
        $logout = Auth::guard('admin')->logout();

        return response([
            'message' => 'Logout Successfully',
        ], 200);
    }

    /**
     * Check auth
     *
     * @return response
     */
    public function loginCheck()
    {
        if (Auth::guard('admin')->user()) {
            return response([
                'message' => 'Login Successfully',
                'user' => Auth::guard('admin')->user(),
                'role' => Auth::guard('admin')->user()->role->name ?? '',
            ], 200);
        }

        return response(['message' => 'Unauthorized'], 201);
    }
}
