
<div id="deleteConfirm" class="modal fade" tabindex="-1" role="dialog">
    <form method="POST" action="{{ route('adverts.destroy', $advert->id) }}">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation de suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous vraiment sûr(e) de supprimer cette annonce ?</p>
                </div>
                @method('DELETE')
                <div class="modal-footer">
                    <div class="row btnFooterDialog"></div>
                    <button type="submit" class="col col-md-auto btn btn-danger">Oui</button>
                    <button type="button" class="col col-md-auto btn btn-secondary" data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </form>
</div>

