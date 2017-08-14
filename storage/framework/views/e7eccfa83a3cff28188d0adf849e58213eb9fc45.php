<?php $__env->startSection('content'); ?>

<div class="container" >
    <div class="row">
    <div class="col-md-3 col-md-offset-4" >
        <form method="post" action="<?php echo e(url('volexit')); ?>/<?php echo e($pranno); ?>">
    <?php echo e(csrf_field()); ?>

   
            
          
            <div  >
            <label class="control-label" for="pranno">Pran Number : </label>
          <input class="form-control" type="text" id="pranno" name="pranno" value="<?php echo e($pranno); ?>" readonly /> 
            </div>
          <div >
            <label class="control-label" for="ifsccd">IFSC Code : </label>
            <input class="form-control" type="text" id="ifsccd" name="ifsccd" value="<?php echo e(old('ifsccd')?old('ifsccd'):'IOBA0PGB001'); ?>" />
          </div>
            
          <div >
            <label class="control-label" for="acno">Account Number : </label>
            <input class="form-control" type="text" id="acno" name="acno" value="<?php echo e(old('acno')); ?>" />
          </div>
  
                      
          <div >
            <label class="control-label" for="mobno">Mobile Number : </label>
            <input class="form-control" type="text" id="mobno" name="mobno" value="<?php echo e(old('mobno')); ?>" />
          </div>
             <div>
            <label class="control-label" for="emailid">Email ID : </label>
            <input class="form-control" type="text" id="emailid" name="emailid" value="<?php echo e(old('emailid')); ?>" />
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
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>