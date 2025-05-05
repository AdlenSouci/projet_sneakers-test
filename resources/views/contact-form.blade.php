<x-app-layout>

    <div class="container contact-form">
        <div class="contact-image">
            <img src="{{ asset('img_design/logo.png') }}" alt="..." />
        </div>

        @if (Auth::check())
        <form id="mailForm" method="POST" class="d-flex flex-column align-items-center">
            @csrf

            <h3 class="text-center">Contactez-nous</h3>

            <div class="form-group w-75">
                <textarea name="message" class="form-control" placeholder="Votre message *" style="width: 100%; height: 150px;" required></textarea>
            </div>

            <div class="form-group w-75 d-flex justify-content-center">
                {!! NoCaptcha::display() !!}
                @error('g-recaptcha-response')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group w-75 d-flex justify-content-center">
                <button type="submit" id="btnEnvoyer" class="btnContact">Envoyer</button>
            </div>
        </form>

        <!-- Pop-up de confirmation -->
        <div id="popupConfirmation" class="popup" style="display:none;">
            <p>Votre message a bien été envoyé.</p>
            <button id="closePopup" class="btnContactSubmit">OK</button>
        </div>
        @else
        <h3 class="text-center">Vous devez vous connecter pour envoyer un message.</h3>
        @endif

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
                        document.getElementById('popupConfirmation').style.display = 'block';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Erreur :", error);
                    alert("Une erreur est survenue lors de l'envoi du message.");
                });
        });

        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('popupConfirmation').style.display = 'none';
        });
    </script>

    {!! NoCaptcha::renderJs() !!}
</x-app-layout>