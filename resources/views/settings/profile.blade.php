@extends('app')

@section('title', 'Konto Einstellungen')

@section('content')

<div class="bg-gray-200 min-h-screen pb-24">
    @include('partials.dashboard-header')

    <div class="container mx-auto max-w-3xl mt-8">

        <h1 class="text-2xl font-bold text-gray-700 px-6 md:px-0">Konto Einstellungen</h1>
        @include('settings.nav')
        <form action="{{ route('profile.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-full bg-white rounded-lg mx-auto mt-8 flex overflow-hidden rounded-b-none">
                <div class="w-1/3 bg-gray-100 p-8 hidden md:inline-block">
                    <h2 class="font-medium text-md text-gray-700 mb-4 tracking-wide">Konto Einstellungen</h2>
                    <p class="text-xs text-gray-500">Aktualisiere Konto Informationen wie Email Adresse, Name und Profilbild.</p>
                </div>
                <div class="md:w-2/3 w-full">
                    <div class="py-8 px-16">
                        <label for="name" class="text-sm text-gray-600">Name</label>
                        <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-blue-500" type="text" value="{{ auth()->user()->name }}" name="name">
                    </div>
                    <hr class="border-gray-200">
                    <div class="py-8 px-16">
                        <label for="email" class="text-sm text-gray-600">Email Adresse</label>
                        <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-blue-500" type="email" name="email" value="{{ auth()->user()->email }}">
                    </div>
                    <hr class="border-gray-200">
                    <div class="py-8 px-16 clearfix">
                        <label for="photo" class="text-sm text-gray-600 w-full block">Profilbild</label>
                        <img class="rounded-full w-16 h-16 border-4 mt-2 border-gray-200 float-left" id="photo" src="{{ auth()->user()->photo }}" alt="photo">
                        <div class="bg-gray-200 text-gray-500 text-xs mt-5 ml-3 font-bold px-4 py-2 rounded-lg float-left hover:bg-gray-300 hover:text-gray-600 relative overflow-hidden cursor-pointer">
                            <input type="file" name="photo" onchange="loadFile(event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"> Bild hochladen
                        </div>
                    </div>

                </div>

            </div>
            <div class="p-16 py-8 bg-gray-300 clearfix rounded-b-lg border-t border-gray-200">
                <p class="float-left text-xs text-gray-500 tracking-tight mt-2">Klicke auf Speichern um deine Konto Informationen zu aktualisieren</p>
                <input type="submit" class="bg-blue-500 text-white text-sm font-medium px-6 py-2 rounded float-right uppercase cursor-pointer" value="Speichern">
            </div>
        </form>
    </div>
</div>

@endsection