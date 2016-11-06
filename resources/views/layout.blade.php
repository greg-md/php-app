<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, maximum-scale=1" />

    <link type="image/png" rel="icon" href="@yield('favicon', $this->img('/favicon.png', 'favicon'))" />

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,500" rel="stylesheet">

    <style>
        html,body {
            margin: 0;
            padding: 0;
            position: relative;
            width: 100%;
            height: 100%;
        }

        body {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            font-family: 'Work Sans', sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        ::selection {
            background: #f60;
            color: #fff;
            text-shadow: none;
        }

        a {
            -webkit-transition:all 0.2s ease-in-out;
            -moz-transition:all 0.2s ease-in-out;
            -o-transition:all 0.2s ease-in-out;
            transition:all 0.2s ease-in-out;
        }

        a,
        a:visited {
            color: #f60;
            text-decoration: none;
            cursor: pointer;
        }

        a:hover {
            color: #ff0007;
        }

        .container {
            position: absolute;
            width: 100%;
            left: 50%;
            top: 50%;
            text-align: center;
            color: #f60;

            -webkit-transform: translateX(-50%) translateY(-50%);
            -moz-transform: translateX(-50%) translateY(-50%);
            -ms-transform: translateX(-50%) translateY(-50%);
            -o-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }

        .title {
            font-size: 48px;
            font-weight: 200;
        }

        nav.menu {
            margin: 50px 0;
        }

        nav.menu a {
            margin: 0 25px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .the-message {
            font-weight: 200;
        }
    </style>

    @stack('head')
</head>

<body>
    @stack('body.start')

    @content

    @stack('scripts')

    @stack('body.end')
</body>
</html>