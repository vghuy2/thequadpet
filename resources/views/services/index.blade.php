@extends('layouts.app')

@section('title', 'Dịch vụ thú cưng')

@section('content')
    <h1 class="h4 mb-3">Dịch vụ thú cưng</h1>

    <div class="row">
        @forelse($services as $service)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="h6">{{ $service->name }}</h2>
                        <p class="small text-muted">{{ $service->type }}</p>
                        <p>{{ $service->description }}</p>
                        @if($service->price)
                            <p class="fw-semibold text-danger">Giá từ {{ number_format($service->price, 0, ',', '.') }} đ</p>
                        @endif
                        <a href="{{ route('appointments.create', ['service_id' => $service->id]) }}" class="btn btn-outline-primary btn-sm mt-2">Đặt lịch dịch vụ này</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có dịch vụ.</p>
        @endforelse
    </div>
@endsection
