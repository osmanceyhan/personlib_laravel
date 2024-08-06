<div class="modal fade leave_modal" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveModalLabel">İzin Talep Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('leave_requests.store')); ?>" method="post" id="leaveRequestForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3 row form_row">
                        <label for="leave_type_id" class="col-md-2 col-form-label">İzin Türü</label>
                        <div class="col-md-10">
                            <div class="select2-full">
                                <select class="select2 form-control" data-id="leave_type_id" name="leave_type_id">
                                    <?php $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($leaveType->id); ?>"><?php echo e($leaveType->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row form_row">
                        <label for="total" class="col-md-2 col-form-label">Toplam</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="total" name="total" value="1 Gün" type="text" readonly>
                        </div>
                    </div>
                    <div class="row form_row">
                        <div class="col-md-6">
                            <label>Başlangıç Tarihi</label>
                            <div class="row">
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <input class="form-control" data-id="start_date" name="start_date" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" data-id="start_time" name="start_time" type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Bitiş Tarihi</label>
                            <div class="row">
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <input class="form-control" data-id="end_date" name="end_date" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" data-id="end_time" name="end_time" type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-md-2 col-form-label">Açıklama</label>
                        <textarea class="form-control" data-id="comment" name="comment"></textarea>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Yerine Bakacak Kişi</label>
                                <div class="col-12 w-full select2-full">
                                    <select class="select2 form-control" data-id="person_replace_id" name="person_replace_id">
                                        <option value="">Seçiniz</option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dönüş Tarihi</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" data-id="return_date" name="return_date" type="date">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" data-id="return_time" name="return_time" type="time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary" data-id="saveButton">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function calculateTotal() {
        const leaveType = $('#leaveModal [data-id="leave_type_id"]').val();
        const startDate = $('#leaveModal [data-id="start_date"]').val();
        const startTime = $('#leaveModal [data-id="start_time"]').val();
        const endDate = $('#leaveModal [data-id="end_date"]').val();
        const endTime = $('#leaveModal [data-id="end_time"]').val();

        if (leaveType && startDate && startTime && endDate && endTime) {
            $.ajax({
                url: '<?php echo e(route("leave_requests_calc")); ?>',
                method: 'GET',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    leave_type_id: leaveType,
                    start_date: startDate,
                    start_time: startTime,
                    end_date: endDate,
                    end_time: endTime
                },
                success: function (response) {
                    $('#leaveModal [data-id="total"]').val(response.total + ' Gün /  (Kalan : '+response.remaining_days+' Gün)' );

                    if (response.success) {
                        $('#leaveModal [data-id="saveButton"]').prop('disabled', false);
                        $('#leaveModal [data-id="alertMessage"]').remove();
                    } else {
                        $('#leaveModal [data-id="saveButton"]').prop('disabled', true);
                        if ($('#leaveModal [data-id="alertMessage"]').length == 0) {
                            $('#leaveModal .modal-body').prepend('<div data-id="alertMessage" class="alert alert-danger" role="alert">' + response.message + '</div>');
                        }
                    }
                }
            });
        }
    }

    function submitLeaveRequest(event) {
        event.preventDefault();

        const leaveType = $('#leaveModal [data-id="leave_type_id"]').val();
        const startDate = $('#leaveModal [data-id="start_date"]').val();
        const startTime = $('#leaveModal [data-id="start_time"]').val();
        const endDate = $('#leaveModal [data-id="end_date"]').val();
        const endTime = $('#leaveModal [data-id="end_time"]').val();
        const comment = $('#leaveModal [data-id="comment"]').val();
        const personReplaceId = $('#leaveModal [data-id="person_replace_id"]').val();
        const returnDate = $('#leaveModal  [data-id="return_date"]').val();
        const returnTime = $('#leaveModal  [data-id="return_time"]').val();

        $.ajax({
            url: '<?php echo e(route("leave_requests.store")); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                leave_type_id: leaveType,
                start_date: startDate,
                start_time: startTime,
                end_date: endDate,
                end_time: endTime,
                comment: comment,
                person_replace_id: personReplaceId,
                return_date: returnDate,
                return_time: returnTime
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Sayfayı yenile
                } else {
                    if ($('#leaveModal [data-id="alertMessage"]').length == 0) {
                        $('#leaveModal .modal-body').prepend('<div data-id="alertMessage" class="alert alert-danger" role="alert">' + response.message + '</div>');
                    }
                }
            },
            error: function () {
                alert('İzin talebi gönderilirken bir hata oluştu.');
            }
        });
    }

    $(document).ready(function () {
        // Yarının tarihini al
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        const yyyy = tomorrow.getFullYear();
        const mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Aylar sıfır tabanlıdır
        const dd = String(tomorrow.getDate()).padStart(2, '0');

        const defaultStartDate = `${yyyy}-${mm}-${dd}`;
        const defaultStartTime = "09:00";
        const defaultEndDate = `${yyyy}-${mm}-${dd}`;
        const defaultEndTime = "18:00";

        // Varsayılan değerleri ayarla
        $('#leaveModal [data-id="start_date"]').val(defaultStartDate);
        $('#leaveModal [data-id="start_time"]').val(defaultStartTime);
        $('#leaveModal [data-id="end_date"]').val(defaultEndDate);
        $('#leaveModal [data-id="end_time"]').val(defaultEndTime);

        $('#leaveModal [data-id="leave_type_id"], #leaveModal [data-id="start_date"], #leaveModal [data-id="start_time"], #leaveModal [data-id="end_date"], #leaveModal [data-id="end_time"]').on('change', function () {
            calculateTotal();
        });

        // Modal açıldığında hesaplamayı tetikle
        $('#leaveModal').on('shown.bs.modal', function () {
            calculateTotal();
        });

        // Bitiş tarihini kontrol et ve dönüş tarihini güncelle
        $('#leaveModal [data-id="end_date"]').on('change', function () {
            const endDate = $('#leaveModal [data-id="end_date"]').val();
            const returnDate = $('#leaveModal [data-id="return_date"]').val();

            if (returnDate && new Date(returnDate) < new Date(endDate)) {
                $('#leaveModal [data-id="return_date"]').val(endDate);
                alert('Dönüş tarihi, bitiş tarihinden önce olamaz.');
            }
        });

        $('#leaveModal [data-id="return_date"]').on('change', function () {
            const endDate = $('#leaveModal [data-id="end_date"]').val();
            const returnDate = $('#leaveModal [data-id="return_date"]').val();

            if (new Date(returnDate) < new Date(endDate)) {
                $('#leaveModal [data-id="return_date"]').val(endDate);
                alert('Dönüş tarihi, bitiş tarihinden önce olamaz.');
            }
        });

        // Form submit işlemi
        $('#leaveRequestForm').on('submit', submitLeaveRequest);
    });
</script>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/components/leaveModal.blade.php ENDPATH**/ ?>