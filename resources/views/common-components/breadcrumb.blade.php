<!-- start page title -->
<div class="row breadcrumb_row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">{{ $title }}</h4>

            <div class="page-title-right d-flex align-items-center">

                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $pagetitle }}</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>

                </ol>
                @if(isset($back_url))
                    <div class="back_btn ml-2 pl-2" style="margin-left: .5rem;">
                        <a href="{{ $back_url }}" class="btn btn-sm btn-primary waves-effect waves-light">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
<!-- end page title -->