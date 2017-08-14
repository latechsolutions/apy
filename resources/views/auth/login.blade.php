<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('css/bootstrap-theme.min.css') }}" />
   <title>APY - Atal Pension Yojana</title> 
  </head>
<body id="app-layout" style="background-color:lightcyan  ">
<div class="container">
  <div class="row">
    <br /><br /><br /><br />
  </div>
    <div class="row ">
      <div class="col-md-8" style="padding:0px">
        <img src="{{ url('images/apybg.png') }}" class="img-responsive"  ></img>
      </div>
        <div class="col-md-4" style="padding:0px;color:black;">
<br /><br /><br /><br />
                    <form class="form-horizontal" id="loginform" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Username </label>

                            <div class="col-md-8">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" 
                                       style="border: 2px solid rebeccapurple;">

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
<br /><br />
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" style="border: 2px solid rebeccapurple;">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
<br />
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" style="border: 2px solid rebeccapurple;"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
<br />
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-5">
                                <button  type="submit" class="btn btn-info col-md-7">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                             <!--   <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a> -->
                            </div>
                        </div>
                    </form>
                 @if($errors->any())
    <div class="row">
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-11 col-md-offset-2">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     {{ $errors->first() }}

      </p>   
    </div>
    
  </div>
    @endif  
                </div>
            </div>
   
    
</div>
<script src="{{ asset('js/jquery.min.js') }}" ></script>
  <script src="{{ url('js/bootstrap.min.js') }}" ></script>
  <script src="{{ url('js/npm.js') }}" ></script>
  <script>
    
  </script>
      </body>
</html>