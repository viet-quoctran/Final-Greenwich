<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Http\Requests\GuestRequest;
use App\Mail\NewUserNotification;
use Illuminate\Support\Facades\Mail;
class GuestController extends Controller
{
    public function store(GuestRequest $request)
    {
        $input = $request->all();
        
        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        $existingUser = Guest::where('email', $input['email'])->first();
        if ($existingUser) {
            return redirect()->back()->withErrors(['email' => 'Email đã tồn tại trong hệ thống'])->withInput();
        }
        
        try {
            $user = Guest::create($input);

            // Gửi email
            Mail::to('vietquoctran2502@gmail.com')->send(new NewUserNotification($user));

            // Nếu muốn thêm trường 'status' mặc định là false
            $user->status = false;
            $user->save();

            return redirect()->back()->with('success', 'Thông tin của bạn đã được gửi tới chúng tớ, đợi trong giây lát bọn tớ nhé');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Đã xảy ra lỗi khi gửi thông tin, vui lòng thử lại sau.']);
        }
    }

}
