@extends('layouts.admin')

@section('title', 'Thêm dịch vụ')

@section('content')
    <h1 class="h4 mb-3">Thêm dịch vụ</h1>

    <form method="post" action="{{ route('admin.services.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên dịch vụ</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Loại</label>
            <input type="text" name="type" value="{{ old('type') }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" value="{{ old('price') }}" class="form-control" min="0" step="1000">
        </div>
        <div class="mb-3">
            <label class="form-label">Thời lượng (phút)</label>
            <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" class="form-control" min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Lưu</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
