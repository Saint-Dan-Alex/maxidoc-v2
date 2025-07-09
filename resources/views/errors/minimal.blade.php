<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        @include('regidoc.layouts.partials.head.styles')

    </head>
    <body>
        <div class="global-div">
            <div class="block-erro-page" style="background: none">
                <div class="content w-100 m-0 p-0" style="background: none">
                    <div class="container-fluid pe-lg-0 px-0">
                        <div class="row align-items-md-center">
                            <div class="col-lg-6 d-none d-sm-block col-sm-6">
                                <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                                   <div class="block-content-text-error">
                                        <h3 class="mb-3"> @yield('message')</h3>
                                        <p class="mb-4"> @yield('paragraph')</p>
                                        <div class="block-btn">
                                            @yield('btn-action')
                                        </div>
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pe-lg-0 col-sm-6">
                                <div class="block-bg-error d-flex align-items-start align-items-sm-center justify-content-center flex-column p-5">
                                    <div class="block-bubbles">
                                        <div class="bubble"></div>
                                        <div class="bubble"></div>
                                        <div class="bubble"></div>
                                    </div>
                                    <h2>
                                        @yield('code')
                                    </h2>
                                    <h3 class="mb-3 d-block d-sm-none"> @yield('message')</h3>
                                    <p class="mb-4 d-block d-sm-none"> @yield('paragraph')</p>
                                    <div class="block-btn d-sm-none">
                                        @yield('btn-action')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </body>
</html>
