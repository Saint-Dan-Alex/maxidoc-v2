{{-- @extends('regidoc.layouts.master') --}}
@extends('regidoc.layouts.app-user')


@section('content')

    @livewire('admin.agents.fiche-create')




@section('scripts')
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
        // const nvFichier = document.querySelector('.file-pdf');
        // const filename = document.querySelector('.list-file .name-file')
        // console.log($(nvFichier,this));

        $('.file-pdf').each(function() {
            $(this).change(function() {
                var parent = $(this).parent().parent().parent()
                var col = parent.find('.col-img')
                var input = parent.find('.col-hidden-3')
                var label = parent.find('.dash')
                var filename = parent.find('.list-file .name-file')

                console.log(filename);

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
                        col.removeClass('d-none')
                        input.removeClass('d-none')
                        label.addClass('active')
                        console.log(namefile);
                        filename.text(namefile)
                        // filename.innerHTML = namefile;
                    })

                }

                console.log($(this));
                // $('.col-img').removeClass('d-none')
            })
        })

        // nvFichier.addEventListener('change', function() {
        //     const fichier = this.files[0];
        //     if (fichier) {
        //         let namefile = fichier.name;
        //         if (namefile.length >= 12) {

        //             let splitName = namefile.split('.');
        //             namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];

        //         }
        //         const analyseur = new FileReader();
        //         analyseur.readAsDataURL(fichier);
        //         analyseur.addEventListener('load', function() {
        //             $('.col-img').removeClass('d-none')
        //             $('#col-hidden-3').removeClass('d-none')
        //             $('#label-4').addClass('active')
        //             filename.innerHTML = namefile;
        //         })

        //     }
        // })
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
            // console.log($(file_user).val());
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
@endsection
