@extends('app')

@section('title', 'Abonnement und Bezahlung')

@section('content')

<div class="bg-gray-200 min-h-screen pb-24">
    @include('partials.dashboard-header')
    
    <div class="container mx-auto max-w-3xl mt-8">

        <h1 class="text-2xl font-bold text-gray-700 px-6 md:px-0">Abonnement und Bezahlung</h1>
        @include('settings.nav')

        @if(auth()->user()->subscribed('main'))
            <div id="switch-plans-modal" class="fixed w-full h-full inset-0 z-50">
                <div class="fixed opacity-50 bg-black inset-0 w-full h-full"></div>
                <form method="POST" action="{{ route('billing.switch_plan') }}" class="absolute bg-white rounded-lg p-5" id="switch-plans">
                    @csrf
                    <div id="switch-plans-close" class="absolute right-0 top-0 -mt-4 -mr-4 w-8 h-8 rounded-full shadow bg-white text-center flex justify-center align-center text-xl font-bold cursor-pointer">&times;</div>
                    <p class="text-sm text-gray-600 mb-4">Abonnement ändern</p>
                    @include('partials.plans')
                    <button class="bg-blue-500 text-white text-sm font-medium px-6 py-2 rounded float-right uppercase cursor-pointer">
                        Abonnement ändern
                    </button>
                </form>
            </div>
        @endif

        <form action="{{ route('billing.save') }}" id="billing-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="w-full bg-white rounded-lg mx-auto mt-8 flex overflow-hidden rounded-b-none">
                <div class="w-1/3 bg-gray-100 p-8 hidden md:inline-block">
                    <h2 class="font-medium text-md text-gray-700 mb-4 tracking-wide">Abonnement und Bezahlung</h2>
                    <p class="text-xs text-gray-500">Aktualisiere dein Abonnement und deine Bezahlung.</p>
                </div>
                <div class="md:w-2/3 w-full">
                    
                    @if(auth()->user()->subscribed('main'))

                        <div class="py-8 px-16">

                            <div class="flex">
                                <img src="/img/plans/{{ auth()->user()->plan->name }}.png" class="w-16 h-16 mr-3">
                                <div>
                                    <span class="block">Plan {{ ucfirst(auth()->user()->plan->title) }} abonniert</span>
                                    <span class="text-xs text-gray-700">{{ auth()->user()->plan->description }}</span>
                                </div>
                            </div>
                            
                            @if (auth()->user()->subscription('main')->onGracePeriod())
                                <div class="bg-orange-500 px-5 py-2 rounded-lg text-white mt-4 text-xs">Du hast dein Abonnement gekündigt. Dein Konto ist noch bis zum {{ auth()->user()->subscription('main')->ends_at->toFormattedDateString() }} aktiv.</div>
                                <div class="flex justify-end items-end mt-4">
                                    <p class="text-sm text-gray-600 mr-2">oder stattdessen kannst du </p>
                                    <a href="{{ route('resume') }}" class="text-green-500 text-sm font-medium underline">Abonnement fortführen</a>
                                </div>
                            @else
                                <div class="flex justify-between items-center mt-4">
                                    <div id="switch-plan-btn" class="bg-gray-300 text-gray-600 text-sm font-medium px-6 py-2 rounded uppercase cursor-pointer inline-block">
                                        Ändere Abonnement
                                    </div>
                                    <a href="{{ route('cancel') }}" class="text-red-500 text-sm underline">Abonnement kündigen</a>
                                </div>
                            @endif
                        </div>

                        <hr class="border-gray-300">

                        <div class="py-8 px-16">
                            <div class="text-xs text-blue-600">Deine Bezahlmethode endet mit {{ auth()->user()->card_last_four }}</div>
                            <div class="text-xs text-gray-500">Um deine Bezahlmethode zu ändern, kannst du unten eine neue Kreditkarte hinzufügen.</div>
                        </div>
                        <hr class="border-gray-300">
                    @endif

                    @if(auth()->user()->onTrial())
                        <div class="py-8 px-16">
                            @include('partials.trial_notification')
                            <p class="text-sm text-gray-500 mt-2">Schließe jetzt ein Abonnement ab.</p>
                        </div>
                        <hr class="border-gray-300">
                    @endif

                    <div class="py-8 px-16">
                        <label for="card-holder-name" class="text-sm text-gray-600">Name auf Kreditkarte</label>
                        <input class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-blue-500" id="card-holder-name" type="text">
                    </div>
                    <hr class="border-gray-300">
                    <div class="py-8 px-16">
                        <label for="cc" class="text-sm text-gray-600">Kreditkarte</label>
                        <div id="card-element" class="mt-2 border-2 border-gray-200 px-3 py-2 block w-full rounded-lg text-base text-gray-900 focus:outline-none focus:border-blue-500"></div>
                        <div id="card-errors" class="text-red-400 text-bold mt-2 text-sm font-medium"></div>
                    </div>
                    @if(!auth()->user()->subscribed('main'))
                        <hr class="border-gray-300">
                        <div class="py-8 px-16">
                            <p class="text-sm text-gray-600 mb-4">Abonnement auswählen</p>
                            @include('partials.plans')
                        </div>
                    @endif

                </div>

            </div>
            <div class="p-16 py-8 bg-gray-300 clearfix rounded-b-lg border-t border-gray-200">
                <p class="float-left text-xs text-gray-500 tracking-tight mt-2">Klicke auf Speichern um dein Abonnement und Bezahlung zu aktualisieren</p>
                <button id="card-button" data-secret="{{ auth()->user()->createSetupIntent()->client_secret }}" class="bg-blue-500 text-white text-sm font-medium px-6 py-2 rounded float-right uppercase cursor-pointer">
                    Speichern
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('javascript')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        const cardError = document.getElementById('card-errors');

        cardElement.addEventListener('change', function(event) {
            if (event.error) {
                cardError.textContent = event.error.message;
            } else {
                cardError.textContent = '';
            }
        });

        var form = document.getElementById('billing-form');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const { setupIntent, error } = await stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
            if (error) {
                // Display "error.message" to the user...
                cardError.textContent = error.message;
            } else {
                // The card has been verified successfully...
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.appendChild(hiddenInput);
                // Submit the form
                form.submit();
            }
        });

    </script>
@endsection