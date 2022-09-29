<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	@stack('title')
	<!-- tab icon -->
	<link rel="icon" href="{{ asset('image/logo.png') }}">
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- tab icon -->
	<link rel="icon" href="{{ asset('css/main.css') }}">
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    @stack('css')

</head>

<body>
    <style>
        html, body {
            height: 100%;
            background-color: #f5f7f6;
        }

        .card-header {
            font-size: 20px;
        }

        .card {
            box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
        }

        img{
            width: 100px;
        }
    </style>
    <div class="h-100 d-flex align-items-center justify-content-center" id="main">
        <div class="col-lg-4 p-4">
            <div class="card">
                <div class="card-header">
                    <span class="{{ ($status=='Success!') ? 'text-success' : 'text-danger' }}">{{$status}}</span>
                </div>
                <div class="card-body">
                    @if($type == 'register' || $type == 'recover')
                        <span>We sent your {{$email_type}} link at this email address {{$email}}.</span>
                        
                        <div class="row text-center m-3">
                            <span>
                                <img src="{{ asset('icon/email_sent.svg') }}" alt="email_sent.svg">
                            </span>
                        </div>
                    @elseif($message_type == 'verify')

                        @if($status=='Success!')
                            <span>You are now verified!.</span>
                            
                            <div class="row text-center m-3">
                                <span>
                                    <img src="{{ asset('icon/success.svg') }}" alt="success.svg">
                                </span>
                            </div>
                        @else
                            

                        @endif

                    @endif
                    
                </div>
            </div>
        </div>
    </div>
	
    @stack('script')
</body>
</html>