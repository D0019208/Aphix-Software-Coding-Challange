<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>YouTube Search - Laravel</title>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='csrf-token' content='{{ csrf_token() }}' />
        <link rel="icon" type="image/png" sizes="32x32" href="https://laravel.com/img/favicon/favicon-32x32.png">

        <link href='{{asset('libraries/css/bootstrap.min.css')}}' rel='stylesheet'>
        <link href='{{asset('plugins/css/main.css')}}' rel='stylesheet' type='text/css'/>
        <link href='{{asset('plugins/css/loading.css')}}' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        @include('partials.header')
        <div class='container'>
            <h1 class=text-center' id='title'>Aphix Software Coding Challange - YouTube Search</h1>
            <div class='row' id='video_container'>
                @for ($i = 1; $i <= 6; $i++)
                <x-video url='https://www.youtube.com/embed/QAUzWtLMnU0' title='Full HD Test 1080p' description='Ein Testvideo In Full HD von Aquos' channel='https://youtube.com/channel/UClsdaxFFFIGvuw0U4BY5OyA'></x-video>
                @endfor
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item disabled" id='previous'><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item page active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item page"><a class="page-link" href="#">2</a></li>
                    <li class="page-item page"><a class="page-link" href="#">3</a></li>
                    <li class="page-item page"><a class="page-link" href="#">4</a></li>
                    <li class="page-item page"><a class="page-link" href="#">5</a></li>
                    <li class="page-item page"><a class="page-link" href="#">6</a></li>
                    <li class="page-item page"><a class="page-link" href="#">7</a></li>
                    <li class="page-item page"><a class="page-link" href="#">8</a></li>
                    <li class="page-item page"><a class="page-link" href="#">9</a></li>
                    <li class="page-item page"><a class="page-link" href="#">10</a></li>
                    <li class="page-item" id='next'><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
        @include('partials.footer')
        <script src='{{asset('libraries/js/jquery.min.js')}}'></script>
        <script src='{{asset('libraries/js/popper.min.js')}}'></script>
        <script src='{{asset('libraries/js/bootstrap.min.js')}}'></script>
        <script src='{{asset('libraries/js/sweetalert.min.js')}}'></script>
        <script src='{{asset('plugins/js/main.js')}}' type='module'></script>
    </body>
</html>
