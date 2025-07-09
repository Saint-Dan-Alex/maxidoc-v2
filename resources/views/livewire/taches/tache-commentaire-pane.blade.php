    <div class="all-comments d-flex flex-column h-100">
        @if ($commentaires->count() > 0)
            <h6 class="mb-2" style="font-size: 14px">
                {{ $commentaires->count() }} commentaire(s)
            </h6>
        @endif
        <div class="block-scroll flex-grow-1 pe-2" id="tache-commentaires" style="overflow-y: auto">
            @if ($commentaires->count() == 0)
                <div class="block-empty-offcanvas h-100 d-flex flex-column justify-content-center align-items-center">
                    <div class="name-file d-flex flex-column align-items-center">
                        <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px" class="mb-1">
                        <p style="font-size: 12px; var(--colorParagraph)">Aucun commentaire pour l'instant !</p>
                    </div>
                </div>
            @else
                @foreach ($commentaires as $comment)
                    <div class="block-comment commentaires">
                        <div class="block-info-comment d-flex">
                            <div class="avatar-comment commentaires">
                                <img src="{{ imageOrDefault($comment->user->agent->image) }}" alt="Photo profil">
                            </div>
                            <div class="name-comment commentaires ">
                                <h6 class="mb-0">
                                    {{ $comment->user->agent->prenom . ' ' . $comment->user->agent->nom }}
                                    <span> - {{ $comment->user->agent->direction?->titre }}</span>
                                </h6>
                                <p>{{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                        <div class="comment commentaires mt-2">
                            <p>
                                {!! $comment->message !!}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <form wire:submit.prevent="addCommentaire" class="pt-3">
            <div class="form-group">
                <textarea wire:model="message" id="comment-textarea" class="form-control" rows="2"
                    placeholder="Ajouter un commentaire..." oninput="updateCharCount()" maxlength="255">
                </textarea>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3">
                <div class="block-indic-text">
                    <span id="num-text" wire:ignore>0</span>
                    <span>/ <small id="num-text-limit">255</small></span>
                </div>
                <button type="submit" class="btn btn-primary" @disabled($active)>Envoyer</button>
            </div>
        </form>
    </div>

    @push('livewireScripts')
        <script>
            function updateCharCount() {
                var maxLength = 255;
                var textarea = document.getElementById('comment-textarea');
                var currentLength = textarea.value.length;

                document.getElementById('num-text').innerText = currentLength;
                document.getElementById('num-text-limit').innerText = maxLength;

                if (currentLength >= maxLength) {
                    // Bloquer la saisie si la limite est atteinte.
                    textarea.value = textarea.value.substring(0, maxLength);
                }

                // Désactiver le bouton si la limite est dépassée.
                document.querySelector('button[type="submit"]').disabled = currentLength > maxLength;
            }
            // function updateCharCount() {
            //     var maxLength = 255;
            //     var currentLength = document.querySelector('#comment-textarea').value.length;
            //     console.log(currentLength);

            //     document.getElementById('num-text').innerText = currentLength;
            //     document.getElementById('num-text-limit').innerText = maxLength;

            //     if (currentLength > maxLength) {
            //         Si la longueur du texte dépasse la limite, vous pouvez ajouter un traitement ici.
            //         Par exemple, désactiver le bouton Envoyer ou changer la couleur du compteur.
            //         Pour l'instant, je vais désactiver le bouton.
            //         document.querySelector('button[type="submit"]').disabled = true;
            //     } else {
            //         document.querySelector('button[type="submit"]').disabled = false;
            //     }
            // }
        </script>
    @endpush
