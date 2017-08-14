 <?php $__env->startSection('content'); ?>

<div class="container">
  <div class="row">
    <div class="panel panel-warning">
      <div class="panel-heading">
        Calculation & Deduction of Premium
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-5 col-md-offset-4">


            
            <input type="button" class="btn btn-success" value="Run Deduction" id="rundeduction"></input>
          </div>
        </div>
    
        <hr/>
        <div class="row" style="display:none" id="progressdiv">
          <div class="well well-sm">
            Status of the Job
          </div>

          <div class="progress" style="height:25px">
            <div class="progress-bar progress-bar-success progress-bar-striped active strong" role="progressbar" 
                 aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" s
                 tyle="width:80%;line-height:25px;font-size:18px;color:rgba(255, 0, 0, 0.9)"
                 id="progressbar">

              80%

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
  var jobid;
$(document).ready(

  function(){
$.getJSON("<?php echo e(url('dedpremium/getjobid')); ?>",function(data){
    status=data.status;
      if(status=="running")
        {
    jobid=data.jobid;
    $('#rundeduction').prop("disabled","disabled");
    setInterval(getstatusupdate,5000);
        }
  });
  
$('#rundeduction').click(function(){
  $('#progressbar').css("width","0%");
  $('#progressbar').prop("aria-valuenow","0");
 $('#progressbar').html("0%");
$('#progressdiv').show();
  $.getJSON("<?php echo e(url('dedpremium/start')); ?>",function(data){
    jobid=data.jobid;
    setInterval(getstatusupdate,5000);
  });
  
});
});
  function getstatusupdate()
  {
    $.getJSON("<?php echo e(url('dedpremium/status')); ?>/"+jobid,function(data){
        if(data.comppercent=="100")
        $('#rundeduction').prop("disabled",false);
      $('#progressdiv').show();
        $('#progressbar').css("width",data.comppercent+"%");
 $('#progressbar').html(data.comppercent+"%");
    });
  }
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>