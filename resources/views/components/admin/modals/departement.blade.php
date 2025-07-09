


 <!-- Modal susp-->
<div class="modal fade" id="deleteDepart" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-sm modal-dialog-centered modal-white">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supprimer un département</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-info">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center text-danger">Voulez-vous supprimer ?</h1>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('departements.delete') }}">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Supprimmer</button>
                </form>
            </div>
        </div>
    </div>
</div>
