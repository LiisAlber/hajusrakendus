@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Our Products</h2>
    <div class="row">
        @foreach ($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow">
              
                @if($product->image)
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 200px; background-color: #f8f9fa;">
                    <i class="fas fa-box-open fa-5x text-secondary"></i> 
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">€{{ number_format($product->price, 2) }}</p>
                    
                    <!-- Quantity selection form -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="input-group mb-3">
                            <input type="number" name="quantity" value="1" min="1" class="form-control" placeholder="Quantity">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
