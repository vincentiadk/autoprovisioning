<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>OTP Verification</title>
		<meta name="description" content="SBR Teknis">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">
		<!--begin::Fonts -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
				google: {
					"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
				},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
        </script>

        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
		<link rel="shortcut icon" href="{{ asset('images') }}/favicon.ico" />

		<style>
			.kt-login.kt-login--v6 .kt-login__aside {
			    z-index: 2;
			    position: relative;
			}
			.kt-login__logo img {
			    max-height: 3.5vw;
			    margin-top: 2vw;
			    opacity: 0.7;
			}
			.titlelog {
				font-weight: bold;
				margin-bottom: -0.5vw;
				color: #505050;
				text-align: left;
			}
			.titlelog span { font-weight: 300; }
			.logotitle {margin-top: 6.5vw;}
			.kt-login__title {
			    color: #9a9a9a!important;
			    font-size: 1.2vw!important;
			    letter-spacing: 0.1vw;
			}
			.kt-login.kt-login--v6 {
			    background: transparent;
			}
			.kt-login.kt-login--v6 .kt-login__aside { background: transparent; }
			body {background-size: 50% 110%;
			}
			.btn-success { background: #037482; border-color: #037482; }
			.btn-success:hover { background: #025863; border-color: #025863; }
			.kt-login.kt-login--v6 .kt-login__aside .kt-login__wrapper .kt-login__container .kt-login__body {margin-bottom: -6.5vw;}
			@media (max-width: 1024px) {
				html, body {
				    background: #FFF;
				    background-size: cover!important;
				    background-position: 70% 0vw!important;
				}
				.titlelog { font-size: 3.7rem; }
				.kt-login.kt-login--v6 .kt-login__aside .kt-login__wrapper .kt-login__container { width: 360px; }
				.kt-login.kt-login--v6 { background:rgba(255,255,255,.6); }
				.kt-login__title {font-size: 1.3rem!important; }
				.kt-login__logo img { max-height: 3rem; margin-top:5rem;}
			}
			.text-md{
				font-size: 1.15rem;
            }
            .kt-login__header{
                height: 75px;
                width: 100%;
                background-color: #037482;
                color: white;
                display: flex;
                align-items:center;
                font-weight: 500;
                font-size: 2rem;
            }
            .d-icon-left{
                flex:1;
                display: flex;
                justify-content: flex-end;
            }
            .d-icon-left a {
                text-decoration: none;
                color:white;
            }
            .title{
                flex:2;
                display: flex;
                justify-content: center;
            }
            .d-icon-rigth{
                flex:1;
            }
            .cotp__box--input{
                width: 100%;
                color: black;
                padding: 25px 50px;
                display: flex;
                align-items: center;
                flex-direction: column;

            }
            .cotp__form-input{
                width: 50%;
                display: flex;
                align-items: center;
                flex-direction: column;
                margin-bottom: 15px;
            }
            .cotp__text--dest{
                text-align: center;
            }
            .text-black{
                font-weight: 600;
            }
            .otp-number-input{
                width: 150px;
                height: 33px;
                margin: auto;
                margin-right: 2.3px;
                border-top: 0;
                border-left: 0;
                border-right: 0;
                border-bottom: 2px solid rgba(0,0,0,.2);
                padding: 0;
                color: rgba(0,0,0,.7);
                margin-bottom: 0;
                padding-bottom: 0;
                font-size: 28px;
                text-shadow: none;
                box-shadow: none;
                text-align: center;
                background-color: transparent;
                font-weight: 600;
                line-height: 0;
                border-radius: 0;
                border-image-width: 0;
            }
            .otp-number-input:hover{
                outline: none;
                border-bottom: 2px solid #037482;
            }

            .otp-number-input:focus{
                outline: none;
                border-bottom: 2px solid #037482;
            }

            .otp-number-input input:not([value=""]):not(:focus):invalid{
                border-bottom: 2px solid #037482;
            }

            .btn-success:disabled {
                color: rgb(105, 105, 105);
                background-color: #c5c5c5;
                border-color: #c5c5c5;
            }

            .btn-verify{
                width: 250px;
                font-weight: 500;
            }
            .cotp__text__top, .cotp__text__bottom{
                text-align: center;
            }
            .cotp__text--resend{
                color: #025863;
                font-weight: 500;
                cursor: pointer;
            }
		</style>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
                <div class="kt-login__header">
                    <span class="d-icon-left"><a href="{{ url('login') }}">
                        <svg class="text-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="512px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="50px" xml:space="preserve"><polygon points="352,128.4 319.7,96 160,256 160,256 160,256 319.7,416 352,383.6 224.7,256 "/></svg></a></span>
                    <span class="title">Verifikasi</span>
                    <div class="d-icon-rigth"></div>
                </div>
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                    
                    <div class="splash-box cotp__box cotp__box--input">
                    @include('partials.message')
                    <form method="post" action="{{ url('otp/verify') }}" id="form-otp" class="cotp__form-input">
                            @csrf
                            <input name="question" value="1" type="hidden">
    
                            <h2 class="cotp__text--title">Masukkan Kode Verifikasi</h2>
       
                            <?php 
                                $phone=str_repeat('*', strlen($user->phone_number) - 3) . substr($user->phone_number, -3);
                            ?>
                            <p class="cotp__text--dest text-black54 cotp--sms" style="display: block;">
                                Kode verifikasi telah dikirimkan melalui 
                                <br> Telegram ke 
                                <span class="text-black">
                                    {{$phone}}
                                </span>
                                
                            </p>
    
    
                            <div class="control-group text-center mt-10">
                                <noscript>
                                    <div id="otp-fail" class="message message-warning text-center mt-10 mb-0 box-dashed">
                                        <h4>Perhatian!</h4>
                                        <p class="m-0 messages">Mohon aktifkan Javascript pada browser anda agar dapat mengirim OTP.</p>
                                    </div>
                                </noscript>
    
                                <div id="otp-input2" class="row-fluid cotp__container-input">
                                    <p class="text-black54">Kode Verifikasi</p>
                                    <div class="input-append mt-10">
                                        <div class="pincode-input-container">
                                            <input type="tel" id="otp-input" class="otp-number-input mr-10 otp-desktop-input" maxlength="6" placeholder="" name="otp_code" autocomplete="off" pattern="[0-9]*" onkeypress="allowNumbersOnly(event)">

                                            <div id="code-error" class="fs-12 cotp__code-error invisible">Kode yang Anda masukkan salah</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <section class="row-fluid cta-fix">
                                <input id="confirm" name="submit" type="submit" value="Verifikasi" class="py-2 px-3 bg-teal-600 text-white rounded cursor-pointer hover:outline-none hover:bg-teal-700" disabled>
                            </section>
                        </form>
    
    
                        <div class="fs-12 text-black38 cotp__text-count">
                                <p class="fs-12 text-black38 lh-21 cotp__countdown-timer" id="clockdiv">Mohon menunggu 
                                    <b class="cotp--wa seconds" id="countdown-timer">0</b>
                                    <b> detik </b>
                                     untuk mengirim ulang 
                                </p>
                                
                                <div id="resend" style="display: none">
                                    <p class="cotp__text__top" style="">
                                        Tidak menerima kode? 
                                        <br>
                                    </p>
                                    <p class="cotp__text__bottom">
                                        <span class="cotp__text--resend" id="btnResendOtp" style="">
                                            Kirim ulang
                                        </span>
                                    </p>
                                </div>
                                
                        </div>
                        <br>
                        <div class="text-center text-green-800 font-bold"><a href="{{ url('otp/telegram') }}" class="fs-13 fw-600 change-phone">Cara mengaktifkan OTP Telegram</a></div> 
                    </div>
				</div>
			</div>
		</div>	
		<script>
            const otpInput = document.getElementById('otp-input');
            otpInput.addEventListener('input', function(){
                toggleBtnVerify();
            })

            function toggleBtnVerify(){
                const btn = document.getElementById('confirm');
                const otp = document.getElementById('otp-input').value;

                if(otp.length > 5){
                    btn.removeAttribute("disabled");
                }else{
                    btn.setAttribute("disabled","true");
                }
            }

            function allowNumbersOnly(e) {
                var code = (e.which) ? e.which : e.keyCode;
                if (code > 31 && (code < 48 || code > 57)) {
                    e.preventDefault();
                }
            }
        </script>
        
        <script>
            
            function initializeClock(id, time) {
                
                const clock = document.getElementById(id);
                const secondsSpan = clock.querySelector('.seconds');
                let remainTime = time;

                function updateClock() {
                    secondsSpan.innerHTML = ('0' + remainTime).slice(-3);

                    if (remainTime <= 0) {
                        clearInterval(timeinterval);
                        document.getElementById('resend').style.display= "block";
                        document.getElementById('clockdiv').style.display= "none";
                    }

                    remainTime--;
                }

                updateClock();
                const timeinterval = setInterval(updateClock, 1000);
            }

            initializeClock('clockdiv', 180);

            document.getElementById('btnResendOtp').addEventListener('click', function(){
                document.getElementById('resend').style.display= "none";
                document.getElementById('clockdiv').style.display= "block";
                resendRequestOTP();
            })

            function resendRequestOTP(){
                const csrf = document.getElementsByName("csrf-token")[0].getAttribute('content');
                fetch("{{ url('otp/send')}}", {
                    headers: {
                        "X-CSRF-Token": csrf
                    },
                    method: "POST",
                    credentials: "same-origin"
                })
                .then(resp => resp)
                .then(data => {
                    initializeClock('clockdiv', 180);
                });
            }

            var close = document.querySelector(".close");
            close.addEventListener("click", function () {
                this.parentElement.parentElement.removeChild(this.parentElement)
            });
        </script>
</body>

<!-- end::Body -->
</html>
