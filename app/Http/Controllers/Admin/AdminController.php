<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Guest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\AccountCreatedFromGuest;
use Illuminate\Support\Facades\Mail;
class AdminController extends Controller
{
    // Phương thức cho màn hình login
    public function login()
    {
       
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // Phương thức cho dashboard
    public function dashboard()
    {
        if (Auth::check()) {
            $dataGuests = Guest::all();
            $dataUsers = User::where('is_admin', 0)->get();
            return view('admin.index', ['dataGuests' => $dataGuests,'dataUsers' => $dataUsers]);
        }
        // Nếu chưa đăng nhập, chuyển hướng đến màn hình login
        return redirect()->route('admin.login');
    }
    public function updateUserFromGuest(Request $request, $guestId)
    {
        $guest = Guest::findOrFail($guestId);
        $user = User::where('email', $guest->email)->first(); // Tìm người dùng dựa trên email của khách hàng

        if (!$user) {

            $user = new User();
            $user->email = $guest->email;
            $user->is_admin = 0;
            $user->name = $guest->fullname;
            
            // Tạo mật khẩu mới
            $newPassword = Str::random(10); 
            $user->password = Hash::make($newPassword); 
            
            // Thử gửi email
            try {
                // Gửi email
                Mail::to($user->email)->send(new AccountCreatedFromGuest($user->name, $user->email, $newPassword));
                
                // Nếu gửi email thành công, thì mới lưu user vào database và xoá guest
                $user->save();
                $guest->delete();

                // Trả về thông báo và thông tin của user trong response JSON
                $userData = $user->toArray();
                return response()->json(['message' => 'Guest status updated successfully', 'user' => $userData]);
            } catch (\Exception $e) {
                // Nếu gửi email gặp lỗi, không lưu user và xoá guest
                return response()->json(['error' => 'Failed to send email', 'details' => $e->getMessage()], 500);
            }
        } else {
            // Nếu người dùng đã tồn tại, không cần tạo mới, trả về thông tin của user trong response JSON
            $userData = $user->toArray();
            return response()->json(['message' => 'User already exists', 'user' => $userData]);
        }
    }

    public function loginProcess(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Thử đăng nhập với các thông tin này
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Bảo mật hơn khi tái tạo session mới sau khi đăng nhập

            // Kiểm tra nếu người dùng là admin
            if (Auth::user()->is_admin) {
                // Chuyển hướng đến trang dashboard nếu đăng nhập thành công
                return redirect()->intended('admin/dashboard');
            } else {
                Auth::logout();
                return redirect('admin/login')->with('error', 'You do not have access to the admin panel.');
            }
        }

        // Nếu đăng nhập không thành công, quay trở lại màn hình login với thông báo lỗi
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Đăng xuất người dùng

        $request->session()->invalidate(); // Làm vô hiệu session
        $request->session()->regenerateToken(); // Tạo lại token mới cho session để bảo mật

        return redirect('/admin/login'); // Chuyển hướng người dùng về trang đăng nhập
    }
}