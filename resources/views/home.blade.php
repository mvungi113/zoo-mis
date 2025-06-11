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
                <a href="#home" class="hover:underline text-base font-medium transition">Home</a>
                <a href="#demo" class="hover:underline text-base font-medium transition">Demo</a>

                <a href="#features" class="hover:underline text-base font-medium transition">Features</a>
                <a href="#contact" class="hover:underline text-base font-medium transition">Contact</a>
            </div>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mt-4 md:mt-0">
                <a href="{{ route('login') }}" class="border border-white px-4 py-2 rounded-md hover:bg-white hover:text-purple-600 font-semibold transition">Login</a>
                {{-- <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-md hover:bg-white hover:text-purple-600 font-semibold transition">Register</a> --}}
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="flex flex-col md:flex-row items-center justify-between min-h-screen p-4 md:p-12 pt-32 bg-gradient-to-br from-purple-800 via-purple-600 to-purple-400 text-white relative overflow-hidden">
        <!-- Decorative Background Shapes -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-900 opacity-20 rounded-full blur-3xl z-0"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-300 opacity-20 rounded-full blur-3xl z-0"></div>
        <!-- Hero Content -->
        <div class="max-w-lg text-center md:text-left z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg leading-tight">
                Real-Time Zoo Surveillance<br class="hidden md:block" />
                <span class="text-purple-200">and Management System</span>
            </h1>
            <h2 class="text-2xl md:text-3xl mb-4 font-semibold text-purple-200">Revolutionizing Animal &amp; Visitor Monitoring</h2>
            <p class="text-base md:text-lg mb-8 text-purple-100">
                Leverage AI-powered surveillance to protect animal welfare, detect stress, and enhance zoo security—all in real time.
            </p>
            <a href="#demo" class="inline-block bg-white text-purple-700 px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-purple-100 hover:text-purple-900 transition">
                See a Demo
            </a>
        </div>
        <!-- Hero Images: Centered in Animated Circle -->
        <div class="flex items-center justify-center mt-12 md:mt-0 z-10">
            <div class="relative w-64 h-64 md:w-96 md:h-96 flex items-center justify-center">
            <!-- Animated Ring -->
            <span class="absolute inset-0 rounded-full border-4 border-purple-300 animate-pulse"></span>
            <!-- Centered Images in a Row -->
            <div class="flex space-x-[-2rem] md:space-x-[-3rem] items-center justify-center absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
                <img src="{{ asset('images/tiger.jpg') }}" alt="Tiger"
                class="w-24 h-24 md:w-36 md:h-36 rounded-full border-4 border-white shadow-xl object-cover animate-fade-in-up delay-100" />
                <img src="{{ asset('images/elephant.jpg') }}" alt="Elephant"
                class="w-24 h-24 md:w-36 md:h-36 rounded-full border-4 border-white shadow-xl object-cover animate-fade-in-up delay-200" />
                <img src="{{ asset('images/wolf.jpg') }}" alt="Wolf"
                class="w-24 h-24 md:w-36 md:h-36 rounded-full border-4 border-white shadow-xl object-cover animate-fade-in-up delay-300" />
            </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>
    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(40px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-up { animation: fade-in-up 1s cubic-bezier(.4,0,.2,1) both;}
        .delay-100 { animation-delay: .1s;}
        .delay-200 { animation-delay: .2s;}
        .delay-300 { animation-delay: .3s;}
    </style>
    <!-- Demo Section -->
    <section id="demo" class="flex flex-col md:flex-row items-center justify-center py-20 px-4 md:px-16 bg-gradient-to-br from-purple-100 via-white to-purple-50">
        <div class="max-w-lg text-center md:text-left mb-10 md:mb-0">
            <h2 class="text-2xl md:text-3xl font-bold text-purple-700 mb-4">See ZooM in Action</h2>
            <p class="text-lg md:text-xl mb-4 font-medium text-gray-700">
                Experience how intelligent video monitoring elevates animal welfare and operational efficiency.
            </p>
            <p class="text-base md:text-lg text-gray-600 mb-6">
                Request a live demo and witness real-time animal behavior analysis, stress detection, and visitor safety features—all powered by AI.
            </p>
            <a href="#contact" class="inline-block bg-purple-700 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-purple-800 transition">
                Request a Demo
            </a>
        </div>
        <div class="md:ml-16 flex items-center justify-center">
            <div class="relative w-full max-w-xs md:max-w-md">
                <img src="{{ asset('images/giraffe-demo.jpg') }}" alt="Giraffe Demo" class="rounded-xl shadow-2xl border-4 border-purple-200 object-cover">
                <span class="absolute top-4 left-4 bg-white bg-opacity-80 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold shadow">
                    Live Monitoring
                </span>
                <span class="absolute bottom-4 right-4 bg-purple-700 bg-opacity-90 text-white px-3 py-1 rounded-full text-xs font-semibold shadow">
                    AI Insights
                </span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="flex items-center justify-center py-16 px-4 md:px-12 bg-white">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-6xl w-full">
            <!-- Card 1 -->
            <div class="group relative flex flex-col items-center text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-600 hover:text-white transition shadow-xl overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 group-hover:bg-white mb-4 transition">
                    <i class="bi bi-heart-pulse text-4xl text-purple-700 group-hover:text-purple-600 transition"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 group-hover:text-white mb-2 transition">Improve Animal Welfare</h3>
                <p class="text-gray-600 group-hover:text-purple-100 text-base mt-2 transition">Monitor animal health and stress in real-time for proactive care.</p>
                <span class="absolute inset-0 bg-purple-600 opacity-0 group-hover:opacity-10 transition"></span>
            </div>
            <!-- Card 2 -->
            <div class="group relative flex flex-col items-center text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-600 hover:text-white transition shadow-xl overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 group-hover:bg-white mb-4 transition">
                    <i class="bi bi-emoji-smile text-4xl text-purple-700 group-hover:text-purple-600 transition"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 group-hover:text-white mb-2 transition">Enhance Guest Experience</h3>
                <p class="text-gray-600 group-hover:text-purple-100 text-base mt-2 transition">Ensure visitor safety and engagement with intelligent monitoring.</p>
                <span class="absolute inset-0 bg-purple-600 opacity-0 group-hover:opacity-10 transition"></span>
            </div>
            <!-- Card 3 -->
            <div class="group relative flex flex-col items-center text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-600 hover:text-white transition shadow-xl overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 group-hover:bg-white mb-4 transition">
                    <i class="bi bi-gear-wide-connected text-4xl text-purple-700 group-hover:text-purple-600 transition"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 group-hover:text-white mb-2 transition">Increase Operational Efficiency</h3>
                <p class="text-gray-600 group-hover:text-purple-100 text-base mt-2 transition">Automate routine tasks and streamline zoo management processes.</p>
                <span class="absolute inset-0 bg-purple-600 opacity-0 group-hover:opacity-10 transition"></span>
            </div>
            <!-- Card 4 -->
            <div class="group relative flex flex-col items-center text-center p-8 border-2 border-purple-600 rounded-2xl bg-purple-50 hover:bg-purple-600 hover:text-white transition shadow-xl overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 group-hover:bg-white mb-4 transition">
                    <i class="bi bi-graph-up-arrow text-4xl text-purple-700 group-hover:text-purple-600 transition"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-purple-700 group-hover:text-white mb-2 transition">Grow Revenue & Reduce Cost</h3>
                <p class="text-gray-600 group-hover:text-purple-100 text-base mt-2 transition">Optimize resources and boost profitability with actionable insights.</p>
                <span class="absolute inset-0 bg-purple-600 opacity-0 group-hover:opacity-10 transition"></span>
            </div>
        </div>
    </section>

    <!-- Contact Section: Two Sides (Left: Text, Right: Table) -->
    <section id="contact" class="flex flex-col md:flex-row items-center justify-center py-16 px-4 md:px-12 bg-gray-100">
        <!-- Left Side: Text -->
        <div class="w-full md:w-1/2 max-w-lg mb-10 md:mb-0 md:mr-12">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 text-purple-700">Talk to a Computer Vision Expert Now</h2>
            <p class="text-base md:text-lg mb-4 text-gray-700">
                Have an idea that could transform your business but not sure how to make it happen? You’re in the right place.
            </p>
            <p class="text-base md:text-lg mb-4 text-gray-700">
                Fill out the form and let’s get this conversation started!, Via Email.
            </p>
            <p class="text-base text-gray-700">
                <span class="font-semibold">Email:</span>
                <a href="mailto:zoomanagement@zoo.com" class="text-purple-700 hover:underline">zoomanagement@zoo.com</a>
            </p>
        </div>
        <!-- Right Side: Table -->
        <div class="w-full md:w-1/2 max-w-lg">
            <div class="overflow-x-auto bg-white rounded-lg shadow p-6">
                <table class="min-w-full text-left text-gray-700">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b font-semibold">Feature</th>
                            <th class="py-2 px-4 border-b font-semibold">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 px-4 border-b">AI Monitoring</td>
                            <td class="py-2 px-4 border-b">Real-time animal and visitor surveillance</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Stress Detection</td>
                            <td class="py-2 px-4 border-b">Detects animal stress and abnormal behavior</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Visitor Safety</td>
                            <td class="py-2 px-4 border-b">Ensures guest safety with smart alerts</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">Operational Insights</td>
                            <td class="py-2 px-4 border-b">Actionable data for zoo management</td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4">Custom Solutions</td>
                            <td class="py-2 px-4">Tailored to your unique business needs</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                {{-- <a href="{{ route('register') }}" class="border border-white px-5 py-2 rounded-md hover:bg-white hover:text-purple-700 font-semibold transition">Register</a> --}}
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
