<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Together Now  - Send OTP</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #445260; color: #FFFFFF;">
    <table cellpadding="0" cellspacing="0" width="100%" align="center" style="background-color: #fff; width: 100%;">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#445260" style="padding: 20px 0;">
                            <!-- Add your logo image here -->
                            <img src="{{ $message->embed(public_path('img/officialLogo.png')) }}" alt="RateMyPeers Logo" width="40" style="display: block; margin: 0 auto;">
                            <h1 style="font-size: 24px; margin: 0; color: #FFFFFF;">Rate Together Now </h1>
                        </td>

                    </tr>
                    <!-- Content -->
                    <tr>
                        <td bgcolor="#FFFFFF" style="padding: 40px 30px;">
                            <p style="font-size: 16px; margin-top: 20px; color: #333333;">
                                Hi,
                            </p>
                            <p style="font-size: 16px; color: #333333;">
                                Thank you for choosing <b>Rate Together Now </b> to support your organizational needs. For your account's security, we have generated a One-Time Password (OTP) to complete your verification process.
                            </p>
                            <div style="font-size: 36px; font-weight: bold; text-align: center; padding: 20px 0; border: 2px dashed #445260; color: #445260;">
                                Your OTP Code: {{ $otp }}
                            </div>
                            <p style="font-size: 16px; color: #333333;">
                                Please enter this code to verify your identity and complete the verification process. This helps us protect your account and ensure that only authorized users can access it.
                            </p>
                            <p style="font-size: 16px; color: #333333;">
                                If you did not request this OTP or suspect any unauthorized activity, please contact our support team immediately at <a href="mailto:support@ratemypeers.com">support@RateTogetherNow .com</a>.
                            </p>
                            <p style="font-size: 16px; color: #333333;">
                                Thank you for trusting <b>Rate Together Now </b>  to support your organizational goals. We look forward to helping you achieve success.
                            </p>
                            <p style="font-size: 16px; margin-top: 20px; color: #333333;">
                                Best Regards,
                            </p>
                            <p style="font-size: 16px; margin-top: 20px; color: #333333;">
                                <!-- CEO Name Here  -->
                            </p>
                            <p style="font-size: 16px; color: #333333; margin-top: -13px;">
                                The Rate Together Now  Team
                            </p>
                            <p style="font-size: 16px; color: #333333; margin-top: -13px;">
                                {{url('/')}}
                            </p>
                            <p style="font-size: 16px; color: #333333; margin-top: -13px;">
                                <a href="mailto:support@ratemypeers.com">support@Rate Together Now .com</a>
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#445260" align="center" style="padding: 20px 0;">
                            <p style="font-size: 14px; color: #FFFFFF;">If you have any questions or need assistance, please contact our support team at <a href="mailto:support@ratemypeers.com" style="color: #FFFFFF; text-decoration: none;">support@Rate Together Now .com</a></p>
                            <p style="font-size: 14px; color: #FFFFFF;">&copy; {{date('Y')}} Rate Together Now . All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
