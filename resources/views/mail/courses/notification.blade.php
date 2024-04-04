<!DOCTYPE html>
<html>

<head>
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        body, html {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333333;
            font-size: 16px;
        }

        .header {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header img {
            max-width: 130px;
            height: auto;
        }

        .slogan {
            font-size: 14px;
            color: #666666;
            margin-top: 10px;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            line-height: 1.5;
        }

        .button {
            background-color: #b51a00;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .footer {
            background-color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #dddddd;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-column {
            flex: 1;
            min-width: 150px;
            margin: 10px;
            text-align: left;
        }

        .footer-column p {
            margin: 5px 0;
        }

        .contact-info {
            font-size: 12px;
        }

        /* Responsive adjustments */
        @media only screen and (max-width: 600px) {
            .header img {
                max-width: 100px; /* Smaller logo on mobile */
            }

            .footer-column {
                flex-basis: 100%;
                max-width: 100%;
                text-align: center;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('images/logo/1579563932.png') }}" alt="Logo">
        <div class="slogan">Salsa und Bachata Tanzschule in Speyer</div>
    </div>

    <div class="content">
        <h1>{{ $course->name }}</h1>
        <p>{{ $bodyMessage }}</p>
        <a href="#" class="button">Button Text</a>
    </div>

    <div class="footer">
        <div class="footer-column">
            <p>© {{ date('Y') }} Habaneando Tanzschule. All rights reserved.</p>
        </div>
        <div class="footer-column">
            <p class="footer-text">Brunckstrasse 8, 67346, Speyer</p>
            <p class="footer-text">Email: info@habaneando.com</p>
            <p class="footer-text">Phone: +49 0176 2329 6739</p>
            <p class="footer-text">Phone: +49 176 8220 1935</p>
        </div>
        <div class="footer-column">
            <p class="footer-text">You are receiving this email because you opted in at our website.</p>
        </div>
    </div>
</body>

</html>
