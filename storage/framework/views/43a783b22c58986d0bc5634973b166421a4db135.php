<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
      <div class="col-md-10 col-sm-offset-1">
        <?php if(session('message')): ?>
        
   <div class="alert alert-danger alert-dismissable">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <?php echo e(session('message')); ?>

        </div>   
        <?php endif; ?>
<div class="panel-group" id="masterdiv">
  <div class="panel panel-warning">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse1">
          <i class="fa fa-plus"></i>
        Generate Voluntary Exit File</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="<?php echo e(url('genvolexitfile')); ?>/newgen">
        <?php echo e(csrf_field()); ?>

          <button type="submit" class="btn btn-primary" >
            Generate File
          </button>
          
        </form>
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse2">
           <i class="fa fa-plus"></i>
        Regenerate Existing File</a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="<?php echo e(url('genvolexitfile')); ?>/regen">
        <?php echo e(csrf_field()); ?>

          <div class="col-md-8">
            <select id="rfname" name="rfname" class="form-control">
              <?php foreach($existingfiles as $file): ?>
              <option value="<?php echo e($file->file_name); ?>"><?php echo e($file->file_name); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-warning">
            Generate File
          </button>
        </form>
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
  
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>