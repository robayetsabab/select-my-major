// Light and dark mode toggle
(function () {
    var btn = document.getElementById('theme-toggle');
    if (!btn) { return; }

    function updateLabel() {
        var current = document.documentElement.getAttribute('data-bs-theme');
        var label = btn.querySelector('span');
        if (label) {
            label.textContent = current === 'dark' ? 'Light mode' : 'Dark mode';
        } else {
            btn.textContent = current === 'dark' ? 'Light mode' : 'Dark mode';
        }
    }

    btn.addEventListener('click', function () {
        var current = document.documentElement.getAttribute('data-bs-theme');
        var next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-bs-theme', next);
        try {
            localStorage.setItem('smm-theme', next);
        } catch (e) {}
        updateLabel();
    });

    updateLabel();
})();

// Interest picker on the Majors page
(function () {
    var chips = document.querySelectorAll('[data-pick]');
    if (!chips.length) { return; }

    var cards = document.querySelectorAll('[data-major-card]');
    var result = document.getElementById('pick-result');

    function refresh() {
        var counts = {};
        chips.forEach(function (chip) {
            if (chip.getAttribute('aria-pressed') === 'true') {
                var slug = chip.getAttribute('data-pick');
                counts[slug] = (counts[slug] || 0) + 1;
            }
        });

        var max = 0;
        Object.keys(counts).forEach(function (key) {
            if (counts[key] > max) { max = counts[key]; }
        });

        var names = [];
        cards.forEach(function (card) {
            var slug = card.getAttribute('data-major-card');
            var hit = max > 0 && counts[slug] === max;
            card.classList.toggle('is-picked', hit);
            var badge = card.querySelector('[data-badge]');
            if (badge) { badge.classList.toggle('d-none', !hit); }
            if (hit) { names.push(card.getAttribute('data-name')); }
        });

        if (result) {
            result.textContent = names.length
                ? 'Closest match: ' + names.join(' and ') + '. Open the card to read more.'
                : 'Pick at least one statement to see a suggestion.';
        }
    }

    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            var pressed = chip.getAttribute('aria-pressed') === 'true';
            chip.setAttribute('aria-pressed', pressed ? 'false' : 'true');
            chip.classList.toggle('active', !pressed);
            refresh();
        });
    });

    refresh();
})();
