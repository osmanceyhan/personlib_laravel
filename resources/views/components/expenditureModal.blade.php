<div class="modal fade leave_modal" id="expenditureModal" tabindex="-1" role="dialog" aria-labelledby="adavancePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="expenditureModalLabel">Harcama Talep Et</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('payment_requests.store')}}" method="post" id="expenditureRequestForm">
                @csrf
                <div class="modal-body">

                    <div class="mb-3 row form_row">
                        <label for="total" class="col-md-2 col-form-label">Tutar (TL)</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="amount" name="amount"  type="text" >
                        </div>
                    </div>

                    <div class="mb-3 row form_row">
                        <label for="attachment" class="col-md-2 col-form-label">Fiş Görseli/Dosyası (opsiyonel)</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="attachment" name="attachment"  type="file" >
                        </div>
                    </div>
                    <div class="mb-3 row form_row">
                        <label for="total" class="col-md-2 col-form-label">Fiş Tarihi</label>
                        <div class="col-md-10">
                            <input class="form-control" data-id="receipt_date" name="receipt_date" type="date">
                        </div>
                    </div>
                    <div class="mb-3 row form_row">
                        <label for="tax_rate" class="col-md-2 col-form-label">Vergi Oranı</label>
                        <div class="col-md-10">
                            <div class="select2-full w-full">
                                @php
                                    $taxRates = [0, 1, 5, 6, 8, 10, 13, 18, 19, 20, 24, 'Diğerleri'];
                                @endphp
                                <select data-id="tax_rate" name="tax_rate" class="select2 form-select">
                                    <?php foreach ($taxRates as $rate): ?>
                                    <option value="<?php echo $rate === 'Diğerleri' ? 'other' : $rate; ?>">
                                        <?php echo $rate; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-4 col-form-label">Açıklama (opsiyonel)</label>
                        <textarea class="form-control"  data-id="comment" name="comment"></textarea>
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
        $('#expenditureRequestForm [data-id="receipt_date"]').val(defaultUsedDate);


        function submitExpenditureRequestForm(event) {
            event.preventDefault();


            $.ajax({
                url: '{{ route("payment_requests.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    payment_type: "EXPENDITURE",
                    amount: $('#expenditureRequestForm [data-id="amount"]').val(),
                    attachment: $('#expenditureRequestForm [data-id="attachment"]').val(),
                    receipt_date: $('#expenditureRequestForm [data-id="receipt_date"]').val(),
                    tax_rate: $('#expenditureRequestForm [data-id="tax_rate"]').val(),
                    comment: $('#expenditureRequestForm [data-id="comment"]').val(),
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

        // Form submit işlemi
        $('#expenditureRequestForm').on('submit', submitExpenditureRequestForm);
    });
</script>