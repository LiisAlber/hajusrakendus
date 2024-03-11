@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Payment Successful</h2>
    <p>Your payment has been processed successfully.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
</div>
@endsection
