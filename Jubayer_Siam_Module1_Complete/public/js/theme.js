(function () {
    var stored = null;
    try {
        stored = localStorage.getItem('smm-theme');
    } catch (e) {}
    var theme = stored;
    if (!theme) {
        theme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    document.documentElement.setAttribute('data-bs-theme', theme);
})();
