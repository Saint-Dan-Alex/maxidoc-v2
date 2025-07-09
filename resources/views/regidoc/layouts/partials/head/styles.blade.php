{{-- <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicons/favicon-16x16.png') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicons/favicon.ico') }}"> --}}
{{-- <link rel="manifest" href="{{ asset('assets/images/favicons/manifest.json') }}"> --}}

<meta name="msapplication-TileImage" content="{{ asset('assets/images/favicons/mstile-150x150.png') }}">
<meta name="theme-color" content="#ffffff">

<script src="{{ asset('assets/js/config.js') }}"></script>
{{-- <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script> --}}
{{-- <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon"> --}}

<link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
    rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">

<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('assets/css/uicons-regular-rounded.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/uicons-solid-rounded.css') }}">

<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}"> --}}
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
{{-- <script>
    var isRTL = JSON.parse(localStorage.getItem('isRTL'));
    if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
    } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
    }
</script> --}}

{{-- <link href="{{ asset('vendors/fullcalendar/main.min.css') }}" rel="stylesheet"> --}}
{{-- <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet"> --}}
{{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}

{{-- <link href="{{ asset('assets/css/user.min.css') }}.." rel="stylesheet" id="user-style-default"> --}}
{{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
