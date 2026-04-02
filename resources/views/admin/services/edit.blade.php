@extends('layouts.admin')

@section('title', 'Sửa dịch vụ')

@section('content')
    <h1 class="h4 mb-3">Sửa dịch vụ</h1>

    <form method="post" action="{{ route('admin.services.update', $service) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Tên dịch vụ</label>
            <input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Loại</label>
            <input type="text" name="type" value="{{ old('type', $service->type) }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" value="{{ old('price', $service->price) }}" class="form-control" min="0" step="1000">
        </div>
        <div class="mb-3">
            <label class="form-label">Thời lượng (phút)</label>
            <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" class="form-control" min="0">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $service->description) }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Cập nhật</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
@endsection
