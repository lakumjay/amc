<!DOCTYPE html>
<html lang="gu" class="h-full bg-slate-50 overflow-x-hidden">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>AMC સેવા - અમદાવાદ મહાનગરપાલિકા | નાગરિક ફરિયાદ & નિવારણ એપ</title>
  
  <!-- Tailwind CSS & FontAwesome Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- Leaflet Map CSS & JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Google Fonts for Gujarati & English -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Gujarati:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            gujarati: ['"Noto Sans Gujarati"', '"Plus Jakarta Sans"', 'sans-serif'],
            sans: ['"Plus Jakarta Sans"', '"Noto Sans Gujarati"', 'sans-serif'],
          },
          colors: {
            solar: {
              emerald: '#047857',
              dark: '#064e3b',
              deep: '#022c22',
              leaf: '#10b981',
              light: '#f0fdf4',
              gold: '#f59e0b',
              amber: '#d97706',
              accent: '#059669'
            }
          }
        }
      }
    }
  </script>

  <style>
    * {
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
    }
    body {
      font-family: 'Noto Sans Gujarati', 'Plus Jakarta Sans', sans-serif;
      overflow-x: hidden;
      width: 100%;
      background-color: #f8fafc;
    }

    /* Fixed Floating Mobile Bottom Navbar (Solar App Style) */
    .mobile-bottom-navbar {
      position: fixed;
      bottom: 14px;
      left: 50%;
      transform: translateX(-50%);
      width: calc(100% - 24px);
      max-width: 480px;
      height: 64px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(203, 213, 225, 0.85);
      border-radius: 36px;
      display: flex;
      align-items: center;
      justify-content: space-around;
      padding: 4px 6px;
      z-index: 1000;
      box-shadow: 0 16px 36px rgba(15, 23, 42, 0.16), 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .bnav-btn {
      background: transparent;
      border: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 3px;
      color: #64748b;
      font-size: 11px;
      font-weight: 700;
      padding: 6px 14px;
      border-radius: 24px;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      flex: 1;
      text-decoration: none;
    }

    .bnav-btn:active {
      transform: scale(0.92);
    }

    .bnav-btn.active {
      background: linear-gradient(135deg, #047857, #065f46);
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(4, 120, 87, 0.35);
    }

    .bnav-btn.active i {
      color: #fef08a !important;
      transform: scale(1.1);
    }

    /* Map container isolation */
    #map, .leaflet-container {
      z-index: 10 !important;
      position: relative !important;
      overflow: hidden !important;
      max-width: 100% !important;
      contain: paint !important;
    }

    /* Pulse animation for active badges */
    @keyframes pulse-ring {
      0% { transform: scale(0.95); opacity: 0.8; }
      50% { transform: scale(1.1); opacity: 1; }
      100% { transform: scale(0.95); opacity: 0.8; }
    }
    .pulse-dot {
      animation: pulse-ring 2s infinite ease-in-out;
    }
  </style>
</head>
<body class="min-h-full flex flex-col antialiased text-slate-800">

  <!-- ================= TOP APP HEADER (Solar App Aesthetic) ================= -->
  <header class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-teal-950 text-white shadow-md sticky top-0 z-40">
    <!-- Top notification status strip -->
    <div class="px-4 py-1.5 border-b border-emerald-800/40 flex items-center justify-between text-xs">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-emerald-400 pulse-dot"></span>
        <span class="text-[11px] font-semibold text-emerald-200">AMC કંટ્રોલ રૂમ ૨૪x૭ ઓનલાઇન</span>
      </div>
      <div class="flex items-center gap-3">
        <a href="tel:155303" class="text-[11px] font-bold text-amber-300 hover:text-amber-200 flex items-center gap-1 transition">
          <i class="fa-solid fa-phone-volume text-[10px]"></i> ટોલ-ફ્રી: 155303
        </a>
      </div>
    </div>

    <!-- Main App Navigation Bar -->
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center gap-3 cursor-pointer" onclick="switchAppTab('dashboard')">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-amber-400 to-emerald-400 p-0.5 shadow-lg flex-shrink-0">
          <div class="w-full h-full bg-emerald-950 rounded-[14px] flex items-center justify-center text-amber-300 font-bold text-lg">
            <i class="fa-solid fa-landmark-dome"></i>
          </div>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <h1 class="text-xl font-black text-white tracking-tight leading-none">AMC સેવા</h1>
            <span class="px-1.5 py-0.5 rounded-md text-[9px] font-extrabold uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-400/40">
              સિટિઝન એપ
            </span>
          </div>
          <p class="text-[11px] text-emerald-200/80 font-medium mt-0.5">અમદાવાદ મહાનગરપાલિકા ડિજિટલ પોર્ટલ</p>
        </div>
      </div>

      <!-- Quick Action: Emergency Helpline Direct Dial -->
      <a href="tel:155303" class="px-3 py-1.5 rounded-xl bg-red-600/90 hover:bg-red-700 text-white text-xs font-bold flex items-center gap-1.5 shadow-md transition active:scale-95">
        <i class="fa-solid fa-headset text-xs"></i>
        <span>હેલ્પલાઇન</span>
      </a>
    </div>
  </header>

  <!-- ================= MAIN CONTENT WRAPPER ================= -->
  <!-- Note: pb-28 ensures content is NEVER hidden behind fixed bottom bar -->
  <main class="max-w-5xl mx-auto px-4 py-5 flex-1 w-full pb-28 space-y-6">

    <!-- ========================================================================= -->
    <!-- 1. DASHBOARD VIEW (Tab 1 - Solar App Style Dashboard)                      -->
    <!-- ========================================================================= -->
    <div id="tab-dashboard" class="app-tab space-y-5">
      
      <!-- Welcome Hero Banner -->
      <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-800 via-emerald-700 to-teal-800 text-white p-5 sm:p-7 shadow-lg">
        <div class="absolute -right-8 -bottom-8 w-44 h-44 rounded-full bg-emerald-600/30 blur-2xl pointer-events-none"></div>
        <div class="absolute right-4 top-4 text-emerald-300/20 text-7xl font-black pointer-events-none">
          <i class="fa-solid fa-building-columns"></i>
        </div>

        <div class="relative z-10 space-y-3 max-w-lg">
          <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-900/60 border border-emerald-400/30 text-emerald-300 text-xs font-semibold">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
            સ્વચ્છ &amp; સુરક્ષિત અમદાવાદ
          </div>
          <h2 class="text-xl sm:text-2xl font-black leading-tight text-white">
            નમસ્તે, અમદાવાદ! 👋
          </h2>
          <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed">
            તમારા વિસ્તારમાં રસ્તાના ખાડા, કચરો, સ્ટ્રીટલાઈટ કે પાણીની સમસ્યા છે? માત્ર ૨ મિનિટમાં ફોટો પાડી ફરિયાદ નોંધાવો અને લાઈવ ટ્રેક કરો.
          </p>

          <div class="pt-2 flex flex-wrap gap-2.5">
            <button onclick="switchAppTab('new-complaint')" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-emerald-950 font-bold text-xs sm:text-sm shadow-md transition flex items-center gap-2 active:scale-95">
              <i class="fa-solid fa-file-circle-plus"></i>
              <span>નવી ફરિયાદ નોંધાવો</span>
            </button>
            <button onclick="switchAppTab('track-status')" class="px-4 py-2.5 rounded-xl bg-emerald-900/80 hover:bg-emerald-900 text-white font-bold text-xs sm:text-sm border border-emerald-400/40 shadow-sm transition flex items-center gap-2 active:scale-95">
              <i class="fa-solid fa-location-crosshairs text-emerald-300"></i>
              <span>સ્ટેટસ ટ્રેક કરો</span>
            </button>
          </div>
        </div>
      </div>

      <!-- Live City Performance Metrics (Solar-Style Counters) -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col justify-between">
          <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
            <span>કુલ ફરિયાદો</span>
            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
              <i class="fa-solid fa-list-check"></i>
            </div>
          </div>
          <div class="mt-2">
            <div class="text-2xl font-black text-slate-900">૧,૪૨૮</div>
            <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1 mt-0.5">
              <i class="fa-solid fa-arrow-trend-up"></i> ૯૪.૨% નિકાલ
            </span>
          </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col justify-between">
          <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
            <span>૨૪ કલાકમાં ઉકેલ</span>
            <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
              <i class="fa-solid fa-bolt"></i>
            </div>
          </div>
          <div class="mt-2">
            <div class="text-2xl font-black text-slate-900">૧,૨૬૫</div>
            <span class="text-[10px] text-slate-500 font-semibold mt-0.5">ઝડપી કામગીરી</span>
          </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col justify-between">
          <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
            <span>સરેરાશ સમય</span>
            <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs">
              <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
          </div>
          <div class="mt-2">
            <div class="text-2xl font-black text-slate-900">૨૬ કલાક</div>
            <span class="text-[10px] text-emerald-600 font-bold mt-0.5">SLA લક્ષ્યાંક પ્રાપ્ત</span>
          </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col justify-between">
          <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
            <span>સંતોષ રેટિંગ</span>
            <div class="w-7 h-7 rounded-lg bg-yellow-50 text-amber-500 flex items-center justify-center text-xs">
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
          <div class="mt-2">
            <div class="text-2xl font-black text-slate-900">૪.૯ <span class="text-sm text-slate-400">/ ૫.૦</span></div>
            <span class="text-[10px] text-amber-600 font-bold mt-0.5">૫,૦૦૦+ નાગરિક રેટિંગ</span>
          </div>
        </div>
      </div>

      <!-- Quick Action Tiles (Solar-App Style Large Tap Buttons) -->
      <div class="space-y-2.5">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
          <i class="fa-solid fa-grip text-emerald-700"></i>
          ઝડપી સેવાઓ (Quick Services)
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <!-- Action 1: New Complaint -->
          <div onclick="switchAppTab('new-complaint')" class="cursor-pointer bg-white rounded-2xl p-4 border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition flex items-center gap-3.5 group">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl group-hover:scale-110 transition flex-shrink-0">
              <i class="fa-solid fa-circle-plus"></i>
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition">નવી ફરિયાદ નોંધાવો</h4>
              <p class="text-xs text-slate-500 truncate mt-0.5">ખાડા, કચરો, સ્ટ્રીટલાઈટ, ગટર વગેરે</p>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300 text-xs"></i>
          </div>

          <!-- Action 2: Track Status -->
          <div onclick="switchAppTab('track-status')" class="cursor-pointer bg-white rounded-2xl p-4 border border-slate-200/90 hover:border-emerald-500 hover:shadow-md transition flex items-center gap-3.5 group">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl group-hover:scale-110 transition flex-shrink-0">
              <i class="fa-solid fa-crosshairs"></i>
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-sm font-bold text-slate-900 group-hover:text-blue-700 transition">ફરિયાદનું સ્ટેટસ જુઓ</h4>
              <p class="text-xs text-slate-500 truncate mt-0.5">ટોકન નંબર દાખલ કરી લાઈવ ટ્રેકિંગ</p>
            </div>
            <i class="fa-solid fa-chevron-right text-slate-300 text-xs"></i>
          </div>

          <!-- Action 3: AMC Helpline Call -->
          <a href="tel:155303" class="bg-white rounded-2xl p-4 border border-slate-200/90 hover:border-red-400 hover:shadow-md transition flex items-center gap-3.5 group">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl group-hover:scale-110 transition flex-shrink-0">
              <i class="fa-solid fa-phone-volume"></i>
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-600 transition">AMC હેલ્પલાઇન 155303</h4>
              <p class="text-xs text-slate-500 truncate mt-0.5">ટોલ-ફ્રી ૨૪x૭ કટોકટી ફરિયાદ કેન્દ્ર</p>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-slate-300 text-xs"></i>
          </a>

          <!-- Action 4: WhatsApp Bot -->
          <a href="https://wa.me/919978333303?text=Hi%20AMC" target="_blank" class="bg-white rounded-2xl p-4 border border-slate-200/90 hover:border-emerald-400 hover:shadow-md transition flex items-center gap-3.5 group">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl group-hover:scale-110 transition flex-shrink-0">
              <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition">AMC વોટ્સએપ ચેટબોટ</h4>
              <p class="text-xs text-slate-500 truncate mt-0.5">+91 99783 33303 પર ચેટ કરો</p>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-slate-300 text-xs"></i>
          </a>
        </div>
      </div>

      <!-- Recent Resolved Complaints Feed -->
      <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-3.5">
        <div class="flex items-center justify-between">
          <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            તાજેતરમાં ઉકેલાયેલી ફરિયાદો (Recent Activity)
          </h3>
          <span class="text-[11px] text-slate-400 font-semibold">અમદાવાદ વોર્ડ્સ</span>
        </div>

        <div class="space-y-2.5">
          <!-- Sample 1 -->
          <div onclick="quickTrack('AMC-2026-W41-5661')" class="cursor-pointer p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 transition flex items-center justify-between gap-3 group">
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm flex-shrink-0">
                <i class="fa-solid fa-lightbulb"></i>
              </div>
              <div class="min-w-0">
                <div class="text-xs font-bold text-slate-800 truncate">૩ સ્ટ્રીટલાઇટ બલ્બ બદલી લાઈન ચાલુ કરી</div>
                <div class="text-[10px] text-slate-400">નવરંગપુરા • ટોકન: AMC-2026-W41-5661</div>
              </div>
            </div>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 whitespace-nowrap">
              ● નિકાલ પૂર્ણ
            </span>
          </div>

          <!-- Sample 2 -->
          <div onclick="quickTrack('AMC-2026-W30-6960')" class="cursor-pointer p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 transition flex items-center justify-between gap-3 group">
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-sm flex-shrink-0">
                <i class="fa-solid fa-road"></i>
              </div>
              <div class="min-w-0">
                <div class="text-xs font-bold text-slate-800 truncate">ઇસ્કોન ચાર રસ્તા પાસે ખાડો પુરાઈ ગયો</div>
                <div class="text-[10px] text-slate-400">બોડકદેવ • ટોકન: AMC-2026-W30-6960</div>
              </div>
            </div>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 whitespace-nowrap">
              ● નિકાલ પૂર્ણ
            </span>
          </div>

          <!-- Sample 3 -->
          <div onclick="quickTrack('AMC-2026-W12-1089')" class="cursor-pointer p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200 transition flex items-center justify-between gap-3 group">
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-sm flex-shrink-0">
                <i class="fa-solid fa-trash-can"></i>
              </div>
              <div class="min-w-0">
                <div class="text-xs font-bold text-slate-800 truncate">જાહેર કચરાપેટી ખાલી કરી સફાઈ કરાઈ</div>
                <div class="text-[10px] text-slate-400">મણિનગર • ટોકન: AMC-2026-W12-1089</div>
              </div>
            </div>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-300 whitespace-nowrap">
              ● પ્રગતિમાં
            </span>
          </div>
        </div>
      </div>

      <!-- AMC Resolution SLA Promise Box -->
      <div class="rounded-3xl bg-emerald-900 text-white p-5 border border-emerald-800 shadow-sm space-y-3">
        <div class="flex items-center gap-2 text-amber-300 text-xs font-bold uppercase tracking-wider">
          <i class="fa-solid fa-shield-halved"></i>
          AMC સેવા નિવારણ ગેરંટી (SLA Commitment)
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
          <div class="bg-emerald-950/60 p-2.5 rounded-xl border border-emerald-800/60 text-center">
            <div class="text-emerald-300 text-[10px]">કચરો સફાઈ</div>
            <div class="font-black text-amber-300 text-sm mt-0.5">૨૪ કલાક</div>
          </div>
          <div class="bg-emerald-950/60 p-2.5 rounded-xl border border-emerald-800/60 text-center">
            <div class="text-emerald-300 text-[10px]">સ્ટ્રીટ લાઈટ</div>
            <div class="font-black text-amber-300 text-sm mt-0.5">૨૪-૪૮ કલાક</div>
          </div>
          <div class="bg-emerald-950/60 p-2.5 rounded-xl border border-emerald-800/60 text-center">
            <div class="text-emerald-300 text-[10px]">રસ્તાના ખાડા</div>
            <div class="font-black text-amber-300 text-sm mt-0.5">૪૮-૭૨ કલાક</div>
          </div>
          <div class="bg-emerald-950/60 p-2.5 rounded-xl border border-emerald-800/60 text-center">
            <div class="text-emerald-300 text-[10px]">ગટર / પાણી</div>
            <div class="font-black text-amber-300 text-sm mt-0.5">૧૨-૨૪ કલાક</div>
          </div>
        </div>
      </div>

    </div>


    <!-- ========================================================================= -->
    <!-- 2. CITIZEN GRIEVANCE REGISTRATION FORM (Tab 2)                             -->
    <!-- ========================================================================= -->
    <div id="tab-new-complaint" class="app-tab hidden space-y-5">
      
      <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-4 sm:p-7 space-y-6">
        
        <!-- Form Header -->
        <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
          <div>
            <h2 class="text-lg sm:text-xl font-black text-slate-900 flex items-center gap-2">
              <i class="fa-solid fa-file-circle-plus text-emerald-600"></i>
              નવી નાગરિક ફરિયાદ નોંધાવો
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">તમારી સમસ્યા નોંધાવો, સંબંધિત AMC વોર્ડ ઓફિસર તાત્કાલિક કાર્યવાહી કરશે.</p>
          </div>
          <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold border border-emerald-200 hidden sm:inline-block">
            પગલું ૧ થી ૪
          </span>
        </div>

        <form id="complaintForm" onsubmit="handleComplaintSubmit(event)" class="space-y-6">

          <!-- 1. Citizen Details -->
          <div class="space-y-3">
            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
              <span class="w-5 h-5 rounded-full bg-emerald-700 text-white text-[10px] flex items-center justify-center font-bold">1</span>
              નાગરિક સંપર્ક વિગત (Citizen Contact)
            </label>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">નાગરિકનું પૂરું નામ *</label>
                <input type="text" id="citizen_name" required placeholder="દા.ત. રમેશભાઈ પટેલ" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-slate-50/50">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">મોબાઇલ નંબર (SMS અપડેટ માટે) *</label>
                <div class="relative">
                  <span class="absolute left-3.5 top-2.5 text-xs font-bold text-slate-400">+91</span>
                  <input type="tel" id="citizen_phone" required pattern="[0-9]{10}" placeholder="9898012345" 
                    class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-slate-50/50">
                </div>
              </div>
            </div>
          </div>

          <!-- 2. Grievance Category Selection (Interactive Cards with Visual Icons) -->
          <div class="space-y-3">
            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
              <span class="w-5 h-5 rounded-full bg-emerald-700 text-white text-[10px] flex items-center justify-center font-bold">2</span>
              સમસ્યાની શ્રેણી પસંદ કરો (Category) *
            </label>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5" id="categoryCardsContainer">
              <!-- Dynamically populated or pre-rendered -->
            </div>

            <!-- Subcategory Dropdown -->
            <div class="mt-3">
              <label class="block text-xs font-semibold text-slate-700 mb-1">વિગતવાર ઉપ-શ્રેણી (Subcategory) *</label>
              <select id="subcategorySelect" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-white font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                <option value="">ઉપ-શ્રેણી પસંદ કરો...</option>
              </select>
            </div>
          </div>

          <!-- 3. AMC Zone, Ward & GPS Location -->
          <div class="space-y-3">
            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
              <span class="w-5 h-5 rounded-full bg-emerald-700 text-white text-[10px] flex items-center justify-center font-bold">3</span>
              AMC ઝોન, વોર્ડ &amp; GPS લોકેશન *
            </label>

            <!-- Pre-populated Zone & Ward dropdowns -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">AMC ઝોન (Zone) *</label>
                <select id="zoneSelect" onchange="handleZoneChange()" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-white font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                  <option value="વેસ્ટ ઝોન (West Zone)">વેસ્ટ ઝોન (West Zone)</option>
                  <option value="ન્યુ વેસ્ટ ઝોન (New West Zone)">ન્યુ વેસ્ટ ઝોન (New West Zone)</option>
                  <option value="સેન્ટ્રલ ઝોન (Central Zone)">સેન્ટ્રલ ઝોન (Central Zone)</option>
                  <option value="સાઉથ ઝોન (South Zone)">સાઉથ ઝોન (South Zone)</option>
                  <option value="ઇસ્ટ ઝોન (East Zone)">ઇસ્ટ ઝોન (East Zone)</option>
                  <option value="નોર્થ ઝોન (North Zone)">નોર્થ ઝોન (North Zone)</option>
                  <option value="સાઉથ વેસ્ટ ઝોન (South West Zone)">સાઉથ વેસ્ટ ઝોન (South West Zone)</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">AMC વોર્ડ (Ward) *</label>
                <select id="wardSelect" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-white font-bold text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition">
                  <!-- Populated instantly via JS -->
                  <option value="નવરંગપુરા (Navrangpura)">નવરંગપુરા (Navrangpura)</option>
                </select>
              </div>
            </div>

            <!-- Leaflet Map for Pinning Location -->
            <div class="space-y-2">
              <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5">
                <span class="text-xs font-semibold text-slate-700">મેપ પર લોકેશન પિન કરો (પિન ખસેડી શકો છો):</span>
                <button type="button" onclick="detectGPS()" class="w-full sm:w-auto text-xs font-bold text-emerald-800 hover:text-emerald-900 flex items-center justify-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-xl border border-emerald-300 transition shadow-2xs">
                  <i class="fa-solid fa-location-crosshairs text-emerald-600"></i>
                  મારું GPS લોકેશન શોધો
                </button>
              </div>

              <div id="map" class="w-full h-52 sm:h-60 rounded-2xl border border-slate-300 overflow-hidden shadow-inner"></div>

              <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                <div class="bg-slate-50 p-2 rounded-xl border border-slate-200">
                  <span class="font-bold text-slate-600">Latitude:</span> <span id="latDisplay">23.0225</span>
                </div>
                <div class="bg-slate-50 p-2 rounded-xl border border-slate-200">
                  <span class="font-bold text-slate-600">Longitude:</span> <span id="lngDisplay">72.5714</span>
                </div>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">સ્થળનું સરનામું / નજીકનો લેન્ડમાર્ક *</label>
                <input type="text" id="addressInput" required placeholder="દા.ત. શિવાલિક પ્લાઝા પાસે, આઇઆઇએમ રોડ, વસ્ત્રાપુર" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition bg-slate-50/50">
              </div>
            </div>
          </div>

          <!-- 4. Photo Proof & Voice Description -->
          <div class="space-y-3">
            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
              <span class="w-5 h-5 rounded-full bg-emerald-700 text-white text-[10px] flex items-center justify-center font-bold">4</span>
              ફોટો પુરાવો &amp; સમસ્યાની વિગત *
            </label>

            <!-- Photo Upload Area -->
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">સમસ્યાનો ફોટો પુરાવો અપલોડ કરો (Live Photo)</label>
              <div class="flex flex-col sm:flex-row items-center gap-3">
                <label class="w-full flex-1 flex flex-col items-center justify-center border-2 border-dashed border-emerald-300 hover:border-emerald-600 rounded-2xl p-4 cursor-pointer bg-emerald-50/30 hover:bg-emerald-50/60 transition text-center">
                  <i class="fa-solid fa-camera text-2xl text-emerald-600 mb-1"></i>
                  <span class="text-xs font-bold text-slate-700">ફોટો સિલેક્ટ કરો અથવા કેમેરાથી પાડો</span>
                  <span class="text-[10px] text-slate-400">JPG, PNG (મહત્તમ 5 MB)</span>
                  <input type="file" id="photoInput" accept="image/*" class="hidden" onchange="previewPhoto(event)">
                </label>
                
                <div id="photoPreviewContainer" class="w-full sm:w-28 h-24 rounded-2xl border border-slate-200 bg-slate-100 flex items-center justify-center overflow-hidden relative flex-shrink-0">
                  <span class="text-[10px] text-slate-400 text-center px-1">કોઈ ફોટો નથી</span>
                </div>
              </div>
            </div>

            <!-- Description with Voice Mic Input -->
            <div>
              <div class="flex items-center justify-between mb-1">
                <label class="text-xs font-semibold text-slate-700">સમસ્યાની વિગત (Description)</label>
                <button type="button" onclick="startVoiceInput()" id="micBtn" class="text-xs text-emerald-800 hover:text-emerald-900 font-bold flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 px-2.5 py-1 rounded-xl border border-emerald-200 transition shadow-2xs">
                  <i class="fa-solid fa-microphone text-emerald-600"></i>
                  <span>બોલીને લખાવો</span>
                </button>
              </div>
              <textarea id="descriptionInput" rows="3" placeholder="સમસ્યા વિશે વધુ વિગત જણાવો (દા.ત. છેલ્લા ૩ દિવસથી ગટર ઉભરાય છે અને દુર્ગંધ ફેલાય છે...)" 
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 outline-none transition bg-slate-50/50"></textarea>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-3 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-end gap-3">
            <button type="reset" class="w-full sm:w-auto px-5 py-3 rounded-2xl border border-slate-300 text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition text-center">
              રીસેટ (Reset)
            </button>
            <button type="submit" id="submitBtn" class="w-full sm:w-auto px-7 py-3 rounded-2xl bg-gradient-to-r from-emerald-700 to-teal-800 hover:from-emerald-800 hover:to-teal-900 text-white text-xs sm:text-sm font-bold shadow-lg shadow-emerald-900/20 transition flex items-center justify-center gap-2 active:scale-95">
              <i class="fa-solid fa-paper-plane text-xs text-amber-300"></i>
              <span>ફરિયાદ સબમિટ કરો (Submit Complaint)</span>
            </button>
          </div>

        </form>

      </div>

    </div>


    <!-- ========================================================================= -->
    <!-- 3. COMPLAINT TRACKING VIEW (Tab 3)                                        -->
    <!-- ========================================================================= -->
    <div id="tab-track-status" class="app-tab hidden space-y-5">
      
      <!-- Search Box Card -->
      <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-7 max-w-2xl mx-auto space-y-4">
        <div class="text-center space-y-1">
          <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto text-xl shadow-inner mb-2">
            <i class="fa-solid fa-magnifying-glass-location"></i>
          </div>
          <h2 class="text-xl font-black text-slate-900">તમારી ફરિયાદનું સ્ટેટસ જુઓ</h2>
          <p class="text-xs text-slate-500">
            ફરિયાદ ટોકન નંબર (દા.ત. AMC-2026-W41-5661) અથવા નોંધાયેલ મોબાઇલ નંબર દાખલ કરો.
          </p>
        </div>

        <form onsubmit="handleTrackSubmit(event)" class="flex flex-col sm:flex-row gap-2.5">
          <div class="relative flex-1">
            <i class="fa-solid fa-ticket absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
            <input type="text" id="trackInput" required placeholder="ટોકન દા.ત. AMC-2026-W41-5661" 
              class="w-full pl-10 pr-3.5 py-3 rounded-2xl border border-slate-300 text-sm font-bold font-mono tracking-wide uppercase focus:ring-2 focus:ring-emerald-500 outline-none transition bg-slate-50/50">
          </div>
          <button type="submit" id="trackBtn" class="px-6 py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm shadow-md transition flex items-center justify-center gap-2 active:scale-95">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>ટ્રેક કરો (Track)</span>
          </button>
        </form>

        <!-- Quick Demo Tokens -->
        <div class="pt-2 border-t border-slate-100 flex flex-wrap items-center justify-center gap-2 text-xs text-slate-500">
          <span>ડેમો ટોકન ટેસ્ટ કરો:</span>
          <button onclick="quickTrack('AMC-2026-W41-5661')" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 font-mono font-bold text-[11px]">
            AMC-2026-W41-5661 (પૂર્ણ)
          </button>
          <button onclick="quickTrack('AMC-2026-W12-1089')" class="px-2.5 py-1 rounded-lg bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-800 font-mono font-bold text-[11px]">
            AMC-2026-W12-1089 (પ્રગતિમાં)
          </button>
        </div>
      </div>

      <!-- Tracking Results Card -->
      <div id="trackingResultContainer" class="hidden max-w-3xl mx-auto space-y-5">
        <!-- Injected via JavaScript -->
      </div>

    </div>


    <!-- ========================================================================= -->
    <!-- 4. WARD OFFICER / ADMIN PORTAL (Tab 4)                                    -->
    <!-- ========================================================================= -->
    <div id="tab-officer-portal" class="app-tab hidden space-y-5">
      
      <!-- Officer Login Gate -->
      <div id="officerLoginBox" class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-8 max-w-md mx-auto space-y-5">
        <div class="text-center space-y-1.5">
          <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center mx-auto text-2xl shadow-inner">
            <i class="fa-solid fa-user-shield"></i>
          </div>
          <h2 class="text-xl font-black text-slate-900">AMC વોર્ડ ઓફિસર લૉગિન</h2>
          <p class="text-xs text-slate-500">માત્ર અધિકૃત AMC સ્ટાફ અને વોર્ડ સુપરવાઇઝર માટે</p>
        </div>

        <form onsubmit="handleAdminLogin(event)" class="space-y-4">
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">યુઝરનેમ (Username)</label>
            <input type="text" id="admin_user" value="admin" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 outline-none">
          </div>
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1">પાસવર્ડ (Password)</label>
            <input type="password" id="admin_pass" value="amc2026" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold focus:ring-2 focus:ring-emerald-500 outline-none">
          </div>

          <div class="bg-emerald-50 p-3 rounded-2xl border border-emerald-200 text-xs text-emerald-900 space-y-1">
            <div class="font-bold flex items-center gap-1.5">
              <i class="fa-solid fa-key text-emerald-700"></i> ડેમો લૉગિન વિગતો:
            </div>
            <div>યુઝરનેમ: <code class="font-bold bg-white px-2 py-0.5 rounded border border-emerald-300 text-emerald-800">admin</code></div>
            <div>પાસવર્ડ: <code class="font-bold bg-white px-2 py-0.5 rounded border border-emerald-300 text-emerald-800">amc2026</code></div>
          </div>

          <button type="submit" id="adminLoginBtn" class="w-full py-3 rounded-2xl bg-emerald-800 hover:bg-emerald-900 text-white font-bold text-sm shadow-md transition active:scale-95">
            ઓફિસર લૉગિન કરો (Sign In)
          </button>
        </form>
      </div>

      <!-- Officer Dashboard (Shown after Login) -->
      <div id="officerDashboard" class="hidden space-y-5">
        
        <!-- Officer Info Strip -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-700 text-white flex-shrink-0 flex items-center justify-center text-xl shadow-md">
              <i class="fa-solid fa-id-badge"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="text-base sm:text-lg font-black text-slate-900" id="officerNameDisplay">વોર્ડ ઓફિસર ડેશબોર્ડ</h3>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">સક્રિય સત્ર</span>
              </div>
              <p class="text-xs text-slate-500" id="officerRoleDisplay">અમદાવાદ મ્યુનિસિપલ કોર્પોરેશન - વોર્ડ ટીમ</p>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <button onclick="loadAllComplaints()" class="flex-1 sm:flex-none px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition flex items-center justify-center gap-1.5">
              <i class="fa-solid fa-arrows-rotate"></i> રિફ્રેશ
            </button>
            <button onclick="handleAdminLogout()" class="flex-1 sm:flex-none px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 text-xs font-bold transition flex items-center justify-center gap-1.5">
              <i class="fa-solid fa-right-from-bracket"></i> લૉગ આઉટ
            </button>
          </div>
        </div>

        <!-- Metric Badges -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
            <div class="text-[11px] font-semibold text-slate-500">કુલ ફરિયાદો</div>
            <div class="text-2xl font-black text-slate-900 mt-1" id="stat-total">0</div>
          </div>
          <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200 shadow-2xs">
            <div class="text-[11px] font-semibold text-amber-800">નવી નોંધાયેલ</div>
            <div class="text-2xl font-black text-amber-900 mt-1" id="stat-submitted">0</div>
          </div>
          <div class="bg-blue-50 p-4 rounded-2xl border border-blue-200 shadow-2xs">
            <div class="text-[11px] font-semibold text-blue-800">કામગીરી પ્રગતિમાં</div>
            <div class="text-2xl font-black text-blue-900 mt-1" id="stat-in-progress">0</div>
          </div>
          <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-200 shadow-2xs">
            <div class="text-[11px] font-semibold text-emerald-800">નિકાલ પૂર્ણ</div>
            <div class="text-2xl font-black text-emerald-900 mt-1" id="stat-resolved">0</div>
          </div>
        </div>

        <!-- Table / Complaints List -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
          <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 bg-slate-50/60">
            <h4 class="text-sm font-bold text-slate-900 flex items-center gap-2">
              <i class="fa-solid fa-clipboard-list text-emerald-700"></i>
              વોર્ડ ફરિયાદોની યાદી &amp; કાર્યવાહી
            </h4>
            
            <div class="flex items-center gap-2">
              <select id="statusFilter" onchange="filterComplaintsTable()" class="text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-300 bg-white outline-none">
                <option value="all">તમામ સ્ટેટસ (All)</option>
                <option value="Submitted">નવી નોંધાયેલ (Submitted)</option>
                <option value="In Progress">પ્રગતિમાં (In Progress)</option>
                <option value="Resolved">નિકાલ પૂર્ણ (Resolved)</option>
              </select>
            </div>
          </div>

          <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-xs text-slate-600 min-w-[500px]">
              <thead class="bg-slate-100/70 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                <tr>
                  <th class="p-3">ટોકન</th>
                  <th class="p-3">નાગરિક</th>
                  <th class="p-3">શ્રેણી &amp; વોર્ડ</th>
                  <th class="p-3">સરનામું</th>
                  <th class="p-3">સ્ટેટસ</th>
                  <th class="p-3 text-right">કાર્યવાહી</th>
                </tr>
              </thead>
              <tbody id="complaintsTableBody" class="divide-y divide-slate-100">
                <!-- Injected via JS -->
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>

  </main>

  <!-- ================= FIXED FLOATING APP BOTTOM NAVIGATION BAR (Solar App Style) ================= -->
  <nav class="mobile-bottom-navbar">
    
    <!-- Tab 1: Dashboard -->
    <button type="button" onclick="switchAppTab('dashboard')" id="bnav-dashboard" class="bnav-btn active">
      <i class="fa-solid fa-house-chimney text-base"></i>
      <span>ડેશબોર્ડ</span>
    </button>

    <!-- Tab 2: New Complaint -->
    <button type="button" onclick="switchAppTab('new-complaint')" id="bnav-new-complaint" class="bnav-btn">
      <i class="fa-solid fa-file-circle-plus text-base"></i>
      <span>ફરિયાદ</span>
    </button>

    <!-- Tab 3: Live Tracking -->
    <button type="button" onclick="switchAppTab('track-status')" id="bnav-track-status" class="bnav-btn">
      <i class="fa-solid fa-location-crosshairs text-base"></i>
      <span>ટ્રેકિંગ</span>
    </button>

    <!-- Tab 4: Officer Portal -->
    <button type="button" onclick="switchAppTab('officer-portal')" id="bnav-officer-portal" class="bnav-btn">
      <i class="fa-solid fa-user-shield text-base"></i>
      <span>ઓફિસર</span>
    </button>

  </nav>

  <!-- ================= SUCCESS POPUP MODAL (Token Display) ================= -->
  <div id="successModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 space-y-4 shadow-2xl border border-slate-100 text-center animate-in fade-in zoom-in duration-200">
      
      <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl shadow-inner">
        <i class="fa-solid fa-circle-check"></i>
      </div>

      <div class="space-y-1">
        <h3 class="text-xl font-black text-slate-900">ફરિયાદ સફળતાપૂર્વક નોંધાઈ ગઈ!</h3>
        <p class="text-xs text-slate-500">સંબંધિત AMC વોર્ડ ઓફિસરને ફરિયાદ સોંપાઈ ગઈ છે.</p>
      </div>

      <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-dashed border-emerald-300 rounded-2xl p-4 space-y-1">
        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">તમારો યુનિક ફરિયાદ ટોકન નંબર</span>
        <div class="text-2xl font-black text-emerald-950 tracking-widest font-mono break-all" id="modalTokenDisplay">
          AMC-2026-W00-0000
        </div>
        <p class="text-[11px] text-slate-500">આ ટોકન નંબર વડે તમે કોઈપણ સમયે લાઈવ સ્ટેટસ જાણી શકશો.</p>
      </div>

      <div class="bg-emerald-50 rounded-2xl p-3 border border-emerald-200 text-left flex items-start gap-2.5">
        <i class="fa-solid fa-comment-sms text-emerald-600 text-base mt-0.5 flex-shrink-0"></i>
        <div class="text-xs text-emerald-950 leading-snug">
          <span class="font-bold">SMS ચેતવણી:</span> તમારા મોબાઇલ નંબર પર કન્ફર્મેશન SMS અને વોર્ડ ઓફિસરનો સંપર્ક મોકલાઈ ગયો છે.
        </div>
      </div>

      <div class="flex items-center gap-2 pt-1">
        <button onclick="closeSuccessModalAndTrack()" class="flex-1 py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs sm:text-sm shadow-md transition active:scale-95">
          <i class="fa-solid fa-location-crosshairs mr-1"></i> સ્ટેટસ ટ્રેક કરો
        </button>
        <button onclick="closeSuccessModal()" class="px-4 py-3 rounded-2xl border border-slate-300 text-slate-700 hover:bg-slate-100 text-xs sm:text-sm font-semibold transition">
          બંધ કરો
        </button>
      </div>

    </div>
  </div>

  <!-- ================= OFFICER STATUS UPDATE MODAL ================= -->
  <div id="updateModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100 text-left">
      <div class="flex items-center justify-between border-b border-slate-100 pb-3">
        <div>
          <h3 class="text-base font-bold text-slate-900">ફરિયાદ સ્ટેટસ અપડેટ કરો</h3>
          <p class="text-xs text-slate-500 font-mono" id="modalUpdateToken">AMC-2026-...</p>
        </div>
        <button onclick="closeUpdateModal()" class="text-slate-400 hover:text-slate-600 p-1">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <form onsubmit="handleStatusUpdateSubmit(event)" class="space-y-4">
        <input type="hidden" id="updateComplaintId">

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">નવું સ્ટેટસ (New Status) *</label>
          <select id="updateStatusSelect" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm bg-white font-bold text-slate-800">
            <option value="In Progress">કામગીરી ચાલુ (In Progress)</option>
            <option value="Resolved">નિકાલ પૂર્ણ (Resolved)</option>
            <option value="Rejected">અમાન્ય / રદ (Rejected)</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">ઓફિસર શેરો / કાર્યવાહી નોંધ (Resolution Remarks) *</label>
          <textarea id="updateRemarksInput" rows="3" required placeholder="દા.ત. વોર્ડ ટીમે સ્થળ પર પહોંચી કામગીરી પૂર્ણ કરી છે..." 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 outline-none"></textarea>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-700 mb-1">નિકાલ પુરાવો ફોટો (After Photo Proof)</label>
          <input type="file" id="updatePhotoInput" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
        </div>

        <div class="pt-2 flex items-center justify-end gap-2">
          <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-100">
            કેન્સલ
          </button>
          <button type="submit" id="saveStatusBtn" class="px-5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold shadow-md">
            સેવ કરો અને અપડેટ કરો
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ================= JAVASCRIPT APP LOGIC ================= -->
  <script>
    // Complete Zones & Wards of Ahmedabad Municipal Corporation (Preloaded & Guaranteed)
    const AMC_ZONES_DATA = [
      {
        name: 'વેસ્ટ ઝોન (West Zone)',
        wards: ['નવરંગપુરા (Navrangpura)', 'પાલડી (Paldi)', 'વાડજ (Vadaj)', 'ઉસ્માનપુરા (Usmanpura)', 'રાણીપ (Ranip)', 'સાબરમતી (Sabarmati)', 'સ્ટેડિયમ (Stadium)']
      },
      {
        name: 'ન્યુ વેસ્ટ ઝોન (New West Zone)',
        wards: ['બોડકદેવ (Bodakdev)', 'સેટેલાઇટ (Satellite)', 'જોધપુર (Jodhpur)', 'વેજલપુર (Vejalpur)', 'ઘાટલોડિયા (Ghatlodia)', 'થલતેજ (Thaltej)', 'ગોટા (Gota)', 'ચાંદલોડિયા (Chandlodia)']
      },
      {
        name: 'સેન્ટ્રલ ઝોન (Central Zone)',
        wards: ['ખાડિયા (Khadia)', 'શાહપુર (Shahpur)', 'જમાલપુર (Jamalpur)', 'દરીયાપુર (Dariapur)', 'અસારવા (Asarwa)', 'શાહીબાગ (Shahibaug)']
      },
      {
        name: 'સાઉથ ઝોન (South Zone)',
        wards: ['મણિનગર (Maninagar)', 'ખોખરા (Khokhra)', 'દાણીલીમડા (Danilimda)', 'બેહરામપુરા (Behrampura)', 'ઇસનપુર (Isanpur)', 'વટવા (Vatva)', 'લાંભા (Lambha)']
      },
      {
        name: 'ઇસ્ટ ઝોન (East Zone)',
        wards: ['બાપુનગર (Bapunagar)', 'નિકોલ (Nikol)', 'ઓઢવ (Odhav)', 'ગોમતીપુર (Gomtipur)', 'અમરાઈવાડી (Amraiwadi)', 'વિરાટનગર (Viratnagar)', 'વસ્ત્રાલ (Vastral)']
      },
      {
        name: 'નોર્થ ઝોન (North Zone)',
        wards: ['નરોડા (Naroda)', 'કુબેરનગર (Kubernagar)', 'સરદારનગર (Sardarnagar)', 'મેઘાણીનગર (Meghaninagar)', 'સૈજપુર બોઘા (Saijpur Bogha)', 'ઇન્ડિયા કોલોની (India Colony)']
      },
      {
        name: 'સાઉથ વેસ્ટ ઝોન (South West Zone)',
        wards: ['સરખેજ (Sarkhej)', 'મક્તમપુરા (Maktampura)', 'જોધપુર વેસ્ટ (Jodhpur West)']
      }
    ];

    // Civic Categories Data with Icons
    const CIVIC_CATEGORIES = [
      {
        id: 'potholes',
        title: 'રસ્તા પરના ખાડા (Roads & Potholes)',
        icon: '🕳️',
        subcategories: ['મોટો ખાડો (Deep Crater)', 'પેવિંગ બ્લોક તૂટેલા', 'રસ્તો બેસી ગયેલ', 'ડામર રોડ ડેમેજ']
      },
      {
        id: 'garbage',
        title: 'કચરો & ગંદકી (Garbage / Solid Waste)',
        icon: '🗑️',
        subcategories: ['કચરાપેટી ઓવરફ્લો', 'જાહેર રસ્તા પર ગંદકી', 'મૃત પશુ ઉપાડવા બાબત', 'કચરા ગાડી ન આવવા બાબત']
      },
      {
        id: 'streetlights',
        title: 'સ્ટ્રીટલાઇટ બંધ (Streetlight Outage)',
        icon: '💡',
        subcategories: ['પોલ લાઈટ બંધ', 'વાયરિંગ ઓપન / શોર્ટ સર્કિટ', 'પોલ ડેમેજ / નમી ગયેલ', 'સમયસર લાઈટ ચાલુ ન થવી']
      },
      {
        id: 'water',
        title: 'પાણી & ગટર (Water Supply & Drainage)',
        icon: '🚰',
        subcategories: ['ગંદુ પાણી આવવા બાબત', 'પાણીનું પ્રેશર ઓછું', 'ગટર ઓવરફ્લો / બેક મારવી', 'મેનહોલ ઢાંકણું તૂટેલ / ગાયબ']
      },
      {
        id: 'health',
        title: 'આરોગ્ય & ફોગિંગ (Health & Mosquitoes)',
        icon: '🦟',
        subcategories: ['મચ્છરનો ઉપદ્રવ / ફોગિંગ જરૂર', 'પાણીના ખાબોચિયા દવા છંટકાવ', 'ખાદ્ય પદાર્થોમાં ભેળસેળ તપાસ']
      },
      {
        id: 'cattle',
        title: 'રખડતા ઢોર & કૂતરા (Cattle Menace & Dogs)',
        icon: '🐄',
        subcategories: ['રસ્તા પર રખડતી ગાયો/ઢોર', 'કૂતરા કરડવાનો ભય / ખસીકરણ']
      }
    ];

    let selectedCategoryId = 'potholes';
    let mapInstance = null;
    let mapMarker = null;
    let currentMarkerCoords = { lat: 23.0225, lng: 72.5714 }; // Ahmedabad Center
    let photoBase64 = null;
    let lastCreatedToken = null;
    let allComplaintsData = [];

    // App Initialization
    document.addEventListener('DOMContentLoaded', () => {
      initMap();
      populateZonesAndWards();
      renderCategoryCards();
      checkSavedSession();

      const hash = window.location.hash.replace('#', '');
      if (['dashboard', 'new-complaint', 'track-status', 'officer-portal'].includes(hash)) {
        switchAppTab(hash);
      }
    });

    // 1. Populate Zone & Ward Dropdowns instantly
    function populateZonesAndWards() {
      const zoneSelect = document.getElementById('zoneSelect');
      zoneSelect.innerHTML = '';

      AMC_ZONES_DATA.forEach((z, index) => {
        const opt = document.createElement('option');
        opt.value = z.name;
        opt.textContent = z.name;
        if (index === 0) opt.selected = true;
        zoneSelect.appendChild(opt);
      });

      handleZoneChange();
    }

    function handleZoneChange() {
      const zoneName = document.getElementById('zoneSelect').value;
      const wardSelect = document.getElementById('wardSelect');
      wardSelect.innerHTML = '';

      const found = AMC_ZONES_DATA.find(z => z.name === zoneName) || AMC_ZONES_DATA[0];
      if (found && found.wards) {
        found.wards.forEach((w, index) => {
          const opt = document.createElement('option');
          opt.value = w;
          opt.textContent = w;
          if (index === 0) opt.selected = true;
          wardSelect.appendChild(opt);
        });
      }
    }

    // 2. Render Category Cards
    function renderCategoryCards() {
      const container = document.getElementById('categoryCardsContainer');
      container.innerHTML = '';

      CIVIC_CATEGORIES.forEach((cat, index) => {
        const isSelected = cat.id === selectedCategoryId;
        const card = document.createElement('div');
        card.id = `cat-card-${cat.id}`;
        card.className = `cursor-pointer p-3 rounded-2xl border transition flex flex-col justify-between ${
          isSelected ? 'border-emerald-600 bg-emerald-50/80 shadow-xs' : 'border-slate-200 bg-slate-50 hover:bg-slate-100'
        }`;
        card.onclick = () => selectCategory(cat.id);

        card.innerHTML = `
          <div class="flex items-center justify-between mb-1.5">
            <span class="text-2xl">${cat.icon}</span>
            <span class="w-3.5 h-3.5 rounded-full border border-slate-300 flex items-center justify-center cat-radio">
              <span class="w-2 h-2 rounded-full ${isSelected ? 'bg-emerald-600' : 'hidden'}"></span>
            </span>
          </div>
          <div class="text-xs font-bold text-slate-800 leading-snug break-words">${cat.title}</div>
        `;
        container.appendChild(card);
      });

      populateSubcategories(selectedCategoryId);
    }

    function selectCategory(catId) {
      selectedCategoryId = catId;
      document.querySelectorAll('#categoryCardsContainer > div').forEach(el => {
        el.classList.remove('border-emerald-600', 'bg-emerald-50/80', 'shadow-xs');
        el.classList.add('border-slate-200', 'bg-slate-50');
        const dot = el.querySelector('.cat-radio span');
        if (dot) dot.classList.add('hidden');
      });

      const selectedEl = document.getElementById(`cat-card-${catId}`);
      if (selectedEl) {
        selectedEl.classList.remove('border-slate-200', 'bg-slate-50');
        selectedEl.classList.add('border-emerald-600', 'bg-emerald-50/80', 'shadow-xs');
        const dot = selectedEl.querySelector('.cat-radio span');
        if (dot) dot.classList.remove('hidden');
      }

      populateSubcategories(catId);
    }

    function populateSubcategories(catId) {
      const subSelect = document.getElementById('subcategorySelect');
      subSelect.innerHTML = '';

      const catObj = CIVIC_CATEGORIES.find(c => c.id === catId);
      if (catObj && catObj.subcategories) {
        catObj.subcategories.forEach((sub, idx) => {
          const opt = document.createElement('option');
          opt.value = sub;
          opt.textContent = sub;
          if (idx === 0) opt.selected = true;
          subSelect.appendChild(opt);
        });
      }
    }

    // 3. Leaflet Map
    function initMap() {
      const ahmedabadCoord = [23.0225, 72.5714];
      mapInstance = L.map('map', { scrollWheelZoom: false }).setView(ahmedabadCoord, 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
      }).addTo(mapInstance);

      mapMarker = L.marker(ahmedabadCoord, { draggable: true }).addTo(mapInstance);

      mapMarker.on('dragend', function () {
        const pos = mapMarker.getLatLng();
        updateMarkerCoords(pos.lat, pos.lng);
      });

      mapInstance.on('click', function (e) {
        mapMarker.setLatLng(e.latlng);
        updateMarkerCoords(e.latlng.lat, e.latlng.lng);
      });
    }

    function updateMarkerCoords(lat, lng) {
      currentMarkerCoords = { lat: Number(lat).toFixed(6), lng: Number(lng).toFixed(6) };
      document.getElementById('latDisplay').textContent = currentMarkerCoords.lat;
      document.getElementById('lngDisplay').textContent = currentMarkerCoords.lng;
    }

    function detectGPS() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
          const lat = pos.coords.latitude;
          const lng = pos.coords.longitude;
          mapInstance.setView([lat, lng], 15);
          mapMarker.setLatLng([lat, lng]);
          updateMarkerCoords(lat, lng);
          alert('તમારું GPS લોકેશન સફળતાપૂર્વક મેળવાઈ ગયું છે.');
        }, () => {
          const fallback = [23.0365, 72.5178];
          mapInstance.setView(fallback, 15);
          mapMarker.setLatLng(fallback);
          updateMarkerCoords(fallback[0], fallback[1]);
          alert('GPS પરવાનગી ન મળવાથી ડેમો લોકેશન (બોડકદેવ, અમદાવાદ) સેટ કરેલ છે.');
        });
      }
    }

    // 4. Photo Preview
    function previewPhoto(event) {
      const file = event.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        photoBase64 = e.target.result;
        const container = document.getElementById('photoPreviewContainer');
        container.innerHTML = `<img src="${photoBase64}" class="w-full h-full object-cover">`;
      };
      reader.readAsDataURL(file);
    }

    // 5. Voice Input
    function startVoiceInput() {
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
      if (!SpeechRecognition) {
        alert("તમારા બ્રાઉઝરમાં વોઇસ ઇનપુટ સપોર્ટ નથી. કૃપા કરીને ટાઇપ કરો.");
        return;
      }

      const recognition = new SpeechRecognition();
      recognition.lang = 'gu-IN';
      const micBtn = document.getElementById('micBtn');

      micBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-emerald-600"></i> સાંભળે છે...';

      recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        const desc = document.getElementById('descriptionInput');
        desc.value = desc.value ? (desc.value + ' ' + transcript) : transcript;
        micBtn.innerHTML = '<i class="fa-solid fa-microphone text-emerald-600"></i> <span>બોલીને લખાવો</span>';
      };

      recognition.onerror = function() {
        micBtn.innerHTML = '<i class="fa-solid fa-microphone text-emerald-600"></i> <span>બોલીને લખાવો</span>';
      };

      recognition.start();
    }

    // 6. Complaint Submission
    async function handleComplaintSubmit(e) {
      e.preventDefault();

      const submitBtn = document.getElementById('submitBtn');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> પ્રોસેસિંગ...';

      const payload = {
        citizen_name: document.getElementById('citizen_name').value.trim(),
        citizen_phone: document.getElementById('citizen_phone').value.trim(),
        category_id: selectedCategoryId,
        subcategory: document.getElementById('subcategorySelect').value,
        zone: document.getElementById('zoneSelect').value,
        ward: document.getElementById('wardSelect').value,
        address: document.getElementById('addressInput').value.trim(),
        lat: currentMarkerCoords.lat,
        lng: currentMarkerCoords.lng,
        description: document.getElementById('descriptionInput').value.trim(),
        photo_base64: photoBase64
      };

      try {
        const res = await fetch('api.php?action=submit_complaint', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        });
        const data = await res.json();

        if (data.success) {
          lastCreatedToken = data.complaint.token;
          showSuccessModal(data.complaint.token);
          document.getElementById('complaintForm').reset();
          photoBase64 = null;
          document.getElementById('photoPreviewContainer').innerHTML = '<span class="text-[10px] text-slate-400 text-center px-1">કોઈ ફોટો નથી</span>';
          populateZonesAndWards();
        } else {
          alert('ભૂલ: ' + (data.error || 'ફરિયાદ સબમિટ ન થઈ શકી'));
        }
      } catch (err) {
        alert('કનેક્શન એરર. ફરી પ્રયાસ કરો.');
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane text-xs text-amber-300"></i> <span>ફરિયાદ સબમિટ કરો (Submit Complaint)</span>';
      }
    }

    function showSuccessModal(token) {
      document.getElementById('modalTokenDisplay').textContent = token;
      document.getElementById('successModal').classList.remove('hidden');
    }

    function closeSuccessModal() {
      document.getElementById('successModal').classList.add('hidden');
    }

    function closeSuccessModalAndTrack() {
      closeSuccessModal();
      if (lastCreatedToken) {
        quickTrack(lastCreatedToken);
      }
    }

    // 7. Tracking
    function quickTrack(token) {
      switchAppTab('track-status');
      document.getElementById('trackInput').value = token;
      handleTrackSubmit(new Event('submit'));
    }

    async function handleTrackSubmit(e) {
      if (e) e.preventDefault();

      const query = document.getElementById('trackInput').value.trim();
      if (!query) return;

      const trackBtn = document.getElementById('trackBtn');
      trackBtn.disabled = true;
      trackBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> શોધાય છે...';

      try {
        const res = await fetch(`api.php?action=track_complaint&query=${encodeURIComponent(query)}`);
        const data = await res.json();

        if (data.success) {
          renderTrackingDetails(data.complaint);
        } else {
          renderTrackingNotFound(query);
        }
      } catch (err) {
        alert('ટ્રેકિંગ ડેટા મેળવવામાં ભૂલ થઈ.');
      } finally {
        trackBtn.disabled = false;
        trackBtn.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i> <span>ટ્રેક કરો (Track)</span>';
      }
    }

    function renderTrackingDetails(c) {
      const container = document.getElementById('trackingResultContainer');
      container.classList.remove('hidden');

      const isSubmitted = true;
      const isInProgress = c.status === 'In Progress' || c.status === 'Resolved';
      const isResolved = c.status === 'Resolved';

      let statusBadgeColor = 'bg-amber-100 text-amber-800 border-amber-300';
      if (c.status === 'In Progress') statusBadgeColor = 'bg-blue-100 text-blue-800 border-blue-300';
      if (c.status === 'Resolved') statusBadgeColor = 'bg-emerald-100 text-emerald-800 border-emerald-300';

      container.innerHTML = `
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-5 sm:p-7 space-y-6">
          
          <!-- Token Header -->
          <div class="flex flex-col xs:flex-row xs:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
              <div class="text-[10px] sm:text-xs text-slate-500 font-semibold">ફરિયાદ ટોકન નંબર</div>
              <div class="text-xl sm:text-2xl font-black font-mono text-emerald-950 tracking-wide break-all">${c.token}</div>
            </div>
            <div class="self-start xs:self-center">
              <span class="px-3 py-1 rounded-full text-xs font-bold border ${statusBadgeColor}">
                ● ${c.status === 'Submitted' ? 'નોંધાયેલ (Submitted)' : (c.status === 'In Progress' ? 'પ્રગતિમાં (In Progress)' : 'નિકાલ પૂર્ણ (Resolved)')}
              </span>
            </div>
          </div>

          <!-- Progress Stepper -->
          <div class="relative py-4">
            <div class="absolute top-1/2 left-4 right-4 h-1.5 bg-slate-200 -translate-y-1/2 z-0 rounded-full"></div>
            <div class="absolute top-1/2 left-4 h-1.5 bg-emerald-600 -translate-y-1/2 z-0 rounded-full transition-all duration-500" style="width: ${isResolved ? '100%' : (isInProgress ? '50%' : '10%')}"></div>

            <div class="relative z-10 flex justify-between items-center text-center">
              <div class="flex flex-col items-center max-w-[85px] sm:max-w-none">
                <div class="w-9 h-9 rounded-full ${isSubmitted ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-200 text-slate-500'} flex items-center justify-center font-bold text-xs">
                  <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-xs font-bold text-slate-800 mt-2 leading-tight">ફરિયાદ નોંધાઈ</span>
                <span class="text-[10px] text-slate-400 mt-0.5">${c.created_at ? c.created_at.split(' ')[0] : 'અત્યારે'}</span>
              </div>

              <div class="flex flex-col items-center max-w-[85px] sm:max-w-none">
                <div class="w-9 h-9 rounded-full ${isInProgress ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-200 text-slate-500'} flex items-center justify-center font-bold text-xs">
                  <i class="fa-solid fa-user-gear"></i>
                </div>
                <span class="text-xs font-bold text-slate-800 mt-2 leading-tight">વોર્ડ ટીમ સોંપાઈ</span>
                <span class="text-[10px] text-slate-400 mt-0.5">${c.assigned_officer ? c.assigned_officer.split(' ')[0] : 'ઇજનેર'}</span>
              </div>

              <div class="flex flex-col items-center max-w-[85px] sm:max-w-none">
                <div class="w-9 h-9 rounded-full ${isResolved ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-200 text-slate-500'} flex items-center justify-center font-bold text-xs">
                  <i class="fa-solid fa-flag-checkered"></i>
                </div>
                <span class="text-xs font-bold text-slate-800 mt-2 leading-tight">નિકાલ પૂર્ણ</span>
                <span class="text-[10px] text-slate-400 mt-0.5">${isResolved ? 'સફળ' : 'પ્રક્રિયામાં'}</span>
              </div>
            </div>
          </div>

          <!-- Grievance Details Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 rounded-2xl p-4 border border-slate-200 text-xs">
            <div>
              <span class="text-slate-400 font-semibold">કેટેગરી:</span>
              <div class="font-bold text-slate-800 mt-0.5">${c.category_id} - ${c.subcategory}</div>
            </div>
            <div>
              <span class="text-slate-400 font-semibold">વોર્ડ &amp; ઝોન:</span>
              <div class="font-bold text-slate-800 mt-0.5">${c.ward} (${c.zone})</div>
            </div>
            <div>
              <span class="text-slate-400 font-semibold">સરનામું:</span>
              <div class="font-bold text-slate-800 mt-0.5 break-words">${c.address}</div>
            </div>
            <div>
              <span class="text-slate-400 font-semibold">અરજદાર:</span>
              <div class="font-bold text-slate-800 mt-0.5">${c.citizen_name} (+91 ${c.citizen_phone || c.citizen_mobile})</div>
            </div>
            <div class="sm:col-span-2">
              <span class="text-slate-400 font-semibold">સમસ્યા વિગત:</span>
              <div class="font-medium text-slate-700 mt-0.5 break-words">${c.description || 'કોઈ વિગત આપેલ નથી.'}</div>
            </div>
          </div>

          <!-- Photos Comparison -->
          <div class="space-y-2.5">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600">ફોટો પુરાવો (Before / After Photo Proof)</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div class="border border-slate-200 rounded-2xl p-3 bg-white space-y-2">
                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                  <span>નાગરિકે મોકલેલ ફોટો</span>
                  <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600">Before</span>
                </div>
                <div class="h-44 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center">
                  ${c.photo_url 
                    ? `<img src="${c.photo_url}" class="w-full h-full object-cover">` 
                    : `<span class="text-xs text-slate-400">કોઈ ફોટો નથી</span>`}
                </div>
              </div>

              <div class="border border-slate-200 rounded-2xl p-3 bg-white space-y-2">
                <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                  <span>કામ પૂરું થયાનો સત્તાવાર ફોટો</span>
                  <span class="text-[10px] px-2 py-0.5 rounded ${isResolved ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'}">After Proof</span>
                </div>
                <div class="h-44 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center">
                  ${(c.resolution_photo || c.resolved_photo)
                    ? `<img src="${c.resolution_photo || c.resolved_photo}" class="w-full h-full object-cover">` 
                    : `<span class="text-xs text-slate-400 text-center px-4">કામગીરી પૂર્ણ થયા પછી AMC વોર્ડ સ્ટાફ ફોટો અપલોડ કરશે.</span>`}
                </div>
              </div>
            </div>
          </div>

          <!-- Officer Remarks -->
          ${c.resolution_remarks ? `
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-1">
              <div class="text-xs font-bold text-emerald-800 flex items-center gap-1.5">
                <i class="fa-solid fa-circle-check"></i> AMC વોર્ડ ઓફિસર શેરો (Resolution Remarks):
              </div>
              <p class="text-xs text-emerald-950 font-medium break-words">${c.resolution_remarks}</p>
            </div>
          ` : ''}

          <!-- Citizen Rating (If Resolved) -->
          ${isResolved ? `
            <div class="p-5 rounded-3xl bg-amber-50/70 border border-amber-200 space-y-3">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                  <h4 class="text-sm font-bold text-amber-950">AMC સેવાથી તમે સંતુષ્ટ છો? તમારું રેટિંગ આપો</h4>
                  <p class="text-xs text-amber-700 mt-0.5">તમારો પ્રતિસાદ AMC સેવા સુધારવામાં મદદ કરશે.</p>
                </div>
                <div class="flex items-center gap-1.5 text-2xl text-amber-400" id="starRatingContainer">
                  ${[1, 2, 3, 4, 5].map(star => `
                    <button onclick="submitRating('${c.token}', ${star})" class="hover:scale-125 transition ${star <= (c.rating || 0) ? 'text-amber-500' : 'text-slate-300'}">
                      ★
                    </button>
                  `).join('')}
                </div>
              </div>
              ${c.rating ? `<div class="text-xs font-bold text-emerald-700">તમે આ નિવારણને ${c.rating} સ્ટાર રેટિંગ આપેલ છે. આભાર!</div>` : ''}
            </div>
          ` : ''}

        </div>
      `;
    }

    function renderTrackingNotFound(query) {
      const container = document.getElementById('trackingResultContainer');
      container.classList.remove('hidden');
      container.innerHTML = `
        <div class="bg-white rounded-3xl border border-red-200 p-7 text-center space-y-2 max-w-md mx-auto shadow-sm">
          <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mx-auto text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
          </div>
          <h3 class="text-base font-bold text-slate-800">કોઈ ફરિયાદ મળી નથી</h3>
          <p class="text-xs text-slate-500">
            "<strong>${query}</strong>" માટે કોઈ ડેટા મળ્યો નથી. કૃપા કરીને સાચો ટોકન નંબર દાખલ કરો.
          </p>
        </div>
      `;
    }

    async function submitRating(token, rating) {
      try {
        const res = await fetch('api.php?action=rate_complaint', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ token: token, rating: rating })
        });
        const data = await res.json();
        if (data.success) {
          alert(`તમારું ${rating} સ્ટાર રેટિંગ સેવ થઈ ગયું છે. આભાર!`);
          document.getElementById('trackInput').value = token;
          handleTrackSubmit(null);
        }
      } catch (err) {
        console.error(err);
      }
    }

    // 8. Officer Portal
    function checkSavedSession() {
      const user = localStorage.getItem('amc_officer_user');
      if (user) {
        document.getElementById('officerLoginBox').classList.add('hidden');
        document.getElementById('officerDashboard').classList.remove('hidden');
        loadAllComplaints();
      }
    }

    async function handleAdminLogin(e) {
      e.preventDefault();
      const user = document.getElementById('admin_user').value.trim();
      const pass = document.getElementById('admin_pass').value.trim();

      const btn = document.getElementById('adminLoginBtn');
      btn.disabled = true;
      btn.textContent = 'વેરિફાય થાય છે...';

      try {
        const res = await fetch('api.php?action=login_admin', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ username: user, password: pass })
        });
        const data = await res.json();

        if (data.success) {
          localStorage.setItem('amc_officer_user', data.user.name);
          document.getElementById('officerNameDisplay').textContent = `${data.user.name}`;
          document.getElementById('officerLoginBox').classList.add('hidden');
          document.getElementById('officerDashboard').classList.remove('hidden');
          loadAllComplaints();
        } else {
          alert('લૉગિન નિષ્ફળ: યુઝરનેમ અથવા પાસવર્ડ ખોટો છે.');
        }
      } catch (err) {
        alert('સર્વર કનેક્શન એરર');
      } finally {
        btn.disabled = false;
        btn.textContent = 'ઓફિસર લૉગિન કરો (Sign In)';
      }
    }

    function handleAdminLogout() {
      localStorage.removeItem('amc_officer_user');
      document.getElementById('officerDashboard').classList.add('hidden');
      document.getElementById('officerLoginBox').classList.remove('hidden');
    }

    async function loadAllComplaints() {
      try {
        const res = await fetch('api.php?action=get_all_complaints');
        const data = await res.json();
        if (data.success) {
          allComplaintsData = data.complaints;
          updateDashboardStats(allComplaintsData);
          renderComplaintsTable(allComplaintsData);
        }
      } catch (err) {
        console.error(err);
      }
    }

    function updateDashboardStats(list) {
      document.getElementById('stat-total').textContent = list.length;
      document.getElementById('stat-submitted').textContent = list.filter(c => c.status === 'Submitted').length;
      document.getElementById('stat-in-progress').textContent = list.filter(c => c.status === 'In Progress').length;
      document.getElementById('stat-resolved').textContent = list.filter(c => c.status === 'Resolved').length;
    }

    function renderComplaintsTable(list) {
      const tbody = document.getElementById('complaintsTableBody');
      tbody.innerHTML = '';

      if (list.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-slate-400">કોઈ ફરિયાદ નોંધાયેલ નથી.</td></tr>`;
        return;
      }

      list.forEach(c => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50 transition';

        let badgeClass = 'bg-amber-100 text-amber-800';
        if (c.status === 'In Progress') badgeClass = 'bg-blue-100 text-blue-800';
        if (c.status === 'Resolved') badgeClass = 'bg-emerald-100 text-emerald-800';

        tr.innerHTML = `
          <td class="p-3 font-mono font-bold text-slate-800">${c.token}</td>
          <td class="p-3">
            <div class="font-bold text-slate-800">${c.citizen_name}</div>
            <div class="text-[10px] text-slate-400">+91 ${c.citizen_phone || c.citizen_mobile}</div>
          </td>
          <td class="p-3">
            <div class="font-semibold text-slate-700">${c.subcategory || c.category}</div>
            <div class="text-[10px] text-slate-400">${c.ward}</div>
          </td>
          <td class="p-3 max-w-[150px] truncate" title="${c.address}">${c.address}</td>
          <td class="p-3">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold ${badgeClass}">${c.status}</span>
          </td>
          <td class="p-3 text-right">
            <button onclick="openUpdateModal('${c.token}', '${c.status}')" class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold border border-emerald-200 transition text-[11px]">
              અપડેટ
            </button>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    function filterComplaintsTable() {
      const filter = document.getElementById('statusFilter').value;
      if (filter === 'all') {
        renderComplaintsTable(allComplaintsData);
      } else {
        const filtered = allComplaintsData.filter(c => c.status === filter);
        renderComplaintsTable(filtered);
      }
    }

    function openUpdateModal(token, currentStatus) {
      document.getElementById('updateComplaintId').value = token;
      document.getElementById('modalUpdateToken').textContent = token;
      document.getElementById('updateStatusSelect').value = currentStatus === 'Submitted' ? 'In Progress' : currentStatus;
      document.getElementById('updateRemarksInput').value = '';
      document.getElementById('updateModal').classList.remove('hidden');
    }

    function closeUpdateModal() {
      document.getElementById('updateModal').classList.add('hidden');
    }

    async function handleStatusUpdateSubmit(e) {
      e.preventDefault();

      const token = document.getElementById('updateComplaintId').value;
      const status = document.getElementById('updateStatusSelect').value;
      const remarks = document.getElementById('updateRemarksInput').value.trim();
      const photoFile = document.getElementById('updatePhotoInput').files[0];

      const saveBtn = document.getElementById('saveStatusBtn');
      saveBtn.disabled = true;
      saveBtn.textContent = 'અપડેટ થાય છે...';

      let resolutionPhotoBase64 = null;
      if (photoFile) {
        resolutionPhotoBase64 = await toBase64(photoFile);
      }

      try {
        const res = await fetch('api.php?action=update_status', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            token: token,
            status: status,
            resolution_remarks: remarks,
            resolution_photo_base64: resolutionPhotoBase64
          })
        });
        const data = await res.json();

        if (data.success) {
          alert('સ્ટેટસ સફળતાપૂર્વક અપડેટ થયું.');
          closeUpdateModal();
          loadAllComplaints();
        } else {
          alert('અપડેટ કરવામાં ભૂલ: ' + data.error);
        }
      } catch (err) {
        alert('કનેક્શન એરર');
      } finally {
        saveBtn.disabled = false;
        saveBtn.textContent = 'સેવ કરો અને અપડેટ કરો';
      }
    }

    function toBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
      });
    }

    // 9. Fixed Bottom App Tab Switcher
    function switchAppTab(tabId) {
      // Hide all tabs
      document.querySelectorAll('.app-tab').forEach(el => el.classList.add('hidden'));

      // Show target tab
      const target = document.getElementById(`tab-${tabId}`);
      if (target) {
        target.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      // Update bottom nav active state
      document.querySelectorAll('.bnav-btn').forEach(btn => {
        btn.classList.remove('active');
      });

      const activeBtn = document.getElementById(`bnav-${tabId}`);
      if (activeBtn) {
        activeBtn.classList.add('active');
      }

      // Invalidate Leaflet Map Size if switching to new complaint
      if (tabId === 'new-complaint' && mapInstance) {
        setTimeout(() => mapInstance.invalidateSize(), 200);
      }
    }
  </script>
</body>
</html>
