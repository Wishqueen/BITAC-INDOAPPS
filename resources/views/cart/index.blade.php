@extends('layouts.main')

@section('konten')
<br><br>
<section class="section" id="cart">
    <div class="container">
        <h2 class="mb-4">Your Cart</h2>
        @if (empty($cartItems))
            <div class="alert alert-info">Your cart is empty.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item['title'] }}</td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item['course_id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total:</strong></td>
                            <td>${{ number_format($totalPrice, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between mt-4">
                <a href="login" class="btn btn-success">Checkout</a>
            </div>
        @endif
    </div>
</section>
@endsection


