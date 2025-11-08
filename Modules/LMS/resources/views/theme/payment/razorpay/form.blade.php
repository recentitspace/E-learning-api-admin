<div class="row d-flex justify-content-center g-4">
    <div class="col-lg-8 col-md-8 text-center">
        <button type="submit"aria-label="Place an order" id="rzp-button1" data-spinning-button
            class="btn b-solid btn-primary-solid btn-xl !rounded-full w-full h-12">{{ translate('Pay with Razorpay') }}
        </button>
        <!-- This form is hidden -->
        <form action="{{ route('payment.success', 'razorpay') }}" method="GET" hidden>
            @csrf
            <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
            <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
            <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
            <button type="submit" id="rzp-paymentresponse" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    var options = {
        "key": "{{ $result['razorpayId'] ?? '' }}",
        "amount": "{{ $result['amount'] ?? '' }}",
        "currency": "{{ $result['currency'] ?? '' }}",
        "name": "{{ $result['app_name'] ?? '' }}",
        "description": "{{ $result['app_name'] ?? '' }}",
        "order_id": "{{ $result['orderId'] ?? '' }}",
        'image': "{{ $result['image'] ?? '' }}",
        "handler": function(response) {
            document.getElementById('rzp_paymentid').value = response.razorpay_payment_id;
            document.getElementById('rzp_orderid').value = response.razorpay_order_id;
            document.getElementById('rzp_signature').value = response.razorpay_signature;
            document.getElementById('rzp-paymentresponse').click();
        },
        "prefill": {
            "email": "{{ $result['email'] }} ?? '' ",
            "contact": "{{ $result['contactNumber'] ?? '' }}"
        },
        "notes": {
            "address": "{{ $result['address'] ?? '' }}"
        },
        "theme": {
            "color": "#F37254"
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e) {
        rzp1.open();
        e.preventDefault();
    }
</script>
