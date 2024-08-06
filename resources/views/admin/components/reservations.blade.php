@section('external_css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection


    <div class="row">
        <div class="col-lg-12">
            @if(session()->has('alert'))
                <div class="alert alert-{{ session()->get('alert')['status'] }} alert-dismissible fade show" role="alert">
                    <h5 class="text-success"> {{ session()->get('alert')['title'] }}</h5>
                    <p>  {{ session()->get('alert')['message'] }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            <div class="table-responsive mb-4">
                <table class="table table-centered datatable dt-responsive  table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                    <thead>
                    <tr class="bg-transparent">
                        <th style="width: 24px;">
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="invoicecheck">
                                <label class="form-check-label" for="invoicecheck"></label>
                            </div>
                        </th>
                        <th>ID</th>
                        <th>Tarih</th>
                        <th>PNR No</th>
                        <th>Kullanıcı</th>
                        <th>Alış Yeri</th>
                        <th>Araç</th>
                        <th>Gün</th>
                        <th>Top. Tutar</th>
                        <th>Durum</th>
                        <th style="width: 120px;">İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $item)
                        <tr>
                            <td>
                                <div class="form-check text-center font-size-16">
                                    <input type="checkbox" class="form-check-input" id="itemCheck{{$item->id}}">
                                    <label class="form-check-label" for="itemCheck{{$item->id}}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="{{route(getRouteWeb('reservations.edit'),$item->id)}}" class="text-dark fw-bold">{{$item->id}}</a>
                            </td>
                            <td>
                                {{showDateTime($item->created_at)}}
                            </td>
                            <td>{{$item->rez_no}}</td>
                            <td>{{$item->name.' '.$item->surname}}</td>
                            <td>{{$item->getPickupLocationName()}}</td>
                            <td>{{$item->getCarName()}}</td>
                            <td>{{$item->day}}</td>
                            <td>{{formatCurrency($item->total_price,$item->currency)}}</td>
                            <td>{!! getReservationStatus($item->status) !!}</td>
                            <td>
                                <a href="{{route(getRouteWeb('reservations.edit'),$item->id)}}"   class="btn px-3 text-primary bg-none"><i class="uil uil-pen font-size-18"></i></a>
                                <button type="button" class="btn   waves-effect waves-light"   onclick="statusModal({{$item->id}},'{{$item->status}}')">
                                    <i class="uil @if($item->status == "ACTIVE") uil-toggle-on text-success @else text-danger uil-toggle-off @endif font-size-18"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

@section('external_script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/ecommerce-datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/ckeditor/ckeditor.min.js') }}"></script>

    <!-- lazyload.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.plugins.min.js"></script>
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>

    <script type="text/javascript">

        function statusModal(id,status){
            var modalToggle = new bootstrap.Modal(document.getElementById('removeModal'),{}); // relatedTarget

            var removeModalForm = $("#removeModalForm");
            var deleteEndpoint = removeModalForm.attr("action");
            removeModalForm.attr("action",deleteEndpoint+"/"+id);
           if(status == "ACTIVE"){
                removeModalForm.find(".modal-footer button[type=submit]").removeClass("btn-success");
                removeModalForm.find(".modal-footer button[type=submit]").addClass("btn-danger");

                removeModalForm.find(".modal-footer button[type=submit]").html("Veriyi Pasife Al");
                removeModalForm.find(".modal-title").html("Veriyi Pasife Al");
            }else{
                removeModalForm.find(".modal-footer button[type=submit]").removeClass("btn-danger");
                removeModalForm.find(".modal-footer button[type=submit]").addClass("btn-success");
                removeModalForm.find(".modal-footer button[type=submit]").html("Veriyi Aktife Al");
                removeModalForm.find(".modal-title").html("Veriyi Aktife Al");
            }
            modalToggle.show()
        }
        $(".select2").select2();

        var imagenUrl = "";
        var dropifyEvent;
        var formAction = "{{route(getRouteWeb('reservations.store'))}}";
        // Dropify eklentisini bir kez oluşturun
        dropifyEvent = $('.dropify').dropify({
            defaultFile: imagenUrl,
            messages: {
                'default': 'Dosyanızı buraya sürükleyin veya tıklayın',
                'replace': 'Değiştirmek için sürükleyin veya tıklayın',
                'remove': 'Kaldır',
                'error': 'Üzgünüz, bir hata oluştu.'
            },
            error: {
                'fileSize': $('.dropify').data('file-size-error'),
                'minWidth': $('.dropify').data('min-width-error'),
                'maxWidth': $('.dropify').data('max-width-error'),
                'minHeight': $('.dropify').data('min-height-error'),
                'maxHeight': $('.dropify').data('max-height-error'),
                'imageFormat': $('.dropify').data('image-format-error')
            }
        });






        // Modal kapatıldığında
        $('#newDataModal').on('hidden.bs.modal', function (e) {
            clearEditorContent();
            changeDropifyImage('');
            $("#newDataModal input[name=_method]").attr("value","post");
            $("#newDataModal form").attr("action",formAction);
            // Diğer input ve textarea'ları temizle
            document.getElementById('name').value = '';
            document.getElementById('title').value = '';
            document.getElementById('sub_title').value = '';
            $("#type").val(null).trigger("change");
            $("#status").val(null).trigger("change");

        });

        function getImage(image) {
            var storageCdn = '{{config('image.storage_asset_url')}}';
            var storageFolder = '{{config('image.cdn_base_dir')}}';
            return storageCdn + storageFolder + image;
        }

        // Dropify'deki dosyayı değiştir ve önizlemeyi sıfırla
        function changeDropifyImage(imageUrl) {
            // Dropify öğesini seç
            var dropifyInstance = $('.dropify').data('dropify');

            // Eğer Dropify öğesi varsa devam et
            if (dropifyInstance) {
                // Dropify'nin resetPreview, clearElement ve settings.defaultFile özelliklerini kontrol et
                if (dropifyInstance.resetPreview && dropifyInstance.clearElement && dropifyInstance.settings && dropifyInstance.settings.defaultFile) {
                    // Reset preview, clear element ve default file özelliklerini ayarla
                    dropifyInstance.resetPreview();
                    dropifyInstance.clearElement();
                    dropifyInstance.settings.defaultFile = imageUrl;
                } else {
                    // Eğer resetPreview kullanılamıyorsa, sadece defaultFile ayarını değiştir
                    dropifyInstance.settings.defaultFile = imageUrl;
                }

                // Dropify'yi tekrar oluştur
                dropifyInstance.destroy();
                dropifyInstance.init();
            }
        }

        function editModal(data) {
            // CKEditor içeriğini doldur
            var decodedContent = atob(data.content);
            $("#newDataModal form").attr("method","post");
            $("#newDataModal input[name=_method]").attr("value","put");



            var image = getImage(data.image);
            changeDropifyImage(image);


            // Diğer input ve textarea'ları doldur
            document.getElementById('name').value = data.name;
            document.getElementById('title').value = data.title;
            document.getElementById('sub_title').value = data.sub_title;
            editor.setData(decodedContent);
            $("#newDataModal form").attr("action",formAction+"/"+data.id);
//        $("#status").val(data.status).trigger("change");

            $("#status").val(data.status).trigger("change");
            $("#type").val(data.type).trigger("change");

            // Modal'ı aç
            $('#newDataModal').modal('show');
        }

        $(document).ready(function () {
            // Lazy loading özelliğini etkinleştirme
            $('img.lazyload').lazy();
        });
    </script>

@endsection
