<x-guest-layout>
    <!-- Navbar -->
    <nav class="flex justify-between items-center p-4 md:p-6 text-white fixed top-0 left-0 right-0 bg-gradient-to-r from-purple-700 to-purple-500 shadow-lg z-10">
        <a href="/" class="text-2xl md:text-3xl font-extrabold tracking-wide flex items-center space-x-2">
            <x-application-logo class="h-8 w-8 md:h-10 md:w-10" />
            <span>ZooM</span>
        </a>
        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div id="menu" class="hidden md:flex md:items-center md:space-x-8">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <a href="#" class="hover:underline text-base font-medium transition">Home</a>
                <a href="#" class="hover:underline text-base font-medium transition">About</a>
                <a href="#" class="hover:underline text-base font-medium transition">Contact Us</a>
            </div>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mt-4 md:mt-0">
                <a href="{{ route('login') }}" class="border border-white px-4 py-2 rounded-md hover:bg-white hover:text-purple-600 font-semibold transition">Login</a>
                <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-md hover:bg-white hover:text-purple-600 font-semibold transition">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col md:flex-row items-center justify-between min-h-screen p-4 md:p-12 pt-28 bg-gradient-to-br from-purple-700 via-purple-600 to-purple-500 text-white">
        <div class="max-w-lg text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg">Real-Time Zoo Surveillance & Management System</h1>
            <h2 class="text-2xl md:text-3xl mb-4 font-semibold">Revolutionizing Animal and Visitor Monitoring</h2>
            <p class="text-base md:text-lg mb-8">Leverage AI and real-time surveillance to protect animal welfare, detect stress, and improve zoo security.</p>
            <a href="#" class="bg-white text-purple-700 px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-gray-200 hover:text-purple-900 transition">See a Demo</a>
        </div>
        <div class="flex items-center justify-center mt-12 md:mt-0">
            <div class="relative w-56 h-56 md:w-80 md:h-80">
                <img src="{{ asset('images/tiger.jpg') }}" alt="Tiger" class="w-28 h-28 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl absolute top-0 left-0 object-cover">
                <img src="{{ asset('images/elephant.jpg') }}" alt="Elephant" class="w-28 h-28 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl absolute bottom-0 left-16 md:left-24 object-cover">
                <img src="{{ asset('images/wolf.jpg') }}" alt="Wolf" class="w-28 h-28 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl absolute top-16 left-28 md:top-24 md:left-44 object-cover">
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section class="flex flex-col md:flex-row items-center justify-center py-16 px-4 md:px-12 bg-gray-100">
        <div class="max-w-md text-center md:text-left mb-8 md:mb-0">
            <p class="text-lg md:text-xl mb-4 font-medium text-gray-700">Transform video feeds into vigilant guardians, observing every aspect of animal well-being with compassion and precision.</p>
            <p class="text-base md:text-lg text-gray-600">Contact us for a live demo and discover how we redefine animal care through intelligent video monitoring.</p>
        </div>
        <div class="md:ml-12">
            <img src="{{ asset('images/giraffe-demo.jpg') }}" alt="Giraffe Demo" class="w-full max-w-xs md:max-w-md rounded-xl shadow-2xl border-2 border-purple-200">
        </div>
    </section>

    <!-- Features Section -->
    <section class="flex items-center justify-center py-16 px-4 md:px-12 bg-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-6xl w-full">
            <div class="text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-100 transition shadow-md">
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 mb-2">Improve Animal Welfare</h3>
            </div>
            <div class="text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-100 transition shadow-md">
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 mb-2">Enhance Guest Experience</h3>
            </div>
            <div class="text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-100 transition shadow-md">
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 mb-2">Increase Operational Efficiency</h3>
            </div>
            <div class="text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-100 transition shadow-md">
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 mb-2">Grow Revenue & Reduce Cost</h3>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="flex items-center justify-center py-16 px-4 md:px-12 bg-gray-100 text-center">
        <div class="max-w-lg w-full">
            <h2 class="text-2xl md:text-3xl font-bold mb-6 text-purple-700">Talk to a Computer Vision Expert</h2>
            <p class="text-base md:text-lg mb-4 text-gray-700">Have an idea to transform your zoo? Fill out the form and let's start the conversation via email.</p>

            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="w-full mt-6 space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <input type="text" name="first_name" placeholder="First Name" required class="w-full p-3 border rounded-md @error('first_name') border-red-500 @enderror focus:ring-2 focus:ring-purple-400">
                    <input type="text" name="last_name" placeholder="Last Name" required class="w-full p-3 border rounded-md @error('last_name') border-red-500 @enderror focus:ring-2 focus:ring-purple-400">
                </div>
                <input type="email" name="email" placeholder="Email Address" required class="w-full p-3 border rounded-md @error('email') border-red-500 @enderror focus:ring-2 focus:ring-purple-400">
                <textarea name="comment" placeholder="Comment Here..." required class="w-full p-3 border rounded-md h-32 @error('comment') border-red-500 @enderror focus:ring-2 focus:ring-purple-400"></textarea>
                <button type="submit" class="bg-purple-700 text-white px-8 py-3 rounded-lg font-bold hover:bg-purple-800 transition">Send</button>
            </form>

            <p class="mt-6 text-base text-gray-700">Email: <a href="mailto:zoomanagement@zoom.com" class="text-purple-700 hover:underline">zoomanagement@zoom.com</a></p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="flex flex-col items-center justify-center py-12 px-4 md:px-6 bg-gradient-to-r from-purple-700 to-purple-500 text-white text-center">
        <div class="flex flex-wrap justify-center gap-6 mb-8">
            <img src="{{ asset('images/lion.jpg') }}" alt="Lion" class="w-20 h-20 md:w-24 md:h-24 rounded-xl shadow-lg border-2 border-white object-cover">
            <img src="{{ asset('images/elephant.jpg') }}" alt="Elephant" class="w-20 h-20 md:w-24 md:h-24 rounded-xl shadow-lg border-2 border-white object-cover">
            <img src="{{ asset('images/zebra.jpg') }}" alt="Zebra" class="w-20 h-20 md:w-24 md:h-24 rounded-xl shadow-lg border-2 border-white object-cover">
            <img src="{{ asset('images/tiger.jpg') }}" alt="Tiger" class="w-20 h-20 md:w-24 md:h-24 rounded-xl shadow-lg border-2 border-white object-cover">
        </div>
        <div class="mb-4">
            <p class="text-base">Login or Register to ZooM Surveillance and Management System</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="{{ route('login') }}" class="border border-white px-5 py-2 rounded-md hover:bg-white hover:text-purple-700 font-semibold transition">Login</a>
                <a href="{{ route('register') }}" class="border border-white px-5 py-2 rounded-md hover:bg-white hover:text-purple-700 font-semibold transition">Register</a>
            </div>
        </div>
        <p class="text-sm mt-6 opacity-80">ZOO SURVEILLANCE AND MANAGEMENT SYSTEM 2024-2025</p>
    </footer>
</x-guest-layout>

<!-- JavaScript to Toggle Mobile Menu -->
<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('menu').classList.toggle('hidden');
    });
</script>
