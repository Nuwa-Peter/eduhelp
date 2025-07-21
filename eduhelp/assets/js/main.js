$(document).ready(function() {
    const themeSwitcher = document.getElementById('themeDropdown');

    const setTheme = (theme) => {
        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark')
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme)
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
