@extends('layout.authentication')

@push('title')
    <title>Login</title>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('css/authentication.css') }}">

@endpush

@section('content')
    <section class="main">
		<div class="login-container">
			<p class="title">O-JoFI: Login</p>
        	<div class="separator"></div>
        	<p class="welcome-message">An Online Job Finder Platform exclusive for Nasugbueños.</p>

        	<form class="login-form mt-2" method="POST" action="{{ route('Login') }}" id="login_form">
                @csrf

                <div class="form-control">
                    <input class="form-control border" type="text" placeholder="Email" name="email" id="email" value="{{ old('userid') }}">
                </div>
                <div class="error-message text-danger px-3" id="email_error" style="font-size: 14px;">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>

                <div class="form-control">
                    <input class="form-control border" type="password" placeholder="Password" name="pass" id="pass" value="{{ old('pass') }}">
                    <span class="showpassword fa-regular fa-eye-slash"></span>      
                </div>
                <div class="error-message text-danger px-3" id="pass_error" style="font-size: 14px;">
                    @error('pass')
                        {{ $message }}
                    @enderror
                </div>

                <div class="form-control non-input">
                	<a class="forgotPassword" href="{{ route('RecoverView') }}">Forgot Password</a>
                </div>

                <div class="form-control reCaptcha">
                    <div id="g-recaptcha" class="g-recaptcha" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired" data-sitekey="6LcasJsgAAAAADf5Toas_DlBccLh5wyGIzmDmjQi"></div>
                </div>
                
                <button id="btn_proceed" class="submit btn btn-secondary my-4" disabled>
                    <div class="spinner-border spinner-border-sm text-light d-none" role="status" id="lbl_loading_proceed"></div>
                    <span id="lbl_proceed">Login</span>   
                </button>
            </form>

            <p> Don't have an account? Sign Up <a href="{{ route('RegisterView') }}">here</a> <p>
        </div>
	</section>
@endsection

@push('script')
    <script src="{{ asset('js/recaptcha.js') }}"></script>
    <!-- google recaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <script>
        $(document).ready(function(){
            $('#login_form').submit(function(e){
                e.preventDefault();
                
                $('.error-message').html('');
                $('#lbl_loading_proceed').removeClass('d-none');
                $('#lbl_proceed').addClass('d-none'); 
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('Login') }}",
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "email": $('#email').val(),
                        "pass": $('#pass').val(),
                        "_token": "{{csrf_token()}}",
                    }),
                    success: function(response){
                        $('.error-message').html('');
                        response = JSON.parse(response);
                        console.log(response);
                        $('#lbl_loading_proceed').addClass('d-none');
                        $('#lbl_proceed').removeClass('d-none'); 

                        if(response.status == 400){
                            $.each(response.errors, function(key, err_values){
                                $('#'+key+'_error').html(err_values);
                            });
                            // show alert message

                            const modal_body = document.createElement('div');
                            modal_body.innerHTML = response.response['message'];
                            modal_body.setAttribute('class', 'swal-body');

                            swal({
                                title: response.response['title'],
                                content: modal_body, 
                                icon: response.response['icon']
                            });
                        }
                        else{
                            window.location.href = response.redirect_to;
                        }
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endpush