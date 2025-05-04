<x-guest-layout>
    <!-- Navbar -->
    <nav class="flex justify-between items-center p-4 md:p-6 text-white fixed top-0 left-0 right-0 bg-purple-600 z-10">
        <div class="text-xl md:text-2xl font-bold">ZooM</div>
        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div id="menu" class="hidden md:flex md:items-center md:space-x-6">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                <a href="#" class="hover:underline text-sm md:text-base">Home</a>
                <a href="#" class="hover:underline text-sm md:text-base">About</a>
                <a href="#" class="hover:underline text-sm md:text-base">Contact Us</a>
            </div>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mt-4 md:mt-0">
                <a href="{{ route('login') }}" class="border border-white px-3 py-1 md:px-4 md:py-2 rounded-md hover:bg-white hover:text-purple-600 transition text-sm md:text-base">Login</a>
                <a href="{{ route('register') }}" class="border border-white px-3 py-1 md:px-4 md:py-2 rounded-md hover:bg-white hover:text-purple-600 transition text-sm md:text-base">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col md:flex-row items-center justify-between min-h-screen p-4 md:p-12 text-white pt-24 bg-purple-700">
        <div class="max-w-lg text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Real-Time Zoo Surveillance & Management System</h1>
            <h2 class="text-2xl md:text-3xl mb-4">Revolutionizing Animal and Visitor Monitoring</h2>
            <p class="text-sm md:text-base mb-6">Leverage AI and real-time surveillance to protect animal welfare, detect stress, and improve zoo security.</p>
            <a href="#" class="bg-white text-purple-600 px-6 py-3 rounded-md font-semibold hover:bg-gray-200 transition">See a Demo</a>
        </div>
        <div class="flex items-center justify-center mt-12 md:mt-0">
            <div class="relative w-48 h-48 md:w-64 md:h-64">
                <img src="{{ asset('images/tiger.jpg') }}" alt="Tiger" class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-lg absolute top-0 left-0">
                <img src="{{ asset('images/elephant.jpg') }}" alt="Elephant" class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-lg absolute bottom-0 left-12 md:left-16">
                <img src="{{ asset('images/wolf.jpg') }}" alt="Wolf" class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-lg absolute top-12 left-24 md:top-16 md:left-32">
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section class="flex flex-col md:flex-row items-center justify-center py-16 px-4 md:px-12 bg-gray-100">
        <div class="max-w-md text-center md:text-left mb-8 md:mb-0">
            <p class="text-base md:text-lg mb-4">Transform video feeds into vigilant guardians, observing every aspect of animal well-being with compassion and precision.</p>
            <p class="text-sm md:text-base">Contact us for a live demo and discover how we redefine animal care through intelligent video monitoring.</p>
        </div>
        <div class="md:ml-12">
            <img src="{{ asset('images/giraffe-demo.jpg') }}" alt="Giraffe Demo" class="w-full max-w-xs md:max-w-md rounded-lg shadow-lg">
        </div>
    </section>

    <!-- Features Section -->
    <section class="flex items-center justify-center py-16 px-4 md:px-12 bg-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 max-w-6xl">
            <div class="text-center p-6 border border-purple-600 rounded-lg">
                <h3 class="text-lg md:text-xl font-semibold">Improve Animal Welfare</h3>
            </div>
            <div class="text-center p-6 border border-purple-600 rounded-lg">
                <h3 class="text-lg md:text-xl font-semibold">Enhance Guest Experience</h3>
            </div>
            <div class="text-center p-6 border border-purple-600 rounded-lg">
                <h3 class="text-lg md:text-xl font-semibold">Increase Operational Efficiency</h3>
            </div>
            <div class="text-center p-6 border border-purple-600 rounded-lg">
                <h3 class="text-lg md:text-xl font-semibold">Grow Revenue & Reduce Cost</h3>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="flex items-center justify-center py-16 px-4 md:px-12 bg-gray-100 text-center">
        <div class="max-w-lg">
            <h2 class="text-2xl font-bold mb-6">Talk to a Computer Vision Expert</h2>
            <p class="text-sm md:text-base mb-4">Have an idea to transform your zoo? Fill out the form and let's start the conversation via email.</p>

            @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="w-full mt-6">
                @csrf
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4">
                    <input type="text" name="first_name" placeholder="First Name" required class="w-full p-3 border rounded-md @error('first_name') border-red-500 @enderror">
                    <input type="text" name="last_name" placeholder="Last Name" required class="w-full p-3 border rounded-md @error('last_name') border-red-500 @enderror">
                </div>
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email Address" required class="w-full p-3 border rounded-md @error('email') border-red-500 @enderror">
                </div>
                <div class="mb-4">
                    <textarea name="comment" placeholder="Comment Here..." required class="w-full p-3 border rounded-md h-32 @error('comment') border-red-500 @enderror"></textarea>
                </div>
                <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-md hover:bg-purple-700 transition">Send</button>
            </form>

            <p class="mt-6 text-sm md:text-base">Email: <a href="mailto:zoomanagement@zoom.com" class="text-purple-600 hover:underline">zoomanagement@zoom.com</a></p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="flex flex-col items-center justify-center py-16 px-4 md:px-6 bg-purple-600 text-white text-center">
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <img src="{{ asset('images/lion.jpg') }}" alt="Lion" class="w-20 h-20 md:w-24 md:h-24 rounded-lg">
            <img src="{{ asset('images/elephant.jpg') }}" alt="Elephant" class="w-20 h-20 md:w-24 md:h-24 rounded-lg">
            <img src="{{ asset('images/zebra.jpg') }}" alt="Zebra" class="w-20 h-20 md:w-24 md:h-24 rounded-lg">
            <img src="{{ asset('images/tiger.jpg') }}" alt="Tiger" class="w-20 h-20 md:w-24 md:h-24 rounded-lg">
        </div>
        <div class="mb-4">
            <p class="text-sm md:text-base">Login or Register to ZooM Surveillance and Management System</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="{{ route('login') }}" class="border border-white px-4 py-2 rounded-md hover:bg-white hover:text-purple-600 transition">Login</a>
                <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-md hover:bg-white hover:text-purple-600 transition">Register</a>
            </div>
        </div>
        <p class="text-sm mt-6">ZOO SURVEILLANCE AND MANAGEMENT SYSTEM 2024-2025</p>
    </footer>
</x-guest-layout>

<!-- JavaScript to Toggle Mobile Menu -->
<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('menu').classList.toggle('hidden');
    });
</script>
