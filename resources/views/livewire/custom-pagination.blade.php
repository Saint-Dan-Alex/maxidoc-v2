@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul class="pagination">
            <!-- Lien "Précédent" -->
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Précédent</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="#"
                        wire:click="updateHistoriquesPage({{ $paginator->currentPage() - 1 }})">Précédent</a>
                </li>
            @endif

            <!-- Liens des pages -->
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="#"
                                    wire:click="updateHistoriquesPage({{ $page }})">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <!-- Lien "Suivant" -->
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="#"
                        wire:click="updateHistoriquesPage({{ $paginator->currentPage() + 1 }})">Suivant</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Suivant</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
