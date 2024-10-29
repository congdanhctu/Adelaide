<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Hiển thị form đăng nhập.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Lưu tên người dùng và vai trò vào session
            Session::put('username', $user->username); // Thay thế 'username' bằng trường tương ứng với tên người dùng trong cơ sở dữ liệu
            Session::put('user_role', $user->role);

            // Điều hướng dựa trên vai trò người dùng
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/hotels');
            } else {
                return redirect()->intended('/');
            }
        }

        // Nếu xác thực không thành công, quay lại trang đăng nhập với thông báo lỗi
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

}
