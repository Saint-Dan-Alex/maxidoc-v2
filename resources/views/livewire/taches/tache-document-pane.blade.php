<form wire:submit.prevent="addFichier" wire:poll.keep-alive>
    <div class="col-12">
        <h6>Ajouter une pièce jointe</h6>
    </div>

    <div class="input-group" wire:ignore style="flex-wrap: nowrap">
        <div class="file-block w-100">
            <input type="file" wire:model="file" class="form-control file-param" accept="image/*, .pdf">
            <div class="fake-input-file gap-3">
                <div class="icon">
                    <i class="fi fi-rr-clip"></i>
                </div>
                <span class="fake-label">
                    Cliquer pour importer un fichier (pdf)
                </span>
            </div>
        </div>


    </div>

    @if ($filePreview)
        <div class="my-4">
            <div>
                <img src="{{ $filePreview }}" alt="File Preview" class="w-100">
            </div>
            <span class="message-input-warning d-flex gap-2 align-items-center" style="font-size: 25px;">
                <i class="fi fi-rr-shield-exclamation"></i>
                <span style="font-size: 13px;">
                    Une fois enregistré, votre fichier ne pourra pas être supprimé. Pour confirmer le choix du document
                    appuyez sur "Enregistrer
                </span>
                <button type="submit" style="flex: 0 0 auto" class="btn btn-primary btn-file-action"
                    wire:loading.attr="disabled">
                    {{-- {{ isset($file) ? 'Ajouter':'Enregistrer' }}  --}} Enregistrer
                    <span class="spinner-border d-none" role="status" wire:target="addFichier, file"
                        wire:loading.class.remove="d-none" style="width: 15px; height: 15px; border-width: 2px;">
                        <span class="sr-only"></span>
                    </span>
                </button>
            </span>
        </div>
    @endif

    @error('file')
        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
    @enderror
</form>
@push('livewireScripts')
    <script>
        var inputFileParam = document.querySelectorAll('.file-param');
        $(inputFileParam).each(function() {
            $(this).on('change', function() {
                const fichiers = this.files;
                const parent = $(this).parent();

                if (fichiers.length > 0) {
                    const fichier = fichiers[0]; // Accéder au premier fichier
                    let namefile = fichier.name;
                    let splitName = namefile.split('.');
                    namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];
                    $(parent).find('span').text(namefile);
                    $(parent).find('span').addClass('opacity');
                }
            });
        });

        $('.btn-file-action').click(function() {
            $(this).parent().find('.fake-label').removeClass('opacity')
            $(this).parent().find('.fake-label').text('Cliquer pour importer un fichier');
        })
    </script>
@endpush
