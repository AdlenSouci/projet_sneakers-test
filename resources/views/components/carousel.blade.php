<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner  w-100">
        @php
            $i = 0;
        @endphp
        @foreach ($annonces as $annonce)

                <div class="carousel-item @if($i == 0) active @endif">
                    @php
                        $i++;
                    @endphp
                    <div class="container">
                        <div class="row p-5">
                            <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                <img class="img-fluid" src="{{ asset('img/' . $annonce['imageURL']) }}" alt="">
                            </div>
                            <div class="col-lg-6 mb-0 d-flex align-items-center">
                                <div class="text-align-left align-self-center">
                                    <h1 style="font-size: 28px; color: #de7105;">{!!$annonce['h1']!!}</h1>
                                    <h3 style="font-size: 20px;">{!!$annonce['h3']!!}</h3>
                                    <p>
                                        {!!$annonce['texte']!!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
        <!-- <div class=" carousel-item active">
                                <div class="container">
                                    <div class="row p-5">
                                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                            <img class="img-fluid" src="{{ asset('img/patta.webp') }}" alt="">
                                        </div>
                                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                                            <div class="text-align-left align-self-center">
                                                <h1 class="h4" style="color: #de7105;"><strong>My sneakers</strong> Shop
                                                </h1>
                                                <h3 class="h5">Le site ou vous pouvez acheter la sublime <strong> Air
                                                        Max x Patta </strong>
                                                </h3>
                                                <p>
                                                    Voici <a rel="sponsored" class="text-success"
                                                        href="https://solesavy.com/history-of-patta-and-nike-collaborations/"
                                                        target="_blank">l'histoire</a> de l'Air Max x Patta
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="carousel-item">
                            <div class="container">
                                <div class="row p-5">
                                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                        <img class="img-fluid" src="{{ asset('img/lyte3.webp') }}" alt="">
                                    </div>
                                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                                        <div class="text-align-left">
                                            <h1 class="h5">Assics revient avec du très lourd</h1>
                                            <h3 class="h6">La qualité au top de gamme</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="container">
                                <div class="row p-5">
                                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                                        <img class="img-fluid" src="{{ asset('img/off.jpeg') }}" alt="">
                                    </div>
                                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                                        <div class="text-align-left">
                                            <h1 class="h5">Nike x Off-White</h1>
                                            <h3 class="h6">Une paire rare presque introuvable sauf en occasion mais ici
                                                tout est
                                                possible</h3>

                                            <p>
                                                Une collaboration exeptionnelle entre Nike et off-white.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel"
            role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel"
            role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    @vite(['resources/css/templatemo.css'])