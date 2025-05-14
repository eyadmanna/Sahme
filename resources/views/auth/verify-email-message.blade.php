<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>التحقق من البريد الإلكتروني</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            direction: rtl;
        }
        .message-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .message-box h1 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .success { color: green; }
        .error { color: red; }
        .info { color: #3498db; }
    </style>
</head>
<body>
<div class="message-box">
    @if(session('success'))
        <h1 class="success">{{ session('success') }}</h1>
    @elseif(session('error'))
        <h1 class="error">{{ session('error') }}</h1>
    @elseif(session('info'))
        <h1 class="info">{{ session('info') }}</h1>
    @else
        <h1 class="info">مرحبا بك في صفحة التحقق.</h1>
    @endif

    <br>
    <a href="{{ route('login') }}">الذهاب لتسجيل الدخول</a>
</div>
</body>
</html>
