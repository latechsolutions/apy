<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo e(url('css/bootstrap.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(url('css/font-awesome.min.css')); ?>" />

  <?php echo $__env->yieldContent('styles'); ?>
   <title>APY - Atal Pension Yojana</title> 
  </head>
<body id="app-layout" >
    <nav class="navbar navbar-warning navbar-static-top">
        <div class="container" style="background-image:'<?php echo e(url('images/logo.png')); ?>';">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image 
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    APY
                </a>-->
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo e(url('/home')); ?>">Home</a></li>
                  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-user-o fa-lg"> </i>
                          Subscriber Menu
                          <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li> <a href="<?php echo e(url('registersub')); ?>"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;Register</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('approvenew')); ?>"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Approve</a></li>
                         <li class="divider"></li>
                          <li><a href="<?php echo e(url('findatamod/penupdw')); ?>"><i class="fa fa-arrows-v"></i>&nbsp;&nbsp;&nbsp;&nbsp;Upgrade/Downgrade Pension</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('findatamod/freqmod')); ?>"><i class="fa fa-arrows-v"></i>&nbsp;&nbsp;&nbsp;&nbsp;Modify Frequency</a></li>
                          <li class="divider"></li>
                          <li><a href="#"><i class="fa fa-pencil"></i>&nbsp;&nbsp;&nbsp;&nbsp;Modify Subscriber Details</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('volexit')); ?>"><i class="fa fa-close"></i>&nbsp;&nbsp;&nbsp;&nbsp;Voluntary Exit</a></li>

                        </ul>
                      </li>
                            <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-user-o fa-lg"> </i>
                          Documents
                          <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li> <a href="<?php echo e(url('docs/apysuitemanual.pdf')); ?>" target="blank"><i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;&nbsp;User Manual</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('docs/APY_FAQs.pdf')); ?>" target="blank"><i class="fa fa-file-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;FAQs</a></li>
                         <li class="divider"></li>
                          <li><a href="<?php echo e(url('docs/APY_subscriber_form.pdf')); ?>" target="blank"><i class="fa fa-file-o"></i>
                            &nbsp;&nbsp;&nbsp;&nbsp;New Subscriber Form</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('docs/APY_Voluntary_Exit_Form.pdf')); ?>" target="blank"><i class="fa fa-file-o"></i>
                            &nbsp;&nbsp;&nbsp;&nbsp;Voluntary Exit Form</a></li>
                          

                        </ul>
                      </li>
                <?php if(Session::get('brcode')=='5001'): ?>   
                  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <i class="fa fa-copy fa-lg"> </i>
                          File Gen Menu
                          <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li> <a href="<?php echo e(url('subfilegen')); ?>"><i class="fa fa-file-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Subscriber File</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('dedpremium')); ?>"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Deduct Premium</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('gencbsfile')); ?>"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Generate CBS Vouch File</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('gencontrfile')); ?>"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Contribution File</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('genvolexitfile')); ?>"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Voluntary Exit File</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('genmodfile')); ?>/submod"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Subscriber Modification File</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('genmodfile')); ?>/penupdw"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Pension Modification File</a></li>
                          <li class="divider"></li>
                          <li><a href="<?php echo e(url('genmodfile')); ?>/freqmod"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;&nbsp;&nbsp;Frequency Modification File</a></li>
                          
          <!--                <li class="divider"></li>
                          <li><a href="#"><i class="fa fa-file-text"></i>&nbsp;&nbsp;&nbsp;&nbsp;Subscriber Modify File</a></li>
              -->            
                        </ul>
                      </li>
                  <?php endif; ?>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
            
                    <?php else: ?>
                      <li class="dropdown">
                        <a href="#">Branch Code:<?php echo e(Session::get('brcode')); ?></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>
<script src="<?php echo e(asset('js/jquery.min.js')); ?>" ></script>
  <script src="<?php echo e(url('js/bootstrap.min.js')); ?>" ></script>
  <script src="<?php echo e(url('js/npm.js')); ?>" ></script>
  <?php echo $__env->yieldContent('scripts'); ?>
      </body>
</html>