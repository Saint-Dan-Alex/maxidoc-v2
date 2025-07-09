<!DOCTYPE html>
<html>

<head>
    <title>Générer un PDF</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/uicons-regular-rounded.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/uicons-solid-rounded.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js?v1') }}"></script>
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
            var activeMenuItem = document.querySelectorAll('a');
            if (activeMenuItem.length != 0) {
                activeMenuItem.classList.add('active');
            }
        }
    </script>

    {{-- <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f8fc;
            margin: 0;
            padding: 0;
        }


        .sidebar-doc {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            margin: 20px;
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;

            h1 {
                font-size: 16px;
                color: #1d1e27;
            }
            h4 {
                color: #1d1e27;
                font-size: 18px;
            }
        }

        .btn-back {
            font-size: 14px;
            color: var(--colorTitre);
            background: var(--whiteColor);
            text-decoration: none !important;
            font-weight: 400;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            position: relative;
            border-radius: 5px;

            .tooltip-indicator {
                position: absolute;
                left: 200%;
                padding: 7px 14px;
                border-radius: 8px;
                background: rgba(0, 0, 0, 0.9);
                color: #ffff;
                font-size: 12px;
                transition: 0.3s;
                opacity: 0;
                visibility: hidden;
                z-index: 3;
                pointer-events: none;
            }

            &:hover {
                .tooltip-indicator {
                    opacity: 1;
                    visibility: visible;
                }
            }
        }

        .preview-doc {
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.05);
            margin: 20px;
            flex: 3;
            font-size: 14px;
            line-height: 1.6;
            font-family: 'Times New Roman', Times, serif;
            min-height: 1122px;
            padding: 37px;
        }

        .header-sidebar {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .btn-back {
            text-decoration: none;
            color: #007bff;
            display: flex;
            align-items: center;
        }

        .btn-back i {
            margin-right: 5px;
        }


        .col-form-label {
            font-size: 14px
        }

        .form-control {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #1d1e27;
            font-size: 14px;
            box-shadow: none!important;
            &::placeholder {
                opacity: .5;
            }

            &:focus {
                boder-color :#3046d5;
            }
        }

        .form-control:disabled {
            background-color: #e9ecef;
        }

        .btn-valid {
            background: #3046d5;
            border-color: #3046d5;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: none;
            font-size: 14px;
        }

        .btn-valid:hover {
            background: transparent;
            color: #3046d5
        }

        .footer-sidebar {
            text-align: right;
            margin-top: 20px;
        }

        /* .letter-preview {
            margin: 0 auto;
            max-width: 800px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        } */

        .letter-preview p {
            margin: 10px 0;
        }

        .letter-preview .header,
        .letter-preview .footer {
            text-align: right;
        }

        .letter-preview .content {
            text-align: justify;
        }
    </style> --}}
</head>

<body>
    <div class="global-div">
        <div class="wrapper-create-doc">
            <div class="sidebar-doc">
                <div class="vertical-bar d-flex flex-column">
                    <div class="header">
                        <div class="block-logo">
                            <img src="{{ asset('assets/regidoc/icon.png') }}">
                        </div>
                    </div>
                    <div class="footer d-flex flex-column align-items-center gap-3">
                        <div class="dropdown">
                            <!--begin::Menu toggle-->
                            <a href="#" class="link-icon" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="svg-icon theme-light-show svg-icon-2">
                                    <i class="fi fi-rr-sun"></i>
                                    {{-- <div class="tooltip-indicator">
                                        Thème
                                    </div> --}}
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" id="theme-switch-menu">
                                <li class="">
                                    <a href="#" class="dropdown-item" data-element="mode" data-value="light">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fi fi-rr-sun"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Claire</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#" class="dropdown-item" data-element="mode" data-value="dark">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fi fi-rr-moon-stars"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Sombre</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#" class="dropdown-item" data-element="mode" data-value="system">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fi fi-rr-computer"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Système</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="link-icon">
                            <i class="fi fi-rr-bell"></i>
                        </a>
                        <div class="block-user d-flex align-items-center">
                            <div class="dropdown">
                                <a href="#" class="d-flex align-items-center" id="dropdownMenuButton2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar-user">
                                        <img src="{{ asset('assets/regidoc/default.png') }}" alt="image profil">
                                    </div>
                                    {{-- <div class="user-name me-2 d-none d-lg-block">
                                        <h6>Herve Kinsala</h6>
                                        <p>Directeur général</p>
                                    </div>
                                    <i class="fi fi-rr-angle-down arrow d-none d-lg-block"
                                        style="color: var(--colorParagraph); font-size: 14px;"></i> --}}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                    <li>
                                        <a class="dropdown-item" href="/mon-profil">
                                            <i class="fi fi-rr-user"></i> Profil
                                        </a>
                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="document.getElementById('logout-form').submit()">
                                            <i class="fi fi-rr-sign-out-alt"></i>Deconnexion
                                        </a>
                                        <form action="http://127.0.0.1:8000/logout" method="POST" id="logout-form">
                                            <input type="hidden" name="_token"
                                                value="hF9cCuqDmKOk5d2Y9CZ2SuKucbZ0EEj4Qlc8pdkU">
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="content-form-create-doc d-flex flex-column">
                    <div class="header">
                        <div class="d-flex align-items-center gap-1">
                            <a href="/" class="back mb-0">
                                <i class="fi fi-rr-angle-left"></i>
                                <div class="tooltip-indicator">
                                    Retour
                                </div>
                            </a>
                            <h1>Création PDF</h1>
                        </div>
                    </div>
                    <div class="body">
                        <div class="content-form h-100">
                            <h2>
                                Zone de saisie
                            </h2>
                            <hr>
                            <div class="form-group row g-lg-1 g-2">
                                <div class="col-12">
                                    <label>
                                        Expéditeur
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Nom complet
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Ville
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Lieu et date
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Lieu des personnes en copie
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Objet
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        N° de référence courrier
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Fonction du signataire
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label>
                                        Nom complet du signataire
                                    </label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="d-flex gap-2">
                            <a class="btn btn-cansel w-50">Annuler</a>
                            <a href="#" class="btn btn-add  w-50" style="flex: 0 0 auto;">
                                Enregistrer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-writting-doc">
                <div class="body">
                    <textarea name="description" id="textarea-edit" cols="30" rows="4"
                        class="form-control form-control-tache-annotation" placeholder="Saisisez votre contenu...">
                                </textarea>
                </div>
                <div class="footer">
                    <div class="container-fluid">
                        <div class="row g-0 justify-content-center">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <p class="mb-0 text-600"><span>Powered by</span>
                                        <span>
                                            <img src="{{ asset('assets/regidoc/logo2.png') }}" alt="">
                                            <img src="{{ asset('assets/regidoc/white.png') }}" alt="">
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class=" btn btn-ia-floating">
            <img src="{{ asset('assets/regidoc/ai.png') }}" alt="icon ia">
        </button>
        <div class="chatbot">
            <div class="header d-flex align-items-center">
                <div class="logo-ia d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/regidoc/ai.png') }}" alt="icon ia">
                    <span>Altaris</span>
                </div>
                <div class="close-chatbot">
                    <i class="fi fi-rr-cross"></i>
                </div>
            </div>
            <div class="body">
                <div
                    class="block-start-chat-ia h-100 d-flex flex-column align-items-center text-center justify-content-center">
                    <div class="icon mb-2">
                        <img src="{{ asset('assets/regidoc/ai.png') }}" alt="icon ia">
                    </div>
                    <h2>Discussion IA</h2>
                    <p>Demandez à l'IA n'importe quoi. Recherchez 10 fois plus vite.</p>
                </div>
                {{-- <div class="block-all-chat d-flex flex-column gap-3">
                    <div class="item-chat me d-flex flex-column gap-1">
                        <div class="card-chat">
                            <p>
                                Comment tu peux m'être utile ?
                            </p>
                        </div>
                    </div>
                    <div class="item-chat d-flex flex-column gap-1">
                        <div class="name-ia d-flex align-items-center gap-2">
                            <div class="icon">
                                <img src="{{asset('assets/regidoc/ai.png')}}" alt="icon ia">
                            </div>
                            <span>GPT-4o-min</span>
                        </div>
                        <div class="card-chat">
                            <p>
                                Je peux t'assister de plusieurs façons ! voici quelques exemples
                            </p>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="footer">
                <div class="d-flex align-items-center gap-1 mb-2">
                    <div class="dropdown">
                        <a href="#" class="link-action d-flex gap-1 align-items-center"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="icon">
                                <img src="{{ asset('assets/regidoc/ai.png') }}" alt="icon ia">
                            </span>
                            <div class="name-ia">GPT-4o-mini</div>
                            <div class="arrow ms-1">
                                <i class="fi fi-rr-angle-down"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <h6 class="mb-0">Chatbots</h6>
                            <hr class="my-2">
                            <li class="mb-1">
                                <a href="#" class="dropdown-item gap-1 active">
                                    <div class="icon">
                                        <img src="{{ asset('assets/regidoc/ai.png') }}" alt="icon ia">
                                    </div>
                                    GPT-4o-mini
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="#" class="dropdown-item gap-1">
                                    <div class="icon">
                                        <img src="{{ asset('assets/regidoc/ai.png') }}" alt="icon ia">
                                    </div>
                                    Gemini
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="link-action d-flex gap-1 align-items-center"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="icon">
                                <i class="fi fi-rr-globe"></i>
                            </span>
                            <div class="name-ia">Français</div>
                            <div class="arrow ms-1">
                                <i class="fi fi-rr-angle-down"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <h6 class="mb-0">Langues</h6>
                            <hr class="my-2">
                            <li class="mb-1">
                                <a href="#" class="dropdown-item">
                                    Anglais
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="#" class="dropdown-item">
                                    Espagnol
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="#" class="dropdown-item active">
                                    Français
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="block-writting">
                    <div class="content-writting d-flex gap-2 align-items-start">
                        <textarea name="message" id="" cols="30" rows="2" class="form-control"
                            placeholder="Demandez à l'IA"></textarea>
                        <button class="btn btn-send">
                            <i class="fi fi-rr-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="container">
        <div class="row g-lg-5 g-3">
            <div class="col-lg-4">
                <div class="sidebar-doc w-100">
                    <div class="header-sidebar d-flex align-items-center gap-2">
                        <a href="{{ url()->previous() }}" style="font-size: 14px; color: var(--colorTitle)"
                            class="btn-back">
                            <i class="fi fi-rr-angle-left"></i>
                            <div class="tooltip-indicator">
                                Retour
                            </div>
                        </a>
                        <h4 class="mb-0">Créer un PDF </h4>
                    </div>
                    <h1>Entrer les informations pour le PDF</h1>
                    <form action="{{ route('generate.pdf') }}" method="POST">
                        @csrf
                        <div class="body-siderbar">
                            <div class="form-group row g-2" id="form-input">
                                <div class="col-12">
                                    <label class="col-form-label text-muted">N° de référence courrier</label>
                                    <input type="text" class="form-control" name="ref" id="ref"
                                        disabled>
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label text-muted">Lieu des personnes en copie</label>
                                    <input type="text" class="form-control" name="lieu_copie" id="lieu_copie"
                                        required oninput="updatePreview()">
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label text-muted">Destinataire</label>
                                    <input type="text" class="form-control" name="dest" id="dest"
                                        required oninput="updatePreview()">
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label text-muted">Ville</label>
                                    <input type="text" class="form-control" name="ville" id="ville"
                                        required oninput="updatePreview()">
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label text-muted">Lieu et date</label>
                                    <input type="text" class="form-control" name="lieu_date" id="lieu_date"
                                        required placeholder="ex : Kinshasa, 30/06/1960" oninput="updatePreview()">
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label text-muted">Objet</label>
                                    <textarea name="objet" id="objet" cols="30" rows="3" class="form-control" style="resize: none"
                                        oninput="updatePreview()"></textarea>
                                </div>
                                <div class="col-12" wire:ignore>
                                    <label class="col-form-label text-muted">Contenu</label>
                                    <textarea name="content" class="form-control body" id="content" cols="30" style="resize: none"
                                        rows="5" wire:ignore.self oninput="updatePreview()"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label text-muted">Signataire</label>
                                    <input type="text" class="mb-2 form-control" name="exp_fonction"
                                        id="exp_fonction" required placeholder="Fonction du Signataire"
                                        oninput="updatePreview()">
                                    <input type="text" class="form-control" name="exp_name" id="exp_name"
                                        required placeholder="Nom du Signataire" oninput="updatePreview()">
                                </div>
                            </div>
                        </div>
                        <div class="footer-sidebar">
                            <button type='submit' class="btn btn-valid">
                                <span>Prévisualiser le PDF</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 ">
                <div class="preview-doc">
                    <div class="letter-preview" id="preview-content">
                        <div class="header">
                            <p><span id="preview-lieu_date"></span></p>
                        </div>
                        <div class="content">
                            <p><strong>Lieu des personnes en copie:</strong> <span id="preview-lieu_copie"></span></p>
                            <p><strong>Destinataire:</strong> <span id="preview-dest"></span></p>
                            <p><strong>Ville:</strong> <span id="preview-ville"></span></p>
                            <p><strong>Objet:</strong> <span id="preview-objet"></span></p>
                            <p><strong>Contenu:</strong> <span id="preview-content-text"></span></p>
                        </div>
                        <div class="footer">
                            <p><strong>Fonction du Signataire:</strong> <span id="preview-exp_fonction"></span></p>
                            <p><strong>Nom du Signataire:</strong> <span id="preview-exp_name"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}
    {{-- <script>
        function updatePreview() {
            // Récupérer les valeurs des champs du formulaire
            const lieuCopie = document.getElementById('lieu_copie').value;
            const dest = document.getElementById('dest').value;
            const ville = document.getElementById('ville').value;
            const lieuDate = document.getElementById('lieu_date').value;
            const objet = document.getElementById('objet').value;
            const content = document.getElementById('content').value;
            const expFonction = document.getElementById('exp_fonction').value;
            const expName = document.getElementById('exp_name').value;

            // Mettre à jour les éléments dans l'aperçu
            document.getElementById('preview-lieu_copie').textContent = lieuCopie;
            document.getElementById('preview-dest').textContent = dest;
            document.getElementById('preview-ville').textContent = ville;
            document.getElementById('preview-lieu_date').textContent = lieuDate;
            document.getElementById('preview-objet').textContent = objet;
            document.getElementById('preview-content-text').innerHTML = content.replace(/\n/g, '<br>');
            document.getElementById('preview-exp_fonction').textContent = expFonction;
            document.getElementById('preview-exp_name').textContent = expName;
        }

        // Ajouter des écouteurs d'événements pour tous les champs de formulaire
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('input', updatePreview);
        });
    </script> --}}
</body>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // const useDarkMode = localStorage.getItem("data-theme") =='dark'; //window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;
    
    tinymce.init({
        selector: 'textarea#textarea-edit',
        // plugins: 'preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount a11ychecker editimage help formatpainter permanentpen pageembed charmap tinycomments mentions linkchecker emoticons advtable export footnotes mergetags autocorrect',
        plugins: 'preview autolink visualblocks visualchars image link table nonbreaking advlist lists wordcount spellchecker',
        mobile: {
            plugins: 'preview importcss searchreplace autolink autosave save visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap charmap emoticons spellchecker'
        },
        // menubar: 'file edit view insert format tools table tc help',
        menubar: false,
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | preview ',
        toolbar_sticky: true,
        spellchecker_language: 'fr_FR',
        // toolbar_sticky_offset: isSmallScreen ? 102 : 108,
        // autosave_ask_before_unload: false,
        // autosave_interval: '30s',
        // autosave_prefix: '{path}{query}-{id}-',
        // autosave_restore_when_empty: false,
        // autosave_retention: '2m',
        // image_advtab: false,
        // link_list: [{
        //         title: 'My page 1',
        //         value: 'https://www.tiny.cloud'
        //     },
        //     {
        //         title: 'My page 2',
        //         value: 'http://www.moxiecode.com'
        //     }
        // ],
        // image_list: [{
        //         title: 'My page 1',
        //         value: 'https://www.tiny.cloud'
        //     },
        //     {
        //         title: 'My page 2',
        //         value: 'http://www.moxiecode.com'
        //     }
        // ],
        // image_class_list: [{
        //         title: 'None',
        //         value: ''
        //     },
        //     {
        //         title: 'Some class',
        //         value: 'class-name'
        //     }
        // ],
        importcss_append: false,
        // templates: [{
        //         title: 'New Table',
        //         description: 'creates a new table',
        //         content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
        //     },
        //     {
        //         title: 'Starting my story',
        //         description: 'A cure for writers block',
        //         content: 'Once upon a time...'
        //     },
        //     {
        //         title: 'New list with dates',
        //         description: 'New List with dates',
        //         content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
        //     }
        // ],
        // template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        // template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 455,
        image_caption: true,
        // quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        // noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        // spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
        // tinycomments_mode: 'embedded',
        // content_style: '.mymention{ color: gray; }',
        // contextmenu: 'link image editimage table configurepermanentpen',
        // a11y_advanced_options: true,
        // skin: useDarkMode ? 'oxide-dark' : 'oxide',
        // content_css: useDarkMode ? 'dark' : 'default',

    })
    $('document').ready(function() {
        $('.btn-ia-floating').click(function() {
            $('.chatbot').addClass('show')
        })
        $('.close-chatbot').click(function() {
            $('.chatbot').removeClass('show')
        })
    })
    document.addEventListener('DOMContentLoaded', function() {

        var items = [].slice.call(document.querySelectorAll('[data-element="mode"]'));

        items.map(function(item) {
            item.addEventListener("click", function(e) {
                e.preventDefault();

                // $(this).toggleClass('active');

                var menuMode = item.getAttribute("data-value");
                var mode = menuMode;

                if (menuMode === "system") {
                    mode = getSystemMode();
                }

                setMode(mode, menuMode);
                window.location.refresh();
            });
        });

        function getMode() {
            var mode;

            if (document.documentElement.hasAttribute("data-theme")) {
                return document.documentElement.getAttribute("data-theme");
            } else if (localStorage.getItem("data-theme") !== null) {
                return localStorage.getItem("data-theme");
            } else if (getMenuMode() === "system") {
                return getSystemMode();
            }

            return "light";
        }

        function setMode(mode, menuMode) {
            var currentMode = getMode();

            // Reset mode if system mode was changed
            if (menuMode === 'system') {
                if (getSystemMode() !== mode) {
                    mode = getSystemMode();
                }
            } else if (mode !== menuMode) {
                menuMode = mode;
            }

            // Read active menu mode value
            var activeMenuItem = document.querySelector('[data-element="mode"][data-value="' + menuMode + '"]');

            // Enable switching state
            document.documentElement.setAttribute("data-theme-mode-switching", "true");

            // Set mode to the target document.documentElement
            document.documentElement.setAttribute("data-theme", mode);

            // Disable switching state
            setTimeout(function() {
                document.documentElement.removeAttribute("data-theme-mode-switching");
            }, 300);

            // Store mode value in storage
            localStorage.setItem("data-theme", mode);

            // Set active menu item
            if (activeMenuItem) {
                localStorage.setItem("data-theme-mode", menuMode);
                setActiveMenuItem(activeMenuItem);
            }

            // if (mode !== currentMode) {
            // 	KTEventHandler.trigger(document.documentElement, 'kt.thememode.change', the);
            // }
        }

        function getMenuMode() {
            // if (!menu) {
            // 	return null;
            // }

            var menuItem = document.querySelector('.active[data-element="mode"]');

            if (menuItem && menuItem.getAttribute('data-value')) {
                return menuItem.getAttribute('data-value');
            } else if (document.documentElement.hasAttribute("data-theme-mode")) {
                return document.documentElement.getAttribute("data-theme-mode")
            } else if (localStorage.getItem("data-theme-mode") !== null) {
                return localStorage.getItem("data-theme-mode");
            } else {
                return typeof defaultThemeMode !== "undefined" ? defaultThemeMode : "light";
            }
        }

        function getSystemMode() {
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? "dark" : "light";
        }

        function setActiveMenuItem(item) {
            var menuMode = item.getAttribute("data-value");

            var activeItem = document.querySelector('.active[data-element="mode"]');

            if (activeItem) {
                activeItem.classList.remove("active");
            }

            item.classList.add("active");
            localStorage.setItem("data-theme-mode", menuMode);
        }

        setTimeout(function() {
            $('.page-loader').remove();
        }, 500);
    });
</script>

</html>
