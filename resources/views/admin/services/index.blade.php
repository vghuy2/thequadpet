@extends('layouts.admin')

@section('title', 'Dịch vụ')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Dịch vụ</h1>
        <a href="{{ route('admin.services.create') }}" class="btn btn-primary btn-sm">Thêm dịch vụ</a>
    </div>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
            <tr>
                <th>Tên</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Thời lượng (phút)</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->type }}</td>
                    <td>{{ number_format($service->price, 0, ',', '.') }} đ</td>
                    <td>{{ $service->duration_minutes }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                        <form method="post" action="{{ route('admin.services.destroy', $service) }}" class="d-inline">
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
@endsection
