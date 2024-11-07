@extends('layouts.main')

@section('konten')
<div class="container my-5">
    <h2 class="mb-4 text-center font-weight-bold" style="color: #333;">Checkout</h2>

    <div class="alert alert-light shadow-sm p-4 rounded" style="background-color: #e3f7fc; border-left: 5px solid #17a2b8;">
        <p><strong>Total Amount:</strong> <span style="color: #17a2b8;">Rp{{ number_format($transaction->amount, 2) }}</span></p>
    </div>

    <form action="{{ route('payment.handle') }}" method="POST" id="payment-form" class="text-center">
        @csrf
        <input type="hidden" name="snapToken" value="{{ $snapToken }}">
        <button type="submit" class="btn btn-lg btn-primary mt-4" style="background-color: #28a745; border: none; border-radius: 50px; padding: 10px 30px; transition: background-color 0.3s;">
            Pay Now
        </button>
    </form>
</div>

<!-- Modal -->
<div id="success_tic" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <a class="close" href="#" data-dismiss="modal">&times;</a>
            <div class="page-body">
                <div class="head">  
                    <h3 style="margin-top:5px;">Payment Successful</h3>
                    <h4>Thank you for your purchase!</h4>
                </div>
                <h1 style="text-align:center;">
                    <div class="checkmark-circle">
                        <div class="background"></div>
                        <div class="checkmark draw"></div>
                    </div>
                </h1>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('payment-form').onsubmit = function (event) {
        event.preventDefault();
        snap.pay(this.snapToken.value, {
            onSuccess: function (result) {
                $('#success_tic').modal('show');
                setTimeout(function() {
                    $('#success_tic').modal('hide');
                    window.location.href = "/my-courses";
                }, 3000);
            },
            onPending: function (result) {
                alert("Waiting for payment confirmation!");
            },
            onError: function (result) {
                alert("Payment failed!");
            }
        });
    };
</script>
@endsection
