<x-app-layout>
    <div class="container mt-4" style="width:600px">
        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="txtNom">Nom, prénom</label>
                <input type="text" name="name" class="form-control rounded" id="txtNom" placeholder="Entrez vos nom et prénom" required>
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
        </form>

        <!--si mail envoyer avec succes -->
        @if
        <!--si mail non envoyer -->
        
        @if 
    </div>
</x-app-layout>