<div id="paypal-button-container"></div>
<script>
    var success_url = "{{ $result['success_url'] ?? '' }}";
    // Render the PayPal button
    paypal.Button.render({
        // Set your environment
        env: "{{ $result['payment_mode'] ?? 'sandbox' }}",
        style: {
            label: 'buynow',
            fundingicons: true, // optional
            branding: true, // optional
            size: 'small', // small | medium | large | responsive
            shape: 'rect', // pill | rect
            color: 'gold' // gold | blue | silver | black
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox: "{{ $result['sandbox_client_id'] ?? '' }}",
            production: "{{ $result['production_client_id'] ?? '' }}"
        },
        commit: true,
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: "{{ $result['amount'] }}",
                        currency: "{{ $result['currency'] }}"
                    }
                }]
            });
        },
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                window.location = `${success_url} ?= 'payment_id='${data. payment_id }`;
            });
        }
    }, '#paypal-button-container');
</script>
