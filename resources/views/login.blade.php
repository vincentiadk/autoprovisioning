<div class="container">
    <form method="POST" action="{{ url('login') }}">
        @csrf
        @include('partials.message')

        <div class="row">
            <img src="{{ asset('assets/static/images/logo_horizontal.svg') }}">
        </div>
        <div class="row">
            <h4>Log In</h4>
            <div class="input-group input-group-icon">
                <input type="text" placeholder="Username / Email" name="username" required
                    value="{{ old('username') }}">
                <div class="input-icon"><i class="fa fa-user"></i></div>
            </div>
            <div class="input-group input-group-icon">
                <input type="password" placeholder="Password" name="password" required>
                <div class="input-icon"><i class="fa fa-key"></i></div>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-primary" style="width:100%">Login</button>
            <div class="sso">
                <a href="{{ url('register') }}" class="page" style="text-align:center">Don't have an account? Register here.</a>
            </div>
        </div>
    </form>
</div>