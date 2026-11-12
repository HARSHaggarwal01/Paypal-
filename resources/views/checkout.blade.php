<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PayPal Checkout</title>
</head>
<body>
    <h1>PayPal Checkout Example</h1>
    <input type="number" id="amount" placeholder="Enter amount" value="10">
    <div id="paypal-button-container"></div>

    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        paypal.Buttons({
            createOrder: function(data, actions) {
                const amount = document.getElementById('amount').value;
                return fetch("{{ route('paypal.create') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ amount })
                })
                .then(res => res.json())
                .then(order => {
                    return order.id;
                });
            },
            onApprove: function(data, actions) {
                return fetch("{{ route('paypal.capture') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ orderId: data.orderID })
                })
                .then(res => res.json())
                .then(capture => {
                    console.log('Capture result', capture);
                    alert('Payment Successful!');
                });
            },
            onError: function(err) {
                console.error('PayPal error:', err);
                alert('Payment failed!');
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
