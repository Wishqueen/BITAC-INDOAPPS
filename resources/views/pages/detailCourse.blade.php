@extends('layouts.main')
@section('konten')
<br><br>
    <!-- Product Section Start -->
    <section class="section" id="product">
        <div class="container wow fadeInUp" data-wow-delay="0.1s">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-images">
                        <img src="assets/img/uiux.jpg" alt="Product Image 1" class="img-fluid rounded mb-4">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4 class="mb-3">UI/UX Design</h4>
                        <span class="price h5 text-primary mb-3">$75.00</span>
                        <ul class="stars list-unstyled d-flex mb-3">
                            <li class="me-1"><i class="fa fa-star text-warning"></i></li>
                            <li class="me-1"><i class="fa fa-star text-warning"></i></li>
                            <li class="me-1"><i class="fa fa-star text-warning"></i></li>
                            <li class="me-1"><i class="fa fa-star text-warning"></i></li>
                            <li class="me-1"><i class="fa fa-star text-warning"></i></li>
                        </ul>
                        <p>Learn the fundamentals of UI/UX design to create user-friendly and visually appealing digital products. This course covers essential skills such as user research, wireframing, prototyping, and usability testing. Gain hands-on experience with tools like Figma and Adobe XD to design engaging websites and apps.</p>
                        <div class="quote p-3 my-3 bg-light rounded">
                            <i class="fa fa-quote-left text-primary me-2"></i><p class="mb-0">Understand UI/UX design principles.</p>
                        </div>
                        <div class="total mb-4">
                            <h4>Total: $210.00</h4>
                            <div class="main-border-button"><a href="#" class="btn btn-primary w-100">Add To Cart</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    @endsection
