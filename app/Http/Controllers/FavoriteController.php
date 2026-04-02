<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(): View
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function store(int $productId): RedirectResponse
    {
        $product = Product::findOrFail($productId);

        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích.');
    }

    public function destroy(int $productId): RedirectResponse
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    }
}
