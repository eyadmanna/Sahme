<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بيانات حسابك</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" style="padding: 20px 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; padding: 30px; border-radius: 8px;">
                <tr>
                    <td align="center" style="padding-bottom: 20px;">
                        <h1 style="color: #333333;">مرحباً {{ $user->name }}</h1>
                    </td>
                </tr>
                <tr>
                    <td style="color: #555555; font-size: 16px; line-height: 1.6;">
                        <p>تم إنشاء حسابك بنجاح على منصتنا.</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
                        <p><strong>كلمة المرور:</strong> {{ $plainPassword }}</p>
                        <p style="margin-top: 30px;">
                            <a href="{{ url('admin/login') }}" style="background-color: #3490dc; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;">
                                تسجيل الدخول إلى حسابك
                            </a>
                        </p>
                        <p style="margin-top: 30px;">شكراً لاستخدامك منصتنا.</p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-top: 30px; font-size: 12px; color: #999999;">
                        &copy; {{ date('Y') }} جميع الحقوق محفوظة منصة سهمى
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
