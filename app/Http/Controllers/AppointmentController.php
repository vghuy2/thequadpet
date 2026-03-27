<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function create(): View
    {
        $services = Service::all();

        return view('appointments.create', compact('services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'pet_name' => ['required', 'string', 'max:255'],
            'pet_type' => ['nullable', 'string', 'max:50'],
            'appointment_time' => ['required', 'date'],
            'note' => ['nullable', 'string'],
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'service_id' => $data['service_id'],
            'pet_name' => $data['pet_name'],
            'pet_type' => $data['pet_type'] ?? null,
            'appointment_time' => $data['appointment_time'],
            'status' => 'pending',
            'note' => $data['note'] ?? null,
        ]);

        return redirect()->route('appointments.create')->with('success', 'Đã gửi yêu cầu đặt lịch.');
    }
}
