@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="mb-0">Chỉnh sửa Người dùng</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</div>
@endsection
