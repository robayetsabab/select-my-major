// Quiz progress bar and "answer everything" check.
(() => {
    const form = document.getElementById('quiz-form');
    if (!form) return;
    const total = Number(form.dataset.total || 0);
    const text = document.getElementById('quiz-progress-text');
    const pct = document.getElementById('quiz-progress-pct');
    const bar = document.getElementById('quiz-progress-bar');

    function answered() {
        return form.querySelectorAll('.quiz-question').length
            ? [...form.querySelectorAll('.quiz-question')].filter((q) => q.querySelector('input:checked')).length
            : 0;
    }
    function update() {
        const done = answered();
        const value = total ? Math.round(done / total * 100) : 0;
        text.textContent = `${done} of ${total} answered`;
        pct.textContent = `${value}%`;
        bar.style.width = `${value}%`;
    }
    form.addEventListener('change', update);
    form.addEventListener('submit', (event) => {
        const missing = [...form.querySelectorAll('.quiz-question')].find((q) => !q.querySelector('input:checked'));
        if (missing) {
            event.preventDefault();
            missing.scrollIntoView({ behavior: 'smooth', block: 'center' });
            missing.classList.add('quiz-missing');
            setTimeout(() => missing.classList.remove('quiz-missing'), 1800);
        }
    });
    update();
})();
