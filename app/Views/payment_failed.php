<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - DJ Song Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #050507;
            color: #fff;
            overflow-x: hidden;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated Glow Background */
        body::before {
            content: "";
            position: fixed;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, #ff006633, #ff000022, transparent);
            animation: moveBg 10s infinite linear;
            z-index: 0;
        }

        @keyframes moveBg {
            0% { transform: translate(-25%, -25%); }
            50% { transform: translate(0%, 0%); }
            100% { transform: translate(-25%, -25%); }
        }

        .container-fluid {
            position: relative;
            z-index: 2;
        }

        .error-card {
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            padding: 40px;
            text-align: center;
            max-width: 500px;
        }

        .error-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: linear-gradient(45deg, #ff0066, #ff6600);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            box-shadow: 0 0 30px #ff0066;
        }

        .error-card h2 {
            color: #ff0066;
            text-shadow: 0 0 10px #ff0066;
            margin-bottom: 15px;
        }

        .error-card p {
            color: rgba(255,255,255,0.8);
            margin-bottom: 10px;
            font-size: 14px;
        }

        .btn-retry {
            background: linear-gradient(45deg, #ff0066, #ff6600);
            border: none;
            border-radius: 30px;
            color: #fff;
            padding: 12px 30px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
            margin-right: 10px;
        }

        .btn-retry:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px #ff0066;
            color: #fff;
        }

        .btn-home {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 30px;
            color: #fff;
            padding: 12px 30px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-home:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }

        /* Floating particles */
        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: #ff0066;
            border-radius: 50%;
            opacity: 0.5;
            animation: float linear infinite;
        }

        @keyframes float {
            from { transform: translateY(100vh); }
            to { transform: translateY(-10vh); }
        }
    </style>
</head>
<body>

<script>
for(let i=0;i<15;i++){
    let p=document.createElement("div");
    p.className="particle";
    p.style.left=Math.random()*100+"%";
    p.style.animationDuration=(5+Math.random()*5)+"s";
    document.body.appendChild(p);
}
</script>

<div class="container-fluid">
    <div class="error-card mx-auto">
        <div class="error-icon">
            ✕
        </div>
        <h2>Payment Failed</h2>
        <p>Unfortunately, your payment could not be processed.</p>
        <p>Please check your payment details and try again.</p>
        <p style="margin-top: 20px; font-size: 12px; color: rgba(255,255,255,0.6);">
            If you continue to experience issues, please contact support.
        </p>
        <div>
            <a href="/" class="btn-retry">Try Again</a>
            <a href="/" class="btn-home">Back to Home</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
