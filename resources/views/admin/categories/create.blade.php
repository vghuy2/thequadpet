@extends('layouts.admin')

@section('title', 'Thêm danh mục')

@section('content')
    <h1 class="h4 mb-3">Thêm danh mục</h1>

    <form method="post" action="{{ route('admin.categories.store') }}" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Tên</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Loại</label>
            <input type="text" name="type" value="{{ old('type') }}" class="form-control" placeholder="dog, cat, accessory,...">
        </div>
        <div class="col-12">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
    </form>
@endsection
