<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DJ Song Request</title>

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
    overflow-y: auto;
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
}

@keyframes float {
    from { transform: translateY(100vh); }
    to { transform: translateY(-10vh); }
}

/* Card */
.glass-card {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,0.05);
    border-radius: 20px;
    backdrop-filter: blur(15px);
    padding: 15px;
}

/* Title */
.neon {
    color: #00f5ff;
    text-shadow: 0 0 10px #00f5ff;
}

/* Equalizer */
.equalizer {
    display: flex;
    justify-content: center;
    gap: 4px;
    margin-bottom: 15px;
}
.equalizer span {
    width: 4px;
    height: 10px;
    background: #00f5ff;
    animation: bounce 1s infinite;
}
.equalizer span:nth-child(2){animation-delay:.2s;}
.equalizer span:nth-child(3){animation-delay:.4s;}
.equalizer span:nth-child(4){animation-delay:.6s;}
.equalizer span:nth-child(5){animation-delay:.8s;}

@keyframes bounce {
    0%,100%{height:10px;}
    50%{height:25px;}
}

/* Floating Inputs */
.floating-group {
    position: relative;
}
.floating-group input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.05);
    color: #fff;
    outline: none;
    transition: 0.3s;
}
.floating-group label {
    position: absolute;
    left: 12px;
    top: 10px;
    font-size: 12px;
    color: rgba(255,255,255,0.6);
    transition: 0.3s;
    pointer-events: none;
}
.floating-group input:focus + label,
.floating-group input:valid + label {
    top: -8px;
    font-size: 11px;
    color: #00f5ff;
    background: #050507;
    padding: 0 5px;
}
.floating-group input:focus {
    border-color: #00f5ff;
    box-shadow: 0 0 10px #00f5ff55;
}

/* Upload */
.upload-box {
    border: 1px dashed rgba(255,255,255,0.2);
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
}
.upload-box:hover {
    border-color: #00f5ff;
}
#preview {
    max-width: 80%;
    max-height: 120px;
    margin-top: 10px;
    border-radius: 10px;
    display: none;
    object-fit: cover;
}

/* Button */
.btn-neon {
    background: linear-gradient(45deg,#00f5ff,#7a00ff);
    border: none;
    border-radius: 30px;
    color: #fff;
    transition: 0.3s;
}
.btn-neon:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px #00f5ff;
}

/* Mobile Centering */
.container-fluid {
    padding-left: 15px !important;
    padding-right: 15px !important;
}

.row {
    margin-left: 0 !important;
    margin-right: 0 !important;
}

@media (max-width: 768px) {
    .col-sm-8 {
        max-width: 100%;
        flex: 0 0 100%;
        padding: 0 10px;
    }
}
</style>

</head>

<body>

<!-- Particles -->

<script>
for(let i=0;i<20;i++){
    let p=document.createElement("div");
    p.className="particle";
    p.style.left=Math.random()*100+"%";
    p.style.animationDuration=(5+Math.random()*5)+"s";
    document.body.appendChild(p);
}
</script>

<div class="container-fluid" style="height: 100vh; display: flex; align-items: center; justify-content: center; padding: 0; overflow: hidden;">
<div class="row justify-content-center w-100" style="padding: 0 15px;">
<div class="col-lg-5 col-md-6 col-sm-8 col-10">

<div class="text-center mb-2">
    <div class="equalizer">
        <span></span><span></span><span></span><span></span><span></span>
    </div>
    <h4 class="neon mb-1">🎧 DJ REQUEST</h4>
    <small style="font-size: 11px;">Feel the beat. Drop your track.</small>
</div>

<div class="glass-card">

<form id="songForm" enctype="multipart/form-data">

<div class="floating-group mb-2">
    <input type="text" name="name" required autofocus>
    <label>Your Name</label>
</div>

<div class="floating-group mb-2">
    <input type="tel" name="phone" required>
    <label>Phone Number</label>
</div>

<div class="floating-group mb-2">
    <input type="text" name="song_name" required>
    <label>Song Name</label>
</div>

<div class="floating-group mb-2">
    <input type="text" name="singer_name">
    <label>Artist / Singer</label>
</div>

<div class="upload-box mb-2" id="uploadBoxTrigger">
    <div>📸 Tap to upload screenshot</div>
    <img id="preview">
</div>

<input type="file" id="fileInput" name="screenshot" hidden>

<button class="btn btn-neon w-100" style="padding: 8px; font-size: 14px;">
    Submit & Pay 🎶
</button>

</form>

<div id="msg" class="text-center mt-2" style="font-size: 12px;"></div>

</div>

</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
// upload click
$('#uploadBoxTrigger').click(function(){
    $('#fileInput').click();
});

// preview
$('#fileInput').on('change', function(){
    let file=this.files[0];
    if(file){
        let reader=new FileReader();
        reader.onload=e=>{
            $('#preview').attr('src',e.target.result).fadeIn();
        };
        reader.readAsDataURL(file);
    }
});

// submit
$('#songForm').submit(function(e){
    e.preventDefault();

    let formData=new FormData(this);
    $('#msg').html("Processing...");

    $.ajax({
        url:"/submit",
        type:"POST",
        data:formData,
        contentType:false,
        processData:false,
        success:function(res){
            let data=JSON.parse(res);
            if(data.status==='success'){
                openRazorpayCheckout(data.order_id, data.id);
            }else{
                $('#msg').html('<span class="text-danger">'+data.message+'</span>');
            }
        },
        error:function(){
            $('#msg').html('<span class="text-danger">Server error</span>');
        }
    });
});

// Razorpay Checkout
function openRazorpayCheckout(orderId, requestId) {
    let options = {
        "key": "<?php echo getenv('RAZORPAY_KEY_ID') ?? 'your_razorpay_key_id'; ?>",
        "amount": 50000,
        "currency": "INR",
        "name": "DJ Request",
        "description": "Song Request Payment",
        "order_id": orderId,
        "handler": function(response){
            $.ajax({
                url: "/payment-callback",
                type: "POST",
                data: {
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    request_id: requestId
                },
                success: function(res) {
                    let result = JSON.parse(res);
                    if(result.status === 'success') {
                        window.location.href = "/payment-success";
                    } else {
                        window.location.href = "/payment-failed";
                    }
                },
                error: function() {
                    window.location.href = "/payment-failed";
                }
            });
        },
        "prefill": {
            "contact": "",
            "email": ""
        },
        "theme": {
            "color": "#00f5ff"
        },
        "modal": {
            "ondismiss": function() {
                $('#msg').html('<span class="text-warning">Payment cancelled</span>');
            }
        }
    };
    let rzp1 = new Razorpay(options);
    rzp1.open();
}
</script>

</body>
</html>
