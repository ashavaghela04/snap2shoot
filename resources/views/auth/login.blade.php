<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Admin Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<section class="section contact-section">
    <div class="container">

        @if(session('error'))
        <div style="background:#f8d7da;color:#721c24;padding:15px 20px;border-radius:8px;margin-bottom:25px;border:1px solid #f5c6cb;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        <div class="contact-grid" style="grid-template-columns: 1fr; max-width:500px; margin:auto;">

            <div class="contact-form-container">

                <h2 class="form-title">Login</h2>

                <form method="POST" action="{{ url('/login') }}" class="contact-form">
                    @csrf

                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email"
                               name="email"
                               required
                               placeholder="admin@gmail.com"
                               value="{{ old('email') }}">

                        @error('email')
                        <span style="color:red;font-size:0.85rem;">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password"
                               name="password"
                               required
                               placeholder="Enter password">

                        @error('password')
                        <span style="color:red;font-size:0.85rem;">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Remember Me</span>
                        </label>
                    </div>


                    <button type="submit" class="btn btn-primary btn-submit">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>

                </form>

            </div>

        </div>

    </div>
</section>

</body>

</html>