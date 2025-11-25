<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject }}</title>
</head>
<body>
    <h2>{{ $subject }}</h2>

    <p>
        @if ($action === 'Accept')
            Congratulations! 🎉 We are pleased to inform you that you have been <strong>Accepted</strong> for the next steps in our hiring process. Further details will be shared soon.
        @elseif ($action === 'Reject')
            Thank you for your interest. After careful consideration, we regret to inform you that you have not been selected this time. We wish you the best of luck in your future endeavors.
        @elseif ($action === 'Pending')
            Your application is currently under review. You are in the <strong>Pending</strong> stage, and we will notify you once a final decision is made.
        @else
            {{ $mailmessage }}
        @endif
    </p>

    <p>Regards,<br>HR Team</p>
    <p>Techvett</p>
</body>
</html>
