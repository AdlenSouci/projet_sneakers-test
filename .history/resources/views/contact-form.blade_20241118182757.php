<x-app-layout>
    <div class="container mt-4" style="width:400px; border: 1px solid #000; padding: 20px; border-radius: 5px;">
        <form id="mailForm" method="POST">
            @csrf

            <div class="container mt-4 mb-4">
                <div class="form-group">
                    <label for="txtNom">Nom</label>
                    <input type="text" name="name" class="form-control rounded" id="txtNom" placeholder="Entrez votre nom" required>
                </div>
                <div class="form-group">
                    <label for="txtPrenom">Prenom</label>
                    <input type="text" name="username" class="form-control rounded" id="txtPrenom" placeholder="Entrez votre prenom" required>
                </div>

                <div class="form-group">
                    <label for="txtEmail">Adresse e-mail</label>
                    <input type="email" name="email" class="form-control rounded" id="txtEmail" placeholder="Entrez votre adresse e-mail" required>
                </div>

                <div class="form-group">
                    <label for="txtMessage">Votre message</label>
                    <textarea class="form-control" name="message" id="txtMessage" placeholder="Entrez votre message" required></textarea>
                </div>
                <br>
                <button type="submit" id="btnEnvoyer" class="btn btn-outline-dark custom-button rounded">Envoyer</button>
            </div>
        </form>

        <!-- Pop-up de confirmation -->
        <div id="popupConfirmation" class="popup" style="display:none;">
            <p>Votre message a bien été envoyé.</p>
            <button id="closePopup" class="btn btn-outline-dark custom-button rounded">OK</button>
        </div>
    </div>


    @vite(['resources/css/accueil.css'])

    <script>
        document.getElementById('mailForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            fetch("{{ route('mail.test') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher le pop-up de succès si l'email est envoyé
                        document.getElementById('popupConfirmation').style.display = 'block';
                    } else {
                        // Afficher une alerte avec le message d'erreur retourné par le serveur
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Erreur :", error);
                    alert("Une erreur est survenue lors de l'envoi du message.");
                });
        });

        // Fermer le pop-up
        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('popupConfirmation').style.display = 'none';
        });
    </script>


    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
    </style>
</x-app-layout>