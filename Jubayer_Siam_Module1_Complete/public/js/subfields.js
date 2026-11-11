(() => {
    const config = window.SubfieldExplorerConfig;
    if (!config) return;

    const search = document.getElementById('subfield-search');
    const major = document.getElementById('subfield-major');
    const difficulty = document.getElementById('subfield-difficulty');
    const reset = document.getElementById('subfield-reset');
    const results = document.getElementById('subfield-results');
    const count = document.getElementById('subfield-result-count');
    const pagination = document.getElementById('subfield-pagination');
    const modalElement = document.getElementById('subfieldPreviewModal');

    const escapeHtml = (value = '') => String(value).replace(/[&<>"']/g, (char) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    })[char]);

    let timer;
    let activeController;

    function buildCard(item) {
        const majorName = item.major?.name || 'Major';
        const tools = (item.technologies || []).slice(0, 3).map((tool) => `<span>${escapeHtml(tool)}</span>`).join('');
        const image = item.image_url || item.major?.image_url || '';
        const detailUrl = `${config.detailBase}/${encodeURIComponent(item.slug)}`;
        const previewUrl = `${config.api}/${encodeURIComponent(item.slug)}`;
        return `
            <div class="col-md-6 col-xl-4 subfield-result-card">
                <article class="card exploration-card h-100">
                    <div class="exploration-image" style="background-image:url('${escapeHtml(image)}')"></div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <span class="major-label">${escapeHtml(majorName)}</span>
                            <span class="level-label">${escapeHtml(item.difficulty || 'Level not set')}</span>
                        </div>
                        <h2 class="h4">${escapeHtml(item.name)}</h2>
                        <p class="text-body-secondary">${escapeHtml(item.summary)}</p>
                        <div class="tool-preview mb-3">${tools}</div>
                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a class="btn btn-primary flex-grow-1" href="${detailUrl}">Explore details <i class="bi bi-arrow-right ms-1"></i></a>
                            <button class="btn btn-outline-secondary preview-subfield" type="button" data-url="${previewUrl}" aria-label="Quick preview ${escapeHtml(item.name)}"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </article>
            </div>`;
    }

    function renderEmpty() {
        results.innerHTML = `<div class="col-12"><div class="empty-state"><i class="bi bi-search"></i><h3>No subfields found</h3><p>Try removing a filter or using a broader search term.</p></div></div>`;
        pagination.innerHTML = '';
    }

    async function loadResults() {
        if (activeController) activeController.abort();
        activeController = new AbortController();
        const params = new URLSearchParams({ per_page: '100' });
        if (search.value.trim()) params.set('q', search.value.trim());
        if (major.value) params.set('major', major.value);
        if (difficulty.value) params.set('difficulty', difficulty.value);
        count.textContent = 'Updating results...';
        try {
            const response = await fetch(`${config.api}?${params.toString()}`, {
                headers: { 'Accept': 'application/json' }, signal: activeController.signal
            });
            if (!response.ok) throw new Error('Unable to retrieve subfields.');
            const payload = await response.json();
            const items = payload.data || [];
            count.textContent = `Showing ${items.length} of ${payload.total ?? items.length} subfields`;
            if (!items.length) renderEmpty();
            else {
                results.innerHTML = items.map(buildCard).join('');
                pagination.innerHTML = '';
            }
            const url = new URL(window.location.href);
            ['q', 'major', 'difficulty'].forEach((key) => url.searchParams.delete(key));
            if (search.value.trim()) url.searchParams.set('q', search.value.trim());
            if (major.value) url.searchParams.set('major', major.value);
            if (difficulty.value) url.searchParams.set('difficulty', difficulty.value);
            history.replaceState({}, '', url);
        } catch (error) {
            if (error.name === 'AbortError') return;
            count.textContent = 'Could not load results';
            results.innerHTML = `<div class="col-12"><div class="alert alert-warning">${escapeHtml(error.message)} Check that Laravel is running and the API route is available.</div></div>`;
        }
    }

    function queueSearch() {
        window.clearTimeout(timer);
        timer = window.setTimeout(loadResults, 220);
    }

    [search, major, difficulty].forEach((control) => {
        control.addEventListener(control === search ? 'input' : 'change', queueSearch);
    });
    reset.addEventListener('click', () => {
        search.value = '';
        major.value = '';
        difficulty.value = '';
        loadResults();
    });

    results.addEventListener('click', async (event) => {
        const button = event.target.closest('.preview-subfield');
        if (!button) return;
        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
        const title = document.getElementById('preview-title');
        const body = document.getElementById('preview-body');
        const openLink = document.getElementById('preview-link');
        title.textContent = 'Loading subfield...';
        body.innerHTML = '<div class="text-center py-5"><div class="spinner-border" role="status"></div></div>';
        modal.show();
        try {
            const response = await fetch(button.dataset.url, { headers: { 'Accept': 'application/json' } });
            if (!response.ok) throw new Error('Preview could not be loaded.');
            const item = (await response.json()).data;
            title.textContent = item.name;
            openLink.href = `${config.detailBase}/${encodeURIComponent(item.slug)}`;
            const tasks = (item.typical_tasks || []).slice(0, 3).map((task) => `<li>${escapeHtml(task)}</li>`).join('');
            const tech = (item.technologies || []).map((tool) => `<span>${escapeHtml(tool)}</span>`).join('');
            body.innerHTML = `
                <p class="major-label mb-3">${escapeHtml(item.major?.name || '')}</p>
                <p>${escapeHtml(item.details || item.summary || '')}</p>
                <h3 class="h6 mt-4">Typical work</h3><ul class="feature-list">${tasks}</ul>
                <h3 class="h6 mt-4">Technologies</h3><div class="tool-cloud">${tech}</div>
                <div class="note-panel mt-4"><strong>Real-world example</strong><p class="mb-0">${escapeHtml(item.real_world_example || 'See the full subfield page for examples.')}</p></div>`;
        } catch (error) {
            body.innerHTML = `<div class="alert alert-warning">${escapeHtml(error.message)}</div>`;
        }
    });

    loadResults();
})();
