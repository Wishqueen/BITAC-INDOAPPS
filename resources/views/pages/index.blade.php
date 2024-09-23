@extends('layouts.main')
@section('konten')
    <!-- Navbar End -->

    <div class="container-fluid p-0 mb-5">
        <div class="position-relative">
            <div style="max-width: 100%; width: 100%; height: 530px; overflow: hidden;">
                <img class="img-fluid w-100" src="assets/img/carousel-1.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h4 class="display-3 text-white animated slideInDown">Unlock Your Potential with Bali IT Academy!</h4>
                                <p class="fs-5 text-white mb-4 pb-2">Discover your path to a successful tech career with Bali IT 
                                    Academy. Our cutting-edge programs are designed to equip you with the latest skills and 
                                    knowledge in the IT field. Whether you're passionate about coding, cybersecurity, or data 
                                    science, we provide the tools and support to help you achieve your goals. Join a community of 
                                    innovators and start building your future today.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="assets/img/about.jpg" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">About Us</h6>
                    <h1 class="mb-4">Bali IT Academy</h1>
                    <p class="mb-4">Welcome to Bali IT Academy, the best place to develop your skills in Information 
                        Technology. Whether you are a beginner looking to learn the basics of IT or a professional 
                        looking to deepen your expertise, our courses are designed to meet your needs.</p>
                    <h4 class="mb-4">Our Vision</h4>
                    <p class="mb-4">At Bali IT Academy, our vision is to empower every individual with the knowledge and 
                        skills needed to succeed in the ever-evolving IT world. We are committed to providing high-quality 
                        training that is practical and relevant to today’s industry needs.</p>
                    <h4 class="mb-4">Why Choose Us?</h4>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Expert Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Flexible Learning</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>National Certificate</p>
                        </div> <br>
                        <h6 class="mb-4">Join Bali IT Academy and take the first 
                            step towards mastering the skills that will shape the future of technology.</h6>
                </div>
        </div>
    </div>
    @endsection
