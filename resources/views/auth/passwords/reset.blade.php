@extends('app')

@section('content')
    @include('partials.nav')
    <div class="flex h-screen bg-gray-200 p-4 rotate">
        <div class="sm:max-w-xl md:max-w-2xl w-full m-auto">

            @if (session('status'))
                <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="flex items-stretch bg-white rounded-lg shadow-lg overflow-hidden border-t-4 border-blue-500 sm:border-0">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="flex hidden overflow-hidden relative sm:block w-5/12 md:w-6/12 bg-gray-600 text-gray-300 py-4 bg-cover bg-center" style="background-image: url('/img/skyline.jpg')">
                    <div class="flex-1 absolute bottom-0 text-white p-10">
                        <h3 class="text-2xl font-bold inline-block">Passwort Zurücksetzen</h3>
                        <p class="whitespace-no-wrap">
                            Setze dein Passwort zurück
                        </p>
                    </div>
                    <svg class="absolute animate h-full w-4/12 sm:w-2/12 right-0 inset-y-0 fill-current text-white" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                        <polygon points="0,0 100,100 100,0">
                    </svg>
                </div>
                <div class="flex-1 p-6 sm:p-10 sm:py-12">
                    <h3 class="text-xl text-gray-700 font-bold mb-6">
                        Neues <span class="text-gray-400 font-light">Passwort</span></h3>

                    <!-- Email Address -->
                    <input id="email" type="email" class="px-3 w-full py-2 bg-gray-200 border border-gray-200 rounded focus:border-gray-400 focus:outline-none focus:bg-white mb-4 {{ $errors->has('email') ? ' border-red' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Mail">
                    @if ($errors->has('email'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('email') }}
                        </p>
                    @endif

                    <!-- Password -->
                    <input id="password" type="password" class="px-3 w-full py-2 bg-gray-200 border border-gray-200 rounded focus:border-gray-400 focus:outline-none focus:bg-white mb-4 {{ $errors->has('password') ? ' border-red' : '' }}" name="password" required placeholder="Passwort">
                    @if ($errors->has('password'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('password') }}
                        </p>
                    @endif

                    <!-- Confirm Password -->
                    <input id="password-confirm" type="password" class="px-3 w-full py-2 bg-gray-200 border border-gray-200 rounded focus:border-gray-400 focus:outline-none focus:bg-white mb-4 " name="password_confirmation" required placeholder="Passwort Bestätigen">

                    <div class="flex flex-wrap items-center">
                        <div class="w-full sm:flex-1">
                            <input type="submit" value="Bestätigen" class="w-full sm:w-auto bg-blue-700 text-blue-100 px-6 py-2 rounded hover:bg-blue-600 focus:outline-none cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
