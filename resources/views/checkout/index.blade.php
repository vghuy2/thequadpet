@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
    <h1 class="h4 mb-3">Thanh toán</h1>

    <div class="row">
        <div class="col-md-7 mb-3">
            <form method="post" action="{{ route('checkout.place') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', optional(auth()->user())->name) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone', optional(auth()->user())->phone) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', optional(auth()->user())->email) }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ giao hàng</label>
                    <textarea name="shipping_address" class="form-control" rows="3" required>{{ old('shipping_address') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label d-block">Phương thức thanh toán</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" @checked(old('payment_method', 'cod') === 'cod')>
                        <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="bank" value="bank_transfer" @checked(old('payment_method') === 'bank_transfer')>
                        <label class="form-check-label" for="bank">Chuyển khoản</label>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Xác nhận đặt hàng</button>
            </form>
        </div>
        <div class="col-md-5 mb-3">
            <h2 class="h5">Tóm tắt đơn hàng</h2>
            <ul class="list-group mb-2">
                @foreach($items as $row)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $row['product']->name }} x {{ $row['quantity'] }}</span>
                        <span>{{ number_format($row['lineTotal'], 0, ',', '.') }} đ</span>
                    </li>
                @endforeach
            </ul>
            <p class="fw-semibold">Tổng tiền: <span class="text-danger">{{ number_format($total, 0, ',', '.') }} đ</span></p>
        </div>
    </div>
@endsection
