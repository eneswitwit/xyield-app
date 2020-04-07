@extends('app')

@section('title', 'Security Settings')

@section('content')

<div class="bg-gray-200 min-h-screen pb-24">
    @include('partials.dashboard-header')
    
    <div class="container mx-auto max-w-3xl mt-8">

        <h1 class="text-2xl font-bold text-gray-700 px-6 md:px-0">Sicherheit</h1>
        @include('settings.nav')
        <form action="{{ route('security.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-full bg-white rounded-lg mx-auto mt-8 flex overflow-hidden rounded-b-none">
                <div class="w-1/3 bg-gray-100 p-8 hidden md:inline-block">
                    <h2 class="font-medium text-md text-gray-700 mb-4 tracking-wide">Sicherheit</h2>
                    <p class="text-xs text-gray-500">Aktualisiere dein Passwort.</p>
                </div>
                <div class="md:w-2/3 w-full">
                    <div class="py-8 px-16">
                        <label for="password" class="text-sm text-gray-600">Passwort</label>
                        <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-blue-500" type="password" value="" name="password">
                    </div>
                    <hr class="border-gray-200">
                    <div class="py-8 px-16">
                        <label for="password_confirmation" class="text-sm text-gray-600">Passwort Bestätigen</label>
                        <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-blue-500" type="password" value="" name="password_confirmation">
                    </div>

                </div>

            </div>
            <div class="p-16 py-8 bg-gray-300 clearfix rounded-b-lg border-t border-gray-200">
                <p class="float-left text-xs text-gray-500 tracking-tight mt-2">Klicke auf Speichern um dein Passwort zu aktualisieren</p>
                <input type="submit" class="bg-blue-500 text-white text-sm font-medium px-6 py-2 rounded float-right uppercase cursor-pointer" value="Speichern">
            </div>
        </form>
    </div>
</div>

@endsection