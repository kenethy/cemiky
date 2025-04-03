@extends('layout')

@section('content')
    {{-- Pastikan AlpineJS sudah dimuat di layout utama atau di sini --}}
    {{-- <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script> 
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    {{-- Latar Belakang Gelap Pekat --}}
    <div class="min-h-screen bg-gradient-to-b from-black via-neutral-950 to-black text-gray-300 font-sans antialiased"> {{-- Slight gradient background --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">

            {{-- Judul Halaman - Minimalis & Tegas --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-semibold text-center text-white mb-16 sm:mb-20 tracking-tight animate-fade-in-up" style="animation-delay: 0.1s;">
                Choose Your Plan
            </h1>

            {{-- Grid untuk Kartu Langganan - Tambahkan perspective --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 max-w-6xl mx-auto" style="perspective: 1000px;">

                @foreach($subscriptions as $index => $subscription)
                    {{-- Kontainer Kartu - Modifikasi Kelas untuk Efek WOW --}}
                    <div
                        x-data="{ showDetails: false }"
                        {{-- Animasi Masuk dengan Stagger --}}
                        class="card-container relative flex flex-col bg-gradient-to-br from-neutral-900 to-gray-900 rounded-xl p-6 sm:p-8 transition-all duration-500 ease-out border border-neutral-800/80 overflow-hidden group transform-style-3d animate-fade-in-up-scale"
                        style="animation-delay: {{ ($index * 0.1) + 0.2 }}s;" {{-- Staggered delay --}}
                        @click="showDetails = !showDetails"
                    >
                        {{-- Efek Shimmer (Pseudo-element, diatur via CSS) --}}
                        <div class="shimmer-overlay"></div>

                        {{-- Konten Kartu diletakkan di atas shimmer --}}
                        <div class="relative z-[2] flex flex-col flex-grow"> {{-- Pastikan konten di atas shimmer --}}

                            {{-- Bagian Atas Kartu (Selalu Terlihat) --}}
                            <div class="flex-grow">
                                {{-- Logo & Nama Paket --}}
                                <div class="flex items-center space-x-4 mb-4">
                                    @if($subscription->logo)
                                        <img src="{{ asset('storage/' . $subscription->logo) }}" alt="{{ $subscription->name }} Logo"
                                             class="w-11 h-11 object-contain rounded-lg bg-neutral-800 p-1 shadow-md"> {{-- Slightly larger logo, shadow --}}
                                    @else
                                        {{-- Placeholder Logo Minimalis --}}
                                        <div class="w-11 h-11 rounded-lg bg-neutral-800 flex items-center justify-center shadow-md">
                                              <svg class="w-5 h-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                        </div>
                                    @endif
                                    <h2 class="text-xl font-semibold text-white">{{ $subscription->name }}</h2>
                                </div>

                                {{-- Deskripsi/Tagline Singkat --}}
                                <p class="text-neutral-400 text-sm mb-6 h-10">
                                    {{-- Sebaiknya ambil dari data $subscription jika ada --}}
                                    Explore premium features with the {{ $subscription->name }} plan.
                                </p>

                                 {{-- Indikator Klik (Lebih Halus) --}}
                                <div class="text-xs text-neutral-500 flex items-center justify-start mt-auto pt-4 border-t border-neutral-800/60 group-hover:border-orange-600/30 transition-colors duration-300">
                                    <span x-show="!showDetails">View Pricing & Details</span>
                                    <span x-show="showDetails">Hide Details</span>
                                    <svg class="w-3 h-3 ml-1.5 transition-transform duration-300" :class="{ 'rotate-180': showDetails }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Detail Harga & Fitur (Muncul Saat Diklik) --}}
                            <div
                                x-show="showDetails"
                                x-collapse.duration.500ms
                                class="pt-6 mt-6 border-t border-neutral-800/60 group-hover:border-orange-600/30 transition-colors duration-300"
                                @click.stop {{-- Prevent card click when clicking details --}}
                            >
                                <h3 class="text-xs uppercase tracking-wider font-semibold text-neutral-500 mb-4">Pricing</h3>
                                <div class="space-y-4 mb-6">
                                     <div class="grid grid-cols-{{ ($subscription->monthly_price && $subscription->yearly_price) ? '2' : '1' }} gap-4">
                                        @if($subscription->monthly_price)
                                            <div class="flex flex-col items-center justify-center p-4 bg-neutral-800 rounded-lg">
                                                <span class="text-sm text-neutral-400">Monthly</span>
                                                <span class="mt-2 text-2xl font-bold text-white">{{ $subscription->monthly_price }}</span>
                                            </div>
                                        @endif
                                        @if($subscription->yearly_price)
                                            <div class="flex flex-col items-center justify-center p-4 bg-gradient-to-tr from-orange-600/10 via-neutral-800 to-neutral-800 border border-orange-600/30 rounded-lg relative overflow-hidden">
                                                 {{-- Subtle highlight for yearly --}}
                                                 <span class="absolute top-1 right-1 text-[10px] bg-orange-500 text-white px-1.5 py-0.5 rounded-full shadow-sm">SAVE</span>
                                                <span class="text-sm text-neutral-400">Yearly</span>
                                                <span class="mt-2 text-2xl font-bold text-white">{{ $subscription->yearly_price }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Daftar Fitur (Minimalis) - Use actual features if available --}}
                                <h3 class="text-xs uppercase tracking-wider font-semibold text-neutral-500 mb-3 mt-6">Features</h3>
                                <ul class="space-y-2 text-sm text-neutral-400">
                                    {{-- Example Features - Replace with actual data loop if possible --}}
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-500/80 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Premium Content Access
                                    </li>
                                    <li class="flex items-center">
                                         <svg class="w-4 h-4 mr-2 text-orange-500/80 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        High Quality Streaming
                                    </li>
                                    <li class="flex items-center text-neutral-500"> {{-- Example limited feature --}}
                                         <svg class="w-4 h-4 mr-2 text-neutral-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                        Limited Downloads
                                    </li>
                                </ul>

                                {{-- Tombol Subscribe (Aksen Oranye) --}}
                                <a href="{{ route('subscriptions.visit', $subscription->id) }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="block w-full mt-8 bg-orange-600 hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-900 focus:ring-orange-400 text-white text-center font-semibold py-3 px-5 rounded-lg transition duration-300 transform hover:scale-[1.02]"
                                   @click.stop {{-- Prevent card click when clicking button --}}
                                >
                                    Subscribe to {{ $subscription->name }}
                                </a>
                            </div>
                         </div> {{-- End content wrapper --}}
                    </div>
                    {{-- Akhir Kartu --}}
                @endforeach

            </div>
            {{-- Akhir Grid --}}

        </div>
    </div>
    {{-- Akhir Container Utama --}}
@endsection

@push('styles')
<style>
    /* Keyframes untuk Animasi Masuk */
    @keyframes fade-in-up-scale {
        from {
            opacity: 0;
            transform: translateY(25px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .animate-fade-in-up-scale {
        animation: fade-in-up-scale 0.6s ease-out forwards;
        opacity: 0; /* Start hidden */
    }

    /* Keyframes untuk Shimmer Effect */
    @keyframes shimmer {
        0% { transform: translateX(-100%) skewX(-25deg); }
        100% { transform: translateX(150%) skewX(-25deg); } /* Move further across */
    }

    /* Styling Kartu dan Efek Hover */
    .card-container {
        transform-style: preserve-3d; /* Enable 3D transforms for children */
        /* Base transform for performance hint */
        transform: translateZ(0); 
    }

    /* Styling untuk Shimmer Overlay */
    .shimmer-overlay {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 60%; /* Lebar kilatan */
        height: 100%;
        background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.08) 50%, transparent 100%); /* Subtle white shine */
        transform: translateX(-100%) skewX(-25deg); /* Start off-screen */
        pointer-events: none; /* Tidak bisa diklik */
        z-index: 1; /* Di atas background kartu */
        opacity: 0; /* Mulai transparan */
        transition: opacity 0.5s ease-out; /* Transisi opacity */
    }

    /* Memicu Animasi Shimmer saat Kartu di-hover */
    .card-container:hover .shimmer-overlay {
        animation: shimmer 1.5s ease-out forwards; /* Durasi animasi kilatan */
        opacity: 1; /* Munculkan saat hover */
        animation-iteration-count: 1; /* Hanya sekali jalan per hover */
    }

    /* Efek Hover untuk Kartu (Tilt, Glow, Scale) */
    .card-container:hover {
        border-color: rgba(234, 88, 12, 0.4); /* Orange border subtle */
        box-shadow: 0 0 25px 5px rgba(234, 88, 12, 0.25), /* Orange Glow */
                    0 10px 20px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
        transform: scale(1.04) rotateX(3deg) rotateY(-4deg) translateZ(10px); /* Tilt & Scale */
    }

    /* Pastikan konten di dalam kartu tidak ikut miring aneh */
    .card-container > .relative {
       transform: translateZ(5px); /* Sedikit mengangkat konten dari background */
    }

    /* Optional: Perhalus font */
    .font-sans {
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Styling tambahan untuk highlight paket tahunan */
     .highlight-yearly {
        border: 1px solid rgba(234, 88, 12, 0.3);
        background: linear-gradient(135deg, rgba(234, 88, 12, 0.05) 0%, rgba(40, 40, 40, 0.1) 100%);
    }
</style>
@endpush

@push('scripts')
    {{-- Pastikan AlpineJS dan plugin Collapse sudah dimuat --}}
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush