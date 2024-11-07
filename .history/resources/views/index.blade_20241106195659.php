<x-app-layout>

<style>
        .custom-Copyright {
            /*changer la police de caractère*/
            font-family: 'Raleway', sans-serif;
            /*changer la couleur de la police*/
            color: #de7105;
            /*changer la taille de la police*/
        }

        .nav-item {
            /*changer la police de caractère*/
            font-family: 'Raleway', sans-serif;
            /*changer la couleur de la police*/
            color: #de7105;
            /*changer la taille de la police*/
        }

    </style>
    @include('components.header')
    <br>

    @include('components.carousel')

    <br>


@vite(['resources/css/accueil.css'])

</x-app-layout>