@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="h4 mb-3">Đăng nhập</h1>
            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                </div>
                <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
            </form>
        </div>
    </div>
@endsection
