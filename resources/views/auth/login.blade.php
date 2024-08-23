<div class="wrapper">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        <div class="logo">
            <img src="{{ asset('assets/img/bitac.png') }}" alt="">
        </div>
        <div class="text-center mt-4 name">
            Login
        </div>
        <form class="p-3 mt-3" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <button class="btn mt-3">Login</button>
        </form>
        <div class="text-center fs-6">
            <a href="#">Forget password?</a> or <a href="#">Sign up</a>
        </div>
    </div>