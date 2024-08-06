@extends('layouts.master')
@section('title')
    Coğrafi Kodlar
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/dropify/dropify.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    <!--  Modal  -->
    @include('definations.leave_types.modal')
    <div class="row">
        <div class="col-md-4">
            <div>
                <a href="{{route('leave_types.create')}}" class="btn btn-success waves-effect waves-light mb-3"   ><i class="mdi mdi-plus me-1"></i> Yeni Veri</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="float-end">
                <div class=" mb-3">
                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-language="tr" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                        <input type="text" class="form-control text-start" placeholder="Başlangıç" name="Başlangıç" />
                        <input type="text" class="form-control text-start" placeholder="Bitiş" name="Bitiş" />

                        <button type="button" class="btn btn-primary"><i class="mdi mdi-filter-variant"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
                <table class="table table-centered datatable dt-responsive nowrap table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
                    <thead>
                    <tr class="bg-transparent">
                        <th style="width: 24px;">
                            <div class="form-check text-center font-size-16">
                                <input type="checkbox" class="form-check-input" id="invoicecheck">
                                <label class="form-check-label" for="invoicecheck"></label>
                            </div>
                        </th>
                        <th>ID</th>
                        <th>İzin Adı</th>
                        <th>Türü</th>
                        <th>Ücretlendirme</th>
                        <th>Günü</th>
                        <th>Durum</th>
                        <th style="width: 120px;">İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($results as $item)
                        <tr>
                            <td>
                                <div class="form-check text-center font-size-16">
                                    <input type="checkbox" class="form-check-input" id="itemCheck{{$item->id}}">
                                    <label class="form-check-label" for="itemCheck{{$item->id}}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="{{route('leave_types.edit',$item->id)}}" class="text-dark fw-bold">{{$item->id}}</a>
                            </td>
                            <td>{{$item->name}}</td>
                            <td>{{\App\Enumerations\LeaveTypeEnum::getStatus($item->type)}}</td>
                            <td>{{\App\Enumerations\PriceTypeEnum::getStatus($item->price_type)}}</td>
                            <td>{{$item->days}}</td>
                            <td>{!! getStatus($item->status) !!}</td>
                            <td>
                                <a href="{{route('leave_types.edit',$item->id)}}"   class="btn px-3 text-primary bg-none"><i class="uil uil-pen font-size-18"></i></a>
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

@endsection
@section('script')
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



        $(document).ready(function () {
            // Lazy loading özelliğini etkinleştirme
            $('img.lazyload').lazy();
        });
    </script>

@endsection
