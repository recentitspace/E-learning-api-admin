<div class="row d-flex justify-content-center g-4">
    <div class="col-lg-8 col-md-8 text-center">
        <button type="submit" aria-label="Place an order" id="waafipay-button" data-spinning-button
            class="btn b-solid btn-primary-solid btn-xl !rounded-full w-full h-12">{{ translate('Pay with WaafiPay') }}
        </button>
        <!-- This form is hidden -->
        <form action="{{ route('payment.success', 'waafipay') }}" method="GET" hidden id="waafipay-form">
            @csrf
            <input type="text" class="form-control" id="waafipay_reference_id" name="reference_id">
            <input type="text" class="form-control" id="waafipay_response_code" name="response_code">
            <input type="text" class="form-control" id="waafipay_response_msg" name="response_msg">
            <button type="submit" id="waafipay-submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
$(function() {
    $(document).on('click', '#waafipay-button', function(e) {
        e.preventDefault();
        let action = "{{ route('checkout') }}";
        let method = "waafipay";
        let submitButton = $(this);
        let btnText = submitButton.text();
        
        $.ajax({
            method: "POST",
            url: action,
            dataType: "json",
            data: {
                'payment_method': method,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                submitButton.html(`<div class="animate-spin text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M304 48a48 48 0 1 0-96 0a48 48 0 1 0 96 0m0 416a48 48 0 1 0-96 0a48 48 0 1 0 96 0M48 304a48 48 0 1 0 0-96a48 48 0 1 0 0 96m464-48a48 48 0 1 0-96 0a48 48 0 1 0 96 0M142.9 437A48 48 0 1 0 75 369.1a48 48 0 1 0 67.9 67.9m0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437a48 48 0 1 0 67.9-67.9a48 48 0 1 0-67.9 67.9"/>
                    </svg>
                </div> ${btnText}`);
                submitButton.attr("disabled", true);
            },
            success: function(data) {
                if (data.status == "success") {
                    // Handle successful WaafiPay response
                    if (data.waafipay_response && data.waafipay_response.responseCode === '2001') {
                        // Payment successful, redirect to success page
                        document.getElementById('waafipay_reference_id').value = data.reference_id || '';
                        document.getElementById('waafipay_response_code').value = data.waafipay_response.responseCode || '';
                        document.getElementById('waafipay_response_msg').value = data.waafipay_response.responseMsg || '';
                        document.getElementById('waafipay-submit').click();
                    } else if (data.gateway_url) {
                        // Redirect to payment gateway if URL provided
                        location.replace(data.gateway_url);
                    } else {
                        // Show success message and redirect
                        toastr.success(data.message || 'Payment initiated successfully');
                        setTimeout(() => {
                            document.getElementById('waafipay-submit').click();
                        }, 1000);
                    }
                }
                if (data.status == 'error') {
                    submitButton.attr("disabled", false);
                    submitButton.html(btnText);
                    if (data.hasOwnProperty("message")) {
                        toastr.error(data.message);
                    }
                }
            },
            error: function(xhr, status, error) {
                submitButton.attr("disabled", false);
                submitButton.html(btnText);
                toastr.error('Payment failed. Please try again.');
                console.error('WaafiPay Error:', error);
            }
        });
    });
});
</script> 