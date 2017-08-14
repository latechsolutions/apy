<?php $__env->startSection('content'); ?>

<div class="container" >
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
    <div class="row">
     <div class="col-md-9 col-md-offset-1">
       <div class="table-responsive">
         <table class="table">
           <thead >
             <tr class="success">
               <th>Pran No.</th>
               <th>Subscriber Name</th>
               <th>Pension Amount</th>
               <th>Application Date</th>
               <th>Action</th>
             </tr>
           </thead>
           <tbody>
             <?php foreach($pranlist as $pran): ?>
             <tr data-pran="<?php echo e($pran->pran_no); ?>">
               <td><?php echo e($pran->pran_no); ?></td><td><?php echo e($pran->sub_name); ?></td><td><?php echo e($pran->pen_amt); ?></td>
               <td><?php echo e($pran->appl_dt); ?></td><td class="col-sm-2">
               <a class="btn btn-primary form-control" href="<?php echo e(url('volexit')); ?>/<?php echo e($pran->pran_no); ?>">Exit</a>
               </td>
             </tr>
             <?php endforeach; ?>
           </tbody>
         </table>
       
<span class="col-md-offset-4"> <?php echo e($pranlist->links()); ?>       </span>
       </div>
      </div>
 

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>