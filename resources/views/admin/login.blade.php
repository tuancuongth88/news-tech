<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<!-- Latest compiled and minified CSS & JS -->
	  <base href="{{ asset('') }}"></base>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>
	<div class="wrapper">
		<div class="container">
			<div class="form-signin">
				<form action="{{ route('login') }}" method="POST" role="form">
					<legend>Please login</legend>
					{{ csrf_field()}}
					<div class="form-group">
						@if ($errors->has('errlogin'))
							<div class="alert alert-danger">
								{{ $errors->first('errlogin')}}
							</div>
						@endif
						<label for="">Username</label>
						<input type="text" class="form-control" name="username" value="{{ old('username')}}">
						@if( $errors->has('username') )
							<p class="text-warning">{{ $errors->first('username')}}</p>
						@endif
					</div>
					<div class="form-group">
						<label for="">Password</label>
						<input type="password" class="form-control" name="password">
						@if( $errors->has('password') )
							<p class="text-warning">{{ $errors->first('password')}}</p>
						@endif
					</div>
					<div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                    </div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button> 
				</form>
			</div>
		</div>
	</div>
</body>
</html>