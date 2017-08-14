<?php $__env->startSection('content'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
				<h3>
					Change Password
				</h3>
				<div class="well" style="background-color:salmon">
					<?php if(count($errors) > 0): ?>
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								<?php foreach($errors->all() as $error): ?>
									<li><?php echo e($error); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
    <?php if(isset($succmsg) && !empty($succmsg)): ?>
  		<div class="alert alert-success">
		 <?php echo e($succmsg); ?>

		 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
 
  </div>
  <?php endif; ?>
					<form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/changepass')); ?>">
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">


						<div class="form-group">
							<label class="col-md-4 control-label">New Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Change Password
								</button>
							</div>
						</div>
					</form>
				</div>
			
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>