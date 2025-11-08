<button type="submit" aria-label="Place an order" data-spinning-button
    class="btn b-solid btn-primary-solid btn-xl !rounded-full w-full h-12"
    id="paystackBtn">{{ translate('Pay with Paystack') }}
</button>

<script>
    $(function() {
        $(document).on('click', '#paystackBtn', function(e) {
            e.preventDefault();
            let action = "{{ route('checkout') }}";
            let method = "paystack";
            let submitButton = $(this);
            let btnText = submitButton.text();
            $.ajax({
                method: "POST",
                url: action,
                dataType: "json",
                data: {
                    'payment_method': method
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
                        location.replace(`${data.gateway_url}`);
                    }
                    if (data.status == 'error') {
                        submitButton.attr("disabled", false);
                        submitButton.html(`${btnText}`);
                        if (data.hasOwnProperty("message")) {
                            Command: toastr["error"](`${data.message}`);
                        }
                    }
                },
            })
        })
    })
</script>
