<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>{{ $data['title'] }}</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
    window.console = window.console || function(t) {};
    </script>

    <script>
    if (document.location.search.match(/type=embed/gi)) {
        window.parent.postMessage("resize", "*");
    }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>

<body translate="no">
    <style>
    .modal-title {
        max-width: 100%;
        margin: 0 0 .4em;
        padding: 0;
        color: #595959;
        font-size: 1.2em;
        font-weight: 400;
        text-align: center;
        text-transform: none;
    }

    .modal-content {
        z-index: 1;
        justify-content: left;
        margin: 0;
        padding: 0;
        color: #545454;
        font-size: 0.8em;
        font-weight: 200;
        line-height: normal;
        text-align: left;
        word-wrap: break-word;
    }
    </style>
    <div id="app">
        <router-view>
        </router-view>
        <input type="hidden" id="loginUserId">
    </div>
    <div id="myContent"></div>
</body>
<script src="{{ asset('js/app.js') }}"></script>

</html>