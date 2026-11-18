(() => {
    const config = window.CareerExplorerConfig;
    if (!config) return;

    const search = document.getElementById('career-search');
    const major = document.getElementById('career-major');
    const level = document.getElementById('career-level');
    const industry = document.getElementById('career-industry');
    const reset = document.getElementById('career-reset');
    const count = document.getElementById('career-result-count');
    const pathBoard = document.getElementById('career-path-board');
    const roleGrid = document.getElementById('career-role-grid');
    const comparePanel = document.getElementById('career-compare');
    const compareTable = document.getElementById('career-compare-table');
    const video = document.getElementById('career-major-video');

    const escapeHtml = (value = '') => String(value).replace(/[&<>"']/g, (char) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    })[char]);
    const slugUrl = (slug) => `${config.detailBase}/${encodeURIComponent(slug)}`;
    let roles = [];
    let selected = new Set();
    let focusedPath = new Set();
    let debounceTimer;

    function roleCard(role) {
        const selectedState = selected.has(role.slug) ? 'checked' : '';
        const focusClass = focusedPath.size && focusedPath.has(role.slug) ? ' path-highlight' : '';
        const responsibilities = (role.responsibilities || []).map((task) => `<li>${escapeHtml(task)}</li>`).join('');
        const skills = (role.skills || []).slice(0, 4).map((skill) => `<span>${escapeHtml(skill)}</span>`).join('');
        const industries = (role.industries || []).slice(0, 3).map((item) => `<span>${escapeHtml(item)}</span>`).join('');
        return `
            <div class="col-md-6 col-xl-4 role-card-wrap${focusClass}" data-role="${escapeHtml(role.slug)}">
                <article class="card role-card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <span class="major-label">${escapeHtml(role.major?.name || 'Major')}</span>
                            <span class="level-label">${escapeHtml(role.level)} · ${escapeHtml(role.experience_range || 'Experience varies')}</span>
                        </div>
                        <h3 class="h4"><a class="role-title-link" href="${slugUrl(role.slug)}">${escapeHtml(role.title)}</a></h3>
                        <p class="text-body-secondary">${escapeHtml(role.summary || role.description || '')}</p>
                        <div class="tool-preview mb-3">${skills}</div>
                        <details class="role-details mb-3">
                            <summary>View responsibilities and industries</summary>
                            <div class="pt-3"><strong class="small">Responsibilities</strong><ul class="feature-list mt-2">${responsibilities}</ul><strong class="small d-block mt-3">Relevant industries</strong><div class="tool-cloud mt-2">${industries}</div></div>
                        </details>
                        <div class="mt-auto d-flex flex-wrap align-items-center gap-2">
                            <a class="btn btn-primary flex-grow-1" href="${slugUrl(role.slug)}">Full role details</a>
                            <button class="btn btn-outline-secondary focus-role" type="button" data-slug="${escapeHtml(role.slug)}" title="Highlight this career path"><i class="bi bi-diagram-3"></i></button>
                        </div>
                        <label class="compare-check mt-3"><input type="checkbox" data-compare="${escapeHtml(role.slug)}" ${selectedState}><span>Compare this role</span></label>
                    </div>
                </article>
            </div>`;
    }

    function pathRoleChip(role) {
        const active = focusedPath.has(role.slug) ? ' active' : '';
        return `<button type="button" class="path-role-chip${active}" data-focus-slug="${escapeHtml(role.slug)}" title="Highlight the path for ${escapeHtml(role.title)}"><strong>${escapeHtml(role.title)}</strong><small>${escapeHtml(role.experience_range || '')}</small></button>`;
    }

    function renderPathBoard() {
        const selectedMajor = major.value;
        const majorsToRender = config.majors.filter((item) => !selectedMajor || item.slug === selectedMajor);
        if (!majorsToRender.length) {
            pathBoard.innerHTML = '<div class="empty-state"><h3>No major found</h3></div>';
            return;
        }
        pathBoard.innerHTML = majorsToRender.map((majorItem) => {
            const majorRoles = roles.filter((role) => role.major?.slug === majorItem.slug);
            const levels = ['Entry', 'Mid', 'Senior'];
            return `
                <section class="major-path-section">
                    <div class="major-path-heading"><h3>${escapeHtml(majorItem.name)}</h3><span>${majorRoles.length} roles</span></div>
                    <div class="path-levels">
                        ${levels.map((levelName, index) => {
                            const items = majorRoles.filter((role) => role.level === levelName);
                            return `<div class="path-level-column"><div class="path-level-heading"><span>${escapeHtml(levelName)}</span><small>${index === 0 ? 'Start here' : index === 1 ? 'Build expertise' : 'Lead and design'}</small></div><div class="path-role-list">${items.length ? items.map(pathRoleChip).join('') : '<span class="text-body-secondary small">No roles mapped</span>'}</div></div>`;
                        }).join('')}
                    </div>
                </section>`;
        }).join('');
    }

    function renderRoleCards(filteredRoles) {
        if (!filteredRoles.length) {
            roleGrid.innerHTML = '<div class="col-12"><div class="empty-state"><i class="bi bi-search"></i><h3>No job roles match</h3><p>Change one or more filters to see more roles.</p></div></div>';
            return;
        }
        roleGrid.innerHTML = filteredRoles.map(roleCard).join('');
    }

    function currentFilters() {
        return {
            q: search.value.trim().toLowerCase(),
            major: major.value,
            level: level.value,
            industry: industry.value,
        };
    }

    function filteredRoles() {
        const filters = currentFilters();
        return roles.filter((role) => {
            const text = [role.title, role.description, role.summary, role.opportunities, ...(role.skills || []), ...(role.responsibilities || [])].join(' ').toLowerCase();
            return (!filters.q || text.includes(filters.q))
                && (!filters.major || role.major?.slug === filters.major)
                && (!filters.level || role.level === filters.level)
                && (!filters.industry || (role.industries || []).includes(filters.industry));
        });
    }

    function renderComparison() {
        const chosen = roles.filter((role) => selected.has(role.slug));
        if (!chosen.length) {
            comparePanel.classList.add('d-none');
            return;
        }
        comparePanel.classList.remove('d-none');
        compareTable.innerHTML = `<table class="table table-bordered align-middle compare-table"><thead><tr><th>Compare by</th>${chosen.map((role) => `<th>${escapeHtml(role.title)}<small class="d-block fw-normal text-body-secondary">${escapeHtml(role.major?.name || '')} · ${escapeHtml(role.level)}</small></th>`).join('')}</tr></thead><tbody>
            <tr><th>Responsibilities</th>${chosen.map((role) => `<td><ul>${(role.responsibilities || []).slice(0, 4).map((item) => `<li>${escapeHtml(item)}</li>`).join('')}</ul></td>`).join('')}</tr>
            <tr><th>Skills</th>${chosen.map((role) => `<td>${(role.skills || []).map((item) => `<span class="compare-tag">${escapeHtml(item)}</span>`).join(' ')}</td>`).join('')}</tr>
            <tr><th>Industries</th>${chosen.map((role) => `<td>${(role.industries || []).map((item) => `<span class="compare-tag">${escapeHtml(item)}</span>`).join(' ')}</td>`).join('')}</tr>
            <tr><th>Progression</th>${chosen.map((role) => `<td>${escapeHtml(role.previous_roles?.length ? 'Builds on: ' + role.previous_roles.join(', ') : 'Entry role')}<br>${escapeHtml(role.next_roles?.length ? 'Next: ' + role.next_roles.join(', ') : 'Advanced / leadership')}</td>`).join('')}</tr>
            </tbody></table>`;
    }

    function render() {
        const visible = filteredRoles();
        count.textContent = `Showing ${visible.length} of ${roles.length} career roles`;
        renderPathBoard();
        renderRoleCards(visible);
        renderComparison();
        syncVideo();
    }

    function syncVideo() {
        const item = config.majors.find((entry) => entry.slug === major.value) || config.majors[0];
        if (item?.video_url && video.src !== item.video_url) video.src = item.video_url;
    }

    function tracePath(slug) {
        const start = roles.find((role) => role.slug === slug);
        if (!start) return;
        const visited = new Set([slug]);
        const queue = [slug];
        while (queue.length) {
            const currentSlug = queue.shift();
            const current = roles.find((role) => role.slug === currentSlug);
            if (!current) continue;
            const links = [...(current.previous_roles || []), ...(current.next_roles || []), ...(current.related_roles || [])];
            links.forEach((linkedSlug) => {
                const linkedRole = roles.find((role) => role.slug === linkedSlug);
                if (linkedRole && linkedRole.major?.slug === start.major?.slug && !visited.has(linkedSlug)) {
                    visited.add(linkedSlug);
                    queue.push(linkedSlug);
                }
            });
        }
        focusedPath = visited;
        major.value = start.major?.slug || '';
        search.value = '';
        level.value = '';
        industry.value = '';
        render();
        document.getElementById('career-path-board').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    async function loadRoles() {
        const params = new URLSearchParams({ per_page: '100' });
        try {
            const response = await fetch(`${config.api}?${params}`, { headers: { 'Accept': 'application/json' } });
            if (!response.ok) throw new Error('Unable to retrieve career data.');
            const payload = await response.json();
            roles = payload.data || [];
            render();
        } catch (error) {
            count.textContent = 'Could not load career roles';
            pathBoard.innerHTML = `<div class="alert alert-warning">${escapeHtml(error.message)} Check that the API route is available.</div>`;
            roleGrid.innerHTML = '';
        }
    }

    [search, major, level, industry].forEach((control) => {
        control.addEventListener(control === search ? 'input' : 'change', () => {
            focusedPath = new Set();
            window.clearTimeout(debounceTimer);
            debounceTimer = window.setTimeout(render, control === search ? 180 : 0);
        });
    });

    reset.addEventListener('click', () => {
        search.value = '';
        major.value = '';
        level.value = '';
        industry.value = '';
        focusedPath = new Set();
        render();
    });

    roleGrid.addEventListener('click', (event) => {
        const button = event.target.closest('.focus-role');
        if (button) tracePath(button.dataset.slug);
    });
    pathBoard.addEventListener('click', (event) => {
        const button = event.target.closest('[data-focus-slug]');
        if (button) tracePath(button.dataset.focusSlug);
    });
    roleGrid.addEventListener('change', (event) => {
        const checkbox = event.target.closest('[data-compare]');
        if (!checkbox) return;
        const slug = checkbox.dataset.compare;
        if (checkbox.checked) {
            if (selected.size >= 3) {
                checkbox.checked = false;
                window.alert('You can compare a maximum of three job roles at a time.');
                return;
            }
            selected.add(slug);
        } else selected.delete(slug);
        renderComparison();
    });
    document.getElementById('clear-comparison').addEventListener('click', () => {
        selected.clear();
        render();
    });

    loadRoles();
})();
