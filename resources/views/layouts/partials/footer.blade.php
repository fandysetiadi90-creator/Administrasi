<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

<!-- Form Logout Tersembunyi -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    // Fungsi global untuk logout
    function logout() {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    }

    // Debug: cek apakah Bootstrap dan jQuery terload
    $(document).ready(function() {
        console.log('jQuery version:', $.fn.jquery);
        console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
    });

    // Sticky footer: tetap di bawah tanpa bergerak saat konten sedikit
    function fixFooter() {
        const body = document.body;
        const html = document.documentElement;
        const height = Math.max(body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight);
        const vh = window.innerHeight;
        if (height < vh) {
            body.classList.add('d-flex', 'flex-column', 'h-100');
            const footer = document.querySelector('footer.main-footer');
            if (footer) {
                footer.classList.add('mt-auto');
            }
        }
    }
    fixFooter();
    window.addEventListener('resize', fixFooter);

    //js toggler login
    const body = document.getElementById('body');
    const toggleBtn = document.getElementById('themeToggle');

    // cek localStorage
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        toggleBtn.innerHTML = '☀️ Light Mode';
    }

    toggleBtn.addEventListener('click', () => {

        body.classList.toggle('dark-mode');

        // simpan mode
        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            toggleBtn.innerHTML = '☀️ Light Mode';
        } else {
            localStorage.setItem('theme', 'light');
            toggleBtn.innerHTML = '🌙 Dark Mode';
        }

    });

    $(document).ready(function() {

        setTimeout(function() {

            $('.auto-hide-alert').alert('close');

        }, 1000);

    });
</script>

@stack('js')