<?php
// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Error handling for production
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Include configuration
require_once 'config.php';

// Include data arrays
require_once 'data/dork_categories.php';
require_once 'data/operators.php';
require_once 'data/search_modes.php';
require_once 'data/threat_levels.php';
require_once 'data/advanced_options.php';

session_start();

// Initialize variables
$generated_dork = '';
$selected_category = '';
$selected_options = [];
$custom_dork = '';
$search_engine = 'https://www.google.com/search?q=';
$final_dork = '';
$error_message = '';
$threat_level = 'informational'; // Default threat level

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize inputs - preserve quotes for dork syntax
    $selected_category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $custom_dork = isset($_POST['custom_term']) ? trim($_POST['custom_term']) : '';
    $search_engine = isset($_POST['search_engine']) ? trim($_POST['search_engine']) : 'https://www.google.com/search?q=';
    $exact_phrase = isset($_POST['exact_phrase']) ? true : false;
    
    // Builder fields - sanitize but preserve dork syntax characters
    $search_in = isset($_POST['search_in']) ? array_filter($_POST['search_in'], function($v) {
        return preg_match('/^[a-z]+$/i', $v); // Only allow alphabetic operators
    }) : [];
    $target_site = isset($_POST['target_site']) ? preg_replace('/[^a-zA-Z0-9.\-_]/', '', trim($_POST['target_site'])) : '';
    $exclude_site = isset($_POST['exclude_site']) ? preg_replace('/[^a-zA-Z0-9.\-_]/', '', trim($_POST['exclude_site'])) : '';
    $filetypes = isset($_POST['filetypes']) ? array_filter($_POST['filetypes'], function($v) {
        return preg_match('/^[a-z0-9]+$/i', $v); // Only allow alphanumeric filetypes
    }) : [];
    $custom_filetype = isset($_POST['custom_filetype']) ? preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['custom_filetype'])) : '';

    // Basic validation
    if (empty($selected_category) && empty($custom_dork) && empty($target_site)) {
        $error_message = "Please enter a search term, select a category, or specify a target site.";
    } else {
        $dork_parts = [];
        
        // Handle custom term with operators
        if (!empty($custom_dork)) {
            $term = $exact_phrase ? "\"$custom_dork\"" : $custom_dork;
            
            if (!empty($search_in)) {
                foreach ($search_in as $operator) {
                    if ($operator === 'allintext') {
                        $dork_parts[] = $term;
                    } else {
                        $dork_parts[] = "$operator:$term";
                    }
                }
            } else {
                $dork_parts[] = $term;
            }
        }

        // Handle category-based dork
        if (!empty($selected_category) && isset($dork_categories[$selected_category])) {
            $category_data = $dork_categories[$selected_category];
            if (isset($category_data['dorks']) && is_array($category_data['dorks'])) {
                // Pick a random dork from the selected category
                $random_dork = $category_data['dorks'][array_rand($category_data['dorks'])];
                $dork_parts[] = $random_dork;
            }
        }

        // Add target site
        if (!empty($target_site)) {
            $dork_parts[] = "site:$target_site";
        }

        // Add exclude site
        if (!empty($exclude_site)) {
            $dork_parts[] = "-site:$exclude_site";
        }

        // Add file types
        foreach ($filetypes as $ft) {
            $dork_parts[] = "filetype:$ft";
        }
        
        // Add custom file type
        if (!empty($custom_filetype)) {
            $dork_parts[] = "filetype:$custom_filetype";
        }

        // Combine parts into the final dork
        $generated_dork = implode(' ', $dork_parts);

        // URL-encode the dork for the search engine
        $final_dork = $search_engine . urlencode($generated_dork);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Dork Search Generator</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-search"></i> Advanced Dork Search Generator</h1>
            <p class="subtitle">Professional Google Dorking Tool for Security Research</p>
            
            <!-- Mode Toggle Switch -->
            <div class="mode-toggle-container">
                <div class="mode-toggle">
                    <span class="mode-label" id="mode-label-normal">Normal Search</span>
                    <label class="toggle-switch">
                        <input type="checkbox" id="adult-mode-toggle">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="mode-label adult-label" id="mode-label-adult">18+ Adult Search</span>
                </div>
                <p class="mode-description" id="mode-description">
                    Currently in <strong>Normal Mode</strong> - Standard search engines and security research tools
                </p>
            </div>
        </header>

        <div class="warning-banner">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Warning:</strong> This tool is for educational and authorized security research only. 
            Unauthorized access to systems is illegal. Use responsibly.
        </div>

        <div class="main-content">
            <div class="generator-section">
                <h2><i class="fas fa-cogs"></i> Advanced Dork Generator</h2>
                
                <!-- Live Preview Panel -->
                <div class="live-preview-panel">
                    <div class="preview-header">
                        <h3><i class="fas fa-eye"></i> Live Preview</h3>
                        <button type="button" class="clear-all-btn" onclick="clearAllFields()">
                            <i class="fas fa-eraser"></i> Clear All
                        </button>
                    </div>
                    <div class="preview-content">
                        <code id="live-preview-dork" class="preview-dork">Start building your dork below...</code>
                    </div>
                    <div class="preview-actions">
                        <button type="button" class="preview-btn" onclick="copyPreviewDork()">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                        <button type="button" class="preview-btn" onclick="testPreviewDork()">
                            <i class="fas fa-external-link-alt"></i> Test in Google
                        </button>
                    </div>
                </div>

                <!-- Quick Templates -->
                <div class="quick-templates">
                    <h3><i class="fas fa-bolt"></i> Quick Templates</h3>
                    <div class="template-grid">
                        <button type="button" class="template-btn" onclick="applyTemplate('admin')">
                            <i class="fas fa-user-shield"></i>
                            <span>Find Admin Panels</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('login')">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login Pages</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('sensitive')">
                            <i class="fas fa-file-alt"></i>
                            <span>Sensitive Files</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('database')">
                            <i class="fas fa-database"></i>
                            <span>Database Files</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('config')">
                            <i class="fas fa-cog"></i>
                            <span>Config Files</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('backup')">
                            <i class="fas fa-archive"></i>
                            <span>Backup Files</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('exposed')">
                            <i class="fas fa-folder-open"></i>
                            <span>Open Directories</span>
                        </button>
                        <button type="button" class="template-btn" onclick="applyTemplate('cameras')">
                            <i class="fas fa-video"></i>
                            <span>IP Cameras</span>
                        </button>
                    </div>
                </div>
                
                <form method="POST" class="dork-form" id="dork-builder-form">
                    <input type="hidden" name="mode" id="selected_mode" value="<?= $selected_mode ?? 'standard' ?>">
                    
                    <!-- Step 1: What to search for -->
                    <div class="form-section builder-step">
                        <div class="step-header">
                            <span class="step-number">1</span>
                            <h3><i class="fas fa-search"></i> What are you looking for?</h3>
                        </div>
                        <p class="step-hint">Enter keywords or phrases you want to find. Use quotes for exact phrases.</p>
                        
                        <div class="search-input-wrapper">
                            <input type="text" name="custom_term" id="custom_term" 
                                   class="main-search-input" 
                                   placeholder="e.g., password, admin login, database dump..."
                                   oninput="updateLivePreview()">
                            <div class="search-modifiers">
                                <label class="modifier-chip" title="Search must contain this exact phrase">
                                    <input type="checkbox" name="exact_phrase" value="1" onchange="updateLivePreview()">
                                    <span><i class="fas fa-quote-left"></i> Exact phrase</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Where to search -->
                    <div class="form-section builder-step">
                        <div class="step-header">
                            <span class="step-number">2</span>
                            <h3><i class="fas fa-map-marker-alt"></i> Where to search?</h3>
                        </div>
                        <p class="step-hint">Choose where in web pages to look for your terms.</p>
                        
                        <div class="operator-cards">
                            <label class="operator-card" title="Search in URLs (web addresses)">
                                <input type="checkbox" name="search_in[]" value="inurl" onchange="updateLivePreview()">
                                <i class="fas fa-link"></i>
                                <span class="op-name">In URL</span>
                                <span class="op-example">e.g., admin, login, panel</span>
                            </label>
                            <label class="operator-card" title="Search in page titles">
                                <input type="checkbox" name="search_in[]" value="intitle" onchange="updateLivePreview()">
                                <i class="fas fa-heading"></i>
                                <span class="op-name">In Title</span>
                                <span class="op-example">e.g., "Admin Panel", Login</span>
                            </label>
                            <label class="operator-card" title="Search in page content/text">
                                <input type="checkbox" name="search_in[]" value="intext" onchange="updateLivePreview()">
                                <i class="fas fa-file-alt"></i>
                                <span class="op-name">In Text</span>
                                <span class="op-example">e.g., password, username</span>
                            </label>
                            <label class="operator-card" title="Search anywhere">
                                <input type="checkbox" name="search_in[]" value="allintext" onchange="updateLivePreview()">
                                <i class="fas fa-globe"></i>
                                <span class="op-name">Anywhere</span>
                                <span class="op-example">General search</span>
                            </label>
                        </div>
                    </div>

                    <!-- Step 3: Target specific site -->
                    <div class="form-section builder-step">
                        <div class="step-header">
                            <span class="step-number">3</span>
                            <h3><i class="fas fa-crosshairs"></i> Target specific domain? (Optional)</h3>
                        </div>
                        <p class="step-hint">Limit search to a specific website or exclude unwanted domains.</p>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="target_site"><i class="fas fa-plus-circle"></i> Only search on:</label>
                                <input type="text" name="target_site" id="target_site" 
                                       placeholder="example.com" oninput="updateLivePreview()">
                            </div>
                            <div class="form-group">
                                <label for="exclude_site"><i class="fas fa-minus-circle"></i> Exclude from search:</label>
                                <input type="text" name="exclude_site" id="exclude_site" 
                                       placeholder="unwanted.com" oninput="updateLivePreview()">
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: File types -->
                    <div class="form-section builder-step">
                        <div class="step-header">
                            <span class="step-number">4</span>
                            <h3><i class="fas fa-file"></i> Looking for specific files? (Optional)</h3>
                        </div>
                        <p class="step-hint">Filter results to show only certain file types.</p>
                        
                        <div class="filetype-grid">
                            <label class="filetype-chip" title="PDF Documents">
                                <input type="checkbox" name="filetypes[]" value="pdf" onchange="updateLivePreview()">
                                <i class="fas fa-file-pdf"></i> PDF
                            </label>
                            <label class="filetype-chip" title="Word Documents">
                                <input type="checkbox" name="filetypes[]" value="doc" onchange="updateLivePreview()">
                                <i class="fas fa-file-word"></i> DOC
                            </label>
                            <label class="filetype-chip" title="Excel Spreadsheets">
                                <input type="checkbox" name="filetypes[]" value="xls" onchange="updateLivePreview()">
                                <i class="fas fa-file-excel"></i> XLS
                            </label>
                            <label class="filetype-chip" title="SQL Database Files">
                                <input type="checkbox" name="filetypes[]" value="sql" onchange="updateLivePreview()">
                                <i class="fas fa-database"></i> SQL
                            </label>
                            <label class="filetype-chip" title="Text Files">
                                <input type="checkbox" name="filetypes[]" value="txt" onchange="updateLivePreview()">
                                <i class="fas fa-file-alt"></i> TXT
                            </label>
                            <label class="filetype-chip" title="Log Files">
                                <input type="checkbox" name="filetypes[]" value="log" onchange="updateLivePreview()">
                                <i class="fas fa-scroll"></i> LOG
                            </label>
                            <label class="filetype-chip" title="Config Files">
                                <input type="checkbox" name="filetypes[]" value="conf" onchange="updateLivePreview()">
                                <i class="fas fa-cog"></i> CONF
                            </label>
                            <label class="filetype-chip" title="Backup Files">
                                <input type="checkbox" name="filetypes[]" value="bak" onchange="updateLivePreview()">
                                <i class="fas fa-archive"></i> BAK
                            </label>
                            <label class="filetype-chip" title="Environment Files">
                                <input type="checkbox" name="filetypes[]" value="env" onchange="updateLivePreview()">
                                <i class="fas fa-key"></i> ENV
                            </label>
                            <label class="filetype-chip" title="PHP Files">
                                <input type="checkbox" name="filetypes[]" value="php" onchange="updateLivePreview()">
                                <i class="fab fa-php"></i> PHP
                            </label>
                            <label class="filetype-chip" title="XML Files">
                                <input type="checkbox" name="filetypes[]" value="xml" onchange="updateLivePreview()">
                                <i class="fas fa-code"></i> XML
                            </label>
                            <label class="filetype-chip" title="JSON Files">
                                <input type="checkbox" name="filetypes[]" value="json" onchange="updateLivePreview()">
                                <i class="fas fa-brackets-curly"></i> JSON
                            </label>
                        </div>
                        
                        <div class="custom-filetype">
                            <label for="custom_filetype">Or enter custom file type:</label>
                            <input type="text" name="custom_filetype" id="custom_filetype" 
                                   placeholder="e.g., csv, yaml, ini" oninput="updateLivePreview()">
                        </div>
                    </div>

                    <!-- Step 5: Generate -->
                    <div class="form-section builder-step generate-step">
                        <div class="generate-buttons">
                            <button type="submit" class="generate-btn primary">
                                <i class="fas fa-magic"></i> Generate Dork
                            </button>
                            <button type="button" class="generate-btn secondary" onclick="generateRandomDork()">
                                <i class="fas fa-random"></i> Random Dork
                            </button>
                        </div>
                        <p class="generate-hint">
                            <i class="fas fa-lightbulb"></i> Tip: Start simple and add filters progressively for best results
                        </p>
                    </div>
                </form>

                <!-- Category-based Dorks (Collapsed by default) -->
                <details class="advanced-section">
                    <summary><i class="fas fa-folder-tree"></i> Browse Pre-built Dorks by Category</summary>
                    <div class="category-browser">
                        <div class="form-group">
                            <label for="category"><i class="fas fa-tags"></i> Select Category:</label>
                            <select name="category" id="category" form="dork-builder-form">
                                <option value="">Choose a category...</option>
                                <?php foreach ($dork_categories as $key => $category): ?>
                                    <option value="<?= $key ?>" 
                                            data-icon="<?= $category['icon'] ?>" 
                                            data-description="<?= htmlspecialchars($category['description']) ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <p class="category-hint">
                            <i class="fas fa-info-circle"></i> Selecting a category will add a random dork from that collection to your search
                        </p>
                    </div>
                </details>
            </div>

            <!-- Results Section (shown after generation) -->
            <?php if (!empty($generated_dork)): ?>
            <div class="results-section" id="results-section">
                <h3><i class="fas fa-check-circle"></i> Generated Dork</h3>
                <div class="dork-result">
                    <code id="generated-dork"><?= htmlspecialchars($generated_dork) ?></code>
                    <div class="result-actions">
                        <button onclick="copyToClipboard()" class="copy-btn" title="Copy to clipboard">
                            <i class="fas fa-copy"></i>
                        </button>
                        <button onclick="saveDork()" class="save-btn" title="Save to history">
                            <i class="fas fa-bookmark"></i>
                        </button>
                        <button onclick="shareDork()" class="share-btn" title="Share dork">
                            <i class="fas fa-share"></i>
                        </button>
                    </div>
                </div>
                
                <div class="dork-analysis">
                    <h4><i class="fas fa-chart-line"></i> Dork Analysis</h4>
                    <div class="analysis-grid">
                        <div class="analysis-item">
                            <span class="label">Complexity:</span>
                            <span class="value" id="complexity-score">Medium</span>
                        </div>
                        <div class="analysis-item">
                            <span class="label">Operators:</span>
                            <span class="value" id="operator-count">3</span>
                        </div>
                        <div class="analysis-item">
                            <span class="label">Risk Level:</span>
                            <span class="value risk-medium" id="risk-level">Medium</span>
                        </div>
                        <div class="analysis-item">
                            <span class="label">Category:</span>
                            <span class="value"><?= htmlspecialchars($dork_categories[$selected_category]['name'] ?? 'Custom') ?></span>
                        </div>
                    </div>
                    </div>
                    
                    <div class="search-engines">
                        <h4><i class="fas fa-rocket"></i> Search Engines</h4>
                        <div class="search-buttons">
                            <a href="https://www.google.com/search?q=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn google-btn">
                                <i class="fab fa-google"></i> Google
                            </a>
                            <a href="https://www.bing.com/search?q=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn bing-btn">
                                <i class="fab fa-microsoft"></i> Bing
                            </a>
                            <a href="https://duckduckgo.com/?q=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn duck-btn">
                                <i class="fas fa-search"></i> DuckDuckGo
                            </a>
                            <a href="https://yandex.com/search/?text=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn yandex-btn">
                                <i class="fab fa-yandex"></i> Yandex
                            </a>
                            <a href="https://www.baidu.com/s?wd=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn baidu-btn">
                                <i class="fas fa-search"></i> Baidu
                            </a>
                            <a href="https://search.yahoo.com/search?p=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn yahoo-btn">
                                <i class="fab fa-yahoo"></i> Yahoo
                            </a>
                        </div>
                    </div>
                    
                    <!-- Specialized Search Engines (Normal Mode) -->
                    <div class="specialized-search normal-mode-content">
                        <h4><i class="fas fa-satellite-dish"></i> Specialized Search Engines</h4>
                        <div class="search-buttons specialized">
                            <a href="https://shodan.io/search?query=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn shodan-btn">
                                <i class="fas fa-satellite-dish"></i> Shodan
                            </a>
                            <a href="https://censys.io/ipv4?q=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn censys-btn">
                                <i class="fas fa-globe"></i> Censys
                            </a>
                            <a href="https://fofa.so/result?qbase64=<?= base64_encode($generated_dork) ?>" 
                               target="_blank" class="search-btn fofa-btn">
                                <i class="fas fa-eye"></i> FOFA
                            </a>
                            <a href="https://zoomeye.org/searchResult?q=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn zoomeye-btn">
                                <i class="fas fa-binoculars"></i> ZoomEye
                            </a>
                            <a href="https://binaryedge.io/search/query/<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn binary-btn">
                                <i class="fas fa-code"></i> BinaryEdge
                            </a>
                            <a href="https://www.onyphe.io/search/?query=<?= urlencode($generated_dork) ?>" 
                               target="_blank" class="search-btn onyphe-btn">
                                <i class="fas fa-search-plus"></i> Onyphe
                            </a>
                        </div>
                    </div>
                    
                    <!-- Adult Search Engines -->
                    <div class="adult-search adult-mode-content" style="display: none;">
                        <h4><i class="fas fa-user-secret"></i> Adult Content Search (18+)</h4>
                        <div class="adult-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> These search engines are for adult content research only. 
                            Must be 18+ and used for legitimate security research purposes.
                        </div>
                        <div class="search-buttons adult">
                            <a href="https://www.bing.com/search?q=<?= urlencode($generated_dork . ' site:pornhub.com OR site:xvideos.com OR site:xnxx.com') ?>" 
                               target="_blank" class="search-btn adult-btn">
                                <i class="fas fa-video"></i> Video Sites
                            </a>
                            <a href="https://www.bing.com/search?q=<?= urlencode($generated_dork . ' site:onlyfans.com OR site:fansly.com') ?>" 
                               target="_blank" class="search-btn adult-btn">
                                <i class="fas fa-users"></i> Premium Sites
                            </a>
                            <a href="https://www.bing.com/search?q=<?= urlencode($generated_dork . ' site:reddit.com/r/nsfw OR site:reddit.com/r/gonewild') ?>" 
                               target="_blank" class="search-btn adult-btn">
                                <i class="fab fa-reddit"></i> Reddit NSFW
                            </a>
                            <a href="https://www.bing.com/search?q=<?= urlencode($generated_dork . ' site:tumblr.com adult') ?>" 
                               target="_blank" class="search-btn adult-btn">
                                <i class="fab fa-tumblr"></i> Tumblr Adult
                            </a>
                            <a href="https://www.google.com/search?q=<?= urlencode($generated_dork . ' filetype:jpg OR filetype:png OR filetype:gif adult OR nsfw') ?>" 
                               target="_blank" class="search-btn adult-btn">
                                <i class="fas fa-image"></i> Image Search
                            </a>
                            <a href="https://www.bing.com/search?q=<?= urlencode($generated_dork . ' site:twitter.com OR site:x.com nsfw') ?>" 
                               target="_blank" class="search-btn adult-btn">
                                <i class="fab fa-twitter"></i> Twitter/X NSFW
                            </a>
                        </div>
                    </div>
                    
                    <div class="export-options">
                        <h4><i class="fas fa-download"></i> Export Options</h4>
                        <div class="export-buttons">
                            <button onclick="exportDork('txt')" class="export-btn">
                                <i class="fas fa-file-alt"></i> Export as TXT
                            </button>
                            <button onclick="exportDork('json')" class="export-btn">
                                <i class="fas fa-file-code"></i> Export as JSON
                            </button>
                            <button onclick="exportDork('csv')" class="export-btn">
                                <i class="fas fa-file-csv"></i> Export as CSV
                            </button>
                            <button onclick="generateReport()" class="export-btn">
                                <i class="fas fa-file-pdf"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="sidebar">
                <div class="info-section">
                    <h3><i class="fas fa-info-circle"></i> Quick Reference</h3>
                    <div class="operator-list">
                        <?php foreach ($operators as $op => $info): ?>
                        <div class="operator-item">
                            <code><?= $op ?></code>
                            <span><?= htmlspecialchars($info['description']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="tips-section">
                    <h3><i class="fas fa-lightbulb"></i> Pro Tips</h3>
                    <ul>
                        <li>Use quotes for exact phrase matching</li>
                        <li>Combine multiple operators for better results</li>
                        <li>Use wildcards (*) for unknown words</li>
                        <li>Try different search engines for varied results</li>
                        <li>Always respect robots.txt and terms of service</li>
                        <li>Use cache: operator to see older versions</li>
                        <li>Combine with social engineering techniques</li>
                        <li>Always verify findings manually</li>
                    </ul>
                </div>

                <div class="stats-section">
                    <h3><i class="fas fa-chart-bar"></i> Statistics</h3>
                    <div class="stat-item">
                        <span class="stat-number"><?= count($dork_categories) ?></span>
                        <span class="stat-label">Categories</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?= array_sum(array_map(function($cat) { return isset($cat['dorks']) ? count($cat['dorks']) : 0; }, $dork_categories)) ?></span>
                        <span class="stat-label">Total Dorks</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?= count($operators) ?></span>
                        <span class="stat-label">Operators</span>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; 2025 Advanced Dork Generator | For Educational Use Only</p>
            <p><strong>Disclaimer:</strong> This tool is designed for legitimate security research and educational purposes. Users are responsible for complying with all applicable laws and regulations.</p>
        </footer>
    </div>

    <script src="script.js"></script>
    
    <?php if ($generated_dork): ?>
    <script>
        // Scroll to results section after page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const resultsSection = document.getElementById('results-section');
                if (resultsSection) {
                    resultsSection.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start',
                        inline: 'nearest'
                    });
                }
            }, 100); // Small delay to ensure page is fully loaded
        });
    </script>
    <?php endif; ?>
</body>
</html>
