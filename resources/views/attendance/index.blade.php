<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Absensi - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: #f4f6fa;
            min-height: 100vh;
        }

        .attendance-wrapper {
            max-width: 480px;
            margin: 0 auto;
            padding: 1.5rem 1rem 3rem;
        }

        .card-attendance {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .card-header-custom {
            background: #1e3a5f;
            color: #fff;
            padding: 1.25rem 1.5rem;
        }

        .card-header-custom .role-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Kamera */
        #camera-box {
            position: relative;
            background: #0f1923;
            width: 100%;
            aspect-ratio: 4/3;
            overflow: hidden;
        }

        #video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transform: scaleX(-1); /* mirror */
        }

        #canvas { display: none; }

        /* Overlay saat kamera belum aktif */
        #camera-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #8899aa;
            gap: 8px;
        }

        #camera-placeholder i { font-size: 48px; }
        #camera-placeholder p { font-size: 13px; margin: 0; }

        /* Preview foto yang sudah diambil */
        #photo-preview {
            display: none;
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
        }

        /* Tombol ambil foto */
        .shutter-btn {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 4px solid #1e3a5f;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.1s, background 0.15s;
            flex-shrink: 0;
        }

        .shutter-btn:active { transform: scale(0.93); }
        .shutter-btn i { font-size: 28px; color: #1e3a5f; }

        .btn-retake {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #374151;
            border-radius: 8px;
            padding: 6px 16px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-retake:hover { background: #f3f4f6; }

        /* Status cards */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .status-pill.done { background: #dcfce7; color: #166534; }
        .status-pill.pending { background: #fef9c3; color: #713f12; }
        .status-pill.late { background: #fee2e2; color: #991b1b; }

        /* Jam */
        #clock {
            font-size: 32px;
            font-weight: 600;
            color: #1e3a5f;
            letter-spacing: 1px;
        }

        #date-label { font-size: 13px; color: #6b7280; }

        /* Alert */
        .alert-custom {
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom {
            background: #1e3a5f;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: background 0.15s, opacity 0.15s;
        }

        .btn-primary-custom:hover { background: #162d4a; }
        .btn-primary-custom:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-checkout-custom {
            background: #0f5132;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: background 0.15s, opacity 0.15s;
        }

        .btn-checkout-custom:hover { background: #0a3d25; }
        .btn-checkout-custom:disabled { opacity: 0.5; cursor: not-allowed; }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 13px;
        }

        .info-row:last-child { border-bottom: none; }
        .info-row .label { color: #6b7280; }
        .info-row .value { font-weight: 500; color: #111827; }

        #toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast-msg {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            animation: slideIn 0.25s ease;
            min-width: 240px;
        }

        .toast-msg.success { background: #166534; color: #fff; }
        .toast-msg.error   { background: #991b1b; color: #fff; }

        @keyframes slideIn {
            from { transform: translateX(60px); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        #location-text { font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>

<div id="toast-container"></div>

<div class="attendance-wrapper">

    {{-- Header info user --}}
    <div class="card-attendance mb-3">
        <div class="card-header-custom">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.15);
                        display:flex;align-items:center;justify-content:center;
                        font-weight:600;font-size:16px;flex-shrink:0;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            
            <div>
                {{-- Mengambil nama user langsung dari database yang sedang login --}}
                <p style="margin:0;font-weight:600;font-size:16px;line-height:1.2;">{{ Auth::user()->name }}</p>
            </div>
        </div>
        
        <span class="role-badge">
            {{ Auth::user()->role ?? 'Teknisi' }}
        </span>
    </div>
</div>

        <div class="p-3">
            {{-- Jam & tanggal --}}
            <div class="text-center mb-3">
                <div id="clock">00:00:00</div>
                <div id="date-label">—</div>
            </div>

            {{-- Status absen hari ini --}}
            @if($absenHariIni)
                <div class="mb-3">
                    <div class="info-row">
                        <span class="label">Check-in</span>
                        <span class="value">
                            @if($absenHariIni->check_in)
                                {{ $absenHariIni->check_in->format('H:i:s') }}
                                <span class="status-pill {{ $absenHariIni->status === 'terlambat' ? 'late' : 'done' }} ms-1">
                                    {{ $absenHariIni->status }}
                                </span>
                            @else
                                <span class="status-pill pending">Belum</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="label">Check-out</span>
                        <span class="value">
                            @if($absenHariIni->check_out)
                                {{ $absenHariIni->check_out->format('H:i:s') }}
                                <span class="status-pill done ms-1">Selesai</span>
                            @else
                                <span class="status-pill pending">Belum</span>
                            @endif
                        </span>
                    </div>
                </div>
            @else
                <div class="alert alert-warning alert-custom mb-3">
                    <i class="bi bi-clock-history"></i>
                    Anda belum absen hari ini.
                </div>
            @endif
        </div>
    </div>

    {{-- Kamera --}}
    @if(!$sudahCheckOut)
    <div class="card-attendance mb-3">
        <div id="camera-box">
            <video id="video" autoplay playsinline></video>
            <canvas id="canvas"></canvas>
            <div id="camera-placeholder">
                <i class="bi bi-camera-video-off"></i>
                <p>Klik tombol kamera untuk mengaktifkan</p>
            </div>
            <img id="photo-preview" alt="Foto absen">
        </div>

        {{-- Kontrol kamera --}}
        <div class="p-3">
            {{-- Lokasi --}}
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-geo-alt text-secondary" style="font-size:14px;"></i>
                <span id="location-text">Mendeteksi lokasi...</span>
            </div>

            {{-- Tombol --}}
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                {{-- Tombol aktifkan kamera --}}
                <button id="btn-start-camera" onclick="startCamera()" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="bi bi-camera-video me-1"></i> Aktifkan Kamera
                </button>

                {{-- Shutter --}}
                <button id="btn-capture" class="shutter-btn" onclick="ambilFoto()" disabled title="Ambil foto">
                    <i class="bi bi-camera"></i>
                </button>

                {{-- Ulangi foto --}}
                <button id="btn-retake" class="btn-retake" onclick="ulangi()" style="display:none;">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Ulangi
                </button>
            </div>

            {{-- Tombol submit --}}
            @if(!$sudahCheckIn)
                <button id="btn-checkin" class="btn-primary-custom" onclick="submitAbsen('check_in')" disabled>
                    <i class="bi bi-box-arrow-in-right me-2"></i> Check In
                </button>
            @elseif(!$sudahCheckOut)
                <button id="btn-checkout" class="btn-checkout-custom" onclick="submitAbsen('check_out')" disabled>
                    <i class="bi bi-box-arrow-right me-2"></i> Check Out
                </button>
            @endif
        </div>
    </div>
    @else
        {{-- Sudah check-in dan check-out --}}
        <div class="card-attendance p-4 text-center">
            <i class="bi bi-check-circle-fill text-success" style="font-size:48px;"></i>
            <h5 class="mt-3 mb-1">Absensi Selesai</h5>
            <p class="text-muted" style="font-size:13px;">Anda sudah check-in dan check-out hari ini.</p>
        </div>
    @endif

    
    

</div>{{-- /attendance-wrapper --}}

<script>
    // State
    let stream        = null;
    let fotoBase64    = null;
    let latitude      = null;
    let longitude     = null;
    let address       = '';

    const video         = document.getElementById('video');
    const canvas        = document.getElementById('canvas');
    const preview       = document.getElementById('photo-preview');
    const placeholder   = document.getElementById('camera-placeholder');
    const btnCapture    = document.getElementById('btn-capture');
    const btnRetake     = document.getElementById('btn-retake');
    const btnStartCam   = document.getElementById('btn-start-camera');
    const btnCheckin    = document.getElementById('btn-checkin');
    const btnCheckout   = document.getElementById('btn-checkout');

    // Jam realtime
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID');
        document.getElementById('date-label').textContent = now.toLocaleDateString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Geolocation
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            pos => {
                latitude  = pos.coords.latitude;
                longitude = pos.coords.longitude;
                document.getElementById('location-text').textContent =
                    `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                    .then(r => r.json())
                    .then(d => {
                        address = d.display_name ?? '';
                        const short = d.address
                            ? [d.address.road, d.address.suburb, d.address.city].filter(Boolean).join(', ')
                            : address;
                        document.getElementById('location-text').textContent = short || `${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
                    })
                    .catch(() => {});
            },
            () => {
                document.getElementById('location-text').textContent = 'Lokasi tidak tersedia';
            }
        );
    } else {
        document.getElementById('location-text').textContent = 'GPS tidak didukung browser ini';
    }

    // Kamera
    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                audio: false
            });
            video.srcObject       = stream;
            video.style.display   = 'block';
            placeholder.style.display = 'none';
            btnCapture.disabled   = false;
            btnStartCam.style.display = 'none';
        } catch (e) {
            toast('Tidak dapat mengakses kamera. Pastikan izin kamera sudah diberikan.', 'error');
        }
    }

    function ambilFoto() {
        if (!stream) return;

        canvas.width  = video.videoWidth  || 640;
        canvas.height = video.videoHeight || 480;

        const ctx = canvas.getContext('2d');
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        fotoBase64 = canvas.toDataURL('image/jpeg', 0.85);

        preview.src           = fotoBase64;
        preview.style.display = 'block';
        video.style.display   = 'none';

        btnCapture.style.display  = 'none';
        btnRetake.style.display   = 'inline-block';

        if (btnCheckin)  btnCheckin.disabled  = false;
        if (btnCheckout) btnCheckout.disabled = false;

        stream.getTracks().forEach(t => t.stop());
        stream = null;
    }

    function ulangi() {
        fotoBase64 = null;
        preview.style.display     = 'none';
        btnRetake.style.display   = 'none';
        btnCapture.style.display  = 'flex';
        btnStartCam.style.display = 'inline-block';

        if (btnCheckin)  btnCheckin.disabled  = true;
        if (btnCheckout) btnCheckout.disabled = true;

        startCamera();
    }

    // Submit absen
    async function submitAbsen(type) {
        if (!fotoBase64) {
            toast('Ambil foto selfie terlebih dahulu.', 'error');
            return;
        }

        const btn = type === 'check_in' ? btnCheckin : btnCheckout;
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...';

        try {
            const res = await fetch('{{ route("attendance.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type'     : 'application/json',
                    'X-CSRF-TOKEN'     : document.querySelector('meta[name="csrf-token"]').content,
                    'Accept'           : 'application/json',
                },
                body: JSON.stringify({
                    photo    : fotoBase64,
                    latitude : latitude,
                    longitude: longitude,
                    address  : address,
                    type     : type,
                }),
            });

            const data = await res.json();

            if (data.success) {
                toast(data.message, 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                toast(data.message ?? 'Terjadi kesalahan.', 'error');
                btn.disabled  = false;
                btn.innerHTML = type === 'check_in'
                    ? '<i class="bi bi-box-arrow-in-right me-2"></i> Check In'
                    : '<i class="bi bi-box-arrow-right me-2"></i> Check Out';
            }
        } catch (e) {
            toast('Koneksi bermasalah. Coba lagi.', 'error');
            btn.disabled  = false;
        }
    }

    // Toast notifikasi
    function toast(msg, type = 'success') {
        const el = document.createElement('div');
        el.className = `toast-msg ${type}`;
        el.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>${msg}`;
        document.getElementById('toast-container').appendChild(el);
        setTimeout(() => el.remove(), 3500);
    }
</script>

</body>
</html>