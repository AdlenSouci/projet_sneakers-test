<x-app-layout>


    @include('components.header')
    <br>

    @include('components.carousel')

    <br>

    <video width="320" height="240" controls>
        <source src="{{ asset('/video/' . $item['1']) }}" type="video/mp4">
        Votre navigateur ne prend pas en charge la vidéo.
    </video>


</x-app-layout>