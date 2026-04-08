@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h4 mb-3">Hồ sơ cá nhân</h1>
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                </div>
                <button class="btn btn-primary" type="submit">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
