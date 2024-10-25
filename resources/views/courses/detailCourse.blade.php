@extends('layouts.main')

@section('konten')
<br><br>
<!-- Product Section Start -->
<section class="section" id="product">
    <div class="container wow fadeInUp" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-8">
                <div class="left-images">
                    <img src="{{ asset('assets/img/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded mb-4">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="right-content">
                    <h4 class="mb-3">{{ $course->title }}</h4>
                    <span class="price h5 text-primary mb-3">Rp{{ number_format($course->price, 2) }}</span>
                    <ul class="stars list-unstyled d-flex mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <li class="me-1">
                                <i class="fa fa-star {{ $i < $course->rating ? 'text-warning' : 'text-muted' }}"></i>
                            </li>
                        @endfor
                    </ul>
                    <p>{{ $course->description }}</p>
                    <div class="quote p-3 my-3 bg-light rounded">
                        <i class="fa fa-quote-left text-primary me-2"></i>
                        <p class="mb-0">Unlock the secrets of {{ $course->title }} and elevate your digital creations to new heights.</p>
                    </div>
                    <div class="total mb-4">
                        <h4>Total: Rp{{ number_format($course->price, 2) }}</h4>

                        <!-- Kondisi jika role user adalah student -->
                        @if(Auth::check() && Auth::user()->role === 'student')
                            <div class="main-border-button">
                                @php
                                    $cart = session('cart');
                                    $inCart = isset($cart[$course->id]);

                                    // Cek apakah user sudah memiliki transaksi yang dikonfirmasi untuk kursus ini
                                    $transactionFinished = \App\Models\TransactionItem::whereHas('transaction', function($query) {
                                        $query->where('user_id', auth()->id())
                                              ->where('status', 'settlement');
                                    })->where('course_id', $course->id)->exists();
                                @endphp

                                <!-- Disable button jika jumlah siswa = 0 -->
                                @if($course->students <= 0)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Students Full
                                    </button>
                                @elseif($inCart)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Already in Cart
                                    </button>
                                @elseif($transactionFinished)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Already Purchased
                                    </button>
                                @else
                                    <form action="{{ route('cart.add', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">
                                            Add to Cart
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <!-- Jika belum login -->
                            <div class="main-border-button">
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">
                                    Login to Add to Cart
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection
