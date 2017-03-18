<!DOCTYPE html>
<html>
    <head>
        <title>Your page session is expired.</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:200,400" rel="stylesheet" type="text/css">
    <link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 200;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 48px;
                margin-bottom: 20px;
        color: #444;
            }
      a {
        font-weight:normal;
        color:#3061B6;
        text-decoration: none;
      }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <i class="fa fa-clock-o" style="font-size:120px;color:#666;margin-bottom:30px;"></i>
                <div class="title">Your page session is expired.</div>
                <div class="title">Please refresh page.</div>

                <a href="">Refresh Page</a>
            </div>
        </div>
    </body>
</html>
