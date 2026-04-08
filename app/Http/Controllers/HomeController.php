<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->limit(6)->get();
        $featuredProducts = Product::query()->orderByDesc('rating')->limit(8)->get();
        $services = Service::all();
        $posts = Post::query()->orderByDesc('published_at')->limit(3)->get();

        return view('home', compact('categories', 'featuredProducts', 'services', 'posts'));
    }
}
