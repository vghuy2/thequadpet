@extends('layouts.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
    <h1 class="h4 mb-3">Thêm sản phẩm</h1>

    <form method="post" action="{{ route('admin.products.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug (để trống sẽ tự tạo)</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" value="{{ old('price') }}" class="form-control" required min="0" step="1000">
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh (URL)</label>
            <input type="text" name="image" value="{{ old('image') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Lưu</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
