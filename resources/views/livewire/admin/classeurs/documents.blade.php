<div>
    <div class="row">
        <div class="col-lg-12">

                <div class="row">

                    @if (count($find_document)== null )
                        <h1 class="text-center text-gray justify-content-center mt-5">Pas de document <br> pour ce dossier</h1>
                    @else
                        {{-- @php
                            $image = DB::table('documents')->where('dossier_id',$id_images)->first();
                            $images = explode('|',$image->file);
                        @endphp
                        @foreach ($images as $image)
                            <img src="{{'/uploads/courriers/'}}/{{$image->file}}" class="img-fluid rounded-start w-100  fit-contain mt-5" alt="">

                        @endforeach --}}
                        @foreach ($find_document as $document )

                            <div class="col-md-6" id="{{$document->title ??''}}">
                                <div class="card mb-3" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-5 ">
                                            <a href="{{route('viewfile',['file_id'=>$document->id])}}" class="p-3">
                                                {{-- @php
                                                    $images_all = DB::table('documents')->where('dossier_id',$id_images)->get();
                                                    foreach ($images_all as $image) {
                                                       $images = explode('|',$image->file);

                                                    }
                                                @endphp --}}
                                                <img src="{{asset('assets\img\gallery\enveloppe.png')}}" class="img-fluid rounded-start w-100  fit-contain mt-5" alt="" srcset="">
                                            </a>

                                        </div>

                                        <div class="col-md-7">
                                            <div class="card-body" >
                                                <span ><b>Dénomination</b> </span>
                                                <h5 class="card-title">{{$document->title ??''}}</h5>
                                                <span> <b>Réference</b> </span>
                                                <h5 class="card-title">{{$document->reference ??''}}</h5>
                                                <div>
                                                    <span> Déscription </span>
                                                    <div>
                                                        <span class="card-text text-gray"> <b>{{Str::substr($document->content,0,21)}}...</b> </span>

                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="card-text"><small class="text-muted">Créé par : <b>{{$document->personnel->nom ??''}}</b> </small></span>

                                                </div>
                                                <div>
                                                    <span class="card-text"><small class="text-muted">Date : {{$document->created_at->format('d-m-Y')}}</small></span>

                                                </div>

                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3 p-3">

                                            <div class="col-md-9">
                                                <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#modifie" aria-controls="modifie" wire:click.prevent="edite({{$document->id}})">Modifier</button>

                                                <button class="btn btn-info btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#edite" aria-controls="edite" wire:click.prevent="">Détail</button>

                                            </div>
                                            <div class="col-md-3">

                                                <a href="{{route('viewfile',['file_id'=>$document->id])}}" class="btn btn-primary btn-sm float-right">Ouvrir</a>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                     @endif
                    <div class="row">
                        <div class="col-md-10"></div>
                        {{-- <div class="col-md-2">
                            <span class="justify-content-end text-end ml-auto ">{{$find_document->links()}}</span>

                        </div> --}}
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
