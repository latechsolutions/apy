<?php $__env->startSection('content'); ?>

<div class="container" >
    <div class="row">
     
      <br /><br /><br /><br /><br />
      <div class="col-md-7 col-md-offset-4 ">
   
      <img src="<?php echo e(url('images/logo.png')); ?>" style="display:inline;z-index:9999" />
  <!--     <h1>
         Welcome to Pandyan Grama Bank 
         <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Atal Pension Yojana Portal
      </h1>
-->
</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>