@extends('layouts.admin')

@section('title', 'Quản lý danh mục')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Danh mục sản phẩm</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">Thêm danh mục</a>
    </div>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tên">
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary" type="submit">Tìm</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
            <tr>
                <th>Tên</th>
                <th>Slug</th>
                <th>Loại</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->type }}</td>
                    <td>{{ $category->is_active ? 'Đang dùng' : 'Đã ẩn' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                        @if($category->is_active)
                            <form method="post" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">Ẩn</button>
                            </form>
                        @else
                            <form method="post" action="{{ route('admin.categories.restore', $category->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-success" type="submit">Khôi phục</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $categories->links() }}</div>
@endsection
