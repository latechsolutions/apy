@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row">
    <div class="col-md-3 col-md-offset-4" >
        <form method="post" action="{{ url('volexit') }}/{{ $pranno }}">
    {{ csrf_field() }}
   
            
          
            <div  >
            <label class="control-label" for="pranno">Pran Number : </label>
          <input class="form-control" type="text" id="pranno" name="pranno" value="{{ $pranno }}" readonly /> 
            </div>
          <div >
            <label class="control-label" for="ifsccd">IFSC Code : </label>
            <input class="form-control" type="text" id="ifsccd" name="ifsccd" value="{{ old('ifsccd')?old('ifsccd'):'IOBA0PGB001' }}" />
          </div>
            
          <div >
            <label class="control-label" for="acno">Account Number : </label>
            <input class="form-control" type="text" id="acno" name="acno" value="{{ old('acno') }}" />
          </div>
  
                      
          <div >
            <label class="control-label" for="mobno">Mobile Number : </label>
            <input class="form-control" type="text" id="mobno" name="mobno" value="{{ old('mobno') }}" />
          </div>
             <div>
            <label class="control-label" for="emailid">Email ID : </label>
            <input class="form-control" type="text" id="emailid" name="emailid" value="{{ old('emailid') }}" />
          </div>
          <div style="padding-top:25px">
            
            <button type="submit" class="btn btn-warning form-control" >
              Voluntary Exit
            </button>
          </div>
      </form>
      </div>
    
    </div>
  <div class="row">
          @if($errors->any())
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-6 col-md-offset-3">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     {{ $errors->first() }}

      </p>    
    </div>
     @endif  
            @if(Session::has('message'))
    <div class="alert alert-success alert-dismissable fade in text-center col-md-6 col-md-offset-3">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     {{ Session::get('message') }}

      </p>    
    </div>
     @endif
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-6 col-md-offset-3"  style="display:none" id="errormsg">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 </div>
    
  </div>
</div>
@endsection
