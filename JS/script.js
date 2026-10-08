const themeToggleBtn = document.getElementById('theme-toggle');

if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');

    if (themeToggleBtn) {
        themeToggleBtn.textContent = 'Modo Claro';
    }
}

if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        if (document.body.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
            themeToggleBtn.textContent = 'Modo Claro';
        } else {
            localStorage.setItem('theme', 'light');
            themeToggleBtn.textContent = 'Modo Escuro';
        }
    });
}