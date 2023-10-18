<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
    <p>Dear {{ $user->email }},</p> 

    @if ($user->role === 'owner')
        <p>We are thrilled to welcome you to {{ config('app.name') }} – your key to connecting with potential renters and maximizing the potential of your properties. As a property owner, you are an essential part of our community, and we're here to help you make the most of your investments.</p>
        <p>Here's what you can do with your account:</p>

        <ul>
            <li>List your properties and showcase them to our vast network of renters.</li>
            <li>Set your own rental terms, pricing, and availability.</li>
            <li>Communicate with renters and receive inquiries.</li>
            <li>Find qualified tenants and screen applications.</li>
            <li>Enjoy secure payment processing and easily manage rental agreements.</li>
            <li>Our platform is designed to make your property management journey smooth and successful. If you have any questions or need assistance along the way, our support team is just a click away at {{ env('SUPPORT_EMAIL') }}.</li>
        </ul>

        <p>Thank you for choosing {{ config('app.name') }} as your property rental partner. We look forward to helping you find the perfect renters and build a successful property portfolio.</p>
    @elseif ($user->role === 'renter')
        <p>Welcome to {{ config('app.name') }} – your gateway to finding the perfect place to call home. We're excited to have you as part of our community and help you discover your ideal rental property.</p>
        <p>Here's what you can do with your account:</p>

        <ul>
            <li>Search for available properties in your desired location and budget.</li>
            <li>View property details, photos, and amenities.</li>
            <li>Connect with property owners and send inquiries.</li>
            <li>Submit rental applications securely and conveniently.</li>
            <li>Keep track of your favorite listings and application status.</li>
            <li>Whether you're looking for a cozy apartment, a family home, or something unique, we've got you covered. If you have any questions or need assistance with your search, our support team is here to assist you at {{ env('SUPPORT_EMAIL') }}.</li>
        </ul>
        <p>Thank you for choosing {{ config('app.name') }} for your rental journey. We're committed to helping you find the perfect place to live and making the process easy and enjoyable.</p> 
    @endif

    <p>Best regards,</p>
    <p>Administration, {{ config('app.name') }}</p>
</body>
</html>
