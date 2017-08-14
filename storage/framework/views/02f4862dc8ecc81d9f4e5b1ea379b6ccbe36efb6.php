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
        Generate CBS File</a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="<?php echo e(url('gencbsfile')); ?>/newgen">
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
        <form method="post" action="<?php echo e(url('gencbsfile')); ?>/regen">
        <?php echo e(csrf_field()); ?>

          <div class="col-md-8">
            <select id="rfname" name="rfname" class="form-control">
              <?php foreach($existingfiles as $file): ?>
              <option value="<?php echo e($file->cbs_file_name); ?>"><?php echo e($file->cbs_file_name); ?></option>
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

  <div class="panel panel-warning">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#masterdiv" href="#collapse4">
           <i class="fa fa-plus"></i>
        Upload Response</a>
      </h4>
    </div>
    <div id="collapse4" class="panel-collapse collapse">
      <div class="panel-body">
        <form method="post" action="<?php echo e(url('gencbsfile')); ?>/uploadresponse" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

          <div class="col-md-8">
       <input type="file" name="respfile" value="" id="respfile" />
            <label for="respfile"> Select a file to upload</label> 
           </div>
          <button type="submit" class="btn btn-warning">
            Upload Response
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