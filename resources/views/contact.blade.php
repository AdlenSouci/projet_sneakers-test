<x-app-layout>


    <div class="container mt-4" style="width:600px">

        <form>
            <div class="form-group">
                <label for="txtNom">Nom, prénom</label>
                <input type="text" class="form-control" id="txtNom" aria-describedby="emailHelp"
                    placeholder="Entrez vos nom et prénom">
            </div>

            <div class="form-group">
                <label for="txtEmail">Adresse e-mail</label>
                <input type="email" class="form-control" id="txtEmail" aria-describedby="emailHelp"
                    placeholder="Entrez votre adresse e-mail">
            </div>

            <div class="form-group">
                <label for="txtMessage">Votre message</label>
                <textarea class="form-control" id="txtMessage" placeholder="Entrez votre message">

                </textarea>
            </div>

            <button type="submit" id="btnEnvoyer" class="btn btn-primary">Envoyer</button>
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
                        email: 'philippe',
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