<div class="modal fade leave_modal" id="adavancePaymentModal" tabindex="-1" role="dialog" aria-labelledby="adavancePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adavancePaymentModalLabel">Avans Talep Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('payment_requests.store')); ?>" method="post" id="advancePaymentRequestForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">

                    <div class="mb-3 row form_row">
                        <label for="total" class="col-md-2 col-form-label">Tutar (TL)</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="amount" name="amount"  type="text" >
                        </div>
                    </div>
                    <div class="mb-3 row form_row">
                        <label for="total" class="col-md-2 col-form-label">Geçerlilik Tarihi</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="used_date" name="used_date" type="date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-4 col-form-label">Açıklama (opsiyonel)</label>
                        <textarea class="form-control" data-id="comment" name="comment"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary" id="saveButton">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {
        // Form yüklendiğinde geçerlilik tarihini +1 gün olarak ayarla
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        const yyyy = tomorrow.getFullYear();
        const mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Aylar sıfır tabanlıdır
        const dd = String(tomorrow.getDate()).padStart(2, '0');

        const defaultUsedDate = `${yyyy}-${mm}-${dd}`;
        $('#advancePaymentRequestForm [data-id="used_date"]').val(defaultUsedDate);


        function submitAdvancePaymentRequest(event) {
            event.preventDefault();


            $.ajax({
                url: '<?php echo e(route("payment_requests.store")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    payment_type: "ADVANCE_PAYMENT",
                    amount: $('#advancePaymentRequestForm [data-id="amount"]').val(),
                    used_date: $('#advancePaymentRequestForm [data-id="used_date"]').val(),
                    comment: $('#advancePaymentRequestForm [data-id="comment"]').val(),
                },
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Sayfayı yenile
                    } else {
                        if ($('#advancePaymentRequestForm [data-id="alertMessage"]').length == 0) {
                            $('#advancePaymentRequestForm .modal-body').prepend('<div id="alertMessage" class="alert alert-danger" role="alert">' + response.message + '</div>');
                        }
                    }
                },
                error: function () {
                    alert('İzin talebi gönderilirken bir hata oluştu.');
                }
            });
        }

        // Form submit işlemi
        $('#advancePaymentRequestForm').on('submit', submitAdvancePaymentRequest);
    });
</script>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/components/advancePaymentModal.blade.php ENDPATH**/ ?>