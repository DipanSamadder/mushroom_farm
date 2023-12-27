<!DOCTYPE html>
<html>
<head>
    <title>{{ $content['title'] }}</title>
</head>
<body>

    <p><strong>Dear {{ App\Models\User::where('id', $content['body']['user_id'])->first()->name  }},</strong></p>
    <p>Your One Time Password (OTP) is {{ @$content['body']['otp']  }} and expired at {{ @$content['body']['expire_at']  }}.</p>

</body>
</html>