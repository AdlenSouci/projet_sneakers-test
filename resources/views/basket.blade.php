<x-app-layout>
    <div class="container mt-4">
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">

                    <div class="col-12 col-sm-12 col-md-10 col-lg-8">


                        <div class="card card-registration" style="border-radius: 15px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    @if (empty($cartItems))
                                    <div class="col text-center p-5">
                                        <h1 class="fw-bold mb-4 text-black">Panier</h1>
                                        <div class="text-center text-white mb-3" style="margin: 50px 0;">Votre panier est vide</div>
                                        <a href="/shop" class="btn btn-outline-secondary mt-3">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-12">
                                        <div class="p-4 rounded-3" style="background-color: #000000;">
                                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                                                <h1 class="fw-bold mb-0 text-white">Panier</h1>
                                                <h6 class="mb-0 text-white">Articles : <span id="total-items-count">{{ $totalItems }}</span></h6>



                                            </div>
                                            <hr class="my-3">

                                            @foreach ($cartItems as $index => $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center {{ $index % 2 == 0 ? 'item-even' : 'item-odd' }} py-1">
                                                <div class="col-4 col-sm-3 col-md-2">
                                                    <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $item['name'] }}">
                                                </div>
                                                <div class="col-6 col-sm-4 col-md-3">
                                                    <h5 class="item-name {{ $index % 2 == 0 ? 'text-black' : 'text-white' }} mb-1">{{ $item['name'] }}</h5>
                                                </div>
                                                <div class="col-6 col-sm-4 col-md-2 text-start text-md-end">
                                                    <h6 class="{{ $index % 2 == 0 ? 'text-black' : 'text-white' }} mb-0 item-price" data-item-price="{{ $item['price'] }}">
                                                        € {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                    </h6>
                                                </div>
                                                <!--pointure-->
                                                <div class="col-3 col-sm-2 col-md-2">
                                                    Pointure
                                                    <h6 class="{{ $index % 2 == 0 ? 'text-black' : 'text-white' }} mb-0 item-size" data-item-size="{{ $item['taille'] }}">
                                                        {{ $item['taille'] }}
                                                    </h6>
                                                </div>



                                                <div class="col-3 col-sm-2 col-md-2">
                                                    <input type="number" value="{{ $item['quantity'] }}" class="form-control rounded input-quantity" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}" style="width: 80px;">
                                                </div>
                                                <div class="col-3 col-sm-1 text-end">
                                                    <a href="#!" class="text-muted delete-item-btn" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}"><i class="fas fa-times"></i></a>
                                                </div>
                                            </div>

                                            <br>

                                            @endforeach

                                            <div class="pt-4 d-flex justify-content-between align-items-center flex-wrap">
                                                <button class="btn btn-danger  " onclick="viderPanier()">Vider le panier</button>
                                                <br>
                                                <div>
                                                    <h3 class="fw-bold text-white">Total : <span id="totalPrice">€ {{ number_format($totalPrice, 2) }}</span></h3>
                                                </div>
                                            </div>

                                            <br>

                                            @if(auth()->check())
                                            <div id="checkout-process-simulation" class="mt-4" @if(!empty($cartItems)) data-initialize-view="true" @endif>
                                                <!-- Étape 1: Adresse -->
                                                <div id="step-address" class="checkout-step">
                                                    <h4 class="text-white mb-3">Adresse de Livraison</h4>
                                                    <input type="text" class="form-control form-control-lg mb-3 rounded-lg" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required value="{{ auth()->user()->adresse_livraison }}">
                                                    <input type="text" class="form-control form-control-lg mb-3 rounded-lg" name="code_postal" id="code_postal" placeholder="Code postal" required value="{{ auth()->user()->code_postal }}">
                                                    <input type="text" class="form-control form-control-lg mb-3 rounded-lg" name="ville" id="ville" placeholder="Ville" required value="{{ auth()->user()->ville }}">
                                                    <button type="button" class="btn btn-dark btn-block w-100 rounded-pill" onclick="validateAddressAndProceed()">Procéder au Paiement</button>
                                                </div>

                                                <!-- Étape 2: Choix du Paiement -->
                                                <div id="step-payment-options" class="checkout-step" style="display:none;">
                                                    <h4 class="text-white mb-3">Choisissez votre mode de paiement :</h4>
                                                    <button type="button" class="btn btn-primary w-100 mb-2 rounded-pill" onclick="showSimulationStep('step-card-form')">
                                                        <i class="far fa-credit-card me-2"></i>Payer par Carte (Simulation)
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-info w-100 mb-2 rounded-pill" onclick="simulatePaypal()">
                                                        <i class="fab fa-paypal me-2"></i>Payer avec PayPal (Simulation)
                                                    </button> -->
                                                    <button type="button" class="btn btn-outline-light w-100 mt-2 rounded-pill" onclick="showSimulationStep('step-address')">Retour à l'adresse</button>
                                                </div>

                                                <!-- Étape 3a: Formulaire de Carte Factice -->
                                                <div id="step-card-form" class="checkout-step" style="display:none;">
                                                    <h5 class="text-white mb-3">Paiement par Carte</h5>
                                                    <input type="text" class="form-control form-control-lg mb-2 rounded-lg" id="fake_card_number" placeholder="Numéro de carte (ex: 4242...)">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <input type="text" class="form-control form-control-lg rounded-lg" id="fake_card_expiry" placeholder="MM/AA (ex: 12/25)">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <input type="text" class="form-control form-control-lg rounded-lg" id="fake_card_cvv" placeholder="CVV (ex: 123)">
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-success w-100 mt-2 rounded-pill" onclick="submitFakeCard()">Valider le paiement (Simulation)</button>
                                                    <button type="button" class="btn btn-outline-light w-100 mt-3 rounded-pill" onclick="showSimulationStep('step-payment-options')">Retour</button>
                                                </div>

                                                <!-- Étape 3b: Message PayPal Factice (this step is now replaced by the modal)
                                                {{-- <div id="step-paypal-message" class="checkout-step text-center py-4" style="display:none;">
                                                    <p class="text-white">Vous allez être redirigé vers PayPal...</p>
                                                    <div class="spinner-border text-light" role="status">
                                                        <span class="visually-hidden">En cours ...</span>
                                                    </div>
                                                </div> --}} -->
                                            </div>
                                            @else
                                            <input type="text" class="form-control form-control-lg mb-3 rounded-lg" name="adresse_livraison" id="adresse_livraison_guest" placeholder="Adresse de livraison" required>
                                            <input type="text" class="form-control form-control-lg mb-3 rounded-lg" name="code_postal" id="code_postal_guest" placeholder="Code postal" required>
                                            <input type="text" class="form-control form-control-lg mb-3 rounded-lg" name="ville" id="ville_guest" placeholder="Ville" required>
                                            <p class="text-center text-white mt-3 rounded-pill">Connectez-vous pour passer une commande.</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="successMessage" class="alert alert-success text-center mt-3" style="display: none;">
            La commande a été passée avec succès !
        </div>

    </div>

    <!-- <div class="modal fade" id="paypalSimulationModal" tabindex="-1" aria-labelledby="paypalSimulationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paypalSimulationModalLabel">paiement PayPal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p id="paypalSimulationMessage">Redirection vers PayPal en cours...</p>
                    <div class="spinner-border text-primary mt-3" role="status">
                        <span class="visually-hidden">En cours...</span>
                    </div>
                </div>

            </div>
        </div>
    </div> -->

    <script>
        let currentStepIdForSimulation = 'step-address';

        function showSimulationStep(stepId) {
            document.querySelectorAll('#checkout-process-simulation .checkout-step').forEach(step => {
                step.style.display = 'none';
            });
            const stepElement = document.getElementById(stepId);
            if (stepElement) {
                stepElement.style.display = 'block';
                currentStepIdForSimulation = stepId;
            }
        }

        function validateAddressAndProceed() {
            const adresse = document.getElementById('adresse_livraison').value.trim();
            const cp = document.getElementById('code_postal').value.trim();
            const ville = document.getElementById('ville').value.trim();

            if (!adresse || !cp || !ville) {
                alert('Veuillez remplir tous les champs de l\'adresse de livraison.');
                return;
            }
            showSimulationStep('step-payment-options');
        }

        // // MISE À JOUR: Fonction simulatePaypal pour utiliser la modale
        // function simulatePaypal() {
        //     // Masquer le processus de checkout principal
        //     const checkoutProcessDiv = document.getElementById('checkout-process-simulation');
        //     if (checkoutProcessDiv) {
        //         checkoutProcessDiv.style.display = 'none';
        //     }

        //     // Récupérer les éléments de la modale
        //     const modalElement = document.getElementById('paypalSimulationModal');
        //     const modalMessage = document.getElementById('paypalSimulationMessage');
        //     const modalSpinner = modalElement.querySelector('.spinner-border');
        //     // Créer une instance de la modale Bootstrap (nécessite que Bootstrap JS soit chargé)
        //     const bsModal = new bootstrap.Modal(modalElement);

        //     // Afficher la modale
        //     bsModal.show();

        //     // Étape 1: Afficher le message de redirection et le spinner dans la modale
        //     modalMessage.textContent = 'Redirection vers PayPal en cours...';
        //     modalSpinner.style.display = 'inline-block'; // Afficher le spinner

        //     // Simuler un délai pour l'interaction PayPal (ex: login, confirmation)
        //     setTimeout(() => {
        //         // Étape 2: Afficher un message de succès simulé dans la modale
        //         modalMessage.textContent = 'Paiement PayPal simulé réussi !';
        //         modalSpinner.style.display = 'none'; // Masquer le spinner
        //         // Optionnel: ajouter une icône de succès
        //         // modalMessage.innerHTML = '<i class="fas fa-check-circle text-success me-2"></i> Paiement PayPal simulé réussi !';


        //         // Simuler le retour sur le site et finaliser la commande
        //         setTimeout(() => {
        //             // Étape 3: Fermer la modale
        //             bsModal.hide();
        //             // Procéder à la finalisation de la commande
        //             passerCommande();
        //         }, 1500); // Petit délai après l'affichage du succès

        //     }, 3000); // Délai simulant l'interaction avec PayPal


        // }


        function submitFakeCard() {
            const cardNumber = document.getElementById('fake_card_number').value.trim();
            const cardExpiry = document.getElementById('fake_card_expiry').value.trim();
            const cardCvv = document.getElementById('fake_card_cvv').value.trim();

            if (!cardNumber || !cardExpiry || !cardCvv) {
                alert('Veuillez remplir tous les champs de la carte pour la simulation.');
                return;
            }

            const checkoutProcessDiv = document.getElementById('checkout-process-simulation');
            if (checkoutProcessDiv) {
                checkoutProcessDiv.style.display = 'none';
            }
            passerCommande(); // Proceed with order finalization
        }

        function changerQuantiter(input) {
            var newQuantity = parseInt(input.value);
            var pricePerItem = parseFloat(input.getAttribute("data-item-price"));
            var itemId = input.getAttribute("data-item-id");

            if (!isNaN(newQuantity) && newQuantity > 0) {
                var itemPriceElement = input.closest('.row').querySelector(".item-price");

                if (itemPriceElement) {
                    var newTotal = newQuantity * pricePerItem;
                    itemPriceElement.textContent = "€ " + newTotal.toFixed(2);
                    calculerPrixTotal();
                }

                // Envoi de la nouvelle quantité au serveur
                fetch('{{ route("update-article-quantity") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            article_id: itemId,
                            quantity: newQuantity,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mise à jour du compteur d'articles dans la barre de navigation
                            document.getElementById('countArticle').textContent = data.totalItems;
                            document.getElementById('total-items-count').textContent = data.totalItems;
                        } else {
                            alert(data.message || 'Une erreur est survenue.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la mise à jour de la quantité :', error);
                    });
            } else {
                input.value = 1;
            }
        }




        function calculerPrixTotal() {
            var itemPrices = document.querySelectorAll('.item-price');
            var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
            document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
        }

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
                    body: JSON.stringify({
                        article_id: articleId
                    })
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



        function passerCommande() {
            const adresseLivraison = document.getElementById('adresse_livraison').value;
            const codePostal = document.getElementById('code_postal').value;
            const ville = document.getElementById('ville').value;

            // Afficher immédiatement un message de chargement
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            successMessage.textContent = 'Commande en cours, veuillez patienter...';

            fetch('{{ route("passer-commande") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        adresse_livraison: adresseLivraison,
                        code_postal: codePostal,
                        ville: ville
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau : ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        // Afficher le message d'erreur
                        successMessage.textContent = data.message;
                    } else {
                        // Mise à jour du message pour indiquer le succès
                        successMessage.textContent = data.message;

                        viderPanier(); // Vide le panier après succès
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la commande :', error);
                    successMessage.textContent = 'Une erreur est survenue lors du passage de la commande.';
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutProcessContainer = document.getElementById('checkout-process-simulation');
            if (checkoutProcessContainer && checkoutProcessContainer.getAttribute('data-initialize-view') === 'true') {
                showSimulationStep('step-address');
            }
        });
    </script>

    @vite(['resources/css/panier.css'])
</x-app-layout>