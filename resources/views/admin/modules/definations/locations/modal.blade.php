
<!-- staticBackdrop Modal example -->
<div class="modal fade" id="removeModal"    tabindex="-1" role="dialog"
     aria-labelledby="removeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route(getRouteWeb('locations.index'))}}" method="post" id="removeModalForm">
                @csrf
                @method('delete')
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
