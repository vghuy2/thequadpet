@extends('layouts.admin')

@section('title', 'Sửa sản phẩm')

@section('content')
    <h1 class="h4 mb-3">Sửa sản phẩm</h1>

    <form method="post" action="{{ route('admin.products.update', $product) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected($product->category_id == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control" required min="0" step="1000">
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh (URL)</label>
            <input type="text" name="image" value="{{ old('image', $product->image) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Cập nhật</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
