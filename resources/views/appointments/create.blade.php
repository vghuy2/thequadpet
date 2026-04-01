@extends('layouts.app')

@section('title', 'Đặt lịch dịch vụ')

@section('content')
    <h1 class="h4 mb-3">Đặt lịch dịch vụ thú cưng</h1>

    <form method="post" action="{{ route('appointments.store') }}" class="row g-3">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Dịch vụ</label>
            <select name="service_id" class="form-select" required>
                <option value="">-- Chọn dịch vụ --</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" @selected((old('service_id') ?? ($selectedServiceId ?? null)) == $service->id)>{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tên thú cưng</label>
            <input type="text" name="pet_name" value="{{ old('pet_name') }}" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Loại thú cưng</label>
            <input type="text" name="pet_type" value="{{ old('pet_type') }}" class="form-control" placeholder="Chó, mèo,...">
        </div>
        <div class="col-md-4">
            <label class="form-label">Thời gian</label>
            <input type="datetime-local" name="appointment_time" value="{{ old('appointment_time') }}" class="form-control" required>
        </div>
        <div class="col-12">
            <label class="form-label">Ghi chú</label>
            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Gửi yêu cầu</button>
        </div>
    </form>
@endsection
