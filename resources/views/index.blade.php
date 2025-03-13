<x-app-layout>

    <div class="container mt-5">
        <div class="card card-3d" style="max-width: 600px;">
            <div class="card-body">
                <h5 class="card-title display-6 fw-bolder">Bienvenue sur My Sneakers</h5>
                <p class="card-text lead">
                    My Sneakers est la boutique de sneakers en ligne qui vous propose une large sélection de modèles, de
                    marques et de prix. Que vous soyez un collectionneur averti ou un simple amateur de sneakers, vous
                    trouverez sur notre site les chaussures qui vous correspondent.

                    Nous proposons une large sélection de sneakers, allant des modèles classiques aux modèles les plus
                    exclusifs. Vous trouverez sur notre site des sneakers de toutes les marques, telles que Nike,
                    Adidas, Jordan, Converse, Puma, etc. Vous pourrez également trouver des sneakers de différentes
                    catégories, telles que les baskets de running, de basketball, de tennis, etc.
                </p>
            </div>
        </div>
    </div>

    <br>

    <div id="carouselExampleControlsNoTouching" class="carousel slide" data-bs-touch="false" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/1.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/3.jpg') }}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControlsNoTouching"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControlsNoTouching"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <br>


    <br>

</x-app-layout>