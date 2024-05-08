@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Payment Details</h2>
    <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
        @csrf
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>

        <!-- Stripe Elements for Card Details -->
        <div class="mb-3">
            <label for="card-element">Credit or Debit Card</label>
            <div id="card-element" class="form-control">
                <!-- Stripe card Element -->
            </div>
          
            <div id="card-errors" role="alert"></div>
        </div>

        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
  
    var stripe = Stripe('{{ config('services.stripe.public') }}');

    var elements = stripe.elements();

    var style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
        },
    };

    var card = elements.create('card', {style: style});

    card.mount('#card-element');

    card.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
            
                stripeTokenHandler(result.token);
            }
        });
    });

    // Submit the form 
    function stripeTokenHandler(token) {
       
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        
        form.submit();
    }
</script>
@endsection
