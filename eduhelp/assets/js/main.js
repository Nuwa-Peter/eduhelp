$(document).ready(function() {
    const body = document.body;
    const sidebarLogo = document.getElementById('sidebar-logo');
    const headerLogo = document.getElementById('header-logo');

    const updateLogos = () => {
        if (body.classList.contains('dark')) {
            if(sidebarLogo) sidebarLogo.src = 'logo_dark.png';
            if(headerLogo) headerLogo.src = 'logo_dark.png';
        } else {
            if(sidebarLogo) sidebarLogo.src = 'logo_light.png';
            if(headerLogo) headerLogo.src = 'logo_light.png';
        }
    };

    // Update logos on page load
    updateLogos();

    // Also listen for changes to the body class in case of SPA navigation
    const observer = new MutationObserver(updateLogos);
    observer.observe(body, { attributes: true, attributeFilter: ['class'] });
});
