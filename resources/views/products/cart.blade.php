@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Shopping Cart</h2>
    @if(session('cart') && count(session('cart')) > 0)
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('cart') as $id => $details)
                    <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group input-group-sm">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" max="99" class="form-control" placeholder="Qty" style="width: 10px; display: inline-block; text-align: center;">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-sm" style="color: white; background-color: #17a2b8;">Update</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>€{{ $details['price'] }}</td>
                        <td>€{{ $details['price'] * $details['quantity'] }}</td>
                        <td>
                            <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="color: white; background-color: #dc3545;">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Continue Shopping</a>
    <div class="row">
        <div class="col-md-12 text-right mb-3">
            <h3>Total: €{{ $totalAmount }}</h3>
            <a href="{{ route('payment') }}" class="btn btn-success">Proceed to Payment</a>
        </div>
    </div>
    @else
    <p>Your cart is empty!</p>
    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">Continue Shopping</a>
    @endif
</div>
@push('scripts')
<script>
    $(document).ready(function () {
        $('.remove-from-cart').click(function () {
            var productId = $(this).data('id');
    
            $.ajax({
                url: `/cart/remove/${productId}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    window.location.reload();
                },
                error: function (response) {
                    alert('Error removing product');
                }
            });
        });
    });
</script>
@endpush
@endsection

