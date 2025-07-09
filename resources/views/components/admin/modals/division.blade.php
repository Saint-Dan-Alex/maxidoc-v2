
    {{-- modal --}}
    <div class="modal fade " id="modifierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier une division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('divisions.update') }}">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="recipient-name" class="">Dénomination</label>
                        <input type="text" class="form-control" id="denomination" name="denomination">
                    </div>
                    <div class="form-group">
                        <label for="depart" class="">Département</label>
                        <select name="departement_id" id="depart" class="form-control">
                            @foreach ($departements as $depart)
                                <option value="{{ $depart->id }}">{{ $depart->denomination }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="chef" class="">chef de la division</label>
                        <select name="chef_id" id="chef" class="form-control">
                            @foreach ($personnels as $personel)
                                <option value="{{ $personel->id }}">{{ $personel->nom. ' ('. $personel->matricule .')' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>


    <div class="modal fade " id="divisionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('divisions.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="denomination" class="">Dénomination</label>
                            <input type="text" class="form-control" id="denomination" name="denomination">
                        </div>
                        <div class="form-group">
                            <label for="depart" class="">Département</label>
                            <select name="departement_id" id="depart" class="form-control">
                                @foreach ($departements as $depart)
                                    <option value="{{ $depart->id }}">{{ $depart->denomination }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="chef" class="">chef de la division</label>
                            <select name="chef_id" id="chef" class="form-control">
                                @foreach ($personnels as $personel)
                                    <option value="{{ $personel->id }}">{{ $personel->nom. ' ('. $personel->matricule .')' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
