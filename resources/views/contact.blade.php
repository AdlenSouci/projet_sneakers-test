<x-app-layout>


    <div class="container mt-4" style="width:600px">

        <form>
            <div class="form-group" >
                <label for="txtNom">Nom, prénom</label>
                <input type="text" class="form-control rounded" id="txtNom" aria-describedby="emailHelp"
                    placeholder="Entrez vos nom et prénom" required>
            </div>

            <div class="form-group">
                <label for="txtEmail">Adresse e-mail</label>
                <input type="email" class="form-control rounded" id="txtEmail" aria-describedby="emailHelp"
                    placeholder="Entrez votre adresse e-mail" required>
            </div>

            <div class="form-group">
                <label for="txtMessage">Votre message</label>
                <textarea class="form-control" id="txtMessage" placeholder="Entrez votre message" required>

                </textarea>
            </div>
            <br>
      
            <button type="submit" id="btnEnvoyer" class="btn btn-outline-dark custom-button rounded">Envoyer</button>
        </form>
    </div>


    <script>
        document.querySelector("#btnEnvoyer").addEventListener('click',
            function (event) {
                fetch("{{ route('mail.test') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: 'le_nom',
                        email: 'adlen',
                        message: 'le_message'
                    })
                })
                
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => {
                        alert("error");
                    })

            }
        );
    </script>
</x-app-layout>