<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bali IT Academy</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="p-0 text-primary"><img src="assets/img/bitac.png" alt="" width="150" height="75"></h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index" class="nav-item nav-link active">Home</a>
                <a href="about" class="nav-item nav-link">About</a>
                <a href="courses" class="nav-item nav-link">Courses</a>
                <a href="instructor" class="nav-item nav-link">Instructor</a>
                <!-- Tambahan Fitur Keranjang -->
                <a href="cart.html" class="nav-item nav-link"><i class="fa fa-shopping-cart"></i> Cart</a>
            </div>
            <!-- Fitur Login dan Register -->
            <a href="login" class="btn btn-primary py-4 px-lg-4 d-none d-lg-block">Login</a>
            <a href="register.html" class="btn btn-secondary py-4 px-lg-4 d-none d-lg-block">Register</a>
        </div>
    </nav>
    <!-- Navbar End -->
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

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-globe me-3"></i>www.indoapps.id</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+62 823-4087-6933</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>partners@indoapps.id</p>
                </div>
            </div>
        </div>
        <div class="container text-center">
            <div class="copyright py-3">
                &copy; <a class="border-bottom text-white" href="#">Bali IT Academy</a>, All Right Reserved.
                <br>
                Designed By <a class="border-bottom text-white" href="https://htmlcodex.com">Bali IT Academy</a>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
</body>

</html>
