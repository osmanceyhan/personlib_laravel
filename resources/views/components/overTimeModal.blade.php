<div class="modal fade leave_modal" id="overTimeModal" tabindex="-1" role="dialog" aria-labelledby="overTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="overTimeModalLabel">Fazla Mesai Talep Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('payment_requests.store')}}" method="post" id="overTimeRequestForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 row form_row">
                        <label for="start_date" class="col-md-12 col-form-label">Başlangıç Tarihi/Saati</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input class="form-control" data-id="start_date" name="start_date" type="date">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" value="09:00" data-id="start_time" name="start_time" type="time">
                            </div>

                        </div>

                    </div>
                    <div class="mb-3 row form_row">

                    </div>
                    <div class="mb-3 row form_row">
                        <label for="hour" class="col-md-2 col-form-label">Süre (saat)</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="hour" value="1" name="hour" type="number">
                        </div>
                    </div>
                    <div class="mb-3 row form_row">
                        <label for="minute" class="col-md-2 col-form-label">Dakika (saat)</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="minute" value="0" name="minute" type="number">
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

    function submitOverTimeRequestForm(event) {
        event.preventDefault();

        $.ajax({
            url: '{{ route("payment_requests.store") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                payment_type: "OVERTIME",
                start_date: $('#overTimeRequestForm [data-id="start_date"]').val(),
                start_time: $('#overTimeRequestForm [data-id="start_time"]').val(),
                hour: $('#overTimeRequestForm [data-id="hour"]').val(),
                minute: $('#overTimeRequestForm [data-id="minute"]').val(),
                comment: $('#overTimeRequestForm [data-id="comment"]').val(),
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Sayfayı yenile
                } else {
                    if ($('#alertMessage').length == 0) {
                        $('.modal-body').prepend('<div id="alertMessage" class="alert alert-danger" role="alert">' + response.message + '</div>');
                    }
                }
            },
            error: function () {
                alert('İzin talebi gönderilirken bir hata oluştu.');
            }
        });
    }

    $(document).ready(function () {
        // Form yüklendiğinde geçerlilik tarihini +1 gün olarak ayarla
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        const yyyy = tomorrow.getFullYear();
        const mm = String(tomorrow.getMonth() + 1).padStart(2, '0'); // Aylar sıfır tabanlıdır
        const dd = String(tomorrow.getDate()).padStart(2, '0');

        const defaultUsedDate = `${yyyy}-${mm}-${dd}`;
        $('#overTimeRequestForm [data-id="start_date"]').val(defaultUsedDate);


        // Form submit işlemi
        $('#overTimeRequestForm').on('submit', submitOverTimeRequestForm);
    });
</script>
