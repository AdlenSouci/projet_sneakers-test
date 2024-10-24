<x-app-layout>
    <div class="container mt-4 ">
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-7">
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                            <div class="card-body p-0 custom-container-basket-shadow">
                                <div class="row g-0">
                                    @if (empty($cartItems))
                                        <div class="col mb-5 custom-col ">
                                            <div class="col-lg-15 ">
                                                <div class="p-10">
                                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                                        <h6 class="mb-0">
                                                            <a href="/shop" class="text-body">
                                                                <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                                            </a>
                                                        </h6>
                                                        <h1 class="fw-bold mb-0 text-black">Panier</h1>
                                                    </div>
                                                    <div class="text-center" style="margin: 50px 0;">Votre panier est vide</div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-lg-15">
                                            <div class="p-10">
                                                <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h6 class="mb-0">
                                                        <a href="/shop" class="text-body">
                                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                                        </a>
                                                    </h6>
                                                    <h1 class="fw-bold mb-0 text-black">Panier</h1>
                                                    <h6 class="mb-0 text-muted">{{ count($cartItems) }} items</h6>
                                                </div>
                                                <hr class="my-4">

                                                @foreach ($cartItems as $item)
                                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                                            <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3" alt="{{ $item['name'] }}">
                                                        </div>
                                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                                            <h6 class="text-muted">article</h6>
                                                            <h6 class="text-black mb-0">{{ $item['name'] }}</h6>
                                                        </div>
                                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                            <h6 class="mb-0 item-price" data-item-price="{{ $item['price'] }}">
                                                                € {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end rounded" style="width: 100px">
                                                            <h6 class="text-muted">Changer Quantité</h6>
                                                            <input type="number" value="{{ $item['quantity'] }}" class="form-control rounded" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}">
                                                        </div>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                                            <a href="#!" class="text-muted"><i class="fas fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                    <hr class="my-4">
                                                @endforeach

                                                <div class="pt-5">
                                                    <button class="btn btn-danger" onclick="viderPanier()">Vider le panier</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 bg-grey">
                                                <div class="p-5">
                                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Résumé</h3>
                                                    <hr class="my-4">
                                                    <div class="d-flex justify-content-between mb-5">
                                                        <h5 class="text-uppercase">Prix Total</h5>
                                                        <h5 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h5>
                                                    </div>
                                                    @if(auth()->check())
                                                        <form action="" method="post" onsubmit="event.preventDefault(); ">
                                                            @csrf
                                                            <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                                            <br>
                                                            <button type="submit" id="passCommandButton" class="btn btn-dark btn-block btn-lg">Passer la commande</button>
                                                        </form>
                                                    @else
                                                        <p>Connectez-vous pour passer une commande.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <div id="successMessage" class="alert alert-success" style="display: none;">
            La commande a été passée avec succès !
        </div>
    </div>

    <script>
        function viderPanier() {
            fetch('/vider-panier', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                location.reload();
            })
            .catch(error => {
                console.error('Erreur lors de la suppression du panier :', error);
            });
        }

        function viderArticlePanier(button) {
            var articleId = button.getAttribute('data-article-id');

            fetch('{{ route("vider-article-panier") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ article_id: articleId })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (!data.error) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erreur lors de la suppression de l\'article :', error);
            });
        }

        function changerQuantiter(input) {
            var newQuantity = parseInt(input.value);
            var pricePerItem = parseFloat(input.getAttribute("data-item-price"));

            if (!isNaN(newQuantity) && newQuantity > 0) {
                var itemPriceElement = input.closest('.row').querySelector(".item-price");

                if (itemPriceElement) {
                    var newTotal = newQuantity * pricePerItem;
                    itemPriceElement.textContent = "€ " + newTotal.toFixed(2);
                    calculerPrixTotal();
                }
            } else {
                input.value = 1; // Default to 1 if invalid
            }
        }

        function calculerPrixTotal() {
            var itemPrices = document.querySelectorAll('.item-price');
            var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
            document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
        }

        function passerCommande() {
    const adresseLivraison = document.getElementById('adresse_livraison').value;

    fetch('{{ route("passer-commande") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            adresse_livraison: adresseLivraison
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.error) {
            alert(data.message);
            viderPanier(); // Appelle la fonction pour vider le panier
        } else {
            alert(data.message || 'Une erreur est survenue.');
        }
    })
    .catch(error => {
        console.error('Erreur lors de la commande :', error);
        alert('Une erreur est survenue lors du passage de la commande.');
    });
}

    </script>
</x-app-layout>
