<div class="wrapper">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <div class="logo">
        <img src="{{ asset('assets/img/bitac.png') }}" alt="">
    </div>
    <div class="text-center mt-4 name">
        Register
    </div>
    <form class="p-3 mt-3" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span>
            <input type="text" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="email" name="email" id="email" placeholder="Email" required>
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="password" name="password" id="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Password" required>
        
            @error('password')
                <span class="invalid-feedback error-message" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn mt-3">Register</button>
    </form>
    <div class="text-center fs-6">
        <p> <small>Already have an account? </small><a href="login">Sign in</a></p>
    </div>
</div>
