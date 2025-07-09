const input = document.getElementById('file-img');
        const img = document.getElementById('sign-img');
        const img_block = document.getElementById('img_block');
        // const loader = document.getElementById('avatar-loader');

        input.addEventListener('change', () => {
            const file = input.files[0];
            const reader = new FileReader();

            // reader.addEventListener('loadstart', () => {
            //     loader.classList.remove('d-none');
            // });

            reader.addEventListener('load', () => {
                img.src = reader.result;
                img_block.classList.remove('d-none');
            });

            reader.readAsDataURL(file);
        });