<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

<link rel="stylesheet" href="sweetalert2.min.css">



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<link rel="stylesheet" href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">



    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="//cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('دخول') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('مستخدم جديد') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('تسجيل الخروج') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                {{-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                </div> --}}
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js') }}"></script>

    <script>
        $(document).on("click", "#delete", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                    title: 'هل تريد تأكيد الحذف
                    icon: 'question',
                    iconHtml: '؟',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم',
                    cancelButtonText: 'لا',
                    showCancelButton: true,
                    showCloseButton: true

                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = link;
                                        Swal.fire(
                                            'تم الحذف!',
                                            'تم الحذف بنجاح.',
                                            'نجاح'
                                        )
                                    }
                                });
                            });
            </script>

            <script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
            <script src="//cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

            <script>
               @if(Session::has('message_id'))
               var type ="{{Session::get('alert-type','info')}}"
               switch(type){
                   case'info':
                   toastr.info("{{Session::get('message_id')}}");

                   break;

                    case'success':
                   toastr.success("{{Session::get('message_id')}}");
                   break;

                   case'warning':
                   toastr.warning ("{{Session::get('message_id')}}");
                   break;

                    case'error':
                   toastr.error ("{{Session::get('message_id')}}");
                   break;
               }

           @endif
           </script>
</body>
</html>
