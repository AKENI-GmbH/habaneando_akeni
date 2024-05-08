<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gift Coupon</title>
    <style>
        /* Reset CSS */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            /* White background for better printing */
            color: #333;
            /* Dark text color */
        }

        /* Main container styling */
        .container {
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Logo styling */
        .logo {
            margin-bottom: 10px;
        }

        .logo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .logo h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
            margin-top: -10px;
        }

        /* Event details section */
        .event-details {
            margin-bottom: 32px;
        }

        .event-details h1 {
            font-size: 24px;
            /* Reduced font size for readability */
            color: #333;
            margin-bottom: 10px;
        }

        .event-details p {
            font-size: 16px;
            margin-bottom: 5px;
        }

        /* Coupon section */
        .coupon {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #f7f7f7;
            /* Light gray background */
            border-radius: 10px;
            margin-bottom: 30px;
            position: relative; /* Relative positioning for pseudo-elements */
        }

        .coupon-details {
            flex: 1;
            text-align: left;
        }

        .coupon-details p {
            font-size: 18px;
            /* Adjusted font size */
            margin-bottom: 8px;
        }

        /* Decorative elements for coupon */
        .coupon::before,
        .coupon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 8px;

            /* Red accent color */
            border-radius: 10px;
        }

        .coupon::before {
            top: -8px;
        }

        .coupon::after {
            bottom: -8px;
        }

        /* Message */
        .message {
            font-size: 18px;
            margin-bottom: 30px;
        }

        /* Footer section */
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
        }

        .footer-contact p {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo">
            <h1>Habaneando Salsa Tanzschule</h1>
        </div>

        <!-- Event details section -->
        <div class="event-details">
            <h1>Special Occasion Celebration</h1>
            <p><strong>Date:</strong> January 1, 2025</p>
            <p><strong>Location:</strong> Grand Venue Hall</p>
            <p><strong>Teachers:</strong> John Smith, Sarah Johnson</p>
            <p><strong>Details:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis
                pulvinar ipsum, eu dapibus odio efficitur eget. Sed non leo tincidunt, eleifend arcu ac, tempus risus.
            </p>
        </div>

        <!-- Coupon section -->
        <div class="coupon">
            <div class="coupon-details">
                <p><strong>Recipient:</strong> {{ $recipientName }}</p>
                <p><strong>Gift:</strong> Experience Package</p>
                <p><strong>Expires:</strong> {{ $expiryDate }}</p>
            </div>
        </div>

        <!-- Message -->
        <div class="message">
            <p>{{ $giftMessage }}</p>
        </div>

        <!-- Footer section -->
        <div class="footer">
            <div class="footer-contact">
                <p>Company Name</p>
                <p>Contact: +1 234 567 890</p>
                <p>Address: 123 Street, City, Country</p>
            </div>
        </div>
    </div>
</body>

</html>
