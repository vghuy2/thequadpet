@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')
    <h1 class="h4 mb-3">Sửa danh mục</h1>

    <form method="post" action="{{ route('admin.categories.update', $category) }}" class="row g-3">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Tên</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Loại</label>
            <input type="text" name="type" value="{{ old('type', $category->type) }}" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Cập nhật</button>
        </div>
    </form>
@endsection
