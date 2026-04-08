@extends('layouts.app')

@section('title', 'The Quad Pets - Home')

@section('content')
    <section class="qp-hero mb-5">
        <div class="row g-0 align-items-center">
            <div class="col-md-7 p-5">
                <p class="text-uppercase small fw-semibold mb-2 opacity-75">Pet shop & spa</p>
                <h2 class="display-6 fw-bold mb-3">The Quad Pets</h2>
                <p class="mb-4">Mua sắm phụ kiện, thức ăn & đặt lịch dịch vụ chăm sóc thú cưng của bạn chỉ trong vài bước.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg qp-pill-btn">Mua sắm ngay</a>
                    <a href="{{ route('services.index') }}" class="btn btn-outline-light btn-lg qp-pill-btn">Đặt lịch dịch vụ</a>
                </div>
            </div>
            <div class="col-md-5 d-none d-md-block p-4">
                <div class="bg-white bg-opacity-10 border border-white border-opacity-25 rounded-4 h-100 d-flex flex-column justify-content-center p-4">
                    <h3 class="h5 mb-3">Ưu đãi hôm nay</h3>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2">• Giảm 10% cho lần đặt lịch spa đầu tiên</li>
                        <li class="mb-2">• Freeship nội thành cho đơn trên 300.000đ</li>
                        <li>• Combo thức ăn + cát vệ sinh tiết kiệm hơn</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <h2 class="qp-section-title">Danh mục sản phẩm</h2>
    <div class="row mb-4">
        @forelse($categories as $category)
            <div class="col-6 col-md-3 mb-3">
                <div class="card qp-card h-100">
                    <div class="card-body text-center">
                        <h3 class="h6">{{ $category->name }}</h3>
                        <p class="small text-muted mb-0">{{ $category->type }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có danh mục.</p>
        @endforelse
    </div>

    <h2 class="qp-section-title">Sản phẩm nổi bật</h2>
    <div class="row mb-4">
        @forelse($featuredProducts as $product)
            <div class="col-6 col-md-3 mb-3">
                <div class="card qp-card h-100">
                    <div class="ratio ratio-4x3 bg-light">
                        @if($product->image)
                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center text-muted">No image</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="h6 mb-1"><a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a></h3>
                        <p class="qp-price mb-1">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                        <p class="small mb-0">Đánh giá: {{ $product->rating }}/5</p>
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có sản phẩm.</p>
        @endforelse
    </div>

    <h2 class="qp-section-title">Dịch vụ thú cưng</h2>
    <div class="row mb-4">
        @forelse($services as $service)
            <div class="col-md-3 mb-3">
                <div class="card qp-card h-100">
                    <div class="card-body">
                        <h3 class="h6">{{ $service->name }}</h3>
                        <p class="small text-muted">{{ $service->description }}</p>
                        @if($service->price)
                            <p class="fw-semibold mb-0">Giá từ {{ number_format($service->price, 0, ',', '.') }} đ</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có dịch vụ.</p>
        @endforelse
    </div>

    <h2 class="qp-section-title">Tin tức</h2>
    <div class="row">
        @forelse($posts as $post)
            <div class="col-md-4 mb-3">
                <div class="card qp-card h-100">
                    <div class="card-body">
                        <h3 class="h6"><a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">{{ $post->title }}</a></h3>
                        <p class="small text-muted">{{ $post->excerpt }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>Chưa có bài viết.</p>
        @endforelse
    </div>
@endsection
