<!-- JAVASCRIPT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="<?php echo e(URL::asset('/assets/libs/bootstrap/bootstrap.min.js')); ?>"></script>
 <script src="<?php echo e(URL::asset('/assets/libs/metismenu/metismenu.min.js')); ?>"></script>
 <script src="<?php echo e(URL::asset('/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
 <script src="<?php echo e(URL::asset('/assets/libs/node-waves/node-waves.min.js')); ?>"></script>
 <script src="<?php echo e(URL::asset('/assets/libs/waypoints/waypoints.min.js')); ?>"></script>
 <script src="<?php echo e(URL::asset('/assets/libs/jquery-counterup/jquery-counterup.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/scripts.js')); ?>?time=<?php echo e(time()); ?>"></script>
 <?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('external_script'); ?>


 <script type="text/javascript">
  $(".topbar_end .profile_info .profile_img").click(function(){
    $(".profile_data").toggleClass("active");
  });

  // .profile_data other click close
    $(document).on("click", function(event){
        var $trigger = $(".topbar_end .profile_info .profile_img");
        if($trigger !== event.target && !$trigger.has(event.target).length){
        $(".profile_data").removeClass("active");
        }
    });

 </script>
 <?php echo $__env->yieldContent('script-bottom'); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>