<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - DJ Song Request</title>
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
            background: radial-gradient(circle, #00f5ff33, #7a00ff22, transparent);
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

        .success-card {
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            padding: 40px;
            text-align: center;
            max-width: 500px;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background: linear-gradient(45deg, #00f5ff, #7a00ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            box-shadow: 0 0 30px #00f5ff;
        }

        .success-card h2 {
            color: #00f5ff;
            text-shadow: 0 0 10px #00f5ff;
            margin-bottom: 15px;
        }

        .success-card p {
            color: rgba(255,255,255,0.8);
            margin-bottom: 10px;
            font-size: 14px;
        }

        .btn-success {
            background: linear-gradient(45deg, #00f5ff, #7a00ff);
            border: none;
            border-radius: 30px;
            color: #fff;
            padding: 12px 30px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-success:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px #00f5ff;
            color: #fff;
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
    <div class="success-card mx-auto">
        <div class="success-icon">
            ✓
        </div>
        <h2>Payment Successful!</h2>
        <p>Your song request has been received.</p>
        <p>Thank you for your payment. Our DJ will play your song soon!</p>
        <p style="margin-top: 20px; font-size: 12px; color: rgba(255,255,255,0.6);">
            You will receive a confirmation on your registered phone number.
        </p>
        <a href="/" class="btn-success">Back to Home</a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
