@extends('regidoc.layouts.app-user')

@section('content')
    @livewire('admin.agents.fiche')

    @include('components.admin.modals.personal-new')

    @foreach (\App\Models\Agent::all() as $agent)
        <div class="modal fade" id="modal-upload-document-{{ $agent->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Joindre un CV</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('regidoc.rh.user.document.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $agent->user->id }}">
                            <div class="form-group row g-3">
                                <div class="col-12 d-flex justify-content-center align-items-center">
                                    <div class="block-up-img w-100">
                                        <input type="file" id="file-pdf" accept=".jpg,.png,.pdf">
                                        <label for="file-pdf" class="dashed" id="label-4">
                                            <svg viewBox="0 0 801.19 537.98">
                                                <g id="Calque_2" data-name="Calque 2">
                                                    <g id="Calque_1-2" data-name="Calque 1">
                                                        <path
                                                            d="M754.28,264.59A159.67,159.67,0,0,0,648.9,217.87c.58-.77,1.13-1.55,1.68-2.34A76.4,76.4,0,0,0,531.91,120,195.87,195.87,0,0,0,351.32,0C256.06,0,176.7,68,159.12,158.11,68.79,173.41,0,252,0,346.7,0,452.34,85.64,538,191.28,538c1.43,0,2.85,0,4.27-.05s2.82.05,4.24.05H642.14A161.47,161.47,0,0,0,796.75,415.41c.12-.47.23-.94.34-1.41a160.45,160.45,0,0,0-42.81-149.41ZM499.56,296.45c-5.09,11.64-15.11,15.75-27.19,15.78-13.62,0-27.23.24-40.84-.06-6.1-.14-8.07,2.22-8,8.13.27,16.07.1,32.13.1,51.47-.93,15.74,1.62,34.84-1.34,53.79-3.89,25-25.87,43.75-50.7,43.4a51.73,51.73,0,0,1-50.17-43.18c-1.85-10.85-1.11-21.72-1.19-32.58-.16-23.69-.35-47.38.12-71.06.16-8-2.58-10.36-10.31-10-12.77.54-25.58.22-38.37.11-11.93-.1-22.14-3.65-27.34-15.48-5.4-12.28-.77-22.17,8-30.91q49.93-49.95,100-99.87c12.27-12.17,26.86-12.3,39-.23q50.48,50,100.53,100.44C500.41,274.72,504.71,284.65,499.56,296.45Z">
                                                        </path>
                                                    </g>
                                                </g>
                                            </svg>
                                            <p>
                                                Cliquez pour uploader le fichier
                                            </p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12 d-none col-img">
                                    <ul class="list-file">
                                        <li class="d-flex align-items-center">
                                            <div class="block-remove">
                                                <a href="#" class="btn btn-remove">
                                                    <i class="fi fi-rr-trash"></i>
                                                </a>
                                            </div>
                                            <i class="bi bi-file-earmark"></i>
                                            <div class="block-detail">
                                                <div class="names">
                                                    <p class="name-file">NOM_POSTNOM... .pdf</p>
                                                    <p class="pourc">
                                                        <i class="bi bi-check-lg"
                                                            style="font-size: 20px; color: #07c451"></i>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12 d-none" id="col-hidden-3">
                                    <label for="">Titre du fichier</label>
                                    <input type="text" name="libelle" id="" class="form-control"
                                        placeholder="Titre du fichier">
                                </div>
                                <div class="mt-5 col-12 d-flex align-items-center justify-content-end mb-4">
                                    <a href="javascript:void(0)" class="btn" data-bs-dismiss="modal" aria-label="Close"
                                        style="color: var(--colorTitre)">Annuler</a>
                                    <button class="btn btn-add mt-0">Enregistrer</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    {{-- @stack('scripts') --}}
    <script>
        $("#input-search-contact").keyup(function() {
            if ($(this).val() === '') {
                $("#block-clean-input-search-contact").removeClass('show')
            } else {
                $("#block-clean-input-search-contact").addClass('show')
                $("#block-clean-input-search-contact").click(function() {
                    $(this).removeClass('show')
                    $("#input-search-contact").val('');
                    if ($("#input-search-contact").val() === '') {
                        $("#list-contact li").show()
                        $(".sidebar-doc .empty-result-contact").removeClass('show')
                    }
                })
            }
            var value = $(this).val().toLowerCase()
            $("#list-contact li").each(function() {
                var searc = $(this).text().toLowerCase();
                if (searc.indexOf(value) > -1) {
                    $(this).show()
                    $(".sidebar-doc .empty-result-contact").removeClass('show')
                } else {
                    $(this).hide()
                    $(".sidebar-doc .empty-result-contact").addClass('show')
                }
            })
        })
        // const nvFichier = document.getElementById('change-photo-profil');
        const nvFichier = document.querySelector('#file-pdf');
        const filename = document.querySelector('.list-file .name-file')

        nvFichier.addEventListener('change', function() {
            const fichier = this.files[0];
            if (fichier) {
                let namefile = fichier.name;
                if (namefile.length >= 12) {

                    let splitName = namefile.split('.');
                    namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];

                }
                const analyseur = new FileReader();
                analyseur.readAsDataURL(fichier);
                analyseur.addEventListener('load', function() {
                    $('.col-img').removeClass('d-none')
                    $('#col-hidden-3').removeClass('d-none')
                    $('#label-4').addClass('active')
                    filename.innerHTML = namefile;
                })

            }
        })
        $('.block-remove .btn-remove').click(function(e) {
            e.preventDefault()
            $(this).parent().parent().parent().parent().addClass('d-none')
            $('#col-hidden-3').addClass('d-none')
            $('#label-4').removeClass('active')
            $(nvFichier).val('');
            console.log($(nvFichier).val());
        })
        const file_user_profil = document.querySelector('#file-user-profil');
        const name_file_user = document.querySelector('#list-file-user .name-file')
        var imgSr = document.getElementById('img-profil-user');

        file_user_profil.addEventListener('change', function() {
            const fichier = this.files[0];
            if (fichier) {
                let namefile = fichier.name;
                if (namefile.length >= 12) {

                    let splitName = namefile.split('.');
                    namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];

                }
                const analyseur = new FileReader();
                analyseur.readAsDataURL(fichier);
                analyseur.addEventListener('load', function() {
                    $('#label-1').addClass('active')
                    imgSr.setAttribute('src', this.result);
                    $(imgSr).addClass('fade')
                    name_file_user.innerHTML = namefile;
                })

            }
            setTimeout(() => {
                $(imgSr).removeClass('fade')
            }, 3000);
        })


        const file_user = document.querySelector('#file-user');
        const name_file = document.querySelector('#list-file .name-file')

        file_user.addEventListener('change', function() {
            const fichier = this.files[0];
            if (fichier) {
                let namefile = fichier.name;
                if (namefile.length >= 12) {

                    let splitName = namefile.split('.');
                    namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];

                }
                const analyseur = new FileReader();
                analyseur.readAsDataURL(fichier);
                analyseur.addEventListener('load', function() {
                    $('#label').addClass('active')
                    $('#col-hidden').removeClass('d-none')
                    $('#col-hidden-1').removeClass('d-none')
                    name_file.innerHTML = namefile;
                })

            }
        })
        $('.block-remove .btn-remove').click(function(e) {
            e.preventDefault()
            $(this).parent().parent().parent().parent().addClass('d-none')
            $('#col-hidden-1').addClass('d-none')
            $('#label').removeClass('active')
            $(file_user).val('');
            console.log($(file_user).val());
        })
        // $("body").on('click','.click', function(){
        //     change_img_profil();
        // })
        // // change_img_profil();

        // function change_img_profil(){
        //     const nvImg_profil = document.querySelector('#file-img-profil');
        //     var nsr = document.getElementById('img_profil');
        //     console.log(nvImg_profil);
        //     nvImg_profil.addEventListener('change', function() {
        //         const fichier_img = this.files[0];
        //         if (fichier_img) {
        //             const analyseur_file = new FileReader();
        //             analyseur_file.readAsDataURL(fichier_img);
        //             analyseur_file.addEventListener('load', function() {
        //                 nsr.setAttribute('src', this.result);
        //             })
        //         }
        //     })
        // }
    </script>
@endsection
