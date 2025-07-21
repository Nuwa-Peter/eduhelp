$(document).ready(function() {
    const themeSwitcher = document.getElementById('themeDropdown');
    const body = document.body;

    const setTheme = (theme) => {
        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            body.classList.add('dark-mode');
            document.documentElement.setAttribute('data-bs-theme', 'dark')
        } else {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                body.classList.remove('dark-mode');
                document.documentElement.setAttribute('data-bs-theme', 'light')
            }
        }
        localStorage.setItem('theme', theme);
    };

    themeSwitcher.addEventListener('click', (e) => {
        if (e.target.dataset.theme) {
            setTheme(e.target.dataset.theme);
        }
    });

    const savedTheme = localStorage.getItem('theme') || 'auto';
    setTheme(savedTheme);
});
