<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', companyName()) - ISP Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('partials.theme')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body class="bg-gray-100 dark:bg-slate-800 transition-colors duration-300">
    
    @yield('content')
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true, toast: true, position: 'top-end' });
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'error', title: 'Error!', text: '{{ session('error') }}', showConfirmButton: true, confirmButtonColor: '#0891b2' });
        });
    </script>
    @endif
    @if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'warning', title: 'Perhatian!', text: '{{ session('warning') }}', showConfirmButton: true, confirmButtonColor: '#0891b2' });
        });
    </script>
    @endif
    @if(session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({ icon: 'info', title: 'Informasi', text: '{{ session('info') }}', showConfirmButton: false, timer: 3000, timerProgressBar: true, toast: true, position: 'top-end' });
        });
    </script>
    @endif

    <script>
function toggleTheme(btn) {
    const html = document.documentElement;
    const icon = btn.querySelector('i');

    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');

        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');

        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const theme = localStorage.getItem('theme');

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');

        const icon = document.querySelector('[onclick*="toggleTheme"] i');
        if (icon) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
    }
});
</script>
 @stack('scripts')
</body>
</html>