@extends('layouts.app') @section('styles')
<link rel="stylesheet" href="{{ url('css/jquery-ui-1.9.2.custom.min.css') }}" /> 
@endsection @section('content')

<div class="container">
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
  <form method="post" action="{{ url('/registersub') }}">
    {{ csrf_field() }}
    <div class="row  form-group-sm ">
      <div class="col-md-9 col-md-offset-3 form-inline">
        
          <div class="form-group {{ $errors->has('cbsacno') ? ' has-error' : '' }}">
         <div class="col-sm-6" style="padding:0px">
            <label class="control-label" for="cbsacno">CBS A/c Number : </label>
         
          <input class="form-control" type="text" id="cbsacno_brcd" name="cbsacno_brcd" value="{{ old('cbsacno_brcd') }}" size="4" /> 
         
            </div>
            <div class="col-sm-3" style="padding:0px">
             <input class="form-control" type="text" id="cbsacno_acno" name="cbsacno_acno" value="{{ old('cbsacno_acno') }}" size="9" /> 
            </div>
            <div class="col-sm-2">
             <input type="button" class="form-control btn btn-success" value="Get CBS Details" id="getcbsbut" />
              </div>
            @if ($errors->has('cbsacno_brcd'))
          <span class="help-block">
                                        <strong>{{ $errors->first('cbsacno_brcd') }}</strong>
                                    </span> @endif
              @if ($errors->has('cbsacno_acno'))
          <span class="help-block">
                                        <strong>{{ $errors->first('cbsacno_acno') }}</strong>
                                    </span> @endif
        </div>

      </div>
  
    </div>
    <hr />
    <div class="row form-group-sm" >
      <div class="col-md-6">


        <div class="panel panel-default">
          <div class="panel-heading">
            CBS Details
          </div>
          <div class="panel-body">
            <div class="col-md-12">
              <div class="form-group {{ $errors->has('custid') ? ' has-error' : '' }}">
                <label class="control-label" for="custid">Customer Id : </label>
                <label class="control-label" id="custidl" value="">{{ old('custid') }}</label>
                <input type="hidden" class="form-control" id="custid" name="custid" value="{{ old('custid') }}" /> @if ($errors->has('custid'))
                <span class="help-block">
                                        <strong>{{ $errors->first('custid') }}</strong>
                                    </span> @endif
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                <label class="control-label" for="title">Title : </label>
                <label class="control-label" id="titlel">{{ old('title') }}</label>
                <input class="form-control" type="hidden" id="title" name="title" value="{{ old('title') }}"  /> @if ($errors->has('title'))
                <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group {{ $errors->has('subname') ? ' has-error' : '' }}">
                <label class="control-label" for="subname">Subscriber Name : </label>
                <label class="control-label" id="subnamel"> {{ old('subname') }}</label>
                <input class="form-control" type="hidden" id="subname" name="subname" value="{{ old('subname') }}" /> @if ($errors->has('subname'))
                <span class="help-block">
                                        <strong>{{ $errors->first('subname') }}</strong>
                                    </span> @endif
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group {{ $errors->has('fthname') ? ' has-error' : '' }}">
                <label class="control-label" for="fthname">Father's Name : </label>
                <label class="control-label" id="fthnamel">{{ old('fthname') }} </label>
                <input class="form-control" type="hidden" id="fthname" name="fthname" value="{{ old('fthname') }}" /> @if ($errors->has('fthname'))
                <span class="help-block">
                                        <strong>{{ $errors->first('fthname') }}</strong>
                                    </span> @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group {{ $errors->has('subdob') ? ' has-error' : '' }}">
                <label class="control-label" for="subdob">Date Of Birth : </label>
                <label class="control-label" id="subdobl">{{ old('subdob') }} </label>
                <input class="form-control" type="hidden" id="subdob" name="subdob" value="{{ old('subdob') }}" readonly /> @if ($errors->has('subdob'))
                <span class="help-block">
                                        <strong>{{ $errors->first('subdob') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('subage') ? ' has-error' : '' }}">
                <label class="control-label" for="subage">Age : </label>
                <label class="control-label" id="subagel">{{ old('subage') }} </label>
                <input class="form-control" type="hidden" id="subage" name="subage" value="{{ old('subage') }}" readonly /> @if ($errors->has('subage'))
                <span class="help-block">
                                        <strong>{{ $errors->first('subage') }}</strong>
                                    </span> @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                <label class="control-label" for="gender">Gender : </label>
                <label class="control-label" id="genderl">{{ old('gender') }} </label>
                <input class="form-control" type="hidden" id="gender" name="gender" value="{{ old('gender') }}" />
                </select> @if ($errors->has('gender'))
                <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('maristat') ? ' has-error' : '' }}">
                <label class="control-label" for="maristat">Marital Status : </label>
                <label class="control-label" id="maristatl"> {{ old('maristat') }} </label>
                <input class="form-control" type="hidden" id="maristat" name="maristat" value="{{ old('maristat') }}" /> @if ($errors->has('maristat'))
                <span class="help-block">
                                        <strong>{{ $errors->first('maristat') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group {{ $errors->has('sponame') ? ' has-error' : '' }}">
                <label class="control-label" for="sponame">Spouse Name : </label>
                <label class="control-label" id="sponamel">{{ old('sponame') }}</label>
                <input class="form-control" type="hidden" id="sponame" name="sponame" value="{{ old('sponame') }}" /> @if ($errors->has('sponame'))
                <span class="help-block">
                                        <strong>{{ $errors->first('sponame') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group {{ $errors->has('addr') ? ' has-error' : '' }}">
                <label class="control-label" for="addr">Address : </label>
                <label class="control-label" id="addrl">{{ old('addr') }} </label>
                <input class="form-control" type="hidden" id="addr" name="addr" value="{{ old('addr') }}" /> @if ($errors->has('addr'))
                <span class="help-block">
                                        <strong>{{ $errors->first('addr') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group {{ $errors->has('addrdist') ? ' has-error' : '' }}">
                <label class="control-label" for="addrdist">District/Town/City : </label>
                <label class="control-label" id="addrdistl">{{ old('addrdist') }}</label>
                <input class="form-control" type="hidden" id="addrdist" name="addrdist" value="{{ old('addrdist') }}" /> @if ($errors->has('addrdist'))
                <span class="help-block">
                                        <strong>{{ $errors->first('addrdist') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group {{ $errors->has('addrpin') ? ' has-error' : '' }}">
                <label class="control-label" for="addrpin">PinCode : </label>
                <label class="control-label" id="addrpinl">{{ old('addrpin') }}</label>
                <input class="form-control" type="hidden" id="addrpin" name="addrpin" value="{{ old('addrpin') }}" /> @if ($errors->has('addrpin'))
                <span class="help-block">
                                        <strong>{{ $errors->first('addrpin') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('addrstut') ? ' has-error' : '' }}">
                <label class="control-label" for="addrstut">State/UT : </label>
                <label class="control-label" id="addrstutl">TamilNadu </label>
                <input class="form-control" id="addrstut" name="addrstut" type="hidden" value="29" /> @if ($errors->has('addrstut'))
                <span class="help-block">
                                        <strong>{{ $errors->first('addrstut') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('addrcty') ? ' has-error' : '' }}">
                <label class="control-label" for="addrcty">Country : </label>
                <label class="control-label" id="addrctyl">India </label>
                <input class="form-control" id="addrcty" name="addrcty" value="IN" type="hidden" /> @if ($errors->has('addrcty'))
                <span class="help-block">
                                        <strong>{{ $errors->first('addrcty') }}</strong>
                                    </span> @endif
              </div>
            </div>
      <!--      <div class="col-md-6">
              <div class="form-group {{ $errors->has('aadhaarno') ? ' has-error' : '' }}">
                <label class="control-label" for="aadhaarno">Aadhaar No : </label>
                <label class="control-label" id="aadhaarnol" >{{ old('aadhaarno') }} </label>
                <input class="form-control" id="aadhaarno" name="aadhaarno" value="{{ old('aadhaarno') }}" type="hidden" /> @if ($errors->has('aadhaarno'))
                <span class="help-block">
                                        <strong>{{ $errors->first('aadhaarno') }}</strong>
                                    </span> @endif
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('mobno') ? ' has-error' : '' }}">
                <label class="control-label" for="mobno">Mobile No : </label>
                <label class="control-label" id="mobnol">{{ old('mobno') }} </label>
                <input class="form-control" id="mobno" name="mobno" value="{{ old('mobno') }}" type="hidden" /> @if ($errors->has('mobno'))
                <span class="help-block">
                                        <strong>{{ $errors->first('mobno') }}</strong>
                                    </span> @endif
              </div>
            </div>




          </div>

        </div>
      </div>



      <div class="col-md-6">
        <div class="panel panel-default" >
          <div class="panel-heading">
            Manual Entry
          </div>
          <div class="panel-body">
            <input type="hidden" class="form-control" id="swavalam" name="swavalam" value="N" />
            <!--
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('swavalam') ? ' has-error' : '' }}">
                 <label class="control-label" for="swavalam">Swavalamban : </label> 
                
          </select> @if ($errors->has('swavalam'))
                <span class="help-block">
                                        <strong>{{ $errors->first('swavalam') }}</strong>
                                    </span> @endif
              </div>
            </div>
-->
            <div class="row">
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('otherssch') ? ' has-error' : '' }}">
                <label class="control-label" for="otherssch">Social Security Schemes : </label>
                <select class="form-control" id="otherssch" name="otherssch">
       <!--     <option value="NA">Select</option> -->
      <!--      <option value="Y" {{ old('otherssch')=='Y'?'selected':'' }} >Yes</option> -->
            <option value="N" {{ old('otherssch')=='N'?'selected':'' }} >No</option>
          </select> @if ($errors->has('otherssch'))
                <span class="help-block">
                                        <strong>{{ $errors->first('otherssch') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('itpay') ? ' has-error' : '' }}">
                <label class="control-label" for="itpay">Income Tax Payer : </label>
                <select class="form-control" id="itpay" name="itpay">
            <option value="NA">Select</option>
            <option value="Y" {{ old('itpay')=='Y'?'selected':'' }} >Yes</option>
            <option value="N" {{ old('itpay')=='N'?'selected':'' }} >No</option>
          </select> @if ($errors->has('itpay'))
                <span class="help-block">
                                        <strong>{{ $errors->first('itpay') }}</strong>
                                    </span> @endif
              </div>
            </div>
          </div>
            <div class="row">
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('nomname') ? ' has-error' : '' }}">
                <label class="control-label" for="nomname">Nominee Name : </label>
                <input class="form-control" type="text" id="nomname" name="nomname" value="{{ old('nomname') }}" /> @if ($errors->has('nomname'))
                <span class="help-block">
                                        <strong>{{ $errors->first('nomname') }}</strong>
                                    </span> @endif
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group {{ $errors->has('nomdob') ? ' has-error' : '' }}">
                <label class="control-label" for="nomdob">Nominee DOB : </label>
                <input class="form-control" type="text" id="nomdob" name="nomdob" value="{{ old('nomdob') }}" readonly/> @if ($errors->has('nomdob'))
                <span class="help-block">
                                        <strong>{{ $errors->first('nomdob') }}</strong>
                                    </span> @endif
              </div>
            </div>
            </div>
            <div class="row">
               <div class="col-md-6">
              <div class="form-group {{ $errors->has('nomrel') ? ' has-error' : '' }}">
                <label class="control-label" for="nomrel">Nominee Relation : </label>
                <input class="form-control" type="text" id="nomrel" name="nomrel" value="{{ old('nomrel') }}" /> @if ($errors->has('nomrel'))
                <span class="help-block">
                                        <strong>{{ $errors->first('nomrel') }}</strong>
                                    </span> @endif
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group {{ $errors->has('nomage') ? ' has-error' : '' }}">
                <label class="control-label" for="nomage">Nominee Age : </label>
                <label class="control-label" id="nomagel" for="nomage">{{ old('nomage') }} </label>
                <input class="form-control" type="hidden" id="nomage" name="nomage" value="{{ old('nomage') }}"  /> @if ($errors->has('nomage'))
                <span class="help-block">
                                        <strong>{{ $errors->first('nomage') }}</strong>
                                    </span> @endif
              </div>
            </div>
            </div>
         <div class="row">
            <div class="col-md-6">
              <div class="form-group {{ $errors->has('guardname') ? ' has-error' : '' }}">
                <label class="control-label" for="guardname">Guardian Name : </label>
                <input class="form-control" type="text" id="guardname" name="guardname" value="{{ old('guardname') }}" /> @if ($errors->has('guardname'))
                <span class="help-block">
                                        <strong>{{ $errors->first('guardname') }}</strong>
                                    </span> @endif
              </div>
            </div>
            </div>
          </div>
        </div>

      </div>
<div class="col-md-6">
          <div class="panel panel-default" >
          <div class="panel-heading">
            Pension Details
          </div>
          <div class="panel-body">
               <div class="row">
            <div class="col-md-4">
              <div class="form-group {{ $errors->has('penamt') ? ' has-error' : '' }}">
                <label class="control-label" for="penamt">Pension Amount : </label>
                <select class="form-control" id="penamt" name="penamt" >
            <option value="NA">Select</option>
            <option value="1000" {{ old('penamt')=='1000'?'selected':'' }} >1000</option>
            <option value="2000" {{ old('penamt')=='2000'?'selected':'' }} >2000</option>
                  <option value="3000" {{ old('penamt')=='3000'?'selected':'' }} >3000</option>
                  <option value="4000" {{ old('penamt')=='4000'?'selected':'' }} >4000</option>
                  <option value="5000" {{ old('penamt')=='5000'?'selected':'' }} >5000</option>
          </select> @if ($errors->has('penamt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('penamt') }}</strong>
                                    </span> @endif
              </div>
            </div>
                  <div class="col-md-3">
              <div class="form-group {{ $errors->has('payfreq') ? ' has-error' : '' }}">
                <label class="control-label" for="payfreq">Frequency : </label>
                <select class="form-control" id="payfreq" name="payfreq" >
            <option value="NA">Select</option>
            <option value="M" {{ old('payfreq')=='M'?'selected':'' }} >Monthly</option>
            <option value="Q" {{ old('payfreq')=='Q'?'selected':'' }} >Quarterly</option>
                  <option value="H" {{ old('payfreq')=='H'?'selected':'' }} >Half-Yearly</option>
                  
          </select> @if ($errors->has('payfreq'))
                <span class="help-block">
                                        <strong>{{ $errors->first('payfreq') }}</strong>
                                    </span> @endif
              </div>
            </div>
                  <div class="col-md-3">
              <div class="form-group {{ $errors->has('contriamt') ? ' has-error' : '' }}">
                <label class="control-label" for="contriamt">Contribution : </label>
                <label class="control-label" id="contriamtl" for="contriamt">{{ old('contriamt') }} </label>
                <input class="form-control" type="hidden" id="contriamt" name="contriamt" value="{{ old('contriamt') }}"  /> 
                @if ($errors->has('contriamt'))
                <span class="help-block">
                                        <strong>{{ $errors->first('contriamt') }}</strong>
                                    </span> @endif
              </div>
            </div>
            </div>
            </div>
  </div>
    </div>

    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <input class="form-control btn btn-danger" type="button" id="resetbut" value="Reset Button" />
        </div>
      </div>
      <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
          <input class="form-control btn btn-warning" type="submit" id="submitbut" value="Register Subscriber" />
        </div>
      </div>
    </div>

  </form>


<!-- Modal -->
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
@endsection @section('scripts')
<script src="{{ url('js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script>
  var todaydt = new Date("{{ Carbon\Carbon::today()->toDateString() }}");
  var yrRange = todaydt.getFullYear() - 100 + ":" + todaydt.getFullYear();
  $(function() {
    $("#nomdob").datepicker({
      maxDate: todaydt,
      yearRange: yrRange,
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd",
      onSelect: function(seldt, dp) {
        var age = calcage(seldt);
        if (age < 18)
          alert("Please provide guardian name since nominee is minor");
        $('#nomagel').text(age);
        $('#nomage').val(age);
      }
    });
  });

  function calcage(dob) {
    var diff = todaydt - (new Date(dob));
    var age = (new Date(diff)).getUTCFullYear() - 1970;
    return age;
  }

  $(document).ready(function() {
     $(document).keypress(function(e) {
    if(e.keyCode == 13) 
    {
      
      if($(document.activeElement).prop("name")=="cbsacno_acno")
        {
          $('#getcbsbut').click();
      e.preventDefault();    
        }
    }
  });
    function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}


    $('#getcbsbut').click(function() {
      //if($('#cbsacno').val().length!=15)
       // return;
      $('#otherssch').val('NA');
      $('#itpay').val('NA');
      $('#nomname').val('');
      $('#nomdob').val('');
      $('#nomrel').val('');
      $('#guardname').val('');
      $('#nomage').val('');
      $('#nomagel').text('');
      $('#penamt').val('NA');
      $('#payfreq').val('NA');
      $('#contriamt').val('');
      $('#contriamtl').text('');

      if(!$.isNumeric($('#cbsacno_brcd').val()) || !$.isNumeric($('#cbsacno_acno').val()))
        return;
      cbsacno=$('#cbsacno_brcd').val()+'01'+pad($('#cbsacno_acno').val(),9);
      $('#loadingdivtext').html("<i class=\"fa fa-spinner fa-spin fa-3x center-align\"></i> Please Wait...Data is being fetched from CBS...");
      $('#loadingdiv').modal({backdrop:"static",keyboard:"false"});
      $.get("{{ url('/getcbsdetails') }}/cid/" + cbsacno, function(data) {
        $('#loadingdiv').modal("hide");
        var obj = jQuery.parseJSON(data);
        if(obj.status=="success")
          {
        $('#custid').val(obj.data.cid);
        $('#custidl').text(obj.data.cid);
        $('#subname').val(obj.data.subname);
        $('#subnamel').text(obj.data.subname);
        $('#fthname').val(obj.data.ftname);
        $('#fthnamel').text(obj.data.ftname);
        $('#subdob').val(obj.data.dob);
        $('#subdobl').text(obj.data.dob);
        $('#subage').val(obj.data.age);
        $('#subagel').text(obj.data.age);
        $('#gender').val(obj.data.sex);
        $('#genderl').text(obj.data.sex);
        $('#maristat').val(obj.data.maristat=='S'?'N':obj.data.maristat=='M'?'Y':'NA');
        $('#maristatl').text(obj.data.maristat=='S'?'Single':obj.data.maristat=='M'?'Married':'NA');
        $('#sponame').val(obj.data.sponame);
        $('#sponamel').text(obj.data.sponame);
        $('#addr').val(obj.data.address);
        $('#addrl').text(obj.data.address);
        $('#addrdist').val(obj.data.district);
        $('#addrdistl').text(obj.data.district);
        $('#addrpin').val(obj.data.pin);
        $('#addrpinl').text(obj.data.pin);
   //     $('#aadhaarno').val(obj.data.aadhaarno);
   //     $('#aadhaarnol').text(obj.data.aadhaarno);
        $('#mobno').val(obj.data.mobile);
        $('#mobnol').text(obj.data.mobile);
        if($('#gender').val()=='M')
          {
          $('#title').val('shri');
            $('#titlel').text('shri');
          }
        else
          {
            if($('#gender').val()=='F' && $('#maristat').val()=='N')
              {
              $('#title').val('kumari');
            $('#titlel').text('kumari');
              }
            if($('#gender').val()=='F' && $('#maristat').val()=='Y')
              {
              $('#title').val('smt');
            $('#titlel').text('smt');
              }
          }
        if(obj.data.mobile=="")
         { $('#errormsg').text("Mobile No missing. Kindly update in CBS"); $('#errormsg').show();}
        if(obj.data.age<18||obj.data.age>39)
          { $('#errormsg').text("Subscriber age not between 18 and 39. Not eligible for the scheme");$('#errormsg').show();}
    
        $("#cbsacno_brcd").prop("readonly", true);
            $("#cbsacno_acno").prop("readonly", true);
          }
        else
          {
            $('#loadingdiv').modal("hide");
            $('#errormsg').text("Error..."+obj.errormsg);
            $('#errormsg').show();
          }
      })
      .error(function(){
            $('#loadingdiv').modal("hide");
          $('#errormsg').text("Error in Fetching CBS Details. Kindly check the CBS Interface");
            $('#errormsg').show();
            
          });
    });
    
    $('#otherssch').change(function(){
      if($('#otherssch').val()=='Y')
        {
         $('#errormsg').text("Subscriber not eligible for APY if covered under other Social Security Schemes");
          $('#errormsg').show();
        }
    });
    
    $('#penamt').change(function(){
      if($('#penamt').val()!="NA" && $('#payfreq').val()!="NA")
        {
                  $('#loadingdivtext').html("<i class=\"fa fa-spinner fa-spin fa-3x center-align\"></i> Please Wait...Premimum Data is being fetched...");
          $('#loadingdiv').modal({backdrop:"static",keyboard:"false"});
          $.getJSON("{{ url('/getpremium/') }}/"+$('#subage').val()+"/"+$('#penamt').val()+"/"+$('#payfreq').val(),
                   function(data){
            if(data.status=="success")
              {$('#loadingdiv').modal("hide");$('#contriamt').val(data.premium);$('#contriamtl').text(data.premium);}
            else
             {$('#loadingdiv').modal("hide"); $('#errormsg').text("Invalid Values Entered.Please check"); $('#errormsg').show();}
          })
          .error(function(){
            $('#loadingdiv').modal("hide");
            alert('Error in Loading the Pension Details. Please Try again after sometime');
          });
        }
      else
        {$('#contriamt').val(0);$('#contriamtl').text(0);}
    });
    $('#payfreq').change(function(){
     if($('#payfreq').val()!="NA" && $('#penamt').val()!="NA")
        {
             $('#loadingdivtext').html("<i class=\"fa fa-spinner fa-spin fa-3x center-align\"></i> Please Wait...Premimum Data is being fetched...");
          $('#loadingdiv').modal({backdrop:"static",keyboard:"false"});
           $.getJSON("{{ url('/getpremium/') }}/"+$('#subage').val()+"/"+$('#penamt').val()+"/"+$('#payfreq').val(),
                   function(data){
if(data.status=="success")
              {$('#loadingdiv').modal("hide"); $('#contriamt').val(data.premium);$('#contriamtl').text(data.premium);}
            else
            {$('#loadingdiv').modal("hide");$('#errormsg').text("Invalid Values Entered.Please check");$('#errormsg').show();}
          })
          .error(function(){
            $('#loadingdiv').modal("hide");
             alert('Error in Loading the Pension Details. Please Try again after sometime');
          });
        }
            else
        {$('#contriamt').val(0);$('#contriamtl').text(0);}
    });
    
    $('#resetbut').click(function(){
        $('#custid').val('');
        $('#custidl').text('');
        $('#title').val('');
        $('#titlel').text('');
        $('#subname').val('');
        $('#subnamel').text('');
        $('#fthname').val('');
        $('#fthnamel').text('');
        $('#subdob').val('');
        $('#subdobl').text('');
        $('#subage').val('');
        $('#subagel').text('');
        $('#gender').val('');
        $('#genderl').text('');
        $('#maristat').val('');
        $('#maristatl').text('');
        $('#sponame').val('');
        $('#sponamel').text('');
        $('#addr').val('');
        $('#addrl').text('');
        $('#addrdist').val('');
        $('#addrdistl').text('');
        $('#addrpin').val('');
        $('#addrpinl').text('');
        $('#mobno').val('');
        $('#mobnol').text('');
        $('#otherssch').val("NA");
        $('#itpay').val("NA");
        $('#nomname').val('');
        $('#nomdob').val('');
        $('#nomage').val('');
        $('#nomagel').text('');
        $('#nomrel').val('');
        $('#guardname').val('');
        $('#cbsacno_brcd').val('');
        $('#cbsacno_acno').val('');
        $("#cbsacno_brcd").prop("readonly", false);
        $("#cbsacno_acno").prop("readonly", false);
        $('#penamt').val("NA");
        $('#payfreq').val("NA");
    });

  });
</script>
@endsection