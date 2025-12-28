// Advanced Dork Generator JavaScript

document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Initialize tooltips
    initializeTooltips();
    
    // Initialize form enhancements
    initializeFormEnhancements();
    
    // Initialize keyboard shortcuts
    initializeKeyboardShortcuts();
    
    // Initialize advanced features
    initializeAdvancedFeatures();
    
    // Add loading states
    initializeLoadingStates();
    
    // Check if we should scroll to results
    checkScrollToResults();
    
    // Analyze dork if present
    analyzeDork();
    
    // Initialize mode toggle
    initializeModeToggle();
}

// Copy to clipboard functionality
function copyToClipboard() {
    const dorkElement = document.getElementById('generated-dork');
    if (!dorkElement) return;
    
    const text = dorkElement.textContent;
    
    // Modern clipboard API
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification('Dork copied to clipboard!', 'success');
        }).catch(() => {
            fallbackCopyTextToClipboard(text);
        });
    } else {
        fallbackCopyTextToClipboard(text);
    }
}

// Fallback for older browsers
function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showNotification('Dork copied to clipboard!', 'success');
    } catch (err) {
        showNotification('Failed to copy dork', 'error');
    }
    
    document.body.removeChild(textArea);
}

// Generate random dork
function generateRandomDork() {
    const form = document.querySelector('.dork-form');
    if (!form) return;
    
    // Get all categories
    const categorySelect = document.getElementById('category');
    if (!categorySelect) return;
    
    // Select random category
    const options = Array.from(categorySelect.options).filter(opt => opt.value !== '');
    if (options.length === 0) return;
    
    const randomCategory = options[Math.floor(Math.random() * options.length)];
    categorySelect.value = randomCategory.value;
    
    // Randomly populate some fields
    const operators = ['inurl', 'intitle', 'filetype', 'intext', 'site'];
    const fileTypes = ['pdf', 'doc', 'xls', 'sql', 'txt', 'xml', 'log', 'conf', 'bak'];
    const advancedOptions = document.querySelectorAll('.advanced-options input[type="checkbox"]');
    
    // Random operator
    const operatorSelect = document.getElementById('operator');
    if (operatorSelect && Math.random() > 0.3) {
        const operatorOptions = Array.from(operatorSelect.options).filter(opt => opt.value !== '');
        if (operatorOptions.length > 0) {
            operatorSelect.value = operatorOptions[Math.floor(Math.random() * operatorOptions.length)].value;
        }
    }
    
    // Random file type
    const fileTypeInput = document.getElementById('file_type');
    if (fileTypeInput && Math.random() > 0.5) {
        fileTypeInput.value = fileTypes[Math.floor(Math.random() * fileTypes.length)];
    }
    
    // Randomly enable/disable advanced options
    advancedOptions.forEach(checkbox => {
        checkbox.checked = Math.random() > 0.7;
    });
    
    showNotification('Random dork configuration generated!', 'success');
    
    // Submit the form
    form.submit();
}

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Style the notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        animation: slideIn 0.3s ease-out;
        max-width: 300px;
        word-wrap: break-word;
    `;
    
    // Set background color based on type
    switch(type) {
        case 'success':
            notification.style.background = 'linear-gradient(45deg, #27ae60, #2ecc71)';
            break;
        case 'error':
            notification.style.background = 'linear-gradient(45deg, #e74c3c, #c0392b)';
            break;
        case 'warning':
            notification.style.background = 'linear-gradient(45deg, #f39c12, #e67e22)';
            break;
        default:
            notification.style.background = 'linear-gradient(45deg, #3498db, #2980b9)';
    }
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOut 0.3s ease-in';
            setTimeout(() => notification.remove(), 300);
        }
    }, 3000);
}

// Initialize tooltips
function initializeTooltips() {
    const elementsWithTooltips = document.querySelectorAll('[title]');
    
    elementsWithTooltips.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(event) {
    const element = event.target;
    const tooltipText = element.getAttribute('title');
    
    if (!tooltipText) return;
    
    // Remove title to prevent default tooltip
    element.removeAttribute('title');
    element.setAttribute('data-original-title', tooltipText);
    
    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip';
    tooltip.textContent = tooltipText;
    tooltip.style.cssText = `
        position: absolute;
        background: rgba(0, 0, 0, 0.9);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 14px;
        white-space: nowrap;
        z-index: 10000;
        pointer-events: none;
        animation: fadeIn 0.2s ease-out;
    `;
    
    document.body.appendChild(tooltip);
    
    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
    
    element.tooltipElement = tooltip;
}

function hideTooltip(event) {
    const element = event.target;
    
    if (element.tooltipElement) {
        element.tooltipElement.remove();
        element.tooltipElement = null;
    }
    
    const originalTitle = element.getAttribute('data-original-title');
    if (originalTitle) {
        element.setAttribute('title', originalTitle);
        element.removeAttribute('data-original-title');
    }
}

// Form enhancements
function initializeFormEnhancements() {
    const form = document.querySelector('.dork-form');
    if (!form) return;
    
    // Add form validation
    form.addEventListener('submit', handleFormSubmit);
    
    // Add real-time preview
    const inputs = form.querySelectorAll('select, input');
    inputs.forEach(input => {
        input.addEventListener('change', updatePreview);
        input.addEventListener('input', updatePreview);
    });
    
    // Add category info display
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        categorySelect.addEventListener('change', showCategoryInfo);
    }
}

function handleFormSubmit(event) {
    const form = event.target;
    const category = form.querySelector('#category').value;
    
    if (!category) {
        event.preventDefault();
        showNotification('Please select a category', 'warning');
        return false;
    }
    
    // Show loading state
    const submitButton = form.querySelector('.generate-btn');
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
    submitButton.disabled = true;
    
    // Store flag to scroll to results after page reload
    sessionStorage.setItem('scrollToResults', 'true');
    
    // Re-enable button after form submission
    setTimeout(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    }, 1000);
}

function updatePreview() {
    // This could show a real-time preview of the dork being built
    const category = document.getElementById('category').value;
    const customTerm = document.getElementById('custom_term').value;
    const targetSite = document.getElementById('target_site').value;
    const fileType = document.getElementById('file_type').value;
    const operator = document.getElementById('operator').value;
    
    if (!category) return;
    
    // Build preview (simplified)
    let preview = 'Preview: ';
    if (operator && operator !== 'none') {
        preview += operator + ':';
    }
    preview += '[category_dork]';
    
    if (customTerm) {
        preview += ' "' + customTerm + '"';
    }
    if (targetSite) {
        preview += ' site:' + targetSite;
    }
    if (fileType) {
        preview += ' filetype:' + fileType;
    }
    
    // Show preview (you could add a preview element to the HTML)
    console.log(preview);
}

function showCategoryInfo(event) {
    const category = event.target.value;
    const categories = {
        'admin_panels': 'Find administrator login pages and control panels',
        'databases': 'Locate database files and database management interfaces',
        'config_files': 'Search for configuration and settings files',
        'vulnerable_files': 'Find potentially vulnerable scripts and backdoors',
        'logs': 'Locate log files that might contain sensitive information',
        'documents': 'Search for sensitive documents and files',
        'cameras': 'Find unsecured IP cameras and surveillance systems',
        'login_pages': 'Locate various types of login and authentication pages',
        'ftp_servers': 'Find FTP servers and file repositories',
        'email_lists': 'Search for email lists and contact databases',
        'xxx_adult': 'Adult and XXX content (18+ only)',
        'social_media': 'Social media platforms and profiles'
    };
    
    if (categories[category]) {
        showNotification(categories[category], 'info');
    }
}

// Keyboard shortcuts
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', function(event) {
        // Ctrl/Cmd + Enter to submit form
        if ((event.ctrlKey || event.metaKey) && event.key === 'Enter') {
            const form = document.querySelector('.dork-form');
            if (form) {
                form.submit();
            }
        }
        
        // Ctrl/Cmd + C to copy generated dork (when focused on result)
        if ((event.ctrlKey || event.metaKey) && event.key === 'c') {
            const dorkResult = document.querySelector('.dork-result');
            if (dorkResult && document.activeElement === dorkResult) {
                event.preventDefault();
                copyToClipboard();
            }
        }
        
        // Escape to clear form
        if (event.key === 'Escape') {
            const form = document.querySelector('.dork-form');
            if (form) {
                form.reset();
                showNotification('Form cleared', 'info');
            }
        }
    });
}

// Advanced features
function initializeAdvancedFeatures() {
    // Add dork history
    initializeDorkHistory();
    
    // Add export functionality
    addExportFunctionality();
}

// ===== MASSIVE EXPANSION - NEW JAVASCRIPT FEATURES =====

// Enhanced Mode Selection
function initializeModeSelection() {
    const modeCards = document.querySelectorAll('.mode-card');
    const modeInput = document.getElementById('selected_mode');
    
    // Set initial active state
    modeCards.forEach(card => {
        const radio = card.querySelector('input[type="radio"]');
        if (radio && radio.checked) {
            card.classList.add('active');
        }
    });
    
    modeCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            modeCards.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked card
            this.classList.add('active');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
            
            // Update hidden input
            const mode = this.dataset.mode;
            if (modeInput) {
                modeInput.value = mode;
            }
            
            // Update form based on mode
            updateFormBasedOnMode(mode);
            
            // Show notification
            const modeName = this.querySelector('.mode-name');
            if (modeName) {
                showNotification(`Selected ${modeName.textContent} mode`, 'info');
            }
        });
    });
}

// Dynamic Form Updates Based on Mode
function updateFormBasedOnMode(mode) {
    const formSections = document.querySelectorAll('.form-section');
    const categorySelect = document.getElementById('category');
    const riskLevelSelect = document.getElementById('risk_level');
    
    // Reset all sections
    formSections.forEach(section => {
        section.style.display = 'block';
        section.classList.remove('highlight');
    });
    
    switch(mode) {
        case 'stealth':
            highlightSection('Security & Risk Options');
            setSelectValue('safe_search', 'strict');
            showModeSpecificTooltip('Stealth mode enables subtle searches with anti-detection measures');
            break;
            
        case 'aggressive':
            highlightSection('Advanced Query Building');
            document.getElementById('deep_search').checked = true;
            showModeSpecificTooltip('Aggressive mode performs intensive searches for maximum coverage');
            break;
            
        case 'vulnerability':
            highlightSection('Security & Risk Options');
            filterCategoriesByVulnerability();
            showModeSpecificTooltip('Vulnerability mode focuses on security weakness discovery');
            break;
            
        case 'osint':
            highlightSection('Date & Location Options');
            document.getElementById('social_media').checked = true;
            showModeSpecificTooltip('OSINT mode optimized for intelligence gathering');
            break;
            
        case 'forensics':
            setSelectValue('date_range', 'y');
            document.getElementById('cache_only').checked = true;
            showModeSpecificTooltip('Forensics mode searches historical and cached content');
            break;
            
        case 'darkweb':
            showWarningMessage('Dark web research mode activated. Use with extreme caution and legal compliance.');
            highlightSection('Security & Risk Options');
            break;
            
        default:
            showModeSpecificTooltip('Standard mode provides basic Google dorking functionality');
    }
}

// Check if we should scroll to results after form submission
function checkScrollToResults() {
    if (sessionStorage.getItem('scrollToResults') === 'true') {
        sessionStorage.removeItem('scrollToResults');
        
        setTimeout(() => {
            const resultsSection = document.getElementById('results-section');
            if (resultsSection) {
                resultsSection.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
                
                // Add a subtle highlight effect to draw attention
                resultsSection.style.animation = 'highlight 2s ease-out';
                setTimeout(() => {
                    resultsSection.style.animation = '';
                }, 2000);
            }
        }, 200); // Small delay to ensure page is fully rendered
    }
}

// Category-based threat level indicator
function updateThreatIndicator() {
    const categorySelect = document.getElementById('category');
    const threatIndicator = document.getElementById('threat-indicator');
    
    if (!categorySelect || !threatIndicator) return;
    
    const category = categorySelect.value;
    const threatLevels = {
        'admin_panels': 'high',
        'cloud_storage': 'critical',
        'api_endpoints': 'medium',
        'databases': 'critical',
        'configuration_files': 'high',
        'log_files': 'medium',
        'backup_files': 'high',
        'vulnerable_apps': 'critical',
        'web_shells': 'critical',
        'ssl_certificates': 'high',
        'email_lists': 'medium',
        'financial_data': 'illegal',
        'documents': 'medium',
        'adult_content': 'illegal',
        'network_devices': 'high',
        'git_repositories': 'high',
        'vpn_remote': 'medium',
        'iot_cameras': 'high',
        'social_media': 'low',
        'dns_records': 'low',
        'source_code': 'medium'
    };
    
    const level = threatLevels[category] || 'informational';
    threatIndicator.className = `threat-indicator ${level}`;
    threatIndicator.textContent = level.charAt(0).toUpperCase() + level.slice(1);
    
    // Add icon based on threat level
    const icons = {
        'informational': 'fas fa-info-circle',
        'low': 'fas fa-shield-alt',
        'medium': 'fas fa-exclamation-triangle',
        'high': 'fas fa-fire',
        'critical': 'fas fa-skull-crossbones',
        'illegal': 'fas fa-ban'
    };
    
    threatIndicator.innerHTML = `<i class="${icons[level]}"></i> ${level.charAt(0).toUpperCase() + level.slice(1)}`;
}

// Advanced Query Builder
function buildAdvancedQuery() {
    const exactPhrase = document.getElementById('exact_phrase_input')?.value;
    const anyWords = document.getElementById('any_words')?.value;
    const noneWords = document.getElementById('none_words')?.value;
    const numbersRange = document.getElementById('numbers_range')?.value;
    
    let query = '';
    
    if (exactPhrase) {
        query += `"${exactPhrase}" `;
    }
    
    if (anyWords) {
        const words = anyWords.split(' ').filter(w => w.trim());
        if (words.length > 1) {
            query += `(${words.join(' OR ')}) `;
        } else {
            query += `${words[0]} `;
        }
    }
    
    if (noneWords) {
        const words = noneWords.split(' ').filter(w => w.trim());
        words.forEach(word => {
            query += `-${word} `;
        });
    }
    
    if (numbersRange && numbersRange.includes('..')) {
        query += `${numbersRange} `;
    }
    
    return query.trim();
}

// Dynamic dork generation based on multiple factors
function generateContextualDork() {
    const category = document.getElementById('category')?.value;
    const mode = document.getElementById('selected_mode')?.value;
    const vulnType = document.getElementById('vulnerability_type')?.value;
    const language = document.getElementById('language')?.value;
    const country = document.getElementById('country')?.value;
    
    // This would integrate with the PHP backend to generate
    // more intelligent dorks based on the selected options
    
    // For now, just show a preview
    const preview = document.getElementById('dork-preview');
    if (preview) {
        let previewText = 'Preview: ';
        if (category) previewText += `[${category}] `;
        if (mode) previewText += `[${mode} mode] `;
        if (vulnType) previewText += `[${vulnType}] `;
        
        preview.textContent = previewText;
        preview.style.display = 'block';
    }
}

// Real-time dork validation
function validateDork(dork) {
    const warnings = [];
    const suggestions = [];
    
    // Check for potentially dangerous queries
    if (dork.includes('password') && dork.includes('filetype:')) {
        warnings.push('This query may expose sensitive password files');
    }
    
    if (dork.includes('site:') && dork.includes('inurl:admin')) {
        warnings.push('This targets administrative interfaces on specific sites');
    }
    
    // Check for query optimization
    if (dork.split(' ').length > 10) {
        suggestions.push('Consider simplifying the query for better results');
    }
    
    if (!dork.includes('site:') && !dork.includes('filetype:')) {
        suggestions.push('Add site: or filetype: operators for more targeted results');
    }
    
    return { warnings, suggestions };
}

// Enhanced export functionality
function exportDorks(format) {
    const dork = document.getElementById('generated-dork')?.textContent;
    const category = document.getElementById('category')?.value;
    const mode = document.getElementById('selected_mode')?.value;
    const timestamp = new Date().toISOString();
    
    if (!dork) {
        showNotification('No dork to export', 'error');
        return;
    }
    
    let content = '';
    let filename = '';
    let mimeType = '';
    
    switch(format) {
        case 'txt':
            content = `Generated Dork: ${dork}\nCategory: ${category}\nMode: ${mode}\nTimestamp: ${timestamp}`;
            filename = `dork_${Date.now()}.txt`;
            mimeType = 'text/plain';
            break;
            
        case 'json':
            const data = {
                dork,
                category,
                mode,
                timestamp,
                metadata: {
                    generator: 'Advanced Dork Generator',
                    version: '2.0'
                }
            };
            content = JSON.stringify(data, null, 2);
            filename = `dork_${Date.now()}.json`;
            mimeType = 'application/json';
            break;
            
        case 'csv':
            content = `Dork,Category,Mode,Timestamp\n"${dork}","${category}","${mode}","${timestamp}"`;
            filename = `dork_${Date.now()}.csv`;
            mimeType = 'text/csv';
            break;
            
        case 'xml':
            content = `<?xml version="1.0" encoding="UTF-8"?>
<dork>
    <query>${dork}</query>
    <category>${category}</category>
    <mode>${mode}</mode>
    <timestamp>${timestamp}</timestamp>
</dork>`;
            filename = `dork_${Date.now()}.xml`;
            mimeType = 'application/xml';
            break;
    }
    
    downloadFile(content, filename, mimeType);
    showNotification(`Exported as ${format.toUpperCase()}`, 'success');
}

// Dork history management
let dorkHistory = JSON.parse(localStorage.getItem('dorkHistory') || '[]');

function saveDorkToHistory(dork, category, mode) {
    const entry = {
        dork,
        category,
        mode,
        timestamp: new Date().toISOString(),
        id: Date.now()
    };
    
    dorkHistory.unshift(entry);
    
    // Keep only last 50 entries
    if (dorkHistory.length > 50) {
        dorkHistory = dorkHistory.slice(0, 50);
    }
    
    localStorage.setItem('dorkHistory', JSON.stringify(dorkHistory));
    updateHistoryDisplay();
}

function updateHistoryDisplay() {
    const historyContainer = document.getElementById('dork-history');
    if (!historyContainer) return;
    
    if (dorkHistory.length === 0) {
        historyContainer.innerHTML = '<p>No dork history available</p>';
        return;
    }
    
    const historyHTML = dorkHistory.slice(0, 10).map(entry => `
        <div class="history-item" data-id="${entry.id}">
            <div class="history-dork">${entry.dork}</div>
            <div class="history-meta">
                <span class="history-category">${entry.category}</span>
                <span class="history-mode">${entry.mode}</span>
                <span class="history-time">${new Date(entry.timestamp).toLocaleString()}</span>
            </div>
            <div class="history-actions">
                <button onclick="loadDorkFromHistory('${entry.id}')" class="btn-small">Load</button>
                <button onclick="deleteDorkFromHistory('${entry.id}')" class="btn-small btn-danger">Delete</button>
            </div>
        </div>
    `).join('');
    
    historyContainer.innerHTML = historyHTML;
}

// Advanced search engine integration
function searchWithEngine(engine, dork) {
    const encodedDork = encodeURIComponent(dork);
    let url = '';
    
    switch(engine) {
        case 'google':
            url = `https://www.google.com/search?q=${encodedDork}`;
            break;
        case 'bing':
            url = `https://www.bing.com/search?q=${encodedDork}`;
            break;
        case 'duckduckgo':
            url = `https://duckduckgo.com/?q=${encodedDork}`;
            break;
        case 'yandex':
            url = `https://yandex.com/search/?text=${encodedDork}`;
            break;
        case 'baidu':
            url = `https://www.baidu.com/s?wd=${encodedDork}`;
            break;
        case 'yahoo':
            url = `https://search.yahoo.com/search?p=${encodedDork}`;
            break;
        case 'shodan':
            url = `https://www.shodan.io/search?query=${encodedDork}`;
            break;
        case 'censys':
            url = `https://search.censys.io/search?resource=hosts&sort=RELEVANCE&per_page=25&virtual_hosts=EXCLUDE&q=${encodedDork}`;
            break;
        case 'fofa':
            url = `https://fofa.info/result?qbase64=${btoa(dork)}`;
            break;
        case 'zoomeye':
            url = `https://www.zoomeye.org/searchResult?q=${encodedDork}`;
            break;
        case 'binaryedge':
            url = `https://app.binaryedge.io/services/query?query=${encodedDork}`;
            break;
    }
    
    if (url) {
        window.open(url, '_blank');
        trackSearchUsage(engine);
    }
}

// Analytics and usage tracking
function trackSearchUsage(engine) {
    const usage = JSON.parse(localStorage.getItem('searchUsage') || '{}');
    usage[engine] = (usage[engine] || 0) + 1;
    localStorage.setItem('searchUsage', JSON.stringify(usage));
}

// Keyboard shortcuts enhancement
function initializeAdvancedKeyboardShortcuts() {
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + G - Generate new dork
        if ((e.ctrlKey || e.metaKey) && e.key === 'g') {
            e.preventDefault();
            document.querySelector('.btn-generate')?.click();
        }
        
        // Ctrl/Cmd + C - Copy dork (when focused on result)
        if ((e.ctrlKey || e.metaKey) && e.key === 'c' && e.target.id === 'generated-dork') {
            e.preventDefault();
            copyToClipboard();
        }
        
        // Ctrl/Cmd + E - Export as JSON
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            exportDorks('json');
        }
        
        // Ctrl/Cmd + H - Toggle history
        if ((e.ctrlKey || e.metaKey) && e.key === 'h') {
            e.preventDefault();
            toggleHistory();
        }
        
        // Escape - Clear form
        if (e.key === 'Escape') {
            if (confirm('Clear all form data?')) {
                clearForm();
            }
        }
        
        // F1 - Help
        if (e.key === 'F1') {
            e.preventDefault();
            showHelp();
        }
    });
}

// Advanced form validation
function validateForm() {
    const category = document.getElementById('category')?.value;
    const mode = document.getElementById('selected_mode')?.value;
    
    if (!category) {
        showNotification('Please select a category', 'error');
        return false;
    }
    
    if (!mode) {
        showNotification('Please select a search mode', 'error');
        return false;
    }
    
    // Validate dangerous combinations
    if (category === 'adult_content' && !confirm('You are about to search for adult content. Continue?')) {
        return false;
    }
    
    if (mode === 'darkweb' && !confirm('Dark web research mode is potentially dangerous. Continue with caution?')) {
        return false;
    }
    
    return true;
}

// Real-time form assistance
function initializeFormAssistance() {
    const categorySelect = document.getElementById('category');
    const vulnTypeSelect = document.getElementById('vulnerability_type');
    
    categorySelect?.addEventListener('change', function() {
        updateThreatIndicator();
        updateCategoryDescription();
        suggestRelatedOptions();
    });
    
    vulnTypeSelect?.addEventListener('change', function() {
        updateVulnerabilityGuidance();
    });
}

// Dynamic tooltips and help
function showContextualHelp(element) {
    const helpTexts = {
        'category': 'Select the type of content you want to search for. Each category has different risk levels.',
        'operator': 'Choose a search operator to modify how your search behaves.',
        'target_site': 'Limit your search to a specific website or domain.',
        'vulnerability_type': 'Focus on specific types of security vulnerabilities.',
        'safe_search': 'Control the level of content filtering applied to results.'
    };
    
    const helpText = helpTexts[element.id];
    if (helpText) {
        showTooltip(element, helpText);
    }
}

// Performance monitoring
function initializePerformanceMonitoring() {
    const startTime = performance.now();
    
    window.addEventListener('load', function() {
        const loadTime = performance.now() - startTime;
        console.log(`Page loaded in ${loadTime.toFixed(2)}ms`);
        
        // Track performance metrics
        const metrics = {
            loadTime,
            timestamp: new Date().toISOString(),
            userAgent: navigator.userAgent
        };
        
        localStorage.setItem('performanceMetrics', JSON.stringify(metrics));
    });
}

// Initialize all enhanced features
function initializeEnhancedFeatures() {
    initializeModeSelection();
    initializeFormAssistance();
    initializeAdvancedKeyboardShortcuts();
    initializePerformanceMonitoring();
    updateHistoryDisplay();
    
    // Add event listeners for new features
    document.getElementById('category')?.addEventListener('change', updateThreatIndicator);
    
    // Initialize contextual help
    document.querySelectorAll('select, input').forEach(element => {
        element.addEventListener('focus', () => showContextualHelp(element));
    });
}

// Utility functions
function highlightSection(sectionName) {
    const sections = document.querySelectorAll('.form-section h3');
    sections.forEach(section => {
        if (section.textContent.includes(sectionName)) {
            section.parentElement.classList.add('highlight');
            section.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
}

function setSelectValue(selectId, value) {
    const select = document.getElementById(selectId);
    if (select) {
        select.value = value;
    }
}

function showModeSpecificTooltip(message) {
    showNotification(message, 'info', 5000);
}

function showWarningMessage(message) {
    const warning = document.createElement('div');
    warning.className = 'warning-message danger';
    warning.innerHTML = `<i class="fas fa-exclamation-triangle"></i><span>${message}</span>`;
    
    const form = document.querySelector('.dork-form');
    if (form) {
        form.insertBefore(warning, form.firstChild);
        setTimeout(() => warning.remove(), 10000);
    }
}

function downloadFile(content, filename, mimeType) {
    const blob = new Blob([content], { type: mimeType });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Initialize enhanced features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeEnhancedFeatures();
});

// Dork Analysis Function
function analyzeDork() {
    const dorkElement = document.getElementById('generated-dork');
    if (!dorkElement) return;
    
    const dork = dorkElement.textContent;
    
    // Count operators
    const operators = ['site:', 'inurl:', 'intitle:', 'intext:', 'filetype:', 'ext:', 'port:', 'after:', 'before:', '-site:'];
    let operatorCount = 0;
    operators.forEach(op => {
        if (dork.includes(op)) operatorCount++;
    });
    
    // Calculate complexity
    const wordCount = dork.split(/\s+/).length;
    let complexity = 'Low';
    let complexityClass = 'risk-low';
    
    if (wordCount > 10 || operatorCount > 5) {
        complexity = 'High';
        complexityClass = 'risk-high';
    } else if (wordCount > 5 || operatorCount > 2) {
        complexity = 'Medium';
        complexityClass = 'risk-medium';
    }
    
    // Determine risk level
    const highRiskKeywords = ['password', 'admin', 'login', 'config', 'database', 'sql', 'backup', '.env'];
    const mediumRiskKeywords = ['index of', 'directory', 'upload', 'file'];
    
    let riskLevel = 'Low';
    let riskClass = 'risk-low';
    
    highRiskKeywords.forEach(keyword => {
        if (dork.toLowerCase().includes(keyword)) {
            riskLevel = 'High';
            riskClass = 'risk-high';
        }
    });
    
    if (riskLevel === 'Low') {
        mediumRiskKeywords.forEach(keyword => {
            if (dork.toLowerCase().includes(keyword)) {
                riskLevel = 'Medium';
                riskClass = 'risk-medium';
            }
        });
    }
    
    // Update UI
    const complexityEl = document.getElementById('complexity-score');
    const operatorCountEl = document.getElementById('operator-count');
    const riskLevelEl = document.getElementById('risk-level');
    
    if (complexityEl) {
        complexityEl.textContent = complexity;
        complexityEl.className = 'value ' + complexityClass;
    }
    
    if (operatorCountEl) {
        operatorCountEl.textContent = operatorCount;
    }
    
    if (riskLevelEl) {
        riskLevelEl.textContent = riskLevel;
        riskLevelEl.className = 'value ' + riskClass;
    }
}

// Mode toggle functionality
function initializeModeToggle() {
    const toggle = document.getElementById('adult-mode-toggle');
    const normalLabel = document.getElementById('mode-label-normal');
    const adultLabel = document.getElementById('mode-label-adult');
    const modeDescription = document.getElementById('mode-description');
    
    if (!toggle) return;
    
    // Load saved preference from localStorage
    const savedMode = localStorage.getItem('searchMode');
    if (savedMode === 'adult') {
        toggle.checked = true;
        updateMode(true);
    }
    
    // Handle toggle change
    toggle.addEventListener('change', function() {
        const isAdultMode = this.checked;
        updateMode(isAdultMode);
        
        // Save preference
        localStorage.setItem('searchMode', isAdultMode ? 'adult' : 'normal');
        
        // Show notification
        showNotification(
            isAdultMode ? 'Switched to 18+ Adult Search Mode' : 'Switched to Normal Search Mode',
            isAdultMode ? 'warning' : 'info'
        );
    });
    
    function updateMode(isAdultMode) {
        // Update label states
        if (normalLabel && adultLabel) {
            if (isAdultMode) {
                normalLabel.classList.remove('active');
                adultLabel.classList.add('active');
            } else {
                normalLabel.classList.add('active');
                adultLabel.classList.remove('active');
            }
        }
        
        // Update description
        if (modeDescription) {
            if (isAdultMode) {
                modeDescription.innerHTML = '<strong>⚠️ 18+ Adult Mode Active</strong> - Showing adult content search engines only';
            } else {
                modeDescription.innerHTML = 'Currently in <strong>Normal Mode</strong> - Standard search engines and security research tools';
            }
        }
        
        // Toggle visibility of content sections
        const normalContent = document.querySelectorAll('.normal-mode-content');
        const adultContent = document.querySelectorAll('.adult-mode-content');
        
        normalContent.forEach(el => {
            el.style.display = isAdultMode ? 'none' : 'block';
        });
        
        adultContent.forEach(el => {
            el.style.display = isAdultMode ? 'block' : 'none';
        });
    }
}
