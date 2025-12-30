<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuditCore - Enterprise Currency Audit</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0ea5e9',    // Sky Blue
                        secondary: '#6366f1',  // Indigo
                        surface: '#ffffff',    // White
                    },
                    backgroundImage: {
                        'accent-gradient': 'linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%)',
                    },
                    boxShadow: {
                        'glow': '0 0 20px -5px rgba(14, 165, 233, 0.3)',
                        'card': '0 10px 30px -5px rgba(0, 0, 0, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; /* Slate-50 */
            color: #0f172a; /* Slate-900 */
            position: relative;
        }

        /* Background Pattern Halus */
        .bg-pattern {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(14, 165, 233, 0.05), transparent 40%),
                radial-gradient(circle at 85% 30%, rgba(99, 102, 241, 0.05), transparent 40%);
            pointer-events: none;
        }
        
        /* Glass Effect Clean */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }

        /* Navbar Sticky Clean */
        .glass-nav { 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid #e2e8f0;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Report Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #0ea5e9; border-radius: 10px; }

        /* Animations */
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0px); } }
        
        /* Radio Button */
        .mode-radio:checked + div { 
            border-color: #0ea5e9; 
            background: #eff6ff; /* Blue-50 */
            box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
        }
        .mode-radio:checked + div i { color: #0ea5e9; }

        /* Laser Line */
        .laser-line {
            position: absolute; width: 100%; height: 2px; background: #0ea5e9;
            box-shadow: 0 0 20px #0ea5e9; z-index: 50; display: none;
            animation: laserScan 1.5s ease-in-out infinite;
        }
        @keyframes laserScan { 0% { top: 0%; opacity: 0; } 50% { opacity: 1; } 100% { top: 100%; opacity: 0; } }

        /* Print Logic */
        @media print {
            body { background: white; color: black; }
            #printable-report { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; overflow: visible !important; max-height: none !important; }
            .glass { background: none; border: 1px solid #ddd; }
            .no-print, #global-back-to-top { display: none !important; } 
            .custom-scrollbar { overflow: visible !important; max-height: none !important; }
        }
    </style>
</head>
<body class="relative overflow-x-hidden text-slate-800">
    <div class="bg-pattern"></div>

    <div class="hidden">
        <audio id="sfx-scan" src="https://assets.mixkit.co/active_storage/sfx/2870/2870-preview.mp3"></audio>
        <audio id="sfx-success" src="https://assets.mixkit.co/active_storage/sfx/2000/2000-preview.mp3"></audio>
        <audio id="sfx-error" src="https://assets.mixkit.co/active_storage/sfx/2573/2573-preview.mp3"></audio>
    </div>

    <div id="loading-overlay" class="fixed inset-0 z-[100] bg-white/90 backdrop-blur-md flex flex-col items-center justify-center hidden transition-opacity duration-300">
        <div class="relative">
            <div class="w-20 h-20 border-4 border-slate-200 border-t-primary rounded-full animate-spin mb-6"></div>
        </div>
        <h2 class="text-2xl font-bold text-slate-800 tracking-wider animate-pulse" id="loading-text" data-translate="loading_title">INITIALIZING CORE...</h2>
        <p class="text-primary text-sm mt-3 font-mono" data-translate="loading_desc">Loading Neural Networks & Feature Matchers</p>
    </div>

    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="#" class="flex items-center gap-3 group">
                    <div class="bg-accent-gradient p-2.5 rounded-xl shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-microchip text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800 leading-none tracking-tight flex items-center">Audit<span class="text-transparent bg-clip-text bg-accent-gradient ml-0.5">Core</span></h1>
                        <p class="text-[9px] text-slate-500 font-bold tracking-[0.2em] uppercase mt-0.5" data-translate="nav_subtitle">Enterprise Audit Solution</p>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <a href="#home" class="text-sm font-medium text-slate-600 hover:text-primary transition" data-translate="nav_home">Home</a>
                    <a href="#features" class="text-sm font-medium text-slate-600 hover:text-primary transition" data-translate="nav_features">Features</a>
                    <a href="#how-it-works" class="text-sm font-medium text-slate-600 hover:text-primary transition" data-translate="nav_how">Process</a>
                    <a href="#reviews" class="text-sm font-medium text-slate-600 hover:text-primary transition" data-translate="nav_reviews">Reviews</a>
                    <a href="#contact" class="text-sm font-medium text-slate-600 hover:text-primary transition" data-translate="nav_contact">Contact</a>
                    <a href="#about" class="text-sm font-medium text-slate-600 hover:text-primary transition" data-translate="nav_team">Leadership</a>
                    
                    <button onclick="toggleLanguage()" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-full text-xs font-bold text-slate-700 transition border border-slate-200">
                        <span id="lang-icon">🇬🇧</span> <span id="lang-text">EN</span>
                    </button>

                    <a href="/" class="flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-md">
                        <i class="fa-solid fa-power-off"></i> <span data-translate="nav_reset">Reset</span>
                    </a>
                </div>

                <button id="mobile-menu-btn" class="md:hidden text-slate-800 text-2xl focus:outline-none p-2 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>
            
            <div id="mobile-menu" class="hidden md:hidden mt-4 bg-white border border-slate-200 rounded-2xl p-5 flex-col gap-4 shadow-xl absolute left-4 right-4 z-50">
                <a href="#home" class="block py-3 text-slate-700 font-medium border-b border-slate-100" onclick="toggleMobileMenu()" data-translate="nav_home">Home</a>
                <a href="#features" class="block py-3 text-slate-700 font-medium border-b border-slate-100" onclick="toggleMobileMenu()" data-translate="nav_features">Features</a>
                <a href="#how-it-works" class="block py-3 text-slate-700 font-medium border-b border-slate-100" onclick="toggleMobileMenu()" data-translate="nav_how">Process</a>
                <a href="#reviews" class="block py-3 text-slate-700 font-medium border-b border-slate-100" onclick="toggleMobileMenu()" data-translate="nav_reviews">Reviews</a>
                <a href="#contact" class="block py-3 text-slate-700 font-medium border-b border-slate-100" onclick="toggleMobileMenu()" data-translate="nav_contact">Contact</a>
                <a href="#about" class="block py-3 text-slate-700 font-medium border-b border-slate-100" onclick="toggleMobileMenu()" data-translate="nav_team">Leadership</a>
                
                <div class="flex justify-between pt-2">
                    <button onclick="toggleLanguage()" class="text-primary font-bold text-sm flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-lg w-full justify-center">
                        <i class="fa-solid fa-globe"></i> Language (ID/EN)
                    </button>
                </div>
                <a href="/" class="flex items-center justify-center gap-2 bg-slate-900 text-white py-3 rounded-xl text-sm font-semibold mt-2" data-translate="nav_reset">Reset System</a>
            </div>
        </div>
    </nav>

    <button id="global-back-to-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-6 right-6 w-12 h-12 bg-primary text-white rounded-full shadow-lg shadow-primary/30 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 hover:scale-110 hover:-translate-y-1 z-50">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <section id="home" class="pt-36 pb-20 px-6 relative min-h-screen flex flex-col justify-center overflow-hidden">
        <div class="absolute top-20 right-20 w-96 h-96 bg-primary/10 rounded-full blur-[128px] -z-10 animate-float opacity-50"></div>
        <div class="absolute bottom-20 left-20 w-96 h-96 bg-secondary/10 rounded-full blur-[128px] -z-10 animate-float opacity-50" style="animation-delay: 2s"></div>

        <div class="max-w-7xl mx-auto w-full z-10">
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white border border-slate-200 text-primary text-xs font-bold uppercase tracking-wider mb-8 shadow-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <span data-translate="hero_badge">AuditCore Enterprise v2.0 Live</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 leading-tight tracking-tight">
                    <span data-translate="hero_title_1">Precision Currency Audit</span> <br class="hidden md:block"/> 
                    <span class="text-transparent bg-clip-text bg-accent-gradient" data-translate="hero_title_2">Powered by Neural Networks</span>
                </h1>
                <p class="text-slate-600 max-w-2xl mx-auto text-lg leading-relaxed" data-translate="hero_desc">
                    Deploying advanced computer vision algorithms (ORB/Flann) to digitize and audit physical assets with 99.8% accuracy.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <div class="w-full lg:w-5/12">
                    <div class="glass rounded-3xl p-6 relative overflow-hidden group hover:border-primary/50 transition-all duration-500 bg-white/60">
                        @if(isset($error) || session('error'))
                            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-4 text-xs font-bold border border-red-200 flex items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> {{ $error ?? session('error') }}
                            </div>
                        @endif

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-sliders"></i> <span data-translate="step_1">1. Processing Engine</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer group/radio">
                                    <input type="radio" name="mode_scan_dummy" value="biasa" class="mode-radio sr-only" checked onchange="updateMode('biasa')">
                                    <div class="p-4 border border-slate-200 bg-slate-50 rounded-2xl text-center transition-all group-hover/radio:border-primary/50">
                                        <i class="fa-solid fa-bolt text-2xl mb-2 text-slate-400 transition-colors"></i>
                                        <p class="text-sm font-bold text-slate-700" data-translate="mode_normal">Fast Scan</p>
                                        <p class="text-[10px] text-slate-400 mt-1">Contour + Shape Analysis</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer group/radio">
                                    <input type="radio" name="mode_scan_dummy" value="premium" class="mode-radio sr-only" onchange="updateMode('premium')">
                                    <div class="p-4 border border-slate-200 bg-slate-50 rounded-2xl text-center transition-all group-hover/radio:border-secondary/50">
                                        <i class="fa-solid fa-brain text-2xl mb-2 text-slate-400 transition-colors"></i>
                                        <p class="text-sm font-bold text-slate-700" data-translate="mode_premium">Deep Scan</p>
                                        <p class="text-[10px] text-slate-400 mt-1">ORB + Flann Matcher</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <form action="{{ route('proses.analisa') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                            @csrf
                            <input type="hidden" name="mode" id="selected-mode" value="biasa">
                            <input type="hidden" name="camera_image" id="camera-input">

                            <div class="relative w-full h-80 rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 flex flex-col items-center justify-center overflow-hidden transition-all group-hover:border-primary/50" id="drop-area">
                                @if(!isset($hasil_deteksi))
                                    <input type="file" name="foto_koin" id="file-input" class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer" accept="image/*" onchange="previewFile(this)">
                                    <div id="placeholder" class="text-center p-6 z-10 pointer-events-none">
                                        <div class="w-20 h-20 mb-4 mx-auto bg-white rounded-full flex items-center justify-center border border-slate-200 shadow-sm">
                                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-600 mb-4" data-translate="step_2">2. Upload Asset Imagery</p>
                                        <div class="flex justify-center gap-3 mb-4 pointer-events-auto">
                                            <button type="button" onclick="document.getElementById('file-input').click()" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-primary hover:border-primary transition flex items-center gap-2"><i class="fa-solid fa-folder-open"></i> <span data-translate="btn_gallery">Gallery</span></button>
                                            <button type="button" onclick="openCamera()" class="bg-white border border-slate-200 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-primary hover:border-primary transition flex items-center gap-2"><i class="fa-solid fa-camera"></i> <span data-translate="btn_camera">Camera</span></button>
                                        </div>
                                        <p class="text-[10px] text-slate-400" data-translate="drop_hint">Drag and drop or click to browse</p>
                                    </div>
                                    <img id="img-preview" class="absolute inset-0 w-full h-full object-contain z-10 bg-white hidden rounded-2xl">
                                @else
                                    <script>
                                        document.getElementById('drop-area').classList.remove('border-dashed', 'bg-slate-50');
                                        document.getElementById('drop-area').classList.add('bg-slate-900', 'border-primary/50');
                                    </script>
                                    <div class="absolute inset-0 w-full h-full bg-slate-900 flex items-center justify-center p-2 rounded-2xl overflow-hidden">
                                        <img src="{{ $hasil_deteksi['img_final'] }}" class="max-w-full max-h-full object-contain rounded-xl relative z-10">
                                        <div class="bounding-box z-20" style="top: 40%; left: 45%; width: 60px; height: 60px;"></div>
                                        <span class="absolute bottom-4 right-4 bg-accent-gradient text-white px-4 py-1.5 rounded-full text-[10px] font-bold shadow-glow z-30 flex items-center gap-2">
                                            <i class="fa-solid fa-crosshairs animate-pulse"></i> AI TARGET LOCKED
                                        </span>
                                    </div>
                                @endif
                                <div id="radar-effect" class="laser-line"></div>
                            </div>

                            <button type="submit" onclick="startScanAnim(event)" class="w-full mt-8 bg-accent-gradient hover:shadow-glow text-white font-bold py-4 rounded-2xl transition-all flex justify-center items-center gap-3 group relative overflow-hidden">
                                <span class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></span>
                                <i class="fa-solid fa-bolt group-hover:animate-bounce relative z-10"></i> 
                                <span class="relative z-10" data-translate="{{ isset($hasil_deteksi) ? 'btn_rescan' : 'btn_scan' }}">
                                    {{ isset($hasil_deteksi) ? 'Reset & Rescan System' : 'Initiate Audit Sequence' }}
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="w-full lg:w-7/12">
                    <div class="bg-white/60 backdrop-blur-xl rounded-3xl p-8 shadow-xl mb-8 relative overflow-hidden border border-slate-200 group hover:border-primary/30 transition-all">
                        <div class="flex justify-between items-start z-10 relative">
                            <div>
                                <p class="text-sm text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2 font-bold">
                                    <span data-translate="wealth_title">Real-time Valuation</span>
                                    <span class="flex h-2 w-2 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                    </span>
                                </p>
                                <h2 class="text-5xl font-mono font-extrabold text-slate-800 tracking-tighter flex items-baseline gap-2">
                                    <span class="text-2xl text-slate-400">Rp</span>
                                    <span id="session-total" class="bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-600">
                                        {{ isset($hasil_deteksi) ? number_format($hasil_deteksi['total_rupiah'], 0, ',', '.') : '0' }}
                                    </span>
                                </h2>
                            </div>
                            <div class="text-center opacity-50 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                <i class="fa-solid fa-shield-halved text-3xl text-primary"></i>
                                <p class="text-[10px] mt-2 font-bold text-slate-600" data-translate="secure_mode">SECURE ENCLAVE</p>
                            </div>
                        </div>
                        <div id="reset-alert" class="mt-6 bg-slate-100 p-3 rounded-xl text-xs text-slate-500 flex items-center gap-3 border border-slate-200">
                            <i class="fa-solid fa-circle-info text-primary"></i>
                            <span data-translate="reset_alert">Session data is volatile and clears after each audit cycle for security.</span>
                        </div>
                    </div>

                    @if(isset($hasil_deteksi))
                        <div id="printable-report" class="glass rounded-3xl shadow-lg border-0 w-full mx-auto animate-float-up overflow-hidden relative">
                            <div class="bg-slate-50 p-6 border-b border-slate-200 flex justify-between items-start z-10 relative">
                                <div>
                                    <h2 class="font-bold text-xl text-slate-800 flex items-center gap-3">
                                        <i class="fa-solid fa-file-contract text-primary"></i> Audit Report Generated
                                    </h2>
                                    <p class="text-xs text-slate-500 mt-2 font-mono flex items-center gap-2"><i class="fa-solid fa-fingerprint"></i> ID: ADC-{{ rand(10000,99999) }} • {{ now()->format('Y-m-d H:i:s T') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider" data-translate="mode_label">Algorithm Used</span>
                                    <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1.5 rounded-full inline-block mt-2 border border-primary/20">{{ $hasil_deteksi['metode'] ?? 'HYBRID AUTO' }}</span>
                                </div>
                            </div>

                            <div id="report-scroll-container" class="p-0 overflow-y-auto max-h-[500px] custom-scrollbar relative scroll-smooth bg-white">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-200 sticky top-0 backdrop-blur-md z-20">
                                        <tr>
                                            <th class="px-6 py-4 font-bold tracking-wider" data-translate="th_object">Asset Class</th>
                                            <th class="px-6 py-4 font-bold tracking-wider" data-translate="th_meta">Technical Specs</th>
                                            <th class="px-6 py-4 font-bold tracking-wider text-right" data-translate="th_value">Valuation</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($hasil_deteksi['data_rinci'] as $index => $item)
                                            <tr class="hover:bg-slate-50 transition group">
                                                <td class="px-6 py-5">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-2 h-2 rounded-full shadow-[0_0_10px] {{ $item['nilai'] > 0 ? 'bg-emerald-500 shadow-emerald-500/50' : 'bg-red-500 shadow-red-500/50' }}"></div>
                                                        <span class="font-bold text-slate-700 text-base">{{ $item['jenis'] }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-slate-500 text-xs font-mono">
                                                    <div class="flex flex-col gap-1">
                                                        <span>YR: {{ $item['info']['tahun'] ?? 'N/A' }}</span>
                                                        <span>MAT: {{ $item['info']['bahan'] ?? 'Unknown alloy' }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-5 text-right">
                                                    <div class="flex items-center justify-end gap-4">
                                                        <span class="font-bold text-slate-800 text-base coin-value font-mono" data-value="{{ $item['nilai'] }}">Rp {{ number_format($item['nilai'], 0, ',', '.') }}</span>
                                                        <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity no-print gap-1">
                                                            <button onclick="manualEdit(this, 100)" class="text-[10px] bg-slate-100 text-primary hover:bg-primary hover:text-white p-1.5 rounded-lg transition"><i class="fa-solid fa-angle-up"></i></button>
                                                            <button onclick="manualEdit(this, -100)" class="text-[10px] bg-slate-100 text-red-500 hover:bg-red-500 hover:text-white p-1.5 rounded-lg transition"><i class="fa-solid fa-angle-down"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="bg-slate-50 p-8 border-t border-slate-200 z-20 relative">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-400 uppercase tracking-widest" data-translate="total_asset">Total Audit Value</span>
                                    <span class="text-3xl font-bold text-slate-800 font-mono" id="receipt-total">Rp {{ number_format($hasil_deteksi['total_rupiah'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button onclick="window.print()" class="w-full mt-8 flex items-center justify-center gap-3 glass text-slate-500 font-bold py-4 rounded-2xl hover:text-primary hover:border-primary transition-all group">
                            <i class="fa-solid fa-file-pdf group-hover:text-primary transition-colors"></i> <span data-translate="btn_download">Export Official Audit (PDF)</span>
                        </button>

                    @else
                        <div class="h-full min-h-[400px] glass rounded-3xl flex flex-col items-center justify-center text-center p-12 border-2 border-dashed border-slate-300">
                            <div class="w-28 h-28 bg-white rounded-full flex items-center justify-center mb-8 shadow-sm border border-slate-200">
                                <i class="fa-solid fa-satellite-dish text-5xl text-primary"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-3" data-translate="waiting_title">System Standby</h3>
                            <p class="text-slate-500 max-w-sm mx-auto text-sm leading-relaxed" data-translate="waiting_desc">
                                Awaiting data input. Please upload high-resolution imagery to initialize the valuation matrix.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <span class="text-primary font-bold text-xs uppercase tracking-[0.2em] mb-4 block animate-pulse" data-translate="process_badge">// SYSTEM CAPABILITIES //</span>
                <h2 class="text-4xl font-bold text-slate-900" data-translate="features_title">Advanced Audit Features</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 glass rounded-3xl hover:bg-white transition group">
                    <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-6 text-2xl"><i class="fa-solid fa-microchip"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Neural Processing</h3>
                    <p class="text-sm text-slate-500">High-speed recognition using optimized ORB algorithms.</p>
                </div>
                <div class="p-8 glass rounded-3xl hover:bg-white transition group">
                    <div class="w-16 h-16 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center mb-6 text-2xl"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Secure Enclave</h3>
                    <p class="text-sm text-slate-500">Data is processed locally in volatile memory for security.</p>
                </div>
                <div class="p-8 glass rounded-3xl hover:bg-white transition group">
                    <div class="w-16 h-16 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center mb-6 text-2xl"><i class="fa-solid fa-chart-line"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Real-time Valuation</h3>
                    <p class="text-sm text-slate-500">Instant currency conversion and total asset valuation.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-24 relative bg-slate-100">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                <span class="text-primary font-bold text-xs uppercase tracking-[0.2em] mb-4 block animate-pulse" data-translate="process_badge">// SYSTEM WORKFLOW //</span>
                <h2 class="text-4xl font-bold text-slate-900" data-translate="how_title">The AuditCore Protocol</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center p-8 glass rounded-3xl hover:bg-white transition group relative">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-4 w-8 h-8 bg-slate-200 rounded-full border border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500">01</div>
                    <div class="w-20 h-20 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-glow group-hover:scale-110 transition-transform border border-primary/20"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Data Ingestion</h3>
                    <p class="text-sm text-slate-500 leading-relaxed" data-translate="how_1">Secure, encrypted image upload pipeline.</p>
                </div>
                <div class="text-center p-8 glass rounded-3xl hover:bg-white transition group relative">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-4 w-8 h-8 bg-slate-200 rounded-full border border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500">02</div>
                    <div class="w-20 h-20 bg-secondary/10 text-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-glow group-hover:scale-110 transition-transform border border-secondary/20"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Pre-processing</h3>
                    <p class="text-sm text-slate-500 leading-relaxed" data-translate="how_2">Adaptive Thresholding & Noise Reduction.</p>
                </div>
                <div class="text-center p-8 glass rounded-3xl hover:bg-white transition group relative">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-4 w-8 h-8 bg-slate-200 rounded-full border border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500">03</div>
                    <div class="w-20 h-20 bg-pink-500/10 text-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-glow group-hover:scale-110 transition-transform border border-pink-500/20"><i class="fa-solid fa-vector-square"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Segmentation</h3>
                    <p class="text-sm text-slate-500 leading-relaxed" data-translate="how_3">Advanced Contour & Shape Extraction.</p>
                </div>
                <div class="text-center p-8 glass rounded-3xl hover:bg-white transition group relative">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -mt-4 w-8 h-8 bg-slate-200 rounded-full border border-slate-300 flex items-center justify-center text-xs font-bold text-slate-500">04</div>
                    <div class="w-20 h-20 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-6 text-3xl shadow-glow group-hover:scale-110 transition-transform border border-emerald-500/20"><i class="fa-solid fa-fingerprint"></i></div>
                    <h3 class="font-bold text-slate-800 mb-3 text-lg">Valuation</h3>
                    <p class="text-sm text-slate-500 leading-relaxed" data-translate="how_4">ORB Feature Matching & Flann Indexing.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="reviews" class="py-24 relative">
        <div class="max-w-4xl mx-auto px-6 relative z-10">
             <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900" data-translate="review_title">Client Testimonials</h2>
                <p class="text-slate-500 text-sm mt-3" data-translate="review_desc">What industry leaders say about AuditCore</p>
            </div>

            <div id="review-list" class="grid gap-6 mb-16">
                </div>

            <div class="glass p-10 rounded-3xl border-primary/30">
                <h3 class="font-bold text-xl text-slate-800 mb-8 flex items-center gap-3"><i class="fa-solid fa-comment-dots text-primary"></i> <span data-translate="add_review">Submit Your Experience</span></h3>
                <form id="review-form" onsubmit="submitReview(event)" class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Identity</label>
                            <input type="text" id="review-name" placeholder="Name / Company Corp." class="w-full p-4 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-primary focus:bg-slate-50 transition" required>
                        </div>
                        <div>
                             <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Satisfaction Rating</label>
                            <select id="review-rating" class="w-full p-4 bg-white border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:border-primary focus:bg-slate-50 transition appearance-none">
                                <option value="5">★★★★★ (Excellent)</option>
                                <option value="4">★★★★☆ (Very Good)</option>
                                <option value="3">★★★☆☆ (Average)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Feedback</label>
                        <textarea id="review-text" rows="4" placeholder="Share your operational experience..." class="w-full p-4 bg-white border border-slate-200 rounded-xl text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-primary focus:bg-slate-50 transition resize-none" required></textarea>
                    </div>
                    <button type="submit" class="bg-accent-gradient text-white px-8 py-4 rounded-xl text-sm font-bold hover:shadow-glow transition-all w-full md:w-auto">Post Verified Review</button>
                </form>
            </div>
        </div>
    </section>

    <section id="contact" class="py-24 relative bg-slate-100">
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-3xl font-bold text-slate-900 mb-4" data-translate="contact_title">Contact Support Protocol</h2>
            <p class="text-slate-500 mb-12" data-translate="contact_desc">Encountered an anomaly? Our engineering team is ready to assist 24/7.</p>
            
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="p-8 glass rounded-3xl hover:border-primary/50 transition group">
                    <i class="fa-solid fa-envelope text-primary text-3xl mb-4 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Encrypted Email</h4>
                    <p class="text-sm text-slate-500 font-mono">support@auditcore.ai</p>
                </div>
                <div class="p-8 glass rounded-3xl hover:border-primary/50 transition group">
                    <i class="fa-solid fa-headset text-primary text-3xl mb-4 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Secure Hotline</h4>
                    <p class="text-sm text-slate-500 font-mono">+62 812-0000-XXXX</p>
                </div>
                <div class="p-8 glass rounded-3xl hover:border-primary/50 transition group">
                    <i class="fa-solid fa-satellite text-primary text-3xl mb-4 group-hover:scale-110 transition-transform"></i>
                    <h4 class="font-bold text-slate-800 mb-2">Global HQ</h4>
                    <p class="text-sm text-slate-500">Mataram, Indonesia</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-20">
                 <span class="text-secondary font-bold text-xs uppercase tracking-[0.2em] mb-4 block animate-pulse" data-translate="team_badge">// CORE ENGINEERING //</span>
                <h2 class="text-4xl font-extrabold text-slate-900" data-translate="team_title">Leadership Command</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="glass p-10 rounded-3xl group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-24 h-24 bg-accent-gradient rounded-2xl flex items-center justify-center text-3xl font-bold text-white mb-8 shadow-glow relative z-10 mx-auto">
                        <i class="fa-solid fa-code"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Ahmad</h3>
                        <p class="text-primary font-medium text-sm mb-6 uppercase tracking-wider" data-translate="role_ahmad">CTO & Lead Architect</p>
                        <div class="flex gap-5 justify-center text-slate-400">
                            <a href="#" class="hover:text-primary transition z-50"><i class="fa-brands fa-github text-2xl"></i></a>
                            <a href="#" class="hover:text-primary transition z-50"><i class="fa-brands fa-linkedin text-2xl"></i></a>
                        </div>
                    </div>
                </div>

                <div class="glass p-10 rounded-3xl group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-secondary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-purple-800 rounded-2xl flex items-center justify-center text-3xl font-bold text-white mb-8 shadow-md relative z-10 mx-auto">
                        <i class="fa-solid fa-pen-nib"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Anggil</h3>
                        <p class="text-secondary font-medium text-sm mb-6 uppercase tracking-wider" data-translate="role_anggil">Head of Product & UX</p>
                        <div class="flex gap-5 justify-center text-slate-400">
                            <a href="#" class="hover:text-secondary transition z-50"><i class="fa-brands fa-dribbble text-2xl"></i></a>
                            <a href="#" class="hover:text-secondary transition z-50"><i class="fa-brands fa-linkedin text-2xl"></i></a>
                        </div>
                    </div>
                </div>

                <div class="glass p-10 rounded-3xl group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-pink-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-24 h-24 bg-gradient-to-br from-pink-600 to-pink-800 rounded-2xl flex items-center justify-center text-3xl font-bold text-white mb-8 shadow-md relative z-10 mx-auto">
                        <i class="fa-solid fa-bug-slash"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Haura</h3>
                        <p class="text-pink-500 font-medium text-sm mb-6 uppercase tracking-wider" data-translate="role_haura">Lead QA Engineer</p>
                        <div class="flex gap-5 justify-center text-slate-400">
                            <a href="#" class="hover:text-pink-500 transition z-50"><i class="fa-brands fa-twitter text-2xl"></i></a>
                            <a href="#" class="hover:text-pink-500 transition z-50"><i class="fa-brands fa-linkedin text-2xl"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-10 text-center text-xs border-t border-slate-800">
        <div class="mb-4 flex justify-center items-center gap-2">
            <i class="fa-solid fa-microchip text-primary"></i>
            <span class="font-bold text-white">AuditCore Enterprise</span>
        </div>
        <p>&copy; 2025 AuditCore Labs Inc. All rights reserved. <span class="mx-2">|</span> Privacy Protocol <span class="mx-2">|</span> Terms of Service</p>
        <p class="mt-2 opacity-50">Engineered by Ahmad, Anggil, & Haura.</p>
    </footer>

    <div id="camera-modal" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center bg-black/95 p-4 backdrop-blur-xl">
        <div class="relative w-full max-w-md bg-white rounded-3xl overflow-hidden shadow-2xl">
            <div class="relative aspect-[3/4] bg-black">
                <video id="video-feed" class="w-full h-full object-cover" autoplay playsinline></video>
                <div class="absolute inset-0 border-2 border-primary/30 grid grid-cols-2 pointer-events-none"></div>
            </div>
            <canvas id="canvas-capture" class="hidden"></canvas>
            <div class="p-8 flex justify-between items-center bg-slate-50 border-t border-slate-200">
                <button onclick="closeCamera()" class="p-4 text-slate-500 hover:text-slate-800 transition flex flex-col items-center gap-1"><i class="fa-solid fa-xmark text-xl"></i> Cancel</button>
                <button onclick="capturePhoto()" class="w-20 h-20 rounded-full border-4 border-slate-200 bg-white flex items-center justify-center hover:bg-slate-50"><div class="w-14 h-14 bg-slate-200 rounded-full"></div></button>
                <button onclick="switchCamera()" class="p-4 text-slate-500 hover:text-slate-800 transition flex flex-col items-center gap-1"><i class="fa-solid fa-rotate text-xl"></i> Flip</button>
            </div>
        </div>
    </div>

    <script>
        // --- 1. LANGUAGE CONFIGURATION ---
        let currentLang = 'en';
        const translations = {
            id: {
                nav_subtitle: "Solusi Audit Enterprise",
                nav_home: "Beranda", nav_features: "Fitur", nav_how: "Proses", nav_reviews: "Ulasan", nav_contact: "Kontak", nav_team: "Pimpinan", nav_reset: "Reset Sistem",
                hero_badge: "AuditCore Enterprise v2.0 Live",
                hero_title_1: "Audit Aset Mata Uang", hero_title_2: "Otomatis & Presisi",
                hero_desc: "Terapkan algoritma computer vision canggih (ORB/Flann) untuk mendigitalkan dan mengaudit aset fisik dengan akurasi 99.8%.",
                step_1: "1. Mesin Pemrosesan", mode_normal: "Pindai Cepat", mode_premium: "Pindai Mendalam",
                step_2: "2. Unggah Citra Aset", btn_gallery: "Galeri", btn_camera: "Kamera", drop_hint: "Tarik dan lepas atau klik untuk menelusuri",
                btn_scan: "Inisiasi Sekuens Audit", btn_rescan: "Reset & Pindai Ulang Sistem",
                loading_title: "MEMULAI INTI...", loading_desc: "Memuat Jaringan Saraf & Pencocok Fitur",
                wealth_title: "Valuasi Real-time", secure_mode: "ENKLAVE AMAN", reset_alert: "Data sesi bersifat volatile dan dihapus setelah setiap siklus audit demi keamanan.",
                how_title: "Protokol AuditCore",
                how_1: "Saluran unggah citra terenkripsi dan aman.", how_2: "Adaptive Thresholding & Pengurangan Noise.", how_3: "Ekstraksi Kontur & Bentuk Tingkat Lanjut.", how_4: "Pencocokan Fitur ORB & Pengindeksan Flann.",
                process_badge: "// ALUR KERJA SISTEM //", team_badge: "// TEKNIK INTI //", team_title: "Komando Pimpinan",
                role_ahmad: "CTO & Arsitek Utama", role_anggil: "Kepala Produk & UX", role_haura: "Kepala Insinyur QA",
                btn_cancel: "Batal", btn_download: "Ekspor Audit Resmi (PDF)",
                waiting_title: "Sistem Siaga", waiting_desc: "Menunggu input data. Silakan unggah citra resolusi tinggi untuk menginisialisasi matriks valuasi.",
                mode_label: "Algoritma Digunakan", th_object: "Kelas Aset", th_meta: "Spesifikasi Teknis", th_value: "Valuasi",
                total_asset: "Total Nilai Audit",
                review_title: "Testimoni Klien", review_desc: "Apa kata pemimpin industri tentang AuditCore",
                add_review: "Kirim Pengalaman Anda", contact_title: "Protokol Dukungan Kontak", contact_desc: "Menemukan anomali? Tim teknis kami siap membantu 24/7."
            },
            en: {
                nav_subtitle: "Enterprise Audit Solution",
                nav_home: "Home", nav_features: "Features", nav_how: "Process", nav_reviews: "Reviews", nav_contact: "Contact", nav_team: "Leadership", nav_reset: "Reset System",
                hero_badge: "AuditCore Enterprise v2.0 Live",
                hero_title_1: "Precision Currency Audit", hero_title_2: "Powered by Neural Networks",
                hero_desc: "Deploying advanced computer vision algorithms (ORB/Flann) to digitize and audit physical assets with 99.8% accuracy.",
                step_1: "1. Processing Engine", mode_normal: "Fast Scan", mode_premium: "Deep Scan",
                step_2: "2. Upload Asset Imagery", btn_gallery: "Gallery", btn_camera: "Camera", drop_hint: "Drag and drop or click to browse",
                btn_scan: "Initiate Audit Sequence", btn_rescan: "Reset & Rescan System",
                loading_title: "INITIALIZING CORE...", loading_desc: "Loading Neural Networks & Feature Matchers",
                wealth_title: "Real-time Valuation", secure_mode: "SECURE ENCLAVE", reset_alert: "Session data is volatile and clears after each audit cycle for security.",
                how_title: "The AuditCore Protocol",
                how_1: "Secure, encrypted image upload pipeline.", how_2: "Adaptive Thresholding & Noise Reduction.", how_3: "Advanced Contour & Shape Extraction.", how_4: "ORB Feature Matching & Flann Indexing.",
                process_badge: "// SYSTEM WORKFLOW //", team_badge: "// CORE ENGINEERING //", team_title: "Leadership Command",
                role_ahmad: "CTO & Lead Architect", role_anggil: "Head of Product & UX", role_haura: "Lead QA Engineer",
                btn_cancel: "Cancel", btn_download: "Export Official Audit (PDF)",
                waiting_title: "System Standby", waiting_desc: "Awaiting data input. Please upload high-resolution imagery to initialize the valuation matrix.",
                mode_label: "Algorithm Used", th_object: "Asset Class", th_meta: "Technical Specs", th_value: "Valuation",
                total_asset: "Total Audit Value",
                review_title: "Client Testimonials", review_desc: "What industry leaders say about AuditCore",
                add_review: "Submit Your Experience", contact_title: "Contact Support Protocol", contact_desc: "Encountered an anomaly? Our engineering team is ready to assist 24/7."
            }
        };

        function toggleLanguage() {
            currentLang = currentLang === 'id' ? 'en' : 'id';
            document.getElementById('lang-icon').innerText = currentLang === 'id' ? '🇮🇩' : '🇬🇧';
            document.getElementById('lang-text').innerText = currentLang.toUpperCase();
            document.querySelectorAll('[data-translate]').forEach(el => {
                const key = el.getAttribute('data-translate');
                if(translations[currentLang][key]) el.innerText = translations[currentLang][key];
            });
        }

        // --- 2. MOBILE MENU ---
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        function toggleMobileMenu() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
        }

        if(mobileBtn) {
            mobileBtn.addEventListener('click', toggleMobileMenu);
        }

        // --- 3. CAMERA & UPLOAD LOGIC ---
        const modal = document.getElementById('camera-modal');
        const video = document.getElementById('video-feed');
        const canvas = document.getElementById('canvas-capture');
        let stream = null; 
        
        async function openCamera() { 
            modal.classList.remove('hidden'); 
            modal.classList.add('flex'); 
            try { 
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }); 
                video.srcObject = stream; 
            } catch (err) { 
                alert("Camera Access Denied"); 
                closeCamera(); 
            }
        }
        function closeCamera() { 
            if(stream) stream.getTracks().forEach(t => t.stop()); 
            modal.classList.add('hidden'); 
            modal.classList.remove('flex'); 
        }
        function capturePhoto() {
            canvas.width = video.videoWidth; canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const dataUrl = canvas.toDataURL('image/jpeg');
            document.getElementById('img-preview').src = dataUrl;
            document.getElementById('img-preview').classList.remove('hidden');
            document.getElementById('placeholder').classList.add('hidden');
            document.getElementById('drop-area').classList.add('border-primary/50');
            document.getElementById('camera-input').value = dataUrl;
            closeCamera();
        }
        function previewFile(input) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('img-preview').src = e.target.result;
                document.getElementById('img-preview').classList.remove('hidden');
                document.getElementById('placeholder').classList.add('hidden');
                document.getElementById('drop-area').classList.add('border-primary/50');
            }
            reader.readAsDataURL(input.files[0]);
        }
        function startScanAnim(e) {
            if(!document.getElementById('file-input').value && !document.getElementById('camera-input').value) {
                alert("Please upload image first"); e.preventDefault(); return;
            }
            document.getElementById('loading-overlay').classList.remove('hidden');
        }
        function updateMode(val) { document.getElementById('selected-mode').value = val; }

        // --- 4. VALUATION LOGIC (PERSISTENT) ---
        window.onload = function() {
            loadReviews();
            
            // 1. Cek Data Baru dari Server (PHP)
            let serverVal = null;
            @if(isset($hasil_deteksi))
                serverVal = {{ $hasil_deteksi['total_rupiah'] }};
                // Jika ada data baru, update session
                sessionStorage.setItem('sessionWealth', serverVal);
                document.getElementById('sfx-success').play();
            @endif

            // 2. Cek Session Storage (untuk refresh)
            const savedWealth = sessionStorage.getItem('sessionWealth');
            
            // 3. Tentukan nilai yang ditampilkan
            let displayVal = 0;
            if (serverVal !== null) {
                displayVal = serverVal;
            } else if (savedWealth) {
                displayVal = savedWealth;
            }

            // 4. Update UI
            document.getElementById('session-total').innerText = new Intl.NumberFormat('id-ID').format(displayVal);
        };

        // --- 5. REVIEWS SYSTEM ---
        function loadReviews() {
            const list = document.getElementById('review-list');
            const reviews = JSON.parse(localStorage.getItem('auditcore_reviews_light')) || [];
            
            if(reviews.length === 0) {
                 // Default dummy review if empty
                 list.innerHTML = `
                    <div class="glass p-8 rounded-3xl">
                        <div class="flex items-center gap-5 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center font-bold text-white shadow-lg">JD</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-lg">John Doe <span class="text-slate-500 text-sm font-normal ml-2">Waitrose Ltd.</span></h4>
                                <div class="text-yellow-500 text-sm mt-1">★★★★★</div>
                            </div>
                        </div>
                        <p class="text-slate-600 text-base italic leading-relaxed">"The ORB algorithm accuracy is astounding. Reduced our cash audit time by 90% with near-zero error rate."</p>
                    </div>`;
                 return;
            }

            list.innerHTML = ''; 
            reviews.forEach(r => {
                const card = document.createElement('div');
                card.className = "glass p-8 rounded-3xl mb-6 animate-fade-in-up";
                card.innerHTML = `
                    <div class="flex items-center gap-5 mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center font-bold text-white shadow-lg">${r.name.substring(0,2).toUpperCase()}</div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-lg">${r.name} <span class="text-slate-500 text-sm font-normal ml-2">Verified Client</span></h4>
                            <div class="text-yellow-500 text-sm mt-1">${'★'.repeat(r.rating)}</div>
                        </div>
                    </div>
                    <p class="text-slate-600 text-base italic leading-relaxed">"${r.text}"</p>
                `;
                list.prepend(card);
            });
        }

        function submitReview(e) {
            e.preventDefault();
            const name = document.getElementById('review-name').value;
            const rating = document.getElementById('review-rating').value;
            const text = document.getElementById('review-text').value;

            if(!name || !text) return;

            const review = { name, rating, text, date: new Date().toISOString() };
            const reviews = JSON.parse(localStorage.getItem('auditcore_reviews_light')) || [];
            reviews.push(review);
            localStorage.setItem('auditcore_reviews_light', JSON.stringify(reviews));

            document.getElementById('review-form').reset();
            loadReviews();
            alert("Review submitted successfully.");
        }
        
        // --- 6. SCROLL BACK TO TOP ---
        const globalScrollBtn = document.getElementById('global-back-to-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                globalScrollBtn.style.opacity = '1';
                globalScrollBtn.style.pointerEvents = 'auto';
            } else {
                globalScrollBtn.style.opacity = '0';
                globalScrollBtn.style.pointerEvents = 'none';
            }
        });
    </script>
</body>
</html>