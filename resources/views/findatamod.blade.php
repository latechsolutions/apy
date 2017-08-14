@extends('layouts.app')

@section('content')

<div class="container" >
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
  
    <div class="row">
            <form method="post" action="{{ url('findatamod') }}/{{ $action }}">
        {{ csrf_field() }}
      @if($action=='penupdw')
   <div class="col-md-6 well">
     <h3>
       Pension Upgrade/Downgrade
     </h3>
              <div class="form-group {{ $errors->has('pranno') ? ' has-error' : '' }}">
                <label class="control-label" for="pranno">Pran No : </label>
                <input type="text" class="form-control" id="pranno" name="pranno" value="{{ old('pranno') }}" /> @if ($errors->has('pranno'))
                <span class="help-block">
                                        <strong>{{ $errors->first('pranno') }}</strong>
                                    </span> @endif
              </div>
      <div class="form-group {{ $errors->has('penamt') ? ' has-error' : '' }}">
                <label class="control-label" for="penamt">Pension Amount : </label>
                <select class="form-control" id="penamt" name="penamt" >
            <option value="NA" selected>Select</option>
            <option value="1000">1000</option>
            <option value="2000">2000</option>
                  <option value="3000">3000</option>
                  <option value="4000">4000</option>
                  <option value="5000">5000</option>
          </select> @if ($errors->has('penamt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('penamt') }}</strong>
                                    </span> @endif
              </div>
                   <div class="form-group {{ $errors->has('contramt') ? ' has-error' : '' }}">
                <label class="control-label" for="contramt">Contribution Amount : </label>
                <label class="control-label" id="contramtl" value="">{{ old('contramt') }}</label>
                <input type="hidden" class="form-control" id="contramt" name="contramt" value="{{ old('contramt') }}" /> @if ($errors->has('contramt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('contramt') }}</strong>
                                    </span> @endif
              </div>
     <div class="form-group">
       <button type="submit" class="btn btn-warning form-control">
         Submit
       </button>
     </div>
      </div>
        @endif
       @if($action=='freqmod')
         
              <div class="col-md-6 well">
                     <h3>
                Frequency Upgrade/Downgrade
              </h3>
              <div class="form-group {{ $errors->has('pranno') ? ' has-error' : '' }}">
                <label class="control-label" for="pranno">Pran No : </label>
                <input type="text" class="form-control" id="pranno" name="pranno" value="{{ old('pranno') }}" /> @if ($errors->has('pranno'))
                <span class="help-block">
                                        <strong>{{ $errors->first('pranno') }}</strong>
                                    </span> @endif
              </div>
                  <div class="form-group {{ $errors->has('payfreq') ? ' has-error' : '' }}">
                <label class="control-label" for="payfreq">Frequency : </label>
                <select class="form-control" id="payfreq" name="payfreq" >
            <option value="NA" selected>Select</option>
            <option value="M" >Monthly</option>
            <option value="Q">Quarterly</option>
                  <option value="H">Half-Yearly</option>
                  
          </select> @if ($errors->has('payfreq'))
                <span class="help-block">
                                        <strong>{{ $errors->first('payfreq') }}</strong>
                                    </span> @endif
              </div>
                  <div class="form-group {{ $errors->has('contramt') ? ' has-error' : '' }}">
                <label class="control-label" for="contramt">Contribution Amount : </label>
                <label class="control-label" id="contramtl" value="">{{ old('contramt') }}</label>
                <input type="hidden" class="form-control" id="contramt" name="contramt" value="{{ old('contramt') }}" /> @if ($errors->has('contramt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('contramt') }}</strong>
                                    </span> @endif
              </div>
                <div class="form-group">
       <button type="submit" class="btn btn-warning form-control">
         Submit
       </button>
     </div>
              </div>
        @endif
      </form>
    </div>
  <div id="loadingdiv" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="background:none">
      <div class="modal-body " style="width:700px">

     <p class="h3 center-align" id="loadingdivtext">
       
           
        </p>
      </div>
      </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function(){
   $('#penamt').change(function(){
      if($('#penamt').val()!="NA")
        {
          if($('#pranno').val()=="")
            {
              alert ("Enter Pran No First");
              $('#penamt').val("NA");
              return;
            }
                  $('#loadingdivtext').html("<i class=\"fa fa-spinner fa-spin fa-3x center-align\"></i> Please Wait...Premimum Data is being fetched...");
          $('#loadingdiv').modal({backdrop:"static",keyboard:"false"});
          $.getJSON("{{ url('/getmodpremium/penupdw') }}/"+$('#penamt').val()+"/"+$('#pranno').val(),
                   function(data){
            if(data.status=="success")
              {$('#loadingdiv').modal("hide");$('#contramt').val(data.premium);$('#contramtl').text(data.premium);}
            else
             {$('#loadingdiv').modal("hide"); $('#errormsg').text("Invalid Values Entered.Please check"); $('#errormsg').show();}
          })
          .error(function(){
            $('#loadingdiv').modal("hide");
            alert('Error in Loading the Pension Details. Please Try again after sometime');
          });
        }
      else
        {$('#contramt').val(0);$('#contramtl').text(0);}
    });
    
    $('#payfreq').change(function(){
      if($('#payfreq').val()!="NA")
        {
          if($('#pranno').val()=="")
            {
              alert ("Enter Pran No First");
              $('#payfreq').val("NA");
              return;
            }
                  $('#loadingdivtext').html("<i class=\"fa fa-spinner fa-spin fa-3x center-align\"></i> Please Wait...Premimum Data is being fetched...");
          $('#loadingdiv').modal({backdrop:"static",keyboard:"false"});
          $.getJSON("{{ url('/getmodpremium/freqmod') }}/"+$('#payfreq').val()+"/"+$('#pranno').val(),
                   function(data){
            if(data.status=="success")
              {$('#loadingdiv').modal("hide");$('#contramt').val(data.premium);$('#contramtl').text(data.premium);}
            else
             {$('#loadingdiv').modal("hide"); $('#errormsg').text("Invalid Values Entered.Please check"); $('#errormsg').show();}
          })
          .error(function(){
            $('#loadingdiv').modal("hide");
            alert('Error in Loading the Pension Details. Please Try again after sometime');
          });
        }
      else
        {$('#contramt').val(0);$('#contramtl').text(0);}
    });
  });
</script>
@endsection




