            @include('emails.template.mail_header')
                <tr>
                    <td style="background:#7b68ee45;font-size:18px;font-weight:bold;padding:11px">
                        <p>تم إنشاء حسابك بنجاح على منصتنا.</p>
                        <p><strong>البريد الإلكتروني:</strong> {{ $body_data['user']->email }}</p>
                        <p><strong>كلمة المرور:</strong> {{ $body_data['plainPassword'] }}</p>
                        <p style="margin-top: 30px;">
                            <a href="{{ url('admin/login') }}" style="background-color: #3490dc; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;">
                                تسجيل الدخول إلى حسابك
                            </a>
                        </p>
                        <p style="margin-top: 30px;">شكراً لاستخدامك منصتنا.</p>
                    </td>
                </tr>
            @include('emails.template.mail_footer')
                