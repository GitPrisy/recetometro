@extends('layouts.app')
@section('content')
<div class="container">
    @if (Auth::user() == $user)
    <h2>Tus recetas creadas:</h2>
    @else
    <h2>Recetas de {{$user->nickname}}:</h2>
    @endif

    <!-- Cards -->
    <div class="row" id="post-data" pages="{{$recipes->lastPage()}}">
        @include('layouts.cards')
    </div>

    <!-- Data Loader -->
    <div class="auto-load text-center" style="display: none">
        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <path fill="#000"
                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                    from="0 50 50" to="360 50 50" repeatCount="indefinite" />
            </path>
        </svg>
    </div>

    <script>
        function loadMore(page) {
            $.ajax({
                url: '?page=' + page,
                type: 'get',
                beforeSend: function() {
                    $('.auto-load').show();
                },
            })
            .done(function(data){
                if(typeof data.html == 'undefined') {
                    
                    return;
                }
                $('.auto-load').hide();
                $('#post-data').append(data.html);
            })
            .fail(function(data) {
                if(typeof data.html == 'undefined') {
                    $('.auto-load').html("No se han encontrado más recetas en esta página...");
                    return;
                }
                $('.auto-load').hide();
                $('#post-data').append(data.html);
            });
        }

        var page = 1;
        $(window).scroll(function(){
            if($(window).scrollTop() + window.innerHeight >= $(document).height()-200) {
                if(page < $('#post-data').attr('pages')) {
                    page++
                    loadMore(page);
                }
            }
        });  
    </script>
</div>
@endsection
