<x-app-layout>

    <!--confirmation de commande uniquement telwinds css -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="display-4 fw-bolder">
                        Confirmation de commande
                    </h1>
                </div>

                <div class="text-center">
                    <h1>Nouvelle commande reçue</h1>
                    <p>Une nouvelle commande a été passée par {{ $client }}.</p>
                    <p>Total de la commande : {{ $total }} €</p>
                </div>

                <div class="text-center">



                    <p class="lead">
                        Votre commande a bien été envoyée. Nous vous contacterons dans les plus bref delais.
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>