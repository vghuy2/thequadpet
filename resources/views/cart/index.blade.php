@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <h1 class="h4 mb-3">Giỏ hàng</h1>

    @if(empty($items))
        <p>Giỏ hàng trống.</p>
    @else
        <div class="table-responsive mb-3">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th class="text-end">Giá</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-end">Thành tiền</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $row)
                    <tr>
                        <td>{{ $row['product']->name }}</td>
                        <td class="text-end">{{ number_format($row['product']->price, 0, ',', '.') }} đ</td>
                        <td class="text-center">
                            <form method="post" action="{{ route('cart.update', $row['product']->id) }}" class="d-inline-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $row['quantity'] }}" min="1" class="form-control form-control-sm me-1" style="width: 80px;">
                                <button class="btn btn-sm btn-outline-secondary" type="submit">Cập nhật</button>
                            </form>
                        </td>
                        <td class="text-end">{{ number_format($row['lineTotal'], 0, ',', '.') }} đ</td>
                        <td class="text-end">
                            <form method="post" action="{{ route('cart.remove', $row['product']->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">Tổng tiền: <span class="text-danger">{{ number_format($total, 0, ',', '.') }} đ</span></h2>
            <a href="{{ route('checkout.form') }}" class="btn btn-primary">Thanh toán</a>
        </div>
    @endif
@endsection
