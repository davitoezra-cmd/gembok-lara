<script>
    tailwind.config = {
        darkMode: 'class'
    }
</script>

<script>
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
    }
</script>