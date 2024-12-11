<footer class="text-center text-white">
    <div class="container py-5">
        <!-- Section: Links -->
        <div class="row text-center d-flex justify-content-center mb-5">
            <div class="col-md-2">
                <h6 class="text-uppercase font-weight-bold">
                    <a href="{{ url('/') }}" class="text-white">Accueil</a>
                </h6>
            </div>
            <div class="col-md-2">
                <h6 class="text-uppercase font-weight-bold">
                    <a href="{{ Route('mentions') }}" class="text-white">Mentions légales</a>
                </h6>
            </div>
            <div class="col-md-2">
                <h6 class="text-uppercase font-weight-bold">
                    <a href="{{ Route('cgu') }}" class="text-white">CGU</a>
                </h6>
            </div>
            <div class="col-md-2">
                <h6 class="text-uppercase font-weight-bold">
                    <a href="{{ url('/contact') }}" class="text-white">Contact</a>
                </h6>
            </div>
            <div class="col-md-2">
                <h6 class="text-uppercase font-weight-bold">
                    <a href="{{ url('/about') }}" class="text-white">À propos</a>
                </h6>
            </div>
        </div>
        <!-- Section: Links -->

        <!-- Section: Address & Phone -->
        <div class="row mb-4">
            <div class="col-md-6 text-left">
                <p class="m-0 text-white">17 Rue des snekers</p>
            </div>
            <div class="col-md-6 text-right">
                <p class="m-0 text-white">01 64 34 72 45</p>
            </div>
        </div>
        <!-- Section: Address & Phone -->

        <!-- Section: Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © Sorel Plastique {{ now()->format('Y') }} designed by Equinox conseil
        </div>
        <!-- Section: Copyright -->
    </div>
</footer>

@vite(['resources/css/footer.css'])
