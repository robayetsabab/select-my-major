(function () {
    'use strict';
    var savedTheme = null;
    try {
        savedTheme = window.localStorage.getItem('smm-theme');
    } catch (error) {
        savedTheme = null;
    }

    var systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    var theme = savedTheme === 'light' || savedTheme === 'dark' ? savedTheme : (systemPrefersDark ? 'dark' : 'light');
    document.documentElement.setAttribute('data-bs-theme', theme);
})();
