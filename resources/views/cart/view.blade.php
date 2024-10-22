@extends('layouts.main')

@section('konten')
<div class="container my-5">
    <h2 class="mb-4 font-weight-bold text-center" style="color: #333;">Your Cart</h2>

    @if(session('cart'))
        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm" style="background-color: #fff; border-radius: 8px;">
                <thead class="thead-dark">
                    <tr>
                        <th>Course</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('cart') as $id => $details)
                        @php $subtotal = $details['price'] * $details['quantity']; @endphp
                        <tr>
                            <td class="align-middle">{{ $details['title'] }}</td>
                            <td class="align-middle">Rp{{ number_format($details['price'], 2) }}</td>
                            <td class="align-middle">{{ $details['quantity'] }}</td>
                            <td class="align-middle">Rp{{ number_format($subtotal, 2) }}</td>
                            <td class="align-middle">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 20px;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $subtotal; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-weight-bold">Total</td>
                        <td colspan="2" class="font-weight-bold">Rp{{ number_format($total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url('/courses') }}" class="btn btn-outline-secondary" style="border-radius: 20px; padding: 10px 30px;">Back to Courses</a>
            <a href="{{ route('checkout') }}" class="btn btn-primary" style="background-color: #17a2b8; border: none; border-radius: 20px; padding: 10px 30px;">Proceed to Checkout</a>
        </div>
    @else
        <div class="alert alert-info text-center">Your cart is empty!</div>
        <div class="text-center">
            <a href="{{ url('/courses') }}" class="btn btn-outline-secondary" style="border-radius: 20px; padding: 10px 30px;">Back to Courses</a>
        </div>
    @endif
</div>
@endsection
