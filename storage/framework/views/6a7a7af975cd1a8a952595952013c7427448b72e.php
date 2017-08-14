 <?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(url('css/jquery-ui-1.9.2.custom.min.css')); ?>" /> 
<?php $__env->stopSection(); ?> <?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
        <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-6 col-md-offset-3">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     <?php echo e($errors->first()); ?>


      </p>    
    </div>
     <?php endif; ?>  
            <?php if(Session::has('message')): ?>
    <div class="alert alert-success alert-dismissable fade in text-center col-md-6 col-md-offset-3">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

   <p class="text-center">
     <?php echo e(Session::get('message')); ?>


      </p>    
    </div>
     <?php endif; ?>
    <div class="alert alert-danger alert-dismissable fade in text-center col-md-6 col-md-offset-3"  style="display:none" id="errormsg">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 </div>
    
  </div>
  <form method="post" action="<?php echo e(url('/registersub')); ?>">
    <?php echo e(csrf_field()); ?>

    <div class="row  form-group-sm ">
      <div class="col-md-5 col-md-offset-4 form-inline">
        
          <div class="form-group <?php echo e($errors->has('cbsacno') ? ' has-error' : ''); ?>">
          <label class="control-label" for="cbsacno">CBS A/c Number : </label>
          <input class="form-control" type="text" id="cbsacno" name="cbsacno" value="<?php echo e(old('cbsacno')); ?>" /> 
             <input type="button" class="form-control btn btn-success" value="Get CBS Details" id="getcbsbut" />
            <?php if($errors->has('cbsacno')): ?>
          <span class="help-block">
                                        <strong><?php echo e($errors->first('cbsacno')); ?></strong>
                                    </span> <?php endif; ?>
              
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
              <div class="form-group <?php echo e($errors->has('custid') ? ' has-error' : ''); ?>">
                <label class="control-label" for="custid">Customer Id : </label>
                <label class="control-label" id="custidl" value=""><?php echo e(old('custid')); ?></label>
                <input type="hidden" class="form-control" id="custid" name="custid" value="<?php echo e(old('custid')); ?>" /> <?php if($errors->has('custid')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('custid')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>


            <div class="col-md-12">
              <div class="form-group <?php echo e($errors->has('title') ? ' has-error' : ''); ?>">
                <label class="control-label" for="title">Title : </label>
                <label class="control-label" id="titlel"><?php echo e(old('title')); ?></label>
                <input class="form-control" type="hidden" id="title" name="title" value="<?php echo e(old('title')); ?>"  /> <?php if($errors->has('title')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('title')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group <?php echo e($errors->has('subname') ? ' has-error' : ''); ?>">
                <label class="control-label" for="subname">Subscriber Name : </label>
                <label class="control-label" id="subnamel"> <?php echo e(old('subname')); ?></label>
                <input class="form-control" type="hidden" id="subname" name="subname" value="<?php echo e(old('subname')); ?>" /> <?php if($errors->has('subname')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('subname')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group <?php echo e($errors->has('fthname') ? ' has-error' : ''); ?>">
                <label class="control-label" for="fthname">Father's Name : </label>
                <label class="control-label" id="fthnamel"><?php echo e(old('fthname')); ?> </label>
                <input class="form-control" type="hidden" id="fthname" name="fthname" value="<?php echo e(old('fthname')); ?>" /> <?php if($errors->has('fthname')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('fthname')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('subdob') ? ' has-error' : ''); ?>">
                <label class="control-label" for="subdob">Date Of Birth : </label>
                <label class="control-label" id="subdobl"><?php echo e(old('subdob')); ?> </label>
                <input class="form-control" type="hidden" id="subdob" name="subdob" value="<?php echo e(old('subdob')); ?>" readonly /> <?php if($errors->has('subdob')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('subdob')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('subage') ? ' has-error' : ''); ?>">
                <label class="control-label" for="subage">Age : </label>
                <label class="control-label" id="subagel"><?php echo e(old('subage')); ?> </label>
                <input class="form-control" type="hidden" id="subage" name="subage" value="<?php echo e(old('subage')); ?>" readonly /> <?php if($errors->has('subage')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('subage')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                <label class="control-label" for="gender">Gender : </label>
                <label class="control-label" id="genderl"><?php echo e(old('gender')); ?> </label>
                <input class="form-control" type="hidden" id="gender" name="gender" value="<?php echo e(old('gender')); ?>" />
                </select> <?php if($errors->has('gender')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('gender')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('maristat') ? ' has-error' : ''); ?>">
                <label class="control-label" for="maristat">Marital Status : </label>
                <label class="control-label" id="maristatl"> <?php echo e(old('maristat')); ?> </label>
                <input class="form-control" type="hidden" id="maristat" name="maristat" value="<?php echo e(old('maristat')); ?>" /> <?php if($errors->has('maristat')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('maristat')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group <?php echo e($errors->has('sponame') ? ' has-error' : ''); ?>">
                <label class="control-label" for="sponame">Spouse Name : </label>
                <label class="control-label" id="sponamel"><?php echo e(old('sponame')); ?></label>
                <input class="form-control" type="hidden" id="sponame" name="sponame" value="<?php echo e(old('sponame')); ?>" /> <?php if($errors->has('sponame')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('sponame')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group <?php echo e($errors->has('addr') ? ' has-error' : ''); ?>">
                <label class="control-label" for="addr">Address : </label>
                <label class="control-label" id="addrl"><?php echo e(old('addr')); ?> </label>
                <input class="form-control" type="hidden" id="addr" name="addr" value="<?php echo e(old('addr')); ?>" /> <?php if($errors->has('addr')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('addr')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group <?php echo e($errors->has('addrdist') ? ' has-error' : ''); ?>">
                <label class="control-label" for="addrdist">District/Town/City : </label>
                <label class="control-label" id="addrdistl"><?php echo e(old('addrdist')); ?></label>
                <input class="form-control" type="hidden" id="addrdist" name="addrdist" value="<?php echo e(old('addrdist')); ?>" /> <?php if($errors->has('addrdist')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('addrdist')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group <?php echo e($errors->has('addrpin') ? ' has-error' : ''); ?>">
                <label class="control-label" for="addrpin">PinCode : </label>
                <label class="control-label" id="addrpinl"><?php echo e(old('addrpin')); ?></label>
                <input class="form-control" type="hidden" id="addrpin" name="addrpin" value="<?php echo e(old('addrpin')); ?>" /> <?php if($errors->has('addrpin')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('addrpin')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('addrstut') ? ' has-error' : ''); ?>">
                <label class="control-label" for="addrstut">State/UT : </label>
                <label class="control-label" id="addrstutl">TamilNadu </label>
                <input class="form-control" id="addrstut" name="addrstut" type="hidden" value="29" /> <?php if($errors->has('addrstut')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('addrstut')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('addrcty') ? ' has-error' : ''); ?>">
                <label class="control-label" for="addrcty">Country : </label>
                <label class="control-label" id="addrctyl">India </label>
                <input class="form-control" id="addrcty" name="addrcty" value="IN" type="hidden" /> <?php if($errors->has('addrcty')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('addrcty')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
      <!--      <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('aadhaarno') ? ' has-error' : ''); ?>">
                <label class="control-label" for="aadhaarno">Aadhaar No : </label>
                <label class="control-label" id="aadhaarnol" ><?php echo e(old('aadhaarno')); ?> </label>
                <input class="form-control" id="aadhaarno" name="aadhaarno" value="<?php echo e(old('aadhaarno')); ?>" type="hidden" /> <?php if($errors->has('aadhaarno')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('aadhaarno')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div> -->
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('mobno') ? ' has-error' : ''); ?>">
                <label class="control-label" for="mobno">Mobile No : </label>
                <label class="control-label" id="mobnol"><?php echo e(old('mobno')); ?> </label>
                <input class="form-control" id="mobno" name="mobno" value="<?php echo e(old('mobno')); ?>" type="hidden" /> <?php if($errors->has('mobno')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('mobno')); ?></strong>
                                    </span> <?php endif; ?>
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
              <div class="form-group <?php echo e($errors->has('swavalam') ? ' has-error' : ''); ?>">
                 <label class="control-label" for="swavalam">Swavalamban : </label> 
                
          </select> <?php if($errors->has('swavalam')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('swavalam')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
-->
            <div class="row">
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('otherssch') ? ' has-error' : ''); ?>">
                <label class="control-label" for="otherssch">Social Security Schemes : </label>
                <select class="form-control" id="otherssch" name="otherssch">
            <option value="NA">Select</option>
            <option value="Y" <?php echo e(old('otherssch')=='Y'?'selected':''); ?> >Yes</option>
            <option value="N" <?php echo e(old('otherssch')=='N'?'selected':''); ?> >No</option>
          </select> <?php if($errors->has('otherssch')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('otherssch')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('itpay') ? ' has-error' : ''); ?>">
                <label class="control-label" for="itpay">Income Tax Payer : </label>
                <select class="form-control" id="itpay" name="itpay">
            <option value="NA">Select</option>
            <option value="Y" <?php echo e(old('itpay')=='Y'?'selected':''); ?> >Yes</option>
            <option value="N" <?php echo e(old('itpay')=='N'?'selected':''); ?> >No</option>
          </select> <?php if($errors->has('itpay')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('itpay')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
          </div>
            <div class="row">
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('nomname') ? ' has-error' : ''); ?>">
                <label class="control-label" for="nomname">Nominee Name : </label>
                <input class="form-control" type="text" id="nomname" name="nomname" value="<?php echo e(old('nomname')); ?>" /> <?php if($errors->has('nomname')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('nomname')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group <?php echo e($errors->has('nomdob') ? ' has-error' : ''); ?>">
                <label class="control-label" for="nomdob">Nominee DOB : </label>
                <input class="form-control" type="text" id="nomdob" name="nomdob" value="<?php echo e(old('nomdob')); ?>" readonly/> <?php if($errors->has('nomdob')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('nomdob')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            </div>
            <div class="row">
               <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('nomrel') ? ' has-error' : ''); ?>">
                <label class="control-label" for="nomrel">Nominee Relation : </label>
                <input class="form-control" type="text" id="nomrel" name="nomrel" value="<?php echo e(old('nomrel')); ?>" /> <?php if($errors->has('nomrel')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('nomrel')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group <?php echo e($errors->has('nomage') ? ' has-error' : ''); ?>">
                <label class="control-label" for="nomage">Nominee Age : </label>
                <label class="control-label" id="nomagel" for="nomage"><?php echo e(old('nomage')); ?> </label>
                <input class="form-control" type="hidden" id="nomage" name="nomage" value="<?php echo e(old('nomage')); ?>"  /> <?php if($errors->has('nomage')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('nomage')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
            </div>
         <div class="row">
            <div class="col-md-6">
              <div class="form-group <?php echo e($errors->has('guardname') ? ' has-error' : ''); ?>">
                <label class="control-label" for="guardname">Guardian Name : </label>
                <input class="form-control" type="text" id="guardname" name="guardname" value="<?php echo e(old('guardname')); ?>" /> <?php if($errors->has('guardname')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('guardname')); ?></strong>
                                    </span> <?php endif; ?>
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
              <div class="form-group <?php echo e($errors->has('penamt') ? ' has-error' : ''); ?>">
                <label class="control-label" for="penamt">Pension Amount : </label>
                <select class="form-control" id="penamt" name="penamt" >
            <option value="NA">Select</option>
            <option value="1000" <?php echo e(old('penamt')=='1000'?'selected':''); ?> >1000</option>
            <option value="2000" <?php echo e(old('penamt')=='2000'?'selected':''); ?> >2000</option>
                  <option value="3000" <?php echo e(old('penamt')=='3000'?'selected':''); ?> >3000</option>
                  <option value="4000" <?php echo e(old('penamt')=='4000'?'selected':''); ?> >4000</option>
                  <option value="5000" <?php echo e(old('penamt')=='5000'?'selected':''); ?> >5000</option>
          </select> <?php if($errors->has('penamt')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('penamt')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
                  <div class="col-md-3">
              <div class="form-group <?php echo e($errors->has('payfreq') ? ' has-error' : ''); ?>">
                <label class="control-label" for="payfreq">Frequency : </label>
                <select class="form-control" id="payfreq" name="payfreq" >
            <option value="NA">Select</option>
            <option value="M" <?php echo e(old('payfreq')=='M'?'selected':''); ?> >Monthly</option>
            <option value="Q" <?php echo e(old('payfreq')=='Q'?'selected':''); ?> >Quarterly</option>
                  <option value="H" <?php echo e(old('payfreq')=='H'?'selected':''); ?> >Half-Yearly</option>
                  
          </select> <?php if($errors->has('payfreq')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('payfreq')); ?></strong>
                                    </span> <?php endif; ?>
              </div>
            </div>
                  <div class="col-md-3">
              <div class="form-group <?php echo e($errors->has('contriamt') ? ' has-error' : ''); ?>">
                <label class="control-label" for="contriamt">Contribution : </label>
                <label class="control-label" id="contriamtl" for="contriamt"><?php echo e(old('contriamt')); ?> </label>
                <input class="form-control" type="hidden" id="contriamt" name="contriamt" value="<?php echo e(old('contriamt')); ?>"  /> 
                <?php if($errors->has('contriamt')): ?>
                <span class="help-block">
                                        <strong><?php echo e($errors->first('contriamt')); ?></strong>
                                    </span> <?php endif; ?>
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
<?php $__env->stopSection(); ?> <?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(url('js/jquery-ui-1.9.2.custom.min.js')); ?>"></script>
<script>
  var todaydt = new Date("<?php echo e(Carbon\Carbon::today()->toDateString()); ?>");
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
      if($(document.activeElement).prop("name")=="cbsacno")
        {
          $('#getcbsbut').click();
      e.preventDefault();    
        }
      
    }
  });

    $('#getcbsbut').click(function() {
      if($('#cbsacno').val().length!=15)
        return;
      if(!$.isNumeric($('#cbsacno').val()))
        return;
      $('#loadingdivtext').html("<i class=\"fa fa-spinner fa-spin fa-3x center-align\"></i> Please Wait...Data is being fetched from CBS...");
      $('#loadingdiv').modal({backdrop:"static",keyboard:"false"});
      $.get("<?php echo e(url('/getcbsdetails')); ?>/cid/" + $('#cbsacno').val(), function(data) {
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
    
        $("#cbsacno").prop("readonly", true);
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
          $.getJSON("<?php echo e(url('/getpremium/')); ?>/"+$('#subage').val()+"/"+$('#penamt').val()+"/"+$('#payfreq').val(),
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
           $.getJSON("<?php echo e(url('/getpremium/')); ?>/"+$('#subage').val()+"/"+$('#penamt').val()+"/"+$('#payfreq').val(),
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
        $('#cbsacno').val('');
        $("#cbsacno").prop("readonly", false);
        $('#penamt').val("NA");
        $('#payfreq').val("NA");
    });

  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>