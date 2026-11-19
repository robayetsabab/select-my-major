// Feature 8: auto-submit filters and the "helpful" vote button.
(() => {
    const form = document.getElementById('experience-filter');
    if (form) {
        let timer;
        form.querySelectorAll('select').forEach((el) => el.addEventListener('change', () => form.submit()));
        const search = form.querySelector('input[name="q"]');
        if (search) {
            search.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(() => form.submit(), 600); });
        }
    }

    const button = document.getElementById('helpful-btn');
    if (!button) return;
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    button.addEventListener('click', async () => {
        button.disabled = true;
        try {
            const response = await fetch(button.dataset.url, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
            });
            if (!response.ok) throw new Error('Request failed');
            const data = await response.json();
            document.getElementById('helpful-count').textContent = data.count;
            document.getElementById('helpful-label').textContent = data.voted ? 'Marked helpful' : 'This was helpful';
            button.classList.toggle('btn-primary', data.voted);
            button.classList.toggle('btn-outline-primary', !data.voted);
        } catch (error) {
            window.alert('Could not save your vote. Please reload and try again.');
        } finally {
            button.disabled = false;
        }
    });
})();
