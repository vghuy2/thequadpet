@extends('layouts.admin')

@section('title', 'Lịch hẹn dịch vụ')

@section('content')
    <h1 class="h4 mb-3">Lịch hẹn dịch vụ</h1>

    <form class="row g-2 mb-3" method="get">
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Tất cả trạng thái --</option>
                @foreach(['pending' => 'Chờ xác nhận','confirmed' => 'Đã xác nhận','done' => 'Hoàn thành','cancelled' => 'Hủy'] as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary" type="submit">Lọc</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
            <tr>
                <th>Dịch vụ</th>
                <th>Khách hàng</th>
                <th>Thú cưng</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ optional($appointment->service)->name }}</td>
                    <td>{{ optional($appointment->user)->name }}</td>
                    <td>{{ $appointment->pet_name }} ({{ $appointment->pet_type }})</td>
                    <td>{{ $appointment->appointment_time->format('d/m/Y H:i') }}</td>
                    <td>{{ $appointment->status }}</td>
                    <td>
                        <form method="post" action="{{ route('admin.appointments.updateStatus', $appointment) }}" class="d-flex gap-1">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select form-select-sm">
                                @foreach(['pending','confirmed','done','cancelled'] as $st)
                                    <option value="{{ $st }}" @selected($appointment->status === $st)>{{ $st }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-primary" type="submit">Lưu</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $appointments->links() }}</div>
@endsection
