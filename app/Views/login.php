<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DJ Song Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #050507;
            color: #fff;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        /* Animated Glow Background */
        body::before {
            content: "";
            position: fixed;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, #00f5ff33, #7a00ff22, transparent);
            animation: moveBg 10s infinite linear;
            z-index: 0;
        }

        @keyframes moveBg {
            0% { transform: translate(-25%, -25%); }
            50% { transform: translate(0%, 0%); }
            100% { transform: translate(-25%, -25%); }
        }

        /* Floating particles */
        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: #00f5ff;
            border-radius: 50%;
            opacity: 0.5;
            animation: float linear infinite;
            z-index: 1;
        }

        @keyframes float {
            from { transform: translateY(100vh); }
            to { transform: translateY(-10vh); }
        }

        /* Card */
        .glass-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            padding: 40px 30px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 245, 255, 0.1);
            border: 1px solid rgba(0, 245, 255, 0.1);
        }

        /* Title */
        .neon {
            color: #00f5ff;
            text-shadow: 0 0 10px #00f5ff;
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        /* Floating Inputs */
        .floating-group {
            position: relative;
            margin-bottom: 20px;
        }

        .floating-group input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            outline: none;
            transition: 0.3s;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
        }

        .floating-group label {
            position: absolute;
            left: 15px;
            top: 12px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            transition: 0.3s;
            pointer-events: none;
            opacity: 1;
        }

        .floating-group input:focus + label,
        .floating-group input.has-value + label {
            top: -8px;
            font-size: 0.8rem;
            color: #00f5ff;
            background: #050507;
            padding: 0 5px;
        }

        .floating-group input:focus {
            border-color: #00f5ff;
            box-shadow: 0 0 10px #00f5ff55;
        }

        .floating-group input::placeholder {
            color: transparent;
        }

        /* Remember me checkbox */
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #00f5ff;
        }

        .forgot-password {
            color: #00f5ff;
            text-decoration: none;
            transition: 0.3s;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Button */
        .btn-neon {
            background: linear-gradient(45deg, #00f5ff, #7a00ff);
            border: none;
            border-radius: 30px;
            color: #fff;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
            transition: 0.3s;
            font-size: 1rem;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-neon:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px #00f5ff;
            color: #fff;
            text-decoration: none;
        }

        .btn-neon:active {
            transform: scale(0.98);
        }

        /* Register Link */
        .auth-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .auth-link p {
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .auth-link a {
            color: #00f5ff;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .auth-link a:hover {
            text-shadow: 0 0 10px #00f5ff;
        }

        /* Error Messages */
        .alert {
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.05);
            color: #ff6b6b;
        }

        .alert-success {
            color: #00f5ff;
            background: rgba(0, 245, 255, 0.05);
        }

        /* Icon in input */
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(0, 245, 255, 0.5);
            pointer-events: none;
        }

        .floating-group input:focus ~ .input-icon {
            color: #00f5ff;
        }

        /* Mobile Responsive */
        @media (max-width: 576px) {
            .glass-card {
                padding: 30px 20px;
            }

            .neon {
                font-size: 1.7rem;
            }

            .btn-neon {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .remember-forgot {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<!-- Particles -->
<script>
    for (let i = 0; i < 20; i++) {
        let p = document.createElement("div");
        p.className = "particle";
        p.style.left = Math.random() * 100 + "%";
        p.style.animationDuration = (5 + Math.random() * 5) + "s";
        document.body.appendChild(p);
    }

    // Handle floating labels
    document.querySelectorAll('.floating-group input').forEach(input => {
        // On focus - float up
        input.addEventListener('focus', function() {
            this.classList.add('has-value');
        });

        // On blur - hide label if empty
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.remove('has-value');
            }
        });

        // Initial check on page load
        if (input.value.trim() !== '') {
            input.classList.add('has-value');
        }
    });
</script>

<!-- Login Card -->
<div class="glass-card">
    <h1 class="neon"><i class="fas fa-music"></i> Login</h1>
    <p class="subtitle">Sign in to your account</p>

    <!-- Error Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle"></i> <?php echo session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i> <?php echo session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="/login" novalidate>
        <?= csrf_field() ?>
        <!-- Email/Username Input -->
        <div class="floating-group">
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder=" " 
                required 
                class="form-control"
            >
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <span class="input-icon"><i class="fas fa-check"></i></span>
        </div>

        <!-- Password Input -->
        <div class="floating-group">
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder=" " 
                required 
                class="form-control"
            >
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <span class="input-icon"><i class="fas fa-check"></i></span>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="remember-forgot">
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember" style="margin: 0; cursor: pointer;">Remember me</label>
            </div>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn-neon">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
    </form>

</div>

</body>
</html>
     