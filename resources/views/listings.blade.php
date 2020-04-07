@extends('app')

@section('title', 'Investmentsuche')

@section('content')

    <div class="bg-gray-200 min-h-screen">
        @include('partials.dashboard-header')
        @if(auth()->user()->onTrial())
            <div class="container rounded-lg mx-auto mt-8">
                @include('partials.trial_notification', ['action_btn' => true])
            </div>
        @endif
        <div class="flex container mx-auto">

            @include('partials.dashboard-navbar')

            <div class="w-full mb-4">
                <div class="flex-auto w-full h-60 bg-white rounded-lg my-8 p-6">
                    <div class="flex-auto container mx-auto items-center">
                        <div class="w-auto justify-between items-center font-black text-gray-700">
                            <span class="text-basic font-medium">Großes Mehrfamilien Haus mit Ausbaupotential</span>
                        </div>
                        <div class="lg:items-center w-auto relative mr-2">
                            <nav class="mr-16">
                                <ul class="items-center justify-between text-sm font-medium text-gray-700 pt-2">
                                    <li class="mr-2"> Teilen </li>
                                    <li class="mr-2"> Speichern </li>
                                    <li class="mr-2"> Anschreiben </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="lg:items-center w-auto relative mr-2">
                            <svg class="h-6 w-6 text-blue-400 pt-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <svg class="h-6 w-6 text-blue-400 pt-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <svg class="h-6 w-6 text-blue-400 pt-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <svg class="h-6 w-6 text-gray-300 pt-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                            <svg class="h-6 w-6 text-gray-300 pt-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        </div>
                    </div>


                </div>
                <div class="w-full h-60 bg-white rounded-lg my-8 p-6">
                    <h1 class="text-2xl font-medium mb-2">Grundstück mit Baugenehmigung</h1>
                    <h2 class="font-medium text-sm text-gray-500 mb-4 uppercase tracking-wide">xyield.io ist die beste Suchmaschine für Immobilieninvestments</h2>
                    <p>Hier sind bald tolle Inserate.</p>
                </div>
            </div>


        </div>

    </div>

@endsection