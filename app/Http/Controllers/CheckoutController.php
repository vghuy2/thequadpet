<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    protected function getCart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }

    public function form(Request $request): View|RedirectResponse
    {
        $cart = $this->getCart($request);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }

            $lineTotal = $product->price * $quantity;
            $items[] = compact('product', 'quantity', 'lineTotal');
            $total += $lineTotal;
        }

        return view('checkout.index', compact('items', 'total'));
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $cart = $this->getCart($request);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['nullable', 'email'],
            'shipping_address' => ['required', 'string'],
            'payment_method' => ['required', 'in:cod,bank_transfer'],
        ]);

        $total = 0;
        $itemsData = [];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if (!$product) {
                continue;
            }

            $lineTotal = $product->price * $quantity;
            $total += $lineTotal;
            $itemsData[] = [
                'product' => $product,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }

        if ($total <= 0 || empty($itemsData)) {
            return redirect()->route('cart.index')->with('error', 'Không thể đặt đơn hàng.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'code' => 'QP-' . Str::upper(Str::random(8)),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => $data['payment_method'],
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'] ?? null,
            'shipping_address' => $data['shipping_address'],
        ]);

        foreach ($itemsData as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $request->session()->forget('cart');

        return redirect()->route('orders.showByCode', $order->code)
            ->with('success', 'Đặt hàng thành công. Mã đơn: ' . $order->code);
    }
}
