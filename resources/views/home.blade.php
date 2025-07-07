<x-guest-layout>
    <!-- Navbar - Increased z-index -->
    <nav class="flex justify-between items-center p-4 md:p-6 text-white fixed top-0 left-0 right-0 bg-gradient-to-r from-indigo-600 to-blue-600 shadow-lg backdrop-blur-sm bg-opacity-90 z-50">
        <a href="/" class="text-2xl md:text-3xl font-extrabold tracking-wide flex items-center space-x-2 transition-transform duration-200 hover:scale-105">
            <x-application-logo class="h-8 w-8 md:h-10 md:w-10" />
            <span>Zoo Intelligence</span>
        </a>
        <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div id="menu" class="hidden md:flex md:items-center md:space-x-8">
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <a href="#home" class="hover:underline text-base font-medium transition flex items-center">
                    <i class="bi bi-house-door mr-1.5"></i> Home
                </a>
                <a href="#demo" class="hover:underline text-base font-medium transition flex items-center">
                    <i class="bi bi-play-circle mr-1.5"></i> Demo
                </a>
                <a href="#features" class="hover:underline text-base font-medium transition flex items-center">
                    <i class="bi bi-grid-3x3-gap mr-1.5"></i> Features
                </a>
                <a href="#contact" class="hover:underline text-base font-medium transition flex items-center">
                    <i class="bi bi-chat-dots mr-1.5"></i> Contact
                </a>
            </div>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mt-4 md:mt-0">
                <a href="{{ route('login') }}" class="px-5 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 backdrop-blur-sm rounded-lg flex items-center justify-center space-x-2 transition-all shadow-md hover:shadow-lg">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Sign In</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Adjusted padding top -->
    <section id="home" class="flex flex-col md:flex-row items-center justify-between min-h-screen p-4 md:p-12 pt-24 md:pt-32 bg-gradient-to-br from-blue-900 via-indigo-700 to-blue-600 text-white relative overflow-hidden">
        <!-- Animated Background Blobs -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-200 opacity-20 rounded-full mix-blend-multiply filter blur-3xl animate-blob z-0"></div>
        <div class="absolute top-1/2 -right-20 transform -translate-y-1/2 w-80 h-80 bg-blue-300 opacity-20 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000 z-0"></div>
        <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-blue-200 opacity-20 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000 z-0"></div>
        
        <!-- Hero Content -->
        <div class="w-full max-w-2xl text-center md:text-left z-10 md:pr-12">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4 drop-shadow-lg leading-tight">
            Real-Time Zoo Surveillance<br class="hidden md:block" />
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-200 to-indigo-100">and Management System</span>
            </h1>
            <h2 class="text-2xl md:text-3xl mb-4 font-semibold text-blue-100">Revolutionizing Animal &amp; Visitor Monitoring</h2>
            <p class="text-base md:text-lg mb-8 text-blue-100 bg-blue-800 bg-opacity-30 backdrop-blur-sm p-4 rounded-lg shadow-lg">
                Leverage AI-powered surveillance to protect animal welfare, detect stress, and enhance zoo security—all in real time.
            </p>
            <a href="#demo" class="inline-block bg-white text-indigo-700 px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-indigo-100 hover:text-indigo-800 transition flex items-center">
                <i class="bi bi-camera-video mr-2"></i>
                See a Demo
            </a>
        </div>
        
        <!-- Hero Images: Centered in Animated Circle -->
        <div class="flex items-center justify-center mt-12 md:mt-0 z-10">
            <div class="relative w-64 h-64 md:w-96 md:h-96 flex items-center justify-center">
                <!-- Animated Rings -->
                <span class="absolute inset-0 rounded-full border-4 border-indigo-300 animate-pulse"></span>
                <span class="absolute inset-2 rounded-full border-2 border-blue-300 animate-ping opacity-75"></span>
                
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
    </section>

    <!-- Demo Section -->
    <section id="demo" class="flex flex-col md:flex-row items-center justify-center py-20 px-4 md:px-16 bg-gradient-to-br from-indigo-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900/40 relative">
        <!-- Background Blobs -->
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-indigo-100 dark:bg-indigo-900/20 opacity-50 rounded-full mix-blend-multiply filter blur-3xl z-0"></div>
        
        <div class="max-w-lg text-center md:text-left mb-10 md:mb-0 z-10">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">See Zoo Intelligence in Action</h2>
            <p class="text-lg md:text-xl mb-4 font-medium text-gray-700 dark:text-gray-300">
                Experience how intelligent video monitoring elevates animal welfare and operational efficiency.
            </p>
            <p class="text-base md:text-lg text-gray-600 dark:text-gray-400 mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md backdrop-blur-sm bg-opacity-60 dark:bg-opacity-60">
                Request a live demo and witness real-time animal behavior analysis, stress detection, and visitor safety features—all powered by AI.
            </p>
            <a href="#contact" class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-bold shadow-lg transition flex items-center">
                <i class="bi bi-calendar-check mr-2"></i>
                Request a Demo
            </a>
        </div>
        <div class="md:ml-16 flex items-center justify-center z-10">
            <div class="relative w-full max-w-xs md:max-w-md">
                <img src="{{ asset('images/giraffe-demo.jpg') }}" alt="Giraffe Demo" class="rounded-xl shadow-2xl border-4 border-white dark:border-gray-700 object-cover">
                <span class="absolute top-4 left-4 bg-white dark:bg-gray-800 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold shadow flex items-center">
                    <i class="bi bi-broadcast mr-1 text-green-500 animate-ping-slow"></i>
                    <span class="text-blue-600 dark:text-blue-400">Live Monitoring</span>
                </span>
                <span class="absolute bottom-4 right-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow flex items-center">
                    <i class="bi bi-cpu mr-1"></i>
                    <span>AI Insights</span>
                </span>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="flex items-center justify-center py-16 px-4 md:px-12 bg-white dark:bg-gray-900 relative overflow-hidden">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-50 dark:bg-blue-900/10 opacity-70 rounded-full mix-blend-multiply filter blur-3xl z-0 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-50 dark:bg-indigo-900/10 opacity-70 rounded-full mix-blend-multiply filter blur-3xl z-0 animate-blob"></div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 max-w-6xl w-full z-10">
            <!-- Card 1 -->
            <div class="group relative flex flex-col items-center text-center p-8 border border-indigo-200 dark:border-indigo-800 rounded-2xl bg-white dark:bg-gray-800 bg-opacity-80 dark:bg-opacity-80 backdrop-blur-sm hover:border-indigo-600 hover:shadow-lg dark:hover:border-indigo-500 transition-all duration-300 shadow-md overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/40 group-hover:bg-indigo-600 dark:group-hover:bg-indigo-600 mb-4 transition-all duration-300">
                    <i class="bi bi-heart-pulse text-4xl text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-all"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Improve Animal Welfare</h3>
                <p class="text-gray-600 dark:text-gray-300 text-base mt-2">Monitor animal health and stress in real-time for proactive care.</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </div>
            
            <!-- Card 2 -->
            <div class="group relative flex flex-col items-center text-center p-8 border border-indigo-200 dark:border-indigo-800 rounded-2xl bg-white dark:bg-gray-800 bg-opacity-80 dark:bg-opacity-80 backdrop-blur-sm hover:border-indigo-600 hover:shadow-lg dark:hover:border-indigo-500 transition-all duration-300 shadow-md overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/40 group-hover:bg-indigo-600 dark:group-hover:bg-indigo-600 mb-4 transition-all duration-300">
                    <i class="bi bi-emoji-smile text-4xl text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-all"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Enhance Guest Experience</h3>
                <p class="text-gray-600 dark:text-gray-300 text-base mt-2">Ensure visitor safety and engagement with intelligent monitoring.</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </div>
            
            <!-- Card 3 -->
            <div class="group relative flex flex-col items-center text-center p-8 border border-indigo-200 dark:border-indigo-800 rounded-2xl bg-white dark:bg-gray-800 bg-opacity-80 dark:bg-opacity-80 backdrop-blur-sm hover:border-indigo-600 hover:shadow-lg dark:hover:border-indigo-500 transition-all duration-300 shadow-md overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/40 group-hover:bg-indigo-600 dark:group-hover:bg-indigo-600 mb-4 transition-all duration-300">
                    <i class="bi bi-gear-wide-connected text-4xl text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-all"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Increase Operational Efficiency</h3>
                <p class="text-gray-600 dark:text-gray-300 text-base mt-2">Automate routine tasks and streamline zoo management processes.</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </div>
            
            <!-- Card 4 -->
            <div class="group relative flex flex-col items-center text-center p-8 border border-indigo-200 dark:border-indigo-800 rounded-2xl bg-white dark:bg-gray-800 bg-opacity-80 dark:bg-opacity-80 backdrop-blur-sm hover:border-indigo-600 hover:shadow-lg dark:hover:border-indigo-500 transition-all duration-300 shadow-md overflow-hidden">
                <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 dark:bg-indigo-900/40 group-hover:bg-indigo-600 dark:group-hover:bg-indigo-600 mb-4 transition-all duration-300">
                    <i class="bi bi-graph-up-arrow text-4xl text-indigo-600 dark:text-indigo-400 group-hover:text-white transition-all"></i>
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Grow Revenue & Reduce Cost</h3>
                <p class="text-gray-600 dark:text-gray-300 text-base mt-2">Optimize resources and boost profitability with actionable insights.</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="flex flex-col md:flex-row items-center justify-center py-16 px-4 md:px-12 bg-gray-50 dark:bg-gray-800 relative">
        <!-- Background Blob -->
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-50 dark:bg-blue-900/10 opacity-70 rounded-full mix-blend-multiply filter blur-3xl z-0 animate-blob"></div>
        
        <!-- Left Side: Text -->
        <div class="w-full md:w-1/2 max-w-lg mb-10 md:mb-0 md:mr-12 z-10">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400">Talk to a Computer Vision Expert Now</h2>
            
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-6 backdrop-blur-sm bg-opacity-80 dark:bg-opacity-80">
                <p class="text-base md:text-lg mb-4 text-gray-700 dark:text-gray-300">
                    Have an idea that could transform your business but not sure how to make it happen? You're in the right place.
                </p>
                <p class="text-base md:text-lg mb-4 text-gray-700 dark:text-gray-300">
                    Fill out the form and let's get this conversation started via email.
                </p>
                <div class="flex items-center mt-6 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-4 text-indigo-600 dark:text-indigo-400">
                        <i class="bi bi-envelope-fill text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Email us at</p>
                        <a href="mailto:zoomanagement@zoo.com" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">
                            zoointelligence@zoo.com
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side: Table -->
        <div class="w-full md:w-1/2 max-w-lg z-10">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden backdrop-blur-sm bg-opacity-80 dark:bg-opacity-80">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-4">
                    <h3 class="font-semibold text-lg">Key System Features</h3>
                </div>
                <div class="overflow-x-auto p-6">
                    <table class="min-w-full text-left text-gray-700 dark:text-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b dark:border-gray-700 font-semibold">Feature</th>
                                <th class="py-2 px-4 border-b dark:border-gray-700 font-semibold">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700 flex items-center">
                                    <i class="bi bi-camera-video mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                    AI Monitoring
                                </td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">Real-time animal and visitor surveillance</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700 flex items-center">
                                    <i class="bi bi-activity mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                    Stress Detection
                                </td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">Detects animal stress and abnormal behavior</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700 flex items-center">
                                    <i class="bi bi-shield-check mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                    Visitor Safety
                                </td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">Ensures guest safety with smart alerts</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b dark:border-gray-700 flex items-center">
                                    <i class="bi bi-graph-up mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                    Operational Insights
                                </td>
                                <td class="py-2 px-4 border-b dark:border-gray-700">Actionable data for zoo management</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 flex items-center">
                                    <i class="bi bi-gear mr-2 text-indigo-500 dark:text-indigo-400"></i>
                                    Custom Solutions
                                </td>
                                <td class="py-2 px-4">Tailored to your unique business needs</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-700 to-indigo-700 text-white py-12 px-4 md:px-6 relative">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 left-1/3 w-96 h-96 bg-blue-400 opacity-10 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute -bottom-24 right-1/4 w-72 h-72 bg-indigo-400 opacity-10 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        </div>
        
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <!-- Logo and Tagline -->
                <div class="md:col-span-3 flex flex-col items-center md:items-start">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                            <x-application-logo class="h-8 w-8" />
                        </div>
                        <span class="text-2xl font-bold">Zoo Intelligence</span>
                    </div>
                    <p class="text-sm opacity-80 text-center md:text-left mb-6">AI-powered surveillance and management system for modern zoos.</p>
                </div>
                
                <!-- Navigation Links -->
                <div class="md:col-span-3 flex flex-col items-center md:items-start">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#home" class="hover:text-indigo-200 transition flex items-center"><i class="bi bi-chevron-right mr-2 text-xs"></i> Home</a></li>
                        <li><a href="#demo" class="hover:text-indigo-200 transition flex items-center"><i class="bi bi-chevron-right mr-2 text-xs"></i> Demo</a></li>
                        <li><a href="#features" class="hover:text-indigo-200 transition flex items-center"><i class="bi bi-chevron-right mr-2 text-xs"></i> Features</a></li>
                        <li><a href="#contact" class="hover:text-indigo-200 transition flex items-center"><i class="bi bi-chevron-right mr-2 text-xs"></i> Contact</a></li>
                    </ul>
                </div>
                
                <!-- Animal Gallery -->
                <div class="md:col-span-6">
                    <h3 class="text-lg font-semibold mb-4 text-center md:text-left">Featured Animals</h3>
                    <div class="grid grid-cols-4 gap-3">
                        <img src="{{ asset('images/lion.jpg') }}" alt="Lion" class="aspect-square rounded-lg shadow-lg border border-white/20 object-cover hover:scale-105 transition">
                        <img src="{{ asset('images/elephant.jpg') }}" alt="Elephant" class="aspect-square rounded-lg shadow-lg border border-white/20 object-cover hover:scale-105 transition">
                        <img src="{{ asset('images/zebra.jpg') }}" alt="Zebra" class="aspect-square rounded-lg shadow-lg border border-white/20 object-cover hover:scale-105 transition">
                        <img src="{{ asset('images/tiger.jpg') }}" alt="Tiger" class="aspect-square rounded-lg shadow-lg border border-white/20 object-cover hover:scale-105 transition">
                    </div>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-white/20 flex flex-col md:flex-row items-center justify-between">
                <p class="text-sm opacity-80 mb-4 md:mb-0">© 2025 Zoo Intelligence System. All rights reserved.</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg flex items-center space-x-2 transition">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Sign In</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(40px);}
            100% { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in-up { animation: fade-in-up 1s cubic-bezier(.4,0,.2,1) both;}
        .delay-100 { animation-delay: .1s;}
        .delay-200 { animation-delay: .2s;}
        .delay-300 { animation-delay: .3s;}
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite alternate;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        @keyframes ping-slow {
            0% { transform: scale(0.95); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(0.95); opacity: 1; }
        }
        .animate-ping-slow {
            animation: ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        
        /* Mobile Menu Animation */
        #menu {
            transition: all 0.3s ease-in-out;
        }
        @media (max-width: 768px) {
            #menu {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(to right, #4338ca, #3b82f6);
                padding: 1rem;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            }
        }
    </style>

    <!-- Enhanced Mobile Menu with Animation -->
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function () {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
            
            if (!menu.classList.contains('hidden')) {
                menu.style.opacity = '0';
                menu.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    menu.style.opacity = '1';
                    menu.style.transform = 'translateY(0)';
                    menu.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                }, 10);
            }
        });
        
        // Close menu when clicking menu items on mobile
        if (window.innerWidth < 768) {
            document.querySelectorAll('#menu a').forEach(link => {
                link.addEventListener('click', () => {
                    document.getElementById('menu').classList.add('hidden');
                });
            });
        }
    </script>
</x-guest-layout>
