<!DOCTYPE html>
<html>
<head>
    <title>New Inquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #1a1a1a; border-bottom: 2px solid #eee; padding-bottom: 10px;">New Package Inquiry</h2>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            @foreach($data as $key => $value)
                @if($key !== '_token' && $key !== 'submit' && $key !== 'InquiryAnswer')
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; width: 40%;">{{ ucwords(str_replace('_', ' ', $key)) }}:</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                </tr>
                @endif
            @endforeach
        </table>

        <div style="margin-top: 30px; font-size: 12px; color: #777; text-align: center;">
            <p>This inquiry was sent from the Umrah Agency Pakistan website contact form.</p>
        </div>
    </div>
</body>
</html>


