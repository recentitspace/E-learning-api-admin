<!DOCTYPE html>
<html>

<head>
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 5px 0;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            padding: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            color: white !important
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1> {{ translate('Welcome to') }} {{ config('app.name') }}</h1>
        </div>
        <div class="content">
            {!! clean($data['message']) !!}
            <p> {{ translate('Best Regards') }} {{ config('app.name') }} {{ translate('Team') }}</p>
        </div>
    </div>
</body>

</html>
