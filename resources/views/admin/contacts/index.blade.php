@extends('layouts.admin')

@section('title', 'Liên hệ khách hàng')

@section('content')
    <h1 class="h4 mb-3">Liên hệ khách hàng</h1>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Trạng thái</th>
                <th>Thời gian</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ Str::limit($contact->message, 80) }}</td>
                    <td>{{ $contact->status }}</td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-end">
                        @if($contact->status !== 'replied')
                            <form method="post" action="{{ route('admin.contacts.markReplied', $contact) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-sm btn-outline-success" type="submit">Đã phản hồi</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $contacts->links() }}</div>
@endsection
