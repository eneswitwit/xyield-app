<div class="absolute w-full z-20">
    <!-- Nav Bar -->
    <nav class="font-sans text-center flex justify-between my-4 mx-auto container overflow-hidden mt-8 z-50 relative px-5">
        <a href="/" class="toggleColour text-gray-700 no-underline hover:no-underline font-bold text-2xl lg:text-4xl h-6 pt-1 mx-auto sm:mx-0">
            <img src="/img/logo.png" class="h-full mt-1" alt="XYield Logo">
        </a>
        <ul class="text-sm text-grey-dark list-reset flex items-center">
            <li class="mr-8">
                <a href="/" class="font-semibold text-blue-500">Startseite</a>
            </li>
            <li class="mr-8">
                <a href="/#_" class="font-semibold text-gray-900 hover:text-blue-500">Funktionen</a>
            </li>
            <li class="mr-8">
                <a href="/#_" class="font-semibold text-gray-900 hover:text-blue-500">Preise</a>
            </li>
            <li class="mr-8">
                <a href="/#_" class="font-semibold text-gray-900 hover:text-blue-500">FAQ</a>
            </li>
            <li>
                <a href="{{ route('login') }}" class="text-white ml-4 py-2 px-6 rounded-full bg-gray-800 font-bold hidden sm:block bg-blue-700">Login</a>
            </li>
        </ul>
    </nav>
</div>