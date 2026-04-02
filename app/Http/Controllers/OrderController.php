<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(string $code): View
    {
        $order = Order::with('items.product')
            ->where('code', $code)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    public function checkForm(): View
    {
        return view('orders.check');
    }

    public function check(Request $request): View
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        $order = Order::with('items.product')
            ->where('code', $data['code'])
            ->where('customer_phone', $data['phone'])
            ->first();

        return view('orders.check', compact('order'));
    }
}
