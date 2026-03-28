<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    protected function getCart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }

    protected function saveCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    public function index(Request $request): View
    {
        $cart = $this->getCart($request);
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

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, int $productId): RedirectResponse
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart($request);

        $quantity = (int) $request->input('quantity', 1);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + max($quantity, 1);

        $this->saveCart($request, $cart);

        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $cart = $this->getCart($request);

        if (!isset($cart[$productId])) {
            return back();
        }

        $quantity = max((int) $request->input('quantity', 1), 1);
        $cart[$productId] = $quantity;

        $this->saveCart($request, $cart);

        return back()->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    public function remove(Request $request, int $productId): RedirectResponse
    {
        $cart = $this->getCart($request);
        unset($cart[$productId]);
        $this->saveCart($request, $cart);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
