{{-- Pastikan AlpineJS dimuat (biasanya di layout utama) --}}
{{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

{{-- Navbar dengan Alpine State untuk Sidebar --}}
<nav x-data="{ open: false }" id="navbar" class="fixed top-0 left-0 w-full z-50 bg-transparent transition-colors duration-300">
    <div class="px-6 md:px-10 mx-auto py-4 flex justify-between items-center">

        {{-- Logo & Title (Selalu terlihat) --}}
        <div class="flex justify-center items-center gap-x-2 md:gap-x-4">
            <a href="{{ route('homepage') }}" class="flex items-center gap-x-2 md:gap-x-4"> {{-- Make logo linkable --}}
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-6 md:h-10 w-auto">
                <h1 class="questrial-title text-md sm:text-lg md:text-2xl text-white">Lotus Tales</h1>
            </a>
        </div>

        {{-- Desktop Navigation Links (Tersembunyi di < lg) --}}
        <div class="hidden lg:flex items-center gap-4">
            <a href="{{ route('homepage') }}" class="text-white hover:text-orange-500 transition-colors duration-200 {{ Request::is('/') ? 'font-bold border-b-2 border-orange-500 pb-1' : '' }}">Home</a>
            <a href="{{ route('subscriptions.index') }}" class="text-white hover:text-orange-500 transition-colors duration-200 {{ Request::is('subscriptions') ? 'font-bold border-b-2 border-orange-500 pb-1' : '' }}">
                Subscription
            </a>
            {{-- Tambahkan Link Desktop Lain Jika Perlu --}}
        </div>

        {{-- Desktop Search / Home Button (Tersembunyi di < lg) --}}
        <div class="hidden lg:flex items-center h-6 md:h-10">
            @if (Request::is('/'))
                {{-- Desktop Search --}}
                <div class="relative">
                     <input
                        type="text"
                        {{-- x-model perlu didefinisikan di scope Alpine yang lebih tinggi jika ingin sinkron --}}
                        {{-- x-model="searchTerm" --}}
                        placeholder="Search..."
                        class="border text-white text-sm border-neutral-600 bg-black/50 rounded-full px-4 py-1 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-neutral-400 transition duration-300"
                    />
                    {{-- Icon search bisa ditambahkan di sini --}}
                    {{-- <span class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400"><i class="fa-solid fa-search"></i></span> --}}
                </div>
            @else
                {{-- Desktop Home Button --}}
                <a href="{{ route('homepage') }}" title="Go Home"
                   class="text-lg lg:text-xl bg-orange-500 rounded-full w-9 h-9 flex items-center justify-center text-white hover:bg-white hover:text-orange-500 transition duration-300 shadow-md">
                   <i class="fa-solid fa-house"></i>
                </a>
            @endif
        </div>

        {{-- Hamburger Button (Hanya terlihat di < lg) --}}
        <div class="lg:hidden">
            <button @click="open = !open" aria-label="Toggle Menu" class="text-white focus:outline-none p-2 -mr-2">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                 <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

    </div>

    {{-- Sidebar Section (Overlay & Menu) --}}
    <div class="lg:hidden">
        {{-- Overlay --}}
        <div x-show="open" @click="open = false"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm z-40" style="display: none;">
        </div>

        {{-- Sidebar Menu --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 w-72 max-w-[80vw] h-full bg-neutral-900 shadow-xl p-6 z-50 overflow-y-auto" style="display: none;"
             {{-- Optional: Trap focus within sidebar --}}
             {{-- x-trap.inert.noscroll="open" --}}
             >

            {{-- Sidebar Header (Logo/Title & Close Button) --}}
            <div class="flex justify-between items-center mb-8">
                 <a href="{{ route('homepage') }}" class="flex items-center gap-x-2">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto">
                    <h1 class="questrial-title text-lg text-white">Lotus Tales</h1>
                 </a>
                <button @click="open = false" aria-label="Close Menu" class="text-neutral-400 hover:text-white p-1 -mr-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Sidebar Navigation --}}
            <nav class="flex flex-col space-y-3">
                <a href="{{ route('homepage') }}" class="block py-2.5 px-4 rounded-lg text-neutral-200 hover:bg-neutral-800 hover:text-white transition-colors duration-200 {{ Request::is('/') ? 'font-semibold bg-neutral-800 text-white' : '' }}">Home</a>
                <a href="{{ route('subscriptions.index') }}" class="block py-2.5 px-4 rounded-lg text-neutral-200 hover:bg-neutral-800 hover:text-white transition-colors duration-200 {{ Request::is('subscriptions') ? 'font-semibold bg-neutral-800 text-white' : '' }}">Subscription</a>
                {{-- Tambahkan Link Sidebar Lain Jika Perlu --}}
            </nav>

             {{-- Mobile Search/Home Button (dalam Sidebar) --}}
             <div class="pt-6 mt-6 border-t border-neutral-700/60">
                 @if (Request::is('/'))
                     {{-- Mobile Search --}}
                     <div class="relative">
                         <input
                             type="text"
                             {{-- x-model="searchTerm" --}}
                             placeholder="Search..."
                             class="w-full border text-white border-neutral-600 bg-neutral-800 rounded-lg px-4 py-2 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 placeholder-neutral-500 transition duration-300"
                         />
                         {{-- Icon search bisa ditambahkan di sini --}}
                         {{-- <span class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400"><i class="fa-solid fa-search"></i></span> --}}
                     </div>
                 @else
                     {{-- Mobile Home Button --}}
                     <a href="{{ route('homepage') }}" class="flex items-center justify-center gap-2 w-full text-center bg-orange-600 rounded-lg px-3 py-2.5 hover:bg-orange-500 text-white font-semibold transition duration-300">
                         <i class="fa-solid fa-house"></i>
                         <span>Go Home</span>
                     </a>
                 @endif
             </div>
        </div>
    </div> {{-- End Sidebar Section --}}

</nav>

{{-- Script untuk background navbar saat scroll (Tetap dipertahankan) --}}
<script>
    // Debounce function to limit how often the scroll event handler runs
    function debounce(func, wait = 10, immediate = false) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    const navbar = document.getElementById('navbar');
    const handleScroll = debounce(function() {
        if (window.scrollY > 50) { // Tambah threshold sedikit
            navbar.classList.remove('bg-transparent');
            navbar.classList.add('bg-black', 'shadow-lg'); // Tambah shadow saat scroll
        } else {
            navbar.classList.remove('bg-black', 'shadow-lg');
            navbar.classList.add('bg-transparent');
        }
    }, 50); // Run max every 50ms

    window.addEventListener('scroll', handleScroll);

    // Set initial state on load in case page is loaded already scrolled
    handleScroll();
</script>