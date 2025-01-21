<!DOCTYPE html>
<html>
<head>
    <title>Proposal Review Notification</title>
</head>
<body>
    <h1>Dear {{ $proposal->speaker->name }},</h1>
    <p>Your proposal titled "<strong>{{ $proposal->title }}</strong>" has been reviewed.</p>
    <p><strong>Review Comments:</strong> {{ $review->comments }}</p>
    <p><strong>Rating:</strong> {{ $review->rating }}/5</p>
    <p>Thank you for your submission.</p>
</body>
</html>
