<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>OTP Telegram</title>
		<meta name="description" content="SBR Teknis">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
            .cotp__box--change{
                width: 450px;
                color: black;
                padding: 25px 50px;
                display: flex;
                align-items: start;
                flex-direction: column;
            }

            .parent-cotp__box--change{
                width: 100%;
                color: black;
                padding: 25px 50px;
                display: flex;
                align-items: center;
                flex-direction: column;
            }
            .cotp__change-list{
                padding: 15px 5px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 450px;
                border-radius: 4px;
                box-shadow: 1px 1px 3px grey;
                margin-bottom:10px;
                cursor: pointer;
            }
            .cotp__change-list-left{
                font-size: 2em;
                color:gray;
                flex:1;
                display: flex;
                justify-content: center;
            }
            .cotp__change-list-right{
                font-size: 1.25em;
                flex:6;
            }
            .cotp__box--change-method{
                margin-bottom: 5px;
            }

            .cotp__change-list:hover{
                background-color: rgb(247, 247, 247); 
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
                    <span class="d-icon-left"><a href="{{ url('otp/verify')}}">
                        <svg class="text-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="512px" id="Layer_1" version="1.1" viewBox="0 0 512 512" width="50px" xml:space="preserve"><polygon points="352,128.4 319.7,96 160,256 160,256 160,256 319.7,416 352,383.6 224.7,256 "/></svg></a></span>
                    <span class="title">Aktivasi OTP melalui Telegram</span>
                    <div class="d-icon-rigth"></div>
                </div>
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                    <div class="parent-cotp__box--change">
                    <h4 class="cotp__text--method-change">Langkah-langkah Aktivasi</h4>
					<div class="cotp__box--change">
                        <p class="cotp-change--title">
                            1. Cari bot TFA di telegram dengan nama <b>TFA_NITS_Bot</b>.
                        </p>
                        <img src="{{asset('img/frontend/step1.png')}}" class="img-fluid" alt="Langkah pertama" width="350px">
                        <br>
                        <br>
                        <p class="cotp-change--title">
                            2. Klik tombol start atau ketik <b>/start</b>.
                        </p>
                        <img src="{{asset('img/frontend/step2.png')}}" class="img-fluid" alt="Langkah pertama" width="350px">
                        <br>
                        <br>
                        <p class="cotp-change--title">
                            3. Ketik <b>/register</b> lalu masukkan NIK atau Username Anda, ketik <b>/profile</b> untuk melihat profile Anda.
                        </p>
                        <img src="{{asset('img/frontend/step3.png')}}" class="img-fluid" alt="Langkah pertama" width="350px">

                    </div>
                </div>
				</div>
			</div>
		</div>	
		<script>

		</script>	
</body>

<!-- end::Body -->
</html>
