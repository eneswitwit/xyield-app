@extends('app')

@section('title', 'Support')

@section('content')

    <div class="bg-gray-200 min-h-screen">
        @include('partials.dashboard-header')
        <div class="max-w-3xl bg-white rounded-lg mx-auto my-16 px-16 py-12">
            <h1 class="text-2xl font-medium mb-2">Du hast eine Frage oder hast Feedback?</h1>
            <p>Bitte beschreibe deine Frage detailliert und sei genau in deiner Formulierung.</p>
            <form action="{{ route('support.send') }}" method="POST" class="clearfix">
                @csrf
                <input type="text" class="wt-input" name="subject" placeholder="Betreff" value="{{ old('subject') }}">
                <textarea class="wt-input" name="message" cols="30" rows="10" placeholder="Deine Nachricht an uns">{{ old('message') }}</textarea>
                <button class="wt-button mt-4">Nachricht schicken</button>
            </form>
        </div>
    </div>

@endsection