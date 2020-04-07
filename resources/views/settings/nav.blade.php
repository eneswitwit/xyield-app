<ul class="flex border-b border-gray-300 text-sm font-medium text-gray-600 mt-3 px-6 md:px-0">
    <li class="mr-8 @if(Request::is('settings/profile')){{ 'text-blue-600 border-b-2 border-blue-500' }}@else{{ 'hover:text-gray-900' }}@endif"><a href="{{ route('profile') }}" class="py-4 inline-block">Profil</a></li>
    <li class="mr-8 @if(Request::is('settings/security')){{ 'text-blue-600 border-b-2 border-blue-500' }}@else{{ 'hover:text-gray-900' }}@endif"><a href="{{ route('security') }}" class="py-4 inline-block">Sicherheit</a></li>
    <li class="mr-8 @if(Request::is('settings/billing')){{ 'text-blue-600 border-b-2 border-blue-500' }}@else{{ 'hover:text-gray-900' }}@endif"><a href="{{ route('billing') }}" class="py-4 inline-block">Abonnement</a></li>
    <li class="mr-8 @if(Request::is('settings/invoices')){{ 'text-blue-600 border-b-2 border-blue-500' }}@else{{ 'hover:text-gray-900' }}@endif"><a href="{{ route('invoices') }}" class="py-4 inline-block">Rechnungen</a></li>
</ul>