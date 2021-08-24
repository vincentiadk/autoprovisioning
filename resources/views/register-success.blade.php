<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Auto Provisioning - Log In Form</title>
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <script>
    window.console = window.console || function(t) {};
    </script>

    <script>
    if (document.location.search.match(/type=embed/gi)) {
        window.parent.postMessage("resize", "*");
    }
    </script>


</head>

<body translate="no">
    <div class="container">
            <div class="row">
                <img src="{{ asset('assets/static/images/logo_horizontal.svg') }}">    
            </div>
            <div class="row text-center">
                <h1>Selamat datang, @if(session('register_name')) {{ session()->get('register_name') }} @endif !</h1> 
                <br/>
                <h4> Mohon menunggu konfirmasi dari admin melalui email yang Anda daftarkan untuk status aktifasi akun Anda. </h4>
            </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>
</html>