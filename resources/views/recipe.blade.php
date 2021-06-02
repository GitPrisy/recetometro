@extends('layouts.app')
@section('content')
    <div class="container">

        <h1 class="titulo-receta">Título de la receta</h1>

        <div id="carouser-receta" class="carousel mx-auto" data-ride="carousel">


            <!-- The slideshow -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://picsum.photos/1280/720">
                </div>
                <div class="carousel-item">
                    <img src="https://picsum.photos/256/144" alt="Chicago">
                </div>
                <div class="carousel-item">
                    <img src="https://picsum.photos/800/450" alt="New York">
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#carouser-receta" data-slide="prev">
                <i class="fas fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#carouser-receta" data-slide="next">
                <i class="fas fa-angle-right"></i>
            </a>
        </div>

        <h3 class="mt-4">Descripción: </h3>
        <div class="texto-receta">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Placeat quidem soluta sequi. Delectus
                velit, exercitationem eos laboriosam nisi sit obcaecati. Illum eveniet quisquam reprehenderit
                tempora ipsum, temporibus iste odit accusamus?</p>
        </div>

        <h3 class="mt-4">Ingredientes: </h3>
        <div class="texto-receta">
            <ul>
                <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, maiores tempore temporibus
                    distinctio numquam quos nulla laudantium voluptatem, animi asperiores exercitationem facere
                    repellendus laboriosam ducimus culpa tenetur, iste eaque. Iure.</li>
                <li>ingredientes</li>
                <li>mas ingredientes</li>
            </ul>
        </div>

        <h3 class="mt-4">Preparación: </h3>
        <div class="texto-receta">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta quis aliquam pariatur natus doloremque
                consectetur dolore eligendi, earum inventore iure tenetur nesciunt, tempore minima rem! Nesciunt
                enim aliquid natus doloribus.</p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, reprehenderit blanditiis temporibus
                quaerat culpa magnam fugiat id. Doloremque, ut officiis inventore, fugiat suscipit, vel alias earum
                iste dolorum fugit dicta!</p>
        </div>
    </div>

@endsection
