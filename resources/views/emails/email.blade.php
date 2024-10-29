<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            padding: 40px;
            text-align: center;
            background-color: #ffffff; 
            border-bottom: 4px solid  #c3c3c3;
        }

        .header h1 {
            margin: 0;
            font-size: 24px; 
            font-weight: 600;
            color: #333333; 
        }

        .content {
            padding: 30px;
            font-size: 16px;
            line-height: 1.6;
            color: #555555; 
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: white; 
            background-color: rgb(220, 38, 38); 
            border-top: 4px solid rgb(220, 38, 38);
        }

        .footer h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }

        
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 15px 0;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: rgb(220, 38, 38);
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #b81c1c; 
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Salsa Tanzschule Habaneando</h1>
        </div>
        <div class="content">
            @yield('content')
            <!-- Optional Button Example -->
            <!-- <a href="#" class="button">Call to Action</a> -->
        </div>
        <div class="footer">
            <h2>Salsa Tanzschule Habaneando</h2>
            <p>Brunckstrasse 8</p>
            <p>67346 Speyer</p>
        </div>
    </div>
</body>

</html>