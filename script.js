// Advanced Dork Generator - Production Build
'use strict';

document.addEventListener('DOMContentLoaded', initializeApp);

function initializeApp() {
    initializeFormEnhancements();
    initializeKeyboardShortcuts();
    checkScrollToResults();
    analyzeDork();
    initializeModeToggle();
}

// ============ CLIPBOARD FUNCTIONS ============
function copyToClipboard() {
    const el = document.getElementById('generated-dork');
    if (!el) return;
    copyText(el.textContent);
}

function copyPreviewDork() {
    const el = document.getElementById('live-preview-dork');
    if (!el || el.classList.contains('empty')) {
        showNotification('Nothing to copy yet!', 'warning');
        return;
    }
    copyText(el.textContent);
}

function copyText(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Copied to clipboard!', 'success');
        }).catch(() => fallbackCopy(text));
    } else {
        fallbackCopy(text);
    }
}

function fallbackCopy(text) {
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;left:-9999px';
    document.body.appendChild(ta);
    ta.select();
    try {
        document.execCommand('copy');
        showNotification('Copied to clipboard!', 'success');
    } catch(e) {
        showNotification('Failed to copy', 'error');
    }
    document.body.removeChild(ta);
}

// ============ LIVE PREVIEW ============
function updateLivePreview() {
    const preview = document.getElementById('live-preview-dork');
    if (!preview) return;
    
    let parts = [];
    const term = document.getElementById('custom_term')?.value?.trim() || '';
    const exact = document.querySelector('input[name="exact_phrase"]')?.checked;
    let finalTerm = term && exact ? `"${term}"` : term;
    
    const ops = document.querySelectorAll('input[name="search_in[]"]:checked');
    if (ops.length > 0 && finalTerm) {
        ops.forEach(op => {
            parts.push(op.value === 'allintext' ? finalTerm : `${op.value}:${finalTerm}`);
        });
    } else if (finalTerm) {
        parts.push(finalTerm);
    }
    
    const site = document.getElementById('target_site')?.value?.trim();
    if (site) parts.push(`site:${site}`);
    
    const exclude = document.getElementById('exclude_site')?.value?.trim();
    if (exclude) parts.push(`-site:${exclude}`);
    
    document.querySelectorAll('input[name="filetypes[]"]:checked').forEach(ft => {
        parts.push(`filetype:${ft.value}`);
    });
    
    const customFt = document.getElementById('custom_filetype')?.value?.trim();
    if (customFt) parts.push(`filetype:${customFt}`);
    
    if (parts.length > 0) {
        preview.textContent = parts.join(' ');
        preview.classList.remove('empty');
    } else {
        preview.textContent = 'Start building your dork above...';
        preview.classList.add('empty');
    }
}

function testPreviewDork() {
    const preview = document.getElementById('live-preview-dork');
    if (!preview || preview.classList.contains('empty')) {
        showNotification('Build a dork first!', 'warning');
        return;
    }
    window.open(`https://www.google.com/search?q=${encodeURIComponent(preview.textContent)}`, '_blank');
}

// ============ FORM MANAGEMENT ============
function clearAllFields() {
    const form = document.getElementById('dork-builder-form');
    if (form) form.reset();
    document.querySelectorAll('.operator-card input, .filetype-chip input, .modifier-chip input').forEach(i => i.checked = false);
    updateLivePreview();
    showNotification('All fields cleared', 'info');
}

function applyTemplate(type) {
    clearAllFields();
    const templates = {
        admin: { term: 'admin OR administrator OR login', ops: ['inurl'], ft: [] },
        login: { term: 'login OR signin OR "sign in"', ops: ['intitle'], ft: [] },
        sensitive: { term: 'password OR secret OR credentials', ops: ['intext'], ft: ['txt', 'log'] },
        database: { term: 'database OR dump OR backup', ops: [], ft: ['sql'] },
        config: { term: 'config OR configuration OR settings', ops: ['inurl'], ft: ['conf', 'env'] },
        backup: { term: 'backup OR bak OR old', ops: [], ft: ['bak', 'sql'] },
        exposed: { term: '"index of" OR "directory listing"', ops: ['intitle'], ft: [] },
        cameras: { term: '"camera" OR "webcam" OR "live view"', ops: ['intitle', 'inurl'], ft: [] }
    };
    
    const t = templates[type];
    if (!t) return;
    
    const termEl = document.getElementById('custom_term');
    if (termEl) termEl.value = t.term;
    
    t.ops.forEach(op => {
        const cb = document.querySelector(`input[name="search_in[]"][value="${op}"]`);
        if (cb) cb.checked = true;
    });
    
    t.ft.forEach(ft => {
        const cb = document.querySelector(`input[name="filetypes[]"][value="${ft}"]`);
        if (cb) cb.checked = true;
    });
    
    updateLivePreview();
    showNotification(`Applied "${type}" template`, 'success');
}

function generateRandomDork() {
    clearAllFields();
    const ops = ['intitle', 'inurl', 'intext', 'filetype', 'site'];
    const terms = ['admin', 'login', 'password', 'config', 'backup', 'database', 'index of', 'secret', 'credentials'];
    const fts = ['pdf', 'doc', 'xls', 'sql', 'txt', 'log', 'conf', 'env', 'bak'];
    
    const pick = arr => arr[Math.floor(Math.random() * arr.length)];
    const term = pick(terms);
    const op = pick(ops.slice(0, 3));
    
    const termEl = document.getElementById('custom_term');
    if (termEl) termEl.value = term;
    
    const opCb = document.querySelector(`input[name="search_in[]"][value="${op}"]`);
    if (opCb) opCb.checked = true;
    
    if (Math.random() > 0.5) {
        const ftCb = document.querySelector(`input[name="filetypes[]"][value="${pick(fts)}"]`);
        if (ftCb) ftCb.checked = true;
    }
    
    updateLivePreview();
    showNotification('Generated random dork!', 'success');
}

// ============ NOTIFICATIONS ============
function showNotification(message, type = 'info') {
    document.querySelectorAll('.notification').forEach(n => n.remove());
    
    const n = document.createElement('div');
    n.className = `notification notification-${type}`;
    n.textContent = message;
    
    const colors = {
        success: 'linear-gradient(45deg, #27ae60, #2ecc71)',
        error: 'linear-gradient(45deg, #e74c3c, #c0392b)',
        warning: 'linear-gradient(45deg, #f39c12, #e67e22)',
        info: 'linear-gradient(45deg, #3498db, #2980b9)'
    };
    
    n.style.cssText = `position:fixed;top:20px;right:20px;padding:15px 25px;border-radius:8px;color:white;font-weight:600;z-index:10000;background:${colors[type] || colors.info};animation:slideIn 0.3s ease-out`;
    
    document.body.appendChild(n);
    setTimeout(() => {
        if (n.parentNode) {
            n.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => n.remove(), 300);
        }
    }, 3000);
}

// ============ FORM ENHANCEMENTS ============
function initializeFormEnhancements() {
    const form = document.querySelector('.dork-form');
    if (!form) return;
    
    form.addEventListener('submit', handleFormSubmit);
    form.querySelectorAll('select, input').forEach(input => {
        input.addEventListener('change', updateLivePreview);
        input.addEventListener('input', updateLivePreview);
    });
}

function handleFormSubmit(e) {
    const form = e.target;
    const cat = form.querySelector('#category')?.value;
    const term = form.querySelector('#custom_term')?.value?.trim();
    const site = form.querySelector('#target_site')?.value?.trim();
    
    if (!cat && !term && !site) {
        e.preventDefault();
        showNotification('Please enter a search term, select a category, or specify a target site', 'warning');
        return false;
    }
    
    const btn = form.querySelector('.generate-btn');
    if (btn) {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
        btn.disabled = true;
        sessionStorage.setItem('scrollToResults', 'true');
        setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; }, 1000);
    }
}

// ============ KEYBOARD SHORTCUTS ============
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            document.querySelector('.generate-btn')?.click();
        }
        if ((e.ctrlKey || e.metaKey) && e.key === 'c' && !window.getSelection().toString()) {
            const dork = document.getElementById('generated-dork');
            if (dork) {
                e.preventDefault();
                copyToClipboard();
            }
        }
        if (e.key === 'Escape') {
            clearAllFields();
        }
    });
}

// ============ SCROLL TO RESULTS ============
function checkScrollToResults() {
    if (sessionStorage.getItem('scrollToResults') === 'true') {
        sessionStorage.removeItem('scrollToResults');
        const results = document.getElementById('results-section');
        if (results) {
            setTimeout(() => results.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
        }
    }
}

// ============ DORK ANALYSIS ============
function analyzeDork() {
    const dorkEl = document.getElementById('generated-dork');
    if (!dorkEl) return;
    
    const dork = dorkEl.textContent;
    const operators = ['intitle:', 'inurl:', 'intext:', 'site:', 'filetype:', 'ext:', 'cache:', 'link:', 'related:', 'info:', 'define:', 'allinurl:', 'allintitle:', 'allintext:'];
    
    let count = 0, complexity = 'Low', risk = 'Low', riskClass = 'risk-low';
    
    operators.forEach(op => { if (dork.toLowerCase().includes(op)) count++; });
    
    if (count >= 4 || dork.length > 150) {
        complexity = 'High'; risk = 'High'; riskClass = 'risk-high';
    } else if (count >= 2 || dork.length > 75) {
        complexity = 'Medium'; risk = 'Medium'; riskClass = 'risk-medium';
    }
    
    const sensitiveTerms = ['password', 'admin', 'login', 'config', 'database', 'backup', 'secret', 'credential', 'private', 'confidential'];
    if (sensitiveTerms.some(t => dork.toLowerCase().includes(t))) {
        risk = 'High'; riskClass = 'risk-high';
    }
    
    const complexityEl = document.getElementById('complexity-score');
    const countEl = document.getElementById('operator-count');
    const riskEl = document.getElementById('risk-level');
    
    if (complexityEl) complexityEl.textContent = complexity;
    if (countEl) countEl.textContent = count;
    if (riskEl) { riskEl.textContent = risk; riskEl.className = 'value ' + riskClass; }
}

// ============ MODE TOGGLE ============
function initializeModeToggle() {
    const toggle = document.getElementById('adult-mode-toggle');
    if (!toggle) return;
    
    const normalLabel = document.getElementById('mode-label-normal');
    const adultLabel = document.getElementById('mode-label-adult');
    const desc = document.getElementById('mode-description');
    
    if (localStorage.getItem('searchMode') === 'adult') {
        toggle.checked = true;
        updateMode(true);
    }
    
    toggle.addEventListener('change', function() {
        const isAdult = this.checked;
        updateMode(isAdult);
        localStorage.setItem('searchMode', isAdult ? 'adult' : 'normal');
        showNotification(isAdult ? 'Switched to 18+ Adult Mode' : 'Switched to Normal Mode', isAdult ? 'warning' : 'info');
    });
    
    function updateMode(isAdult) {
        if (normalLabel && adultLabel) {
            normalLabel.classList.toggle('active', !isAdult);
            adultLabel.classList.toggle('active', isAdult);
        }
        if (desc) {
            desc.innerHTML = isAdult 
                ? '<strong>⚠️ 18+ Adult Mode Active</strong> - Showing adult content search engines only'
                : 'Currently in <strong>Normal Mode</strong> - Standard search engines and security research tools';
        }
        document.querySelectorAll('.normal-mode-content').forEach(el => el.style.display = isAdult ? 'none' : 'block');
        document.querySelectorAll('.adult-mode-content').forEach(el => el.style.display = isAdult ? 'block' : 'none');
    }
}

// ============ UTILITY FUNCTIONS ============
function saveDork() {
    const dork = document.getElementById('generated-dork')?.textContent;
    if (!dork) return;
    
    const history = JSON.parse(localStorage.getItem('dorkHistory') || '[]');
    history.unshift({ dork, timestamp: new Date().toISOString() });
    localStorage.setItem('dorkHistory', JSON.stringify(history.slice(0, 50)));
    showNotification('Dork saved to history!', 'success');
}

function shareDork() {
    const dork = document.getElementById('generated-dork')?.textContent;
    if (!dork) return;
    
    if (navigator.share) {
        navigator.share({ title: 'Google Dork', text: dork, url: window.location.href });
    } else {
        copyToClipboard();
        showNotification('Dork copied - paste to share!', 'info');
    }
}

function exportDorks(format = 'txt') {
    const history = JSON.parse(localStorage.getItem('dorkHistory') || '[]');
    if (!history.length) {
        showNotification('No dorks to export', 'warning');
        return;
    }
    
    let content = format === 'json' 
        ? JSON.stringify(history, null, 2) 
        : history.map(h => h.dork).join('\n');
    
    const blob = new Blob([content], { type: format === 'json' ? 'application/json' : 'text/plain' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `dorks.${format}`;
    a.click();
    URL.revokeObjectURL(a.href);
    showNotification(`Exported ${history.length} dorks!`, 'success');
}

// CSS Animation keyframes
const style = document.createElement('style');
style.textContent = `
@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
@keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }
`;
document.head.appendChild(style);
