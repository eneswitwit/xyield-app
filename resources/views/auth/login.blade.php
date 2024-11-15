@extends('app')

@section('content')
    @include('partials.nav')
    <div class="flex h-screen bg-gray-200 p-4 rotate">
        <div class="sm:max-w-xl md:max-w-2xl w-full m-auto">
            @if (session('alert'))
                <div class="container mx-auto max-w-3xl mt-8 mb-8">
                    @php $alert_type = session('alert_type'); @endphp
                    <div class="@if($alert_type == 'info'){{ 'bg-blue-400' }}@elseif($alert_type == 'success'){{ 'bg-green-400' }}@elseif($alert_type == 'error'){{ 'bg-red-400' }}@elseif($alert_type == 'warning'){{ 'bg-orange-400' }}@endif text-white p-4 rounded-lg" role="alert">
                        <p class="font-bold">{{ ucfirst(session('alert_type')) }}</p>
                        <p>{{ session('alert') }}</p>
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="flex items-stretch bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-blue-500 sm:border-0">
                @csrf
                <div class="flex hidden overflow-hidden relative sm:block w-5/12 md:w-6/12 bg-gray-600 text-gray-300 py-4 bg-cover bg-center" style="background-image: url('/img/skyline.jpg')">
                    <div class="flex-1 absolute bottom-0 text-white p-10">
                        <h3 class="text-4xl font-bold inline-block">Anmelden</h3>
                        <p class="whitespace-no-wrap">
                            Willkommen zurück!
                        </p>
                    </div>
                    <svg class="absolute animate h-full w-4/12 sm:w-2/12 right-0 inset-y-0 fill-current text-white" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <polygon points="0,0 100,100 100,0">
                    </svg>
                </div>
                <div class="flex-1 p-6 sm:p-10 sm:py-12">
                    <h3 class="text-xl text-gray-700 font-bold mb-6">
                        Anmelden <span class="text-gray-400 font-light"> per Mail</span></h3>

                    <input id="email" type="email" class="px-3 w-full py-2 bg-gray-200 border border-gray-200 rounded focus:border-gray-400 focus:outline-none focus:bg-white mb-4 {{ $errors->has('email') ? ' border-red-500' : '' }}" placeholder="Mail" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('email') }}
                        </p>
                    @endif

                    <input id="password" type="password" class="px-3 w-full py-2 bg-gray-200 border border-gray-200 rounded focus:border-gray-400 focus:outline-none focus:bg-white mb-4 {{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required placeholder="Passwort">

                    <div class="flex flex-wrap items-center">
                        <div class="w-full sm:flex-1">
                            <input type="submit" value="Login" class="w-full sm:w-auto bg-blue-700 text-blue-100 px-6 py-2 rounded-full hover:bg-blue-600 focus:outline-none cursor-pointer">
                        </div>
                        <div class="text-sm text-gray-500 hover:text-gray-700 pt-4 sm:p-0">
                            <a href="{{ route('password.request') }}">Passwort vergessen?</a>
                        </div>
                    </div>

                    <p class="text-gray-500 font-medium mt-8 mb-4">oder anmelden mit</p>
                    @include('partials.oauth-buttons')

                    <p class="w-full text-xs text-left text-gray-700 mt-8">
                        Noch nicht registriert?
                        <a class="text-blue-500 hover:text-blue-700 no-underline" href="/register">
                            Jetzt Registrieren
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>
@endsection
