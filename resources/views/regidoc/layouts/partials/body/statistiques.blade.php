@php
    $quantite_critique = 0;
    $quantite_urgence = 0;

    foreach ($allproduits->where('statut_id', '1') as $produit) {
        $total_achat = 0;
        $total_vente = 0;

        foreach ($produit->inventaires as $invent) {
            $total_achat = $total_achat + $invent->nombre;
        }

        foreach ($produit->ventes as $vente) {
            $total_vente = $total_vente + $vente->nombre;
        }

        if ($total_achat - $total_vente <= 50) {
            $quantite_critique = $quantite_critique + 1;
        }

        if ($total_achat - $total_vente <= 100 && $total_achat - $total_vente > 50) {
            $quantite_urgence = $quantite_urgence + 1;
        }
    }
@endphp

<div class="d-flex block-statits w-100" style="position: relative">
    <div class="block-opacity-sm"></div>
    <div class="block-card-xs">
        <div class="card card-sm ">
            <div class="content-text">
                <div class="text-star">
                    <div class="icon icon-call icon-sm">
                        <div class="bg" style="background: #5d17e3;"></div>
                        <i class="fi fi-rr-shop"></i>
                    </div>
                    <h5>Stock disponibles</h5>

                </div>
                <div class="row">
                    <div class="col-12">
                        <h3 class="d-flex align-items-center justify-content-between success">
                            {{ $allproduits->where('statut_id', '1')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="block-card-xs">
    <div class="card card-sm ">
        <div class="content-text">
            <div class="text-star">
                <div class="icon icon-call icon-sm">
                    <div class="bg" style="background: #ffa601;"></div>
                    <i class="fi fi-rr-shield-exclamation"></i>
                </div>
                <h5>Stock critique</h5>

            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="d-flex align-items-center justify-content-between success">
                        {{ $quantite_critique }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-card-xs">
    <div class="card card-sm ">
        <div class="content-text">
            <div class="text-star">
                <div class="icon icon-call icon-sm">
                    <div class="bg" style="background: #f74343;"></div>
                    <i class="fi fi-rr-chart-histogram"></i>
                </div>
                <h5>Stock d'urgence</h5>

            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="d-flex align-items-center justify-content-between success">
                        {{ $quantite_urgence }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-card-xs">
    <div class="card card-sm ">
        <div class="content-text">
            <div class="text-star">
                <div class="icon icon-call icon-sm">
                    <div class="bg" style="background: #2d29f7;"></div>
                    <i class="fi fi-rr-shopping-cart-check"></i>
                </div>
                <h5>Commandés</h5>

            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="d-flex align-items-center justify-content-between success">
                        {{ $allproduits->where('statut_id', '2')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-card-xs">
    <div class="card card-sm ">
        <div class="content-text">
            <div class="text-star">
                <div class="icon icon-call icon-sm">
                    <div class="bg" style="background: #f31818;"></div>
                    <i class="fi fi-rr-trash"></i>
                </div>
                <h5>Supprimés</h5>

            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="d-flex align-items-center justify-content-between success">
                        {{ $allproduits->where('statut_id', '4')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block-card-xs">
    <div class="card card-sm ">
        <div class="content-text">
            <div class="text-star">
                <div class="icon icon-call icon-sm">
                    <div class="bg" style="background: #fff020;"></div>
                    <i class="fi fi-rr-eye-crossed"></i>
                </div>
                <h5>Quarantaines</h5>

            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="d-flex align-items-center justify-content-between success">
                        {{ $inventaires->where('statut_id', '5')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{{-- <div class="col-lg-2">
    <a href="{{ route('produits.index.stock.actif', ['1']) }}" style="color: black;">
        <div class="card card-show-info">
            <div class="row">
                <div class="col-4">
                    <div class="text-star">
                        <div class="icon">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-end">
                        <h4>{{ $allproduits->where('statut_id', '1')->count() }}</h4>

                    </div>
                </div>
                <div class="col-12">
                    <h6>Stock disponible</h6>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-lg-2">
    <a href="#" style="color: black;">
        <div class="card card-show-info">
            <div class="row">
                <div class="col-4">
                    <div class="text-star">
                        <div class="icon">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-end">
                        <h4>{{ $quantite_critique }}</h4>

                    </div>
                </div>
                <div class="col-12">
                    <h6>Stock critique</h6>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-lg-2">
    <a href="#" style="color: black;">
        <div class="card card-show-info">
            <div class="row">
                <div class="col-4">
                    <div class="text-star">
                        <div class="icon">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-end">
                        <h4>{{ $quantite_urgence }}</h4>

                    </div>
                </div>
                <div class="col-12">
                    <h6>Stock d'urgence</h6>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-lg-2">
    <a href="{{ route('produits.index.stock.actif', ['2']) }}" style="color: black;">
        <div class="card card-show-info">
            <div class="row">
                <div class="col-4">
                    <div class="text-star">
                        <div class="icon">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-end">
                        <h4>{{ $allproduits->where('statut_id', '2')->count() }}</h4>

                    </div>
                </div>
                <div class="col-12">
                    <h6>Commandés</h6>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-lg-2">
    <a href="{{ route('produits.index.stock.actif', ['3']) }}" style="color: black;">
        <div class="card card-show-info">
            <div class="row">
                <div class="col-4">
                    <div class="text-star">
                        <div class="icon">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-end">
                        <h4>{{ $allproduits->where('statut_id', '4')->count() }}</h4>

                    </div>
                </div>
                <div class="col-12">
                    <h6>Supprimés</h6>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="col-lg-2">
    <a href="{{ route('quarantaines.index') }}" style="color: black;">
        <div class="card card-show-info">
            <div class="row">
                <div class="col-4">
                    <div class="text-star">
                        <div class="icon">
                            <i data-feather="user"></i>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="text-end">
                        <h4>{{ $inventaires->groupBy('produit_id')->count() }}</h4>

                    </div>
                </div>
                <div class="col-12">
                    <h6>Quarantaines</h6>
                </div>
            </div>
        </div>
    </a>
</div> --}}
