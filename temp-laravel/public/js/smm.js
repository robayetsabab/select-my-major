(function () {
  'use strict';
  const $ = (selector, root = document) => root.querySelector(selector);
  const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
  const escapeHTML = value => String(value ?? '').replace(/[&<>"']/g, char => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[char]));

  // Theme preference
  const themeButton = $('#theme-toggle');
  if (themeButton) {
    const setThemeLabel = () => {
      const dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
      themeButton.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
      themeButton.setAttribute('aria-pressed', String(dark));
      themeButton.title = dark ? 'Switch to light mode' : 'Switch to dark mode';
      const icon = $('.theme-icon', themeButton);
      if (icon) icon.textContent = dark ? '☀' : '☾';
    };
    themeButton.addEventListener('click', () => {
      const next = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-bs-theme', next);
      try { localStorage.setItem('smm-theme', next); } catch (_) {}
      setThemeLabel();
    });
    setThemeLabel();
  }

  // Keep the sticky navigation compact after the page begins to scroll.
  const mainNav = $('.smm-nav');
  const updateNavState = () => mainNav?.classList.toggle('is-scrolled', window.scrollY > 12);
  updateNavState();
  window.addEventListener('scroll', updateNavState, { passive: true });

  // Major explorer: live search + three independent filters
  const majorCards = $$('[data-major-card]');
  const majorSearch = $('#major-search');
  const majorFocus = $('#major-focus');
  const majorInterest = $('#major-interest');
  const majorStyle = $('#major-style');
  function filterMajors() {
    if (!majorCards.length) return;
    const term = (majorSearch?.value || '').trim().toLowerCase();
    const focus = majorFocus?.value || 'all';
    const interest = majorInterest?.value || 'all';
    const style = majorStyle?.value || 'all';
    let visible = 0;
    majorCards.forEach(card => {
      const textMatch = !term || (card.dataset.search || '').includes(term);
      const show = textMatch && (focus === 'all' || card.dataset.focus === focus)
        && (interest === 'all' || card.dataset.interest === interest)
        && (style === 'all' || card.dataset.style === style);
      card.classList.toggle('d-none', !show);
      if (show) visible++;
    });
    const count = $('#major-result-count');
    if (count) count.textContent = `${visible} ${visible === 1 ? 'major' : 'majors'}`;
    $('#major-empty')?.classList.toggle('d-none', visible !== 0);
  }
  [majorSearch, majorFocus, majorInterest, majorStyle].forEach(element => {
    element?.addEventListener(element === majorSearch ? 'input' : 'change', filterMajors);
  });
  const resetMajorFilters = () => {
    if (majorSearch) majorSearch.value = '';
    [majorFocus, majorInterest, majorStyle].forEach(element => { if (element) element.value = 'all'; });
    filterMajors();
  };
  $('#clear-major-filters')?.addEventListener('click', resetMajorFilters);
  $('#empty-reset')?.addEventListener('click', resetMajorFilters);
  // Apply a homepage search term when the visitor arrives through the hero search.
  filterMajors();
  document.addEventListener('keydown', event => {
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k' && majorSearch) {
      event.preventDefault(); majorSearch.focus();
    }
  });

  // Interest prompt: maps stated interest to a major already present in the catalog.
  const interestChoice = $('#interest-choice');
  interestChoice?.addEventListener('change', () => {
    const slugByInterest = { protect: 'cyber-security', build: 'robotics', quality: 'software-testing', analyze: 'data-science' };
    const chosen = slugByInterest[interestChoice.value];
    const card = chosen ? majorCards.find(item => (item.dataset.search || '').includes(chosen.replaceAll('-', ' ')) || item.querySelector('.tile-link')?.href.includes(chosen)) : null;
    const result = $('#interest-result');
    if (!result) return;
    if (!chosen) { result.textContent = 'Your suggested area will appear here.'; return; }
    const names = { 'cyber-security': 'Cyber Security', robotics: 'Robotics', 'software-testing': 'Software Testing', 'data-science': 'Data Science' };
    const href = card?.querySelector('.tile-link')?.href || `/majors/${chosen}`;
    result.innerHTML = `<strong>Explore ${escapeHTML(names[chosen])}</strong><a href="${escapeHTML(href)}">View major overview ↗</a><span>This is a starting suggestion based on the interest you selected.</span>`;
    majorInterest && (majorInterest.value = interestChoice.value);
    filterMajors();
  });

  // Major comparison: overview, fit and reasons, not careers or subfields.
  const majorCompareChecks = $$('[data-compare-major]');
  const compareOutput = $('#compare-output');
  const majorData = majorCards.map(card => ({
    id: card.querySelector('[data-compare-major]')?.value,
    name: card.querySelector('h2')?.textContent.trim() || card.querySelector('h3')?.textContent.trim(),
    tagline: card.querySelector('p')?.textContent.trim(),
    overview: card.dataset.overview || '',
    reasons: card.dataset.reasons || '',
    bestFor: card.dataset.bestFor || '',
    href: card.querySelector('.tile-link')?.href
  }));
  function renderMajorCompare() {
    if (!compareOutput) return;
    const selected = majorCompareChecks.filter(check => check.checked).map(check => majorData.find(item => item.id === check.value)).filter(Boolean);
    if (selected.length < 2) {
      compareOutput.className = 'compare-placeholder';
      compareOutput.innerHTML = '<span class="compare-plus">＋</span><span>Select at least two majors to compare.</span>';
      return;
    }
    const row = (label, field) => `<tr><th>${escapeHTML(label)}</th>${selected.map(item => `<td>${escapeHTML(item[field])}</td>`).join('')}</tr>`;
    compareOutput.className = 'table-wrap compare-table-wrap';
    compareOutput.innerHTML = `<table class="compare-table"><thead><tr><th>Compare</th>${selected.map(item => `<th>${escapeHTML(item.name)}</th>`).join('')}</tr></thead><tbody>${row('Main focus', 'tagline')}${row('Overview', 'overview')}${row('Why choose it', 'reasons')}${row('May suit', 'bestFor')}<tr><th>Explore</th>${selected.map(item => `<td><a href="${escapeHTML(item.href)}">View full overview ↗</a></td>`).join('')}</tr></tbody></table>`;
  }
  majorCompareChecks.forEach(check => check.addEventListener('change', () => {
    if (majorCompareChecks.filter(item => item.checked).length > 4) { check.checked = false; window.alert('You can compare up to four majors at a time.'); }
    renderMajorCompare();
  }));
  $('#clear-compare')?.addEventListener('click', () => { majorCompareChecks.forEach(item => { item.checked = false; }); renderMajorCompare(); });
  renderMajorCompare();

  // Major details: accessible tab-like panels
  const detailTabs = $$('[data-detail-tab]');
  const detailPanels = $$('[data-detail-panel]');
  detailTabs.forEach((tab, index) => {
    tab.addEventListener('click', () => {
      const target = tab.dataset.detailTab;
      detailTabs.forEach(item => {
        const active = item === tab;
        item.classList.toggle('active', active);
        item.setAttribute('aria-selected', String(active));
        item.tabIndex = active ? 0 : -1;
      });
      detailPanels.forEach(panel => panel.classList.toggle('d-none', panel.dataset.detailPanel !== target));
    });
    tab.addEventListener('keydown', event => {
      if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) return;
      event.preventDefault();
      let nextIndex = index;
      if (event.key === 'ArrowRight') nextIndex = (index + 1) % detailTabs.length;
      if (event.key === 'ArrowLeft') nextIndex = (index - 1 + detailTabs.length) % detailTabs.length;
      if (event.key === 'Home') nextIndex = 0;
      if (event.key === 'End') nextIndex = detailTabs.length - 1;
      detailTabs[nextIndex]?.click();
      detailTabs[nextIndex]?.focus();
    });
  });
  detailTabs.forEach((tab, index) => { tab.tabIndex = index === 0 ? 0 : -1; });

  // Certification catalog: search, major, cost, level, provider and sorting.
  const certGrid = $('#cert-grid');
  const certCards = $$('[data-cert-card]');
  const certSearch = $('#cert-search');
  const certMajor = $('#cert-major');
  const certCost = $('#cert-cost');
  const certLevel = $('#cert-level');
  const certProvider = $('#cert-provider-filter');
  const certSort = $('#cert-sort');
  function filterCertifications() {
    if (!certCards.length) return;
    const term = (certSearch?.value || '').trim().toLowerCase();
    const major = certMajor?.value || 'all';
    const cost = certCost?.value || 'all';
    const level = certLevel?.value || 'all';
    const provider = certProvider?.value || 'all';
    let visible = 0;
    certCards.forEach(card => {
      const textMatch = !term || (card.dataset.search || '').includes(term);
      const show = textMatch && (major === 'all' || card.dataset.major === major)
        && (cost === 'all' || card.dataset.cost === cost)
        && (level === 'all' || (card.dataset.level || '').includes(level))
        && (provider === 'all' || card.dataset.provider === provider);
      card.classList.toggle('d-none', !show);
      if (show) visible++;
    });
    const count = $('#cert-result-count');
    if (count) count.textContent = `${visible} ${visible === 1 ? 'resource' : 'resources'}`;
    $('#cert-empty')?.classList.toggle('d-none', visible !== 0);
  }
  [certSearch, certMajor, certCost, certLevel, certProvider].forEach(element => {
    element?.addEventListener(element === certSearch ? 'input' : 'change', filterCertifications);
  });
  certSort?.addEventListener('change', () => {
    if (!certGrid) return;
    const cards = [...certCards];
    const mode = certSort.value;
    cards.sort((a, b) => {
      if (mode === 'name') return a.querySelector('h2').textContent.localeCompare(b.querySelector('h2').textContent);
      if (mode === 'provider') return a.dataset.provider.localeCompare(b.dataset.provider);
      if (mode === 'free-first') return (a.dataset.cost === 'free' ? 0 : 1) - (b.dataset.cost === 'free' ? 0 : 1);
      return Number(a.dataset.id) - Number(b.dataset.id);
    });
    cards.forEach(card => certGrid.appendChild(card));
  });
  const resetCertFilters = () => {
    if (certSearch) certSearch.value = '';
    [certMajor, certCost, certLevel, certProvider].forEach(element => { if (element) element.value = 'all'; });
    if (certSort) certSort.value = 'recommended';
    certSort?.dispatchEvent(new Event('change'));
    filterCertifications();
  };
  $('#cert-reset')?.addEventListener('click', resetCertFilters);
  $('#cert-empty-reset')?.addEventListener('click', resetCertFilters);
  filterCertifications();

  // Saved resources stay in this browser only.
  const readBookmarks = () => { try { return JSON.parse(localStorage.getItem('smm-bookmarks') || '[]'); } catch (_) { return []; } };
  function paintBookmarks() {
    const saved = readBookmarks();
    $$('[data-bookmark]').forEach(button => {
      const isSaved = saved.includes(String(button.dataset.bookmark));
      button.classList.toggle('saved', isSaved);
      button.textContent = isSaved ? '♥' : '♡';
      button.setAttribute('aria-pressed', String(isSaved));
    });
  }
  $$('[data-bookmark]').forEach(button => button.addEventListener('click', () => {
    const id = String(button.dataset.bookmark);
    const saved = readBookmarks();
    const next = saved.includes(id) ? saved.filter(item => item !== id) : saved.concat(id);
    try { localStorage.setItem('smm-bookmarks', JSON.stringify(next)); } catch (_) {}
    paintBookmarks();
  }));
  paintBookmarks();

  // Resource comparison
  const certChecks = $$('[data-compare-cert]');
  const certOutput = $('#cert-compare-output');
  function renderCertCompare() {
    if (!certOutput) return;
    const selected = certChecks.filter(check => check.checked).map(check => check.closest('[data-cert-card]')).filter(Boolean);
    if (selected.length < 2) {
      certOutput.className = 'compare-placeholder';
      certOutput.innerHTML = '<span class="compare-plus">＋</span><span>Select at least two resources to compare.</span>';
      return;
    }
    const row = (label, selector) => `<tr><th>${escapeHTML(label)}</th>${selected.map(card => `<td>${escapeHTML($(selector, card)?.textContent.trim() || '—')}</td>`).join('')}</tr>`;
    certOutput.className = 'table-wrap compare-table-wrap';
    certOutput.innerHTML = `<table class="compare-table"><thead><tr><th>Compare</th>${selected.map(card => `<th>${escapeHTML($('h2', card)?.textContent.trim())}</th>`).join('')}</tr></thead><tbody>${row('Provider', '.cert-provider strong')}${row('Major', '.cert-provider span')}${row('Level', '.level-badge')}${row('Price / cost', '.cert-price-label')}${row('Free study option', '.free-option p')}</tbody></table>`;
  }
  certChecks.forEach(check => check.addEventListener('change', () => {
    if (certChecks.filter(item => item.checked).length > 4) { check.checked = false; window.alert('You can compare up to four resources at a time.'); }
    renderCertCompare();
  }));
  $('#clear-cert-compare')?.addEventListener('click', () => { certChecks.forEach(item => { item.checked = false; }); renderCertCompare(); });
  renderCertCompare();
})();
