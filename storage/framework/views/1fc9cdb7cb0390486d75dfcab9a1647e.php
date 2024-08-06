
<!-- staticBackdrop Modal example -->
<div class="modal fade" id="removeModal"    tabindex="-1" role="dialog"
     aria-labelledby="removeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?php echo e(route('leave_types.index')); ?>" method="post" id="removeModalForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('delete'); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="rem">Veriyi Pasife Al</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bu veriyi değiştirmek istediğinize emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Pasife Al</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Kapat</button>

                </div>
            </form>

        </div>
    </div>
</div>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/definations/leave_types/modal.blade.php ENDPATH**/ ?>