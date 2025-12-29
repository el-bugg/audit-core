{{-- <!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoinVision Pro - Kelompok UAS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Navbar Glass Effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Animasi Scanner */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: #3b82f6;
            box-shadow: 0 0 15px #3b82f6;
            animation: scan 2s infinite linear;
            display: none;
            z-index: 20;
        }
        @keyframes scan {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Loading Spinner */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        /* Toggle Switch Custom Style */
        .toggle-checkbox:checked { right: 0; border-color: #3b82f6; }
        .toggle-checkbox:checked + .toggle-label { background-color: #3b82f6; }

        /* Animation Utilities */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
        
        /* Marquee for Tech Stack */
        .marquee-container { overflow: hidden; white-space: nowrap; }
        .marquee-content { display: inline-block; animation: marquee 20s linear infinite; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 relative">

    <div id="loading-overlay" class="fixed inset-0 z-[100] bg-white/95 backdrop-blur-md flex flex-col items-center justify-center hidden transition-opacity duration-300">
        <div class="loader mb-4"></div>
        <h2 class="text-xl font-bold text-slate-800 animate-pulse">Sedang Memproses Citra...</h2>
        <p class="text-slate-500 text-sm mt-2">Mencocokkan Pola Hough Circle & Metadata Koin</p>
    </div>

    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg z-40 hidden hover:bg-blue-700 transition transform hover:scale-110">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="#" class="flex items-center gap-2 group">
                    <div class="bg-blue-600 text-white p-2 rounded-xl shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cube text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800 leading-none">Coin<span class="text-blue-600">Vision</span></h1>
                        <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Computer Vision AI</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#home" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Beranda</a>
                    <a href="#features" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#how-it-works" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Cara Kerja</a>
                    <a href="#about" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Tim Kami</a>
                </div>

                <a href="/" class="hidden md:flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all shadow-lg hover:shadow-blue-500/25">
                    <i class="fa-solid fa-rotate-right"></i> Reset Sistem
                </a>

                <button id="mobile-menu-btn" class="md:hidden text-slate-800 text-2xl focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div id="mobile-menu" class="hidden md:hidden mt-4 bg-white/50 backdrop-blur-md rounded-2xl p-4 border border-slate-200 shadow-xl flex-col gap-4">
                <a href="#home" class="block py-2 text-slate-600 font-medium border-b border-slate-100 hover:text-blue-600">Beranda</a>
                <a href="#features" class="block py-2 text-slate-600 font-medium border-b border-slate-100 hover:text-blue-600">Fitur</a>
                <a href="#how-it-works" class="block py-2 text-slate-600 font-medium border-b border-slate-100 hover:text-blue-600">Cara Kerja</a>
                <a href="#about" class="block py-2 text-slate-600 font-medium hover:text-blue-600">Tim Kami</a>
                <a href="/" class="flex items-center justify-center gap-2 bg-slate-900 text-white py-3 rounded-xl text-sm font-semibold mt-2">
                    <i class="fa-solid fa-rotate-right"></i> Reset Sistem
                </a>
            </div>
        </div>
    </nav>

    <section id="home" class="pt-32 pb-20 px-6 relative overflow-hidden min-h-screen flex flex-col justify-center">
        <div class="absolute top-20 right-0 w-72 h-72 bg-blue-400/20 rounded-full blur-[80px] -z-10 animate-float"></div>
        <div class="absolute bottom-20 left-0 w-80 h-80 bg-purple-400/20 rounded-full blur-[80px] -z-10 animate-float" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto w-full">
            
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-8 flex flex-col md:flex-row items-start gap-4 animate-fade-in-up max-w-4xl mx-auto shadow-sm">
                <div class="bg-blue-100 p-2 rounded-full text-blue-600 mt-1 shrink-0">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-blue-800 text-sm">Tips Agar Akurasi Scan Maksimal (90%+)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1 mt-1">
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Gunakan alas rata & kontras (gelap/putih).</p>
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Jarak kamera tegak lurus (±15-20cm).</p>
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Hindari bayangan gelap menutupi koin.</p>
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Pastikan koin tidak menumpuk total.</p>
                    </div>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-blue-400 hover:text-blue-600 ml-auto"><i class="fa-solid fa-times"></i></button>
            </div>

            <div class="text-center mb-12 animate-fade-in-up">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-200">
                    ✨ Final Project Pengolahan Citra
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 leading-tight">
                    Hitung Nilai Koin Secara <br class="hidden md:block"/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Otomatis & Akurat</span>
                </h1>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">
                    Upload foto tumpukan koin Anda, dan biarkan AI kami menghitung total nilainya menggunakan algoritma <strong>Hough Circle Transform</strong> & <strong>Adaptive Thresholding</strong>.
                </p>

                <div class="flex justify-center gap-8 mt-8 border-t border-slate-200 pt-8 w-fit mx-auto">
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-slate-800">95%</h4>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Akurasi</p>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-slate-800">0.5s</h4>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Kecepatan</p>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-slate-800">4+</h4>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Tipe Koin</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <div class="w-full lg:w-5/12">
                    <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200 border border-slate-100 p-6 relative overflow-hidden group hover:border-blue-300 transition-colors">
                        
                        @if(session('error'))
                            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-4 text-sm font-semibold border border-red-100 flex items-center gap-2 animate-pulse">
                                <i class="fa-solid fa-circle-xmark text-lg"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if(session('hasil_deteksi'))
                            <div class="absolute top-4 right-4 z-30 bg-white/90 backdrop-blur rounded-full px-4 py-2 shadow-lg border border-slate-200 flex items-center gap-3">
                                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Mode X-Ray</span>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="mode-toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300 transition-all duration-300 left-0 top-0"/>
                                    <label for="mode-toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-slate-300 cursor-pointer transition-all duration-300"></label>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('proses.analisa') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                            @csrf
                            <div class="relative w-full h-80 rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50/50 hover:border-blue-500 transition-all overflow-hidden" id="drop-area">
                                
                                <input type="file" name="foto_koin" id="file-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*" onchange="previewFile(this)">
                                
                                <div id="placeholder" class="text-center p-6 transition-all duration-300 {{ session('hasil_deteksi') ? 'hidden' : '' }}">
                                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md mx-auto mb-4 text-blue-500 text-3xl group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-700">Upload Foto Koin</h3>
                                    <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG (Maks 5MB)</p>
                                    <p class="text-[10px] text-slate-400 mt-4 bg-slate-200 inline-block px-2 py-1 rounded">Klik atau Drag & Drop</p>
                                </div>

                                <img id="img-preview" 
                                     src="{{ session('hasil_deteksi')['img_final'] ?? session('image_preview') }}" 
                                     class="absolute inset-0 w-full h-full object-contain z-10 bg-slate-900 {{ session('hasil_deteksi') || session('image_preview') ? '' : 'hidden' }}">
                                
                                @if(session('hasil_deteksi') && isset(session('hasil_deteksi')['img_edge']))
                                    <img id="img-ai" 
                                         src="{{ session('hasil_deteksi')['img_edge'] }}" 
                                         class="absolute inset-0 w-full h-full object-contain z-10 bg-black hidden">
                                @endif
                                
                                <div id="scan-effect" class="scan-line"></div>
                            </div>

                            <button type="submit" onclick="submitForm()" class="w-full mt-6 bg-gradient-to-r from-slate-900 to-slate-800 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 group">
                                <i class="fa-solid fa-wand-magic-sparkles group-hover:rotate-12 transition-transform"></i> {{ session('hasil_deteksi') ? 'Scan Ulang' : 'Analisa Sekarang' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-7/12">
                    @if(session('hasil_deteksi'))
                        <div class="space-y-6 animate-fade-in-up">
                            
                            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 md:p-8 text-white shadow-2xl shadow-blue-500/30 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                                
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center relative z-10 gap-4">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-2">Total Nilai Terdeteksi</p>
                                        <h2 class="text-5xl md:text-6xl font-bold tracking-tight">Rp {{ number_format(session('hasil_deteksi')['total_rupiah'], 0, ',', '.') }}</h2>
                                    </div>
                                    <div class="bg-white/20 p-3 rounded-2xl backdrop-blur-sm self-end md:self-auto">
                                        <i class="fa-solid fa-wallet text-2xl"></i>
                                    </div>
                                </div>

                                <div class="mt-8 flex gap-8 relative z-10 border-t border-white/20 pt-6">
                                    <div>
                                        <span class="block text-xs text-blue-200 uppercase">Jumlah Item</span>
                                        <span class="text-2xl font-bold">{{ session('hasil_deteksi')['jumlah_koin'] }} <span class="text-sm font-normal text-blue-200">Keping</span></span>
                                    </div>
                                    <div>
                                        <span class="block text-xs text-blue-200 uppercase">Status</span>
                                        <span class="text-2xl font-bold flex items-center gap-2">
                                            <i class="fa-solid fa-check-circle text-green-400 text-lg"></i> Sukses
                                        </span>
                                    </div>
                                </div>
                                <audio autoplay><source src="https://assets.mixkit.co/active_storage/sfx/2000/2000-preview.mp3" type="audio/mpeg"></audio>
                            </div>

                            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                                <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-700"><i class="fa-solid fa-list text-blue-500 mr-2"></i> Rincian Koin</h3>
                                    <span class="hidden md:inline text-xs font-bold text-slate-400 uppercase">Data Metadata & Klasifikasi</span>
                                </div>
                                <div class="max-h-[350px] overflow-y-auto">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 text-xs text-slate-400 uppercase sticky top-0 z-10 shadow-sm">
                                            <tr>
                                                <th class="p-4 font-semibold">No</th>
                                                <th class="p-4 font-semibold">Tipe</th>
                                                <th class="p-4 font-semibold">Info Detail</th>
                                                <th class="p-4 font-semibold hidden md:table-cell">Radius</th>
                                                <th class="p-4 font-semibold text-right">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 text-sm">
                                            @foreach(session('hasil_deteksi')['data_rinci'] as $index => $item)
                                                <tr class="hover:bg-slate-50/80 transition-colors">
                                                    <td class="p-4 text-slate-400">{{ $index + 1 }}</td>
                                                    <td class="p-4 font-bold text-slate-700">
                                                        <span class="w-2 h-2 rounded-full {{ $item['nilai'] == 0 ? 'bg-red-500' : ($item['nilai'] >= 500 ? 'bg-yellow-400' : 'bg-slate-300') }} inline-block mr-2"></span>
                                                        {{ $item['jenis'] }}
                                                    </td>
                                                    <td class="p-4 text-slate-600 text-xs">
                                                        @if($item['nilai'] > 0)
                                                            <div class="flex flex-col gap-1">
                                                                <span class="font-semibold text-slate-700"><i class="fa-regular fa-calendar mr-1"></i> {{ $item['info']['tahun'] ?? '-' }}</span>
                                                                <span><i class="fa-solid fa-building-columns mr-1"></i> {{ $item['info']['asal'] ?? '-' }}</span>
                                                                <span class="text-[10px] text-slate-400 hidden md:inline">{{ $item['info']['bahan'] ?? '' }}</span>
                                                            </div>
                                                        @else
                                                            <span class="text-red-500 italic"><i class="fa-solid fa-triangle-exclamation"></i> Tidak Dikenali</span>
                                                        @endif
                                                    </td>
                                                    <td class="p-4 text-slate-500 font-mono text-xs bg-slate-100 rounded w-fit hidden md:table-cell">{{ $item['radius'] }} px</td>
                                                    <td class="p-4 text-right font-bold text-slate-800">Rp {{ number_format($item['nilai'], 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full min-h-[400px] bg-white rounded-3xl shadow-xl border border-slate-100 flex flex-col items-center justify-center text-center p-10">
                            <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                                <i class="fa-solid fa-magnifying-glass-chart text-5xl text-slate-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Siap Menganalisa</h3>
                            <p class="text-slate-500 max-w-sm mx-auto mb-8">
                                Belum ada data. Silakan upload gambar di panel sebelah kiri untuk melihat keajaiban AI.
                            </p>
                            <div class="grid grid-cols-2 gap-4 text-left w-full max-w-sm">
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <i class="fa-solid fa-bolt text-yellow-500 mb-1"></i>
                                    <p class="text-xs font-bold text-slate-600">Proses Cepat</p>
                                    <p class="text-[10px] text-slate-400">Hasil dalam hitungan detik</p>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <i class="fa-solid fa-eye text-blue-500 mb-1"></i>
                                    <p class="text-xs font-bold text-slate-600">Computer Vision</p>
                                    <p class="text-[10px] text-slate-400">Menggunakan OpenCV</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-slate-100 border-y border-slate-200 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 mb-4 text-center">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Powered By</p>
        </div>
        <div class="marquee-container relative">
            <div class="marquee-content flex gap-12 items-center">
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-brands fa-python"></i> Python</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-solid fa-microchip"></i> OpenCV</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-brands fa-laravel"></i> Laravel</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-brands fa-css3-alt"></i> Tailwind</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-solid fa-flask"></i> Flask</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-solid fa-chart-area"></i> NumPy</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-brands fa-python"></i> Python</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-solid fa-microchip"></i> OpenCV</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-brands fa-laravel"></i> Laravel</div>
                <div class="flex items-center gap-2 text-2xl font-bold text-slate-400"><i class="fa-brands fa-css3-alt"></i> Tailwind</div>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-bold text-sm uppercase tracking-wider">Keunggulan</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-2">Kenapa CoinVision?</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-2xl mb-6">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Pemrosesan Cepat</h3>
                    <p class="text-slate-500 leading-relaxed">Menggunakan algoritma optimasi gambar yang memungkinkan deteksi ratusan koin dalam waktu kurang dari 2 detik.</p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 text-2xl mb-6">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Adaptive Vision</h3>
                    <p class="text-slate-500 leading-relaxed">Sistem threshold adaptif yang mampu mengenali koin meskipun dalam kondisi pencahayaan yang tidak merata.</p>
                </div>
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-white hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-2xl mb-6">
                        <i class="fa-solid fa-database"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-3">Database Metadata</h3>
                    <p class="text-slate-500 leading-relaxed">Tidak hanya nilai, sistem menampilkan sejarah, tahun emisi, dan bahan material dari setiap koin yang terdeteksi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-20 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Cara Kerja Sistem</h2>
                <p class="text-slate-500 max-w-2xl mx-auto">Alur pemrosesan citra dari input hingga output data.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                <div class="text-center group">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mx-auto mb-6 group-hover:scale-110 transition-transform border-4 border-blue-50">
                        <i class="fa-solid fa-upload text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">1. Upload</h3>
                    <p class="text-xs text-slate-500">Input citra digital</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mx-auto mb-6 group-hover:scale-110 transition-transform border-4 border-purple-50">
                        <i class="fa-solid fa-filter text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">2. Preprocessing</h3>
                    <p class="text-xs text-slate-500">Grayscale & Blur</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mx-auto mb-6 group-hover:scale-110 transition-transform border-4 border-pink-50">
                        <i class="fa-solid fa-circle-nodes text-2xl text-pink-600"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">3. Detection</h3>
                    <p class="text-xs text-slate-500">Hough Circle Transform</p>
                </div>
                <div class="text-center group">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg mx-auto mb-6 group-hover:scale-110 transition-transform border-4 border-green-50">
                        <i class="fa-solid fa-clipboard-check text-2xl text-green-600"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 mb-2">4. Result</h3>
                    <p class="text-xs text-slate-500">Kalkulasi & Metadata</p>
                </div>
            </div>
            
            <div class="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-slate-200 -z-0 translate-y-[-50%]"></div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800">Pertanyaan Umum</h2>
            </div>
            <div class="space-y-4">
                <details class="group bg-slate-50 p-6 rounded-2xl cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-slate-800 list-none">
                        <span>Apakah sistem bisa mendeteksi koin asing?</span>
                        <span class="transition group-open:rotate-180"><i class="fa-solid fa-chevron-down"></i></span>
                    </summary>
                    <p class="text-slate-600 mt-4 text-sm leading-relaxed">Saat ini sistem dikalibrasi khusus untuk mata uang Rupiah (IDR). Koin asing mungkin terdeteksi sebagai objek, namun nominalnya tidak akan akurat atau masuk kategori "Tidak Dikenal".</p>
                </details>
                <details class="group bg-slate-50 p-6 rounded-2xl cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-slate-800 list-none">
                        <span>Berapa ukuran file maksimal yang diizinkan?</span>
                        <span class="transition group-open:rotate-180"><i class="fa-solid fa-chevron-down"></i></span>
                    </summary>
                    <p class="text-slate-600 mt-4 text-sm leading-relaxed">Sistem mendukung file hingga 5MB. Untuk kinerja terbaik, gunakan format JPG atau PNG dengan pencahayaan yang baik.</p>
                </details>
                <details class="group bg-slate-50 p-6 rounded-2xl cursor-pointer">
                    <summary class="flex justify-between items-center font-bold text-slate-800 list-none">
                        <span>Bagaimana jika koin saling bertumpuk?</span>
                        <span class="transition group-open:rotate-180"><i class="fa-solid fa-chevron-down"></i></span>
                    </summary>
                    <p class="text-slate-600 mt-4 text-sm leading-relaxed">Algoritma Hough Circle mampu mendeteksi koin yang sedikit bersentuhan, namun jika bertumpuk total (satu di atas yang lain), hanya koin teratas yang akan terhitung.</p>
                </details>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
            <div class="absolute w-96 h-96 bg-blue-600 rounded-full blur-[100px] -top-20 -left-20"></div>
            <div class="absolute w-96 h-96 bg-purple-600 rounded-full blur-[100px] bottom-0 right-0"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16">
                <span class="text-blue-400 font-bold uppercase tracking-widest text-xs mb-3 block">Kelompok UAS Pengolahan Citra</span>
                <h2 class="text-4xl md:text-5xl font-extrabold mb-6">Meet The Developers</h2>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg">
                    Project ini dikembangkan oleh mahasiswa <strong>Universitas Bumigora</strong> sebagai implementasi teknologi Computer Vision modern.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                <div class="group bg-slate-800/50 backdrop-blur-md rounded-3xl p-8 border border-white/5 hover:border-blue-500/50 hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 transition-opacity">
                        <i class="fa-brands fa-python text-6xl text-white"></i>
                    </div>
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-3xl font-bold mb-6 shadow-lg shadow-blue-500/20">A</div>
                    <h3 class="text-2xl font-bold mb-1">Ahmad</h3>
                    <p class="text-blue-400 font-medium text-sm mb-4">Lead Developer & Backend</p>
                    <div class="text-slate-300 text-sm mb-4 space-y-1">
                        <p><i class="fa-solid fa-id-card mr-2 text-slate-500"></i> NIM: 22010100xx</p>
                        <p><i class="fa-solid fa-location-dot mr-2 text-slate-500"></i> Asal: Lombok, NTB</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="px-3 py-1 rounded-full bg-slate-700 text-xs text-slate-300">Python</span>
                        <div class="flex gap-3 text-lg">
                            <a href="#" class="text-slate-400 hover:text-white transition"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="text-slate-400 hover:text-blue-400 transition"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="group bg-slate-800/50 backdrop-blur-md rounded-3xl p-8 border border-white/5 hover:border-purple-500/50 hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 transition-opacity">
                        <i class="fa-brands fa-laravel text-6xl text-white"></i>
                    </div>
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-3xl font-bold mb-6 shadow-lg shadow-purple-500/20">An</div>
                    <h3 class="text-2xl font-bold mb-1">Anggil</h3>
                    <p class="text-purple-400 font-medium text-sm mb-4">Frontend & UI/UX</p>
                    <div class="text-slate-300 text-sm mb-4 space-y-1">
                        <p><i class="fa-solid fa-id-card mr-2 text-slate-500"></i> NIM: 22010100xx</p>
                        <p><i class="fa-solid fa-location-dot mr-2 text-slate-500"></i> Asal: Mataram, NTB</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="px-3 py-1 rounded-full bg-slate-700 text-xs text-slate-300">Laravel</span>
                        <div class="flex gap-3 text-lg">
                            <a href="#" class="text-slate-400 hover:text-white transition"><i class="fa-brands fa-linkedin"></i></a>
                            <a href="#" class="text-slate-400 hover:text-purple-400 transition"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

                <div class="group bg-slate-800/50 backdrop-blur-md rounded-3xl p-8 border border-white/5 hover:border-pink-500/50 hover:bg-slate-800 transition-all duration-300 transform hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 transition-opacity">
                        <i class="fa-solid fa-file-lines text-6xl text-white"></i>
                    </div>
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-3xl font-bold mb-6 shadow-lg shadow-pink-500/20">H</div>
                    <h3 class="text-2xl font-bold mb-1">Haura</h3>
                    <p class="text-pink-400 font-medium text-sm mb-4">System Analyst & QA</p>
                    <div class="text-slate-300 text-sm mb-4 space-y-1">
                        <p><i class="fa-solid fa-id-card mr-2 text-slate-500"></i> NIM: 22010100xx</p>
                        <p><i class="fa-solid fa-location-dot mr-2 text-slate-500"></i> Asal: Lombok, NTB</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="px-3 py-1 rounded-full bg-slate-700 text-xs text-slate-300">Analyst</span>
                        <div class="flex gap-3 text-lg">
                            <a href="#" class="text-slate-400 hover:text-white transition"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="text-slate-400 hover:text-pink-400 transition"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-12 flex flex-col md:flex-row justify-between items-center gap-6 opacity-70">
                <div class="flex items-center gap-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" class="h-8 grayscale hover:grayscale-0 transition opacity-50 hover:opacity-100" title="Laravel">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c3/Python-logo-notext.svg" class="h-8 grayscale hover:grayscale-0 transition opacity-50 hover:opacity-100" title="Python">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg" class="h-8 grayscale hover:grayscale-0 transition opacity-50 hover:opacity-100" title="Tailwind">
                </div>
                <p class="text-sm text-center md:text-left">© 2025 Universitas Bumigora. Computer Vision Project.<br><span class="text-xs">All Rights Reserved.</span></p>
            </div>
        </div>
    </section>

    <footer class="bg-slate-950 text-slate-600 py-6 text-center text-xs border-t border-slate-900">
        <p>Built with ❤️ by Ahmad, Anggil, & Haura.</p>
    </footer>

    <script>
        // --- Navbar Scroll Effect ---
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            const backToTop = document.getElementById('back-to-top');
            
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
                nav.classList.replace('bg-white/95', 'bg-white/90');
                backToTop.classList.remove('hidden');
            } else {
                nav.classList.remove('shadow-md');
                backToTop.classList.add('hidden');
            }
        });

        // --- Mobile Menu Toggle ---
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if(mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
            });
        }

        // --- Preview File Logic ---
        function previewFile(input) {
            const preview = document.getElementById('img-preview');
            const placeholder = document.getElementById('placeholder');
            const dropArea = document.getElementById('drop-area');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden'); 
                    dropArea.classList.remove('border-dashed');
                    dropArea.classList.add('border-solid', 'border-blue-500', 'shadow-lg');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- Submit Form Animation ---
        function submitForm() {
            const input = document.getElementById('file-input');
            const previewSrc = document.getElementById('img-preview').getAttribute('src');
            
            // Cek apakah ada file input atau gambar preview (untuk kasus rescan)
            if((input.files && input.files.length > 0) || (previewSrc && previewSrc !== '')) {
                document.getElementById('loading-overlay').classList.remove('hidden');
                document.getElementById('scan-effect').style.display = 'block';
            } else {
                alert("Silakan pilih gambar koin terlebih dahulu!");
                return false;
            }
        }

        // --- Toggle X-Ray Mode ---
        const toggleBtn = document.getElementById('mode-toggle');
        const imgNormal = document.getElementById('img-preview');
        const imgAI = document.getElementById('img-ai');

        if(toggleBtn) {
            toggleBtn.addEventListener('change', function() {
                if(this.checked) {
                    if(imgNormal) imgNormal.classList.add('hidden');
                    if(imgAI) imgAI.classList.remove('hidden');
                } else {
                    if(imgNormal) imgNormal.classList.remove('hidden');
                    if(imgAI) imgAI.classList.add('hidden');
                }
            });
        }
    </scrip<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoinVision Pro - Kelompok UAS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Navbar Glass Effect */
        .glass-nav {
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Animasi Scanner */
        .scan-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: #3b82f6;
            box-shadow: 0 0 15px #3b82f6;
            animation: scan 2s infinite linear;
            display: none;
            z-index: 20;
        }
        @keyframes scan {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Loading Spinner */
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        /* Toggle Switch Custom Style */
        .toggle-checkbox:checked { right: 0; border-color: #3b82f6; }
        .toggle-checkbox:checked + .toggle-label { background-color: #3b82f6; }

        /* Animation Utilities */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
        
        /* Marquee for Tech Stack */
        .marquee-container { overflow: hidden; white-space: nowrap; }
        .marquee-content { display: inline-block; animation: marquee 20s linear infinite; }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* Styling Pilihan Mode & Kamera */
        .mode-radio:checked + div {
            border-color: #3b82f6;
            background-color: #eff6ff;
            color: #1e3a8a;
        }
        .mode-radio:checked + div .icon-mode { color: #2563eb; }
        
        #camera-modal { backdrop-filter: blur(10px); }
        video { transform: scaleX(-1); border-radius: 1rem; object-fit: cover; } 
    </style>
</head>
<body class="bg-slate-50 text-slate-800 relative">

    <div id="loading-overlay" class="fixed inset-0 z-[100] bg-white/95 backdrop-blur-md flex flex-col items-center justify-center hidden transition-opacity duration-300">
        <div class="loader mb-4"></div>
        <h2 class="text-xl font-bold text-slate-800 animate-pulse">Sedang Memproses Citra...</h2>
        <p class="text-slate-500 text-sm mt-2">Mencocokkan Pola & Mengambil Metadata AI</p>
    </div>

    <button id="back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg z-40 hidden hover:bg-blue-700 transition transform hover:scale-110">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="#" class="flex items-center gap-2 group">
                    <div class="bg-blue-600 text-white p-2 rounded-xl shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cube text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800 leading-none">Coin<span class="text-blue-600">Vision</span></h1>
                        <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Computer Vision AI</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#home" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Beranda</a>
                    <a href="#features" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#how-it-works" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Cara Kerja</a>
                    <a href="#about" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Tim Kami</a>
                </div>

                <a href="/" class="hidden md:flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-all shadow-lg hover:shadow-blue-500/25">
                    <i class="fa-solid fa-rotate-right"></i> Reset Sistem
                </a>

                <button id="mobile-menu-btn" class="md:hidden text-slate-800 text-2xl focus:outline-none">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

            <div id="mobile-menu" class="hidden md:hidden mt-4 bg-white/50 backdrop-blur-md rounded-2xl p-4 border border-slate-200 shadow-xl flex-col gap-4">
                <a href="#home" class="block py-2 text-slate-600 font-medium border-b border-slate-100 hover:text-blue-600">Beranda</a>
                <a href="#features" class="block py-2 text-slate-600 font-medium border-b border-slate-100 hover:text-blue-600">Fitur</a>
                <a href="#how-it-works" class="block py-2 text-slate-600 font-medium border-b border-slate-100 hover:text-blue-600">Cara Kerja</a>
                <a href="#about" class="block py-2 text-slate-600 font-medium hover:text-blue-600">Tim Kami</a>
                <a href="/" class="flex items-center justify-center gap-2 bg-slate-900 text-white py-3 rounded-xl text-sm font-semibold mt-2">
                    <i class="fa-solid fa-rotate-right"></i> Reset Sistem
                </a>
            </div>
        </div>
    </nav>

    <section id="home" class="pt-32 pb-20 px-6 relative overflow-hidden min-h-screen flex flex-col justify-center">
        <div class="absolute top-20 right-0 w-72 h-72 bg-blue-400/20 rounded-full blur-[80px] -z-10 animate-float"></div>
        <div class="absolute bottom-20 left-0 w-80 h-80 bg-purple-400/20 rounded-full blur-[80px] -z-10 animate-float" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto w-full">
            
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 mb-8 flex flex-col md:flex-row items-start gap-4 animate-fade-in-up max-w-4xl mx-auto shadow-sm">
                <div class="bg-blue-100 p-2 rounded-full text-blue-600 mt-1 shrink-0">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-blue-800 text-sm">Tips Agar Akurasi Scan Maksimal (90%+)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1 mt-1">
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Gunakan alas rata & kontras (gelap/putih).</p>
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Jarak kamera tegak lurus (±15-20cm).</p>
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Pilih mode "Menumpuk" jika koin saling tindih.</p>
                        <p class="text-xs text-blue-600"><i class="fa-solid fa-check mr-1"></i> Pastikan cahaya terang.</p>
                    </div>
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-blue-400 hover:text-blue-600 ml-auto"><i class="fa-solid fa-times"></i></button>
            </div>

            <div class="text-center mb-12 animate-fade-in-up">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-200">
                    ✨ Final Project Pengolahan Citra
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 mb-6 leading-tight">
                    Hitung Nilai Koin Secara <br class="hidden md:block"/> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Otomatis & Akurat</span>
                </h1>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">
                    Pilih kondisi koin (Tersebar/Menumpuk), gunakan Kamera atau Upload foto, dan biarkan AI kami menghitung total nilainya dengan data valid.
                </p>

                <div class="flex justify-center gap-8 mt-8 border-t border-slate-200 pt-8 w-fit mx-auto">
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-slate-800">98%</h4>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Akurasi</p>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-slate-800">Dual</h4>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Mode Scan</p>
                    </div>
                    <div class="w-px bg-slate-200"></div>
                    <div class="text-center">
                        <h4 class="text-2xl font-bold text-slate-800">AI</h4>
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Metadata</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <div class="w-full lg:w-5/12">
                    <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200 border border-slate-100 p-6 relative overflow-hidden group hover:border-blue-300 transition-colors">
                        
                        @if(session('error'))
                            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-4 text-sm font-semibold border border-red-100 flex items-center gap-2 animate-pulse">
                                <i class="fa-solid fa-circle-xmark text-lg"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if(session('hasil_deteksi'))
                            <div class="absolute top-4 right-4 z-30 bg-white/90 backdrop-blur rounded-full px-4 py-2 shadow-lg border border-slate-200 flex items-center gap-3">
                                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-wider">Mode X-Ray</span>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input type="checkbox" name="toggle" id="mode-toggle" class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer border-slate-300 transition-all duration-300 left-0 top-0"/>
                                    <label for="mode-toggle" class="toggle-label block overflow-hidden h-5 rounded-full bg-slate-300 cursor-pointer transition-all duration-300"></label>
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">1. Pilih Kondisi Koin</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="mode_scan_dummy" value="spread" class="mode-radio sr-only" checked onchange="updateMode('spread')">
                                    <div class="p-3 border-2 border-slate-200 rounded-xl text-center transition-all group-hover:border-blue-300">
                                        <i class="fa-solid fa-shapes text-2xl mb-1 text-slate-400 icon-mode transition-colors"></i>
                                        <p class="text-xs font-bold">Tersebar</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="mode_scan_dummy" value="stacked" class="mode-radio sr-only" onchange="updateMode('stacked')">
                                    <div class="p-3 border-2 border-slate-200 rounded-xl text-center transition-all group-hover:border-purple-300">
                                        <i class="fa-solid fa-layer-group text-2xl mb-1 text-slate-400 icon-mode transition-colors"></i>
                                        <p class="text-xs font-bold">Menumpuk</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <form action="{{ route('proses.analisa') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                            @csrf
                            <input type="hidden" name="mode" id="selected-mode" value="spread">
                            <input type="hidden" name="camera_image" id="camera-input">

                            <div class="relative w-full h-72 rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center overflow-hidden transition-all" id="drop-area">
                                
                                <input type="file" name="foto_koin" id="file-input" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="previewFile(this)">
                                
                                <div id="placeholder" class="text-center p-4 z-10 pointer-events-none {{ session('hasil_deteksi') ? 'hidden' : '' }}">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">2. Input Gambar</p>
                                    <div class="flex justify-center gap-4 mb-2 pointer-events-auto">
                                        <button type="button" onclick="document.getElementById('file-input').click()" class="flex flex-col items-center gap-2 group">
                                            <div class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 group-hover:border-blue-400 transition-all">
                                                <i class="fa-solid fa-image text-lg text-blue-500"></i>
                                            </div>
                                            <span class="text-[10px] font-bold text-slate-500">Galeri</span>
                                        </button>

                                        <button type="button" onclick="openCamera()" class="flex flex-col items-center gap-2 group">
                                            <div class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center shadow-sm group-hover:scale-110 group-hover:border-purple-400 transition-all">
                                                <i class="fa-solid fa-camera text-lg text-purple-500"></i>
                                            </div>
                                            <span class="text-[10px] font-bold text-slate-500">Kamera</span>
                                        </button>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2">Klik ikon atau drag file</p>
                                </div>

                                <img id="img-preview" src="{{ session('hasil_deteksi')['img_final'] ?? session('image_preview') }}" class="absolute inset-0 w-full h-full object-contain z-10 bg-slate-900 {{ session('hasil_deteksi') || session('image_preview') ? '' : 'hidden' }}">
                                
                                @if(session('hasil_deteksi') && isset(session('hasil_deteksi')['img_edge']))
                                    <img id="img-ai" src="{{ session('hasil_deteksi')['img_edge'] }}" class="absolute inset-0 w-full h-full object-contain z-10 bg-black hidden">
                                @endif
                                
                                <div id="scan-effect" class="scan-line"></div>
                            </div>

                            <button type="submit" onclick="startScan(event)" class="w-full mt-6 bg-gradient-to-r from-slate-900 to-slate-800 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex justify-center items-center gap-2 group">
                                <i class="fa-solid fa-wand-magic-sparkles group-hover:rotate-12 transition-transform"></i> {{ session('hasil_deteksi') ? 'Scan Ulang' : 'Analisa Sekarang' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-7/12">
                    @if(session('hasil_deteksi'))
                        <div class="space-y-6 animate-fade-in-up">
                            
                            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 md:p-8 text-white shadow-2xl shadow-blue-500/30 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                                
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center relative z-10 gap-4">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wider mb-2">Total Nilai Terdeteksi</p>
                                        <h2 class="text-5xl md:text-6xl font-bold tracking-tight">Rp {{ number_format(session('hasil_deteksi')['total_rupiah'], 0, ',', '.') }}</h2>
                                    </div>
                                    <div class="bg-white/20 p-3 rounded-2xl backdrop-blur-sm self-end md:self-auto">
                                        <i class="fa-solid fa-wallet text-2xl"></i>
                                    </div>
                                </div>

                                <div class="mt-8 flex gap-8 relative z-10 border-t border-white/20 pt-6">
                                    <div>
                                        <span class="block text-xs text-blue-200 uppercase">Jumlah Item</span>
                                        <span class="text-2xl font-bold">{{ session('hasil_deteksi')['jumlah_koin'] }} <span class="text-sm font-normal text-blue-200">Keping</span></span>
                                    </div>
                                    <div>
                                        <span class="block text-xs text-blue-200 uppercase">Metode</span>
                                        <span class="text-sm font-bold bg-white/20 px-2 py-1 rounded">
                                            {{ session('hasil_deteksi')['metode'] ?? 'Auto' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
                                <div class="p-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                                    <h3 class="font-bold text-slate-700"><i class="fa-solid fa-list text-blue-500 mr-2"></i> Rincian Koin</h3>
                                    <span class="hidden md:inline text-xs font-bold text-slate-400 uppercase">Data Metadata (AI)</span>
                                </div>
                                <div class="max-h-[350px] overflow-y-auto">
                                    <table class="w-full text-left">
                                        <thead class="bg-slate-50 text-xs text-slate-400 uppercase sticky top-0 z-10 shadow-sm">
                                            <tr>
                                                <th class="p-4 font-semibold">No</th>
                                                <th class="p-4 font-semibold">Tipe</th>
                                                <th class="p-4 font-semibold">Info Metadata</th>
                                                <th class="p-4 font-semibold hidden md:table-cell">Radius</th>
                                                <th class="p-4 font-semibold text-right">Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 text-sm">
                                            @foreach(session('hasil_deteksi')['data_rinci'] as $index => $item)
                                                <tr class="hover:bg-slate-50/80 transition-colors">
                                                    <td class="p-4 text-slate-400">{{ $index + 1 }}</td>
                                                    <td class="p-4 font-bold text-slate-700">
                                                        <span class="w-2 h-2 rounded-full {{ $item['nilai'] == 0 ? 'bg-red-500' : ($item['nilai'] >= 500 ? 'bg-yellow-400' : 'bg-slate-300') }} inline-block mr-2"></span>
                                                        {{ $item['jenis'] }}
                                                    </td>
                                                    <td class="p-4 text-slate-600 text-xs">
                                                        @if($item['nilai'] > 0)
                                                            <div class="flex flex-col gap-1">
                                                                <span class="font-semibold text-slate-700"><i class="fa-regular fa-calendar mr-1"></i> {{ $item['info']['tahun'] ?? '-' }}</span>
                                                                <span><i class="fa-solid fa-layer-group mr-1"></i> {{ $item['info']['bahan'] ?? '-' }}</span>
                                                                <span class="text-[10px] text-blue-500 bg-blue-50 px-2 py-0.5 rounded w-fit border border-blue-100">
                                                                    <i class="fa-solid fa-circle-check mr-1"></i> Sumber: {{ $item['info']['sumber'] ?? 'AI' }}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <span class="text-red-500 italic"><i class="fa-solid fa-triangle-exclamation"></i> Tidak Dikenali</span>
                                                        @endif
                                                    </td>
                                                    <td class="p-4 text-slate-500 font-mono text-xs bg-slate-100 rounded w-fit hidden md:table-cell">{{ $item['radius'] }} px</td>
                                                    <td class="p-4 text-right font-bold text-slate-800">Rp {{ number_format($item['nilai'], 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full min-h-[400px] bg-white rounded-3xl shadow-xl border border-slate-100 flex flex-col items-center justify-center text-center p-10">
                            <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mb-6 animate-pulse">
                                <i class="fa-solid fa-magnifying-glass-chart text-5xl text-slate-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Siap Menganalisa</h3>
                            <p class="text-slate-500 max-w-sm mx-auto mb-8">
                                Belum ada data. Silakan pilih mode dan upload gambar di panel sebelah kiri.
                            </p>
                            <div class="grid grid-cols-2 gap-4 text-left w-full max-w-sm">
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <i class="fa-solid fa-bolt text-yellow-500 mb-1"></i>
                                    <p class="text-xs font-bold text-slate-600">Dual Mode</p>
                                    <p class="text-[10px] text-slate-400">Spread & Stacked Algo</p>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <i class="fa-solid fa-database text-blue-500 mb-1"></i>
                                    <p class="text-xs font-bold text-slate-600">Data Valid</p>
                                    <p class="text-[10px] text-slate-400">Sumber Terpercaya</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-950 text-slate-600 py-6 text-center text-xs border-t border-slate-900">
        <p>Built with ❤️ by Ahmad, Anggil, & Haura.</p>
    </footer>

    <div id="camera-modal" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center bg-black/90 p-4">
        <div class="relative w-full max-w-md bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-700">
            <div class="relative aspect-[3/4] bg-black">
                <video id="video-feed" class="w-full h-full object-cover" autoplay playsinline></video>
                <div class="absolute inset-0 border-2 border-white/20 grid grid-cols-2 pointer-events-none"></div>
            </div>
            
            <canvas id="canvas-capture" class="hidden"></canvas>
            
            <div class="p-6 flex justify-between items-center bg-slate-900">
                <button onclick="closeCamera()" class="p-3 text-slate-400 hover:text-white transition">
                    <i class="fa-solid fa-times text-xl"></i> Batal
                </button>
                <button onclick="capturePhoto()" class="w-16 h-16 rounded-full border-4 border-white bg-transparent flex items-center justify-center hover:bg-white/20 transition">
                    <div class="w-12 h-12 bg-white rounded-full"></div>
                </button>
                <button onclick="switchCamera()" class="p-3 text-slate-400 hover:text-white transition">
                    <i class="fa-solid fa-rotate text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        // --- Navbar Scroll Effect ---
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            const backToTop = document.getElementById('back-to-top');
            
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
                nav.classList.replace('bg-white/95', 'bg-white/90');
                backToTop.classList.remove('hidden');
            } else {
                nav.classList.remove('shadow-md');
                backToTop.classList.add('hidden');
            }
        });

        // --- Mobile Menu Toggle ---
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if(mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
            });
        }

        // --- 1. Mode Selection Logic ---
        function updateMode(val) {
            document.getElementById('selected-mode').value = val;
        }

        // --- 2. Camera Logic ---
        const modal = document.getElementById('camera-modal');
        const video = document.getElementById('video-feed');
        const canvas = document.getElementById('canvas-capture');
        let stream = null;
        let currentFacingMode = 'environment'; // Default kamera belakang

        async function openCamera() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            await startStream();
        }

        async function startStream() {
            if (stream) { stream.getTracks().forEach(track => track.stop()); }
            try {
                stream = await navigator.mediaDevices.getUserMedia({ 
                    video: { facingMode: currentFacingMode } 
                });
                video.srcObject = stream;
            } catch (err) {
                alert("Tidak dapat mengakses kamera. Pastikan izin diberikan.");
                closeCamera();
            }
        }

        function switchCamera() {
            currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
            startStream();
        }

        function closeCamera() {
            if (stream) { stream.getTracks().forEach(track => track.stop()); }
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function capturePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            // Convert ke Base64
            const dataUrl = canvas.toDataURL('image/jpeg');
            
            // Tampilkan di Preview
            const preview = document.getElementById('img-preview');
            preview.src = dataUrl;
            preview.classList.remove('hidden');
            document.getElementById('placeholder').classList.add('hidden');
            document.getElementById('drop-area').classList.remove('border-dashed');
            document.getElementById('drop-area').classList.add('border-solid', 'border-blue-500', 'shadow-lg');
            
            // Masukkan ke Hidden Input
            document.getElementById('camera-input').value = dataUrl;
            document.getElementById('file-input').value = ""; // Clear file input jika ada
            
            closeCamera();
        }

        // --- 3. File Preview Logic ---
        function previewFile(input) {
            const preview = document.getElementById('img-preview');
            const placeholder = document.getElementById('placeholder');
            const dropArea = document.getElementById('drop-area');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden'); 
                    dropArea.classList.remove('border-dashed');
                    dropArea.classList.add('border-solid', 'border-blue-500', 'shadow-lg');
                    
                    // Reset camera input jika user memilih file upload setelah foto
                    document.getElementById('camera-input').value = "";
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- 4. Submit & Scan Animation ---
        function startScan(event) {
            const fileInput = document.getElementById('file-input');
            const camInput = document.getElementById('camera-input');
            const previewSrc = document.getElementById('img-preview').getAttribute('src');

            // Cek apakah input valid (File / Camera / atau Previous Scan untuk rescan)
            if (!fileInput.value && !camInput.value && (!previewSrc || previewSrc === '')) {
                alert("Harap ambil foto atau upload gambar dulu!");
                event.preventDefault();
                return;
            }
            
            document.getElementById('loading-overlay').classList.remove('hidden');
            document.getElementById('scan-effect').style.display = 'block';
        }

        // --- 5. Toggle X-Ray Mode ---
        const toggleBtn = document.getElementById('mode-toggle');
        const imgNormal = document.getElementById('img-preview');
        const imgAI = document.getElementById('img-ai');

        if(toggleBtn) {
            toggleBtn.addEventListener('change', function() {
                if(this.checked) {
                    if(imgNormal) imgNormal.classList.add('hidden');
                    if(imgAI) imgAI.classList.remove('hidden');
                } else {
                    if(imgNormal) imgNormal.classList.remove('hidden');
                    if(imgAI) imgAI.classList.add('hidden');
                }
            });
        }
    </script>
    
</body>
</html>t>
    
</body>
</html> --}}