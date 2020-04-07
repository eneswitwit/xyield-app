@extends('app')

@section('title', 'Dashboard')

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

            <div class="w-full bg-white rounded-lg mx-auto my-8 p-16">
                <h1 class="text-2xl font-medium mb-2">Dashboard</h1>
                <h2 class="font-medium text-sm text-gray-500 mb-4 uppercase tracking-wide">xyield.io ist die beste Suchmaschine für Immobilieninvestments</h2>
                <p>Hier sind bald tolle Statistiken und Analysen.</p>
            </div>
        </div>
    </div>

@endsection