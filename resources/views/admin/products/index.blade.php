@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Thêm sản phẩm</a>
    </div>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tên">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">-- Tất cả danh mục --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
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
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Đánh giá</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ optional($product->category)->name }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                    <td>{{ $product->rating }}/5</td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                        <form method="post" action="{{ route('admin.products.destroy', $product) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $products->links() }}</div>
@endsection
