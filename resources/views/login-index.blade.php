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
    <!--script src="{{ asset('js/jquery-pjax.js') }}"></script-->
    <script>
    // $(document).pjax('.page', '#pjax-container');
    </script>

</head>

<body translate="no">
    <div id="app">
        <login-form></login-form>
    </div>
</body>
<script src="{{ asset('js/app.js') }}" defer></script>
<!--<body translate="no" id="pjax-container">
    @include($data['content'], $data)
</body>
-->

</html>