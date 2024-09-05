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
                    <span class="price h5 text-primary mb-3">${{ number_format($course->price, 2) }}</span>
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
                        <h4>Total: ${{ number_format($course->price, 2) }}</h4>
                        <div class="main-border-button">
                            <form action="{{ route('cart.add', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Add To Cart</button>
                            </form>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection
