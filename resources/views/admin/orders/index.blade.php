@extends('layouts.admin')

@section('title', 'Đơn hàng')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Đơn hàng</h1>
    </div>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Tất cả trạng thái --</option>
                @foreach(['pending' => 'Chờ xác nhận','confirmed' => 'Đã xác nhận','shipping' => 'Đang giao','completed' => 'Hoàn thành','cancelled' => 'Hủy'] as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary" type="submit">Lọc</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
            <tr>
                <th>Mã</th>
                <th>Khách hàng</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->code }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>
                    <td class="text-end">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Xem</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $orders->links() }}</div>
@endsection
