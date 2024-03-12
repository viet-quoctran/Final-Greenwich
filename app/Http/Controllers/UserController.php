<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }

    // Phương thức lưu người dùng mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Tạo người dùng mới
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        // Chuyển hướng đến trang danh sách người dùng
        return redirect()->route('users.index')->with('success', 'Người dùng đã được thêm thành công.');
    }

    // Phương thức hiển thị form sửa người dùng
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Phương thức cập nhật người dùng trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // Tìm người dùng cần cập nhật
        $user = User::findOrFail($id);

        // Cập nhật thông tin người dùng
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Chuyển hướng đến trang danh sách người dùng
        return redirect()->route('users.index')->with('success', 'Thông tin người dùng đã được cập nhật thành công.');
    }

    // Phương thức xóa người dùng
    public function destroy($id)
    {
        // Tìm người dùng cần xóa
        $user = User::findOrFail($id);

        // Xóa người dùng
        $user->delete();

        // Chuyển hướng đến trang danh sách người dùng
        return redirect()->route('users.index')->with('success', 'Người dùng đã được xoá thành công.');
    }

    // Phương thức hiển thị chi tiết người dùng
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }
}
