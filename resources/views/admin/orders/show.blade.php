@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <h1 class="h4 mb-3">Đơn hàng {{ $order->code }}</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <h6>Khách hàng</h6>
            <p class="mb-1">{{ $order->customer_name }}</p>
            <p class="mb-1">{{ $order->customer_phone }}</p>
            <p class="mb-1">{{ $order->customer_email }}</p>
        </div>
        <div class="col-md-4">
            <h6>Thông tin đơn</h6>
            <p class="mb-1">Ngày tạo: {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p class="mb-1">Thanh toán: {{ $order->payment_method }}</p>
            <p class="mb-1">Trạng thái: {{ $order->status }}</p>
        </div>
        <div class="col-md-4">
            <h6>Cập nhật trạng thái</h6>
            <form method="post" action="{{ route('admin.orders.updateStatus', $order) }}">
                @csrf
                @method('PUT')
                <div class="input-group">
                    <select name="status" class="form-select">
                        @foreach(['pending','confirmed','shipping','completed','cancelled'] as $st)
                            <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" type="submit">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <h5>Sản phẩm</h5>
    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ optional($item->product)->name }}</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-end fw-bold">Tổng: {{ number_format($order->total_amount, 0, ',', '.') }} đ</div>
@endsection
