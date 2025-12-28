<?php
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
    // Sanitize inputs
    $selected_category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '';
    $selected_options = isset($_POST['options']) ? array_map('htmlspecialchars', $_POST['options']) : [];
    $custom_dork = isset($_POST['custom_term']) ? htmlspecialchars($_POST['custom_term']) : '';
    $search_engine = isset($_POST['search_engine']) ? htmlspecialchars($_POST['search_engine']) : 'https://www.google.com/search?q=';
    $threat_level = isset($_POST['threat_level']) ? htmlspecialchars($_POST['threat_level']) : 'informational';

    // Basic validation
    if (empty($selected_category) && empty($custom_dork)) {
        $error_message = "Please select a dork category or enter a custom dork.";
    } else {
        $dork_parts = [];

        // Handle custom dork first
        if (!empty($custom_dork)) {
            $dork_parts[] = $custom_dork;
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

        // Handle additional form fields
        $primary_operator = isset($_POST['operator']) ? htmlspecialchars($_POST['operator']) : '';
        $secondary_operator = isset($_POST['secondary_operator']) ? htmlspecialchars($_POST['secondary_operator']) : '';
        $target_site = isset($_POST['target_site']) ? htmlspecialchars($_POST['target_site']) : '';
        $exclude_site = isset($_POST['exclude_site']) ? htmlspecialchars($_POST['exclude_site']) : '';
        $file_type = isset($_POST['file_type']) ? htmlspecialchars($_POST['file_type']) : '';
        $port_number = isset($_POST['port_number']) ? htmlspecialchars($_POST['port_number']) : '';
        $date_range = isset($_POST['date_range']) ? htmlspecialchars($_POST['date_range']) : '';

        // Add target site
        if (!empty($target_site)) {
            $dork_parts[] = "site:$target_site";
        }

        // Add exclude site
        if (!empty($exclude_site)) {
            $dork_parts[] = "-site:$exclude_site";
        }

        // Add file type
        if (!empty($file_type)) {
            $dork_parts[] = "filetype:$file_type";
        }

        // Add port number
        if (!empty($port_number)) {
            $dork_parts[] = "port:$port_number";
        }

        // Add date range
        if (!empty($date_range)) {
            $dork_parts[] = "after:$date_range";
        }

        // Add primary operator if specified
        if (!empty($primary_operator) && $primary_operator !== 'none') {
            if (!empty($custom_dork)) {
                $dork_parts[] = $primary_operator . $custom_dork;
            }
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
                
                <!-- Mode Selection -->
                <div class="mode-selection">
                    <h3><i class="fas fa-sliders-h"></i> Search Mode</h3>
                    <div class="mode-grid">
                        <?php foreach ($search_modes as $mode_key => $mode_info): ?>
                        <div class="mode-card" data-mode="<?= $mode_key ?>">
                            <input type="radio" name="mode" value="<?= $mode_key ?>" id="mode_<?= $mode_key ?>" 
                                   <?= ($selected_mode ?? 'standard') === $mode_key ? 'checked' : '' ?>>
                            <label for="mode_<?= $mode_key ?>">
                                <i class="<?= $mode_info['icon'] ?>"></i>
                                <span class="mode-name"><?= $mode_info['name'] ?></span>
                                <span class="mode-desc"><?= $mode_info['description'] ?></span>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <form method="POST" class="dork-form">
                    <input type="hidden" name="mode" id="selected_mode" value="<?= $selected_mode ?? 'standard' ?>">
                    
                    <div class="form-section">
                        <h3><i class="fas fa-list"></i> Basic Configuration</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="category">
                                    <i class="fas fa-tags"></i> Category:
                                    <span class="threat-indicator" id="threat-indicator"></span>
                                </label>
                                <select name="category" id="category" required>
                                    <option value="">Select a category...</option>
                                    <?php foreach ($dork_categories as $key => $category): ?>
                                        <option value="<?= $key ?>" <?= $selected_category === $key ? 'selected' : '' ?>
                                                data-icon="<?= $category['icon'] ?>" 
                                                data-description="<?= htmlspecialchars($category['description']) ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="category-description" id="category-desc"></small>
                            </div>

                            <div class="form-group">
                                <label for="operator"><i class="fas fa-tools"></i> Primary Operator:</label>
                                <select name="operator" id="operator">
                                    <option value="none">None</option>
                                    <?php foreach ($operators as $op => $info): ?>
                                        <option value="<?= $op ?>" title="<?= htmlspecialchars($info['description']) ?>"><?= $op ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-search-plus"></i> Advanced Options</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="custom_term"><i class="fas fa-quote-right"></i> Custom Term:</label>
                                <input type="text" name="custom_term" id="custom_term" placeholder="Additional search term">
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="exact_phrase" value="1">
                                        <span class="checkmark"></span>
                                        Exact phrase
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="combine_with_or" value="1">
                                        <span class="checkmark"></span>
                                        Combine with OR
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="wildcard_search" value="1">
                                        <span class="checkmark"></span>
                                        Wildcard search
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="secondary_operator"><i class="fas fa-plus-circle"></i> Secondary Operator:</label>
                                <select name="secondary_operator" id="secondary_operator">
                                    <option value="none">None</option>
                                    <?php foreach (array_slice($operators, 0, 10) as $op => $info): ?>
                                        <option value="<?= $op ?>" title="<?= htmlspecialchars($info['description']) ?>"><?= $op ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fas fa-filter"></i> Targeting & Filtering</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="target_site"><i class="fas fa-crosshairs"></i> Target Site:</label>
                                <input type="text" name="target_site" id="target_site" placeholder="example.com">
                                <small>Domain to focus the search on</small>
                            </div>

                            <div class="form-group">
                                <label for="exclude_site"><i class="fas fa-ban"></i> Exclude Site:</label>
                                <input type="text" name="exclude_site" id="exclude_site" placeholder="unwanted.com">
                                <small>Domain to exclude from results</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="file_type"><i class="fas fa-file"></i> File Type:</label>
                                <select name="file_type" id="file_type">
                                    <option value="">Any</option>
                                    <optgroup label="Documents">
                                        <option value="pdf">PDF</option>
                                        <option value="doc">DOC</option>
                                        <option value="docx">DOCX</option>
                                        <option value="xls">XLS</option>
                                        <option value="xlsx">XLSX</option>
                                        <option value="ppt">PPT</option>
                                        <option value="pptx">PPTX</option>
                                        <option value="txt">TXT</option>
                                        <option value="rtf">RTF</option>
                                    </optgroup>
                                    <optgroup label="Data Files">
                                        <option value="sql">SQL</option>
                                        <option value="db">DB</option>
                                        <option value="mdb">MDB</option>
                                        <option value="csv">CSV</option>
                                        <option value="json">JSON</option>
                                        <option value="xml">XML</option>
                                        <option value="yaml">YAML</option>
                                    </optgroup>
                                    <optgroup label="Config Files">
                                        <option value="conf">CONF</option>
                                        <option value="config">CONFIG</option>
                                        <option value="ini">INI</option>
                                        <option value="cfg">CFG</option>
                                        <option value="env">ENV</option>
                                        <option value="properties">PROPERTIES</option>
                                    </optgroup>
                                    <optgroup label="Code Files">
                                        <option value="php">PHP</option>
                                        <option value="asp">ASP</option>
                                        <option value="aspx">ASPX</option>
                                        <option value="jsp">JSP</option>
                                        <option value="js">JS</option>
                                        <option value="py">PY</option>
                                        <option value="java">JAVA</option>
                                    </optgroup>
                                    <optgroup label="Archives">
                                        <option value="zip">ZIP</option>
                                        <option value="rar">RAR</option>
                                        <option value="7z">7Z</option>
                                        <option value="tar">TAR</option>
                                        <option value="gz">GZ</option>
                                    </optgroup>
                                    <optgroup label="Backup Files">
                                        <option value="bak">BAK</option>
                                        <option value="backup">BACKUP</option>
                                        <option value="old">OLD</option>
                                        <option value="orig">ORIG</option>
                                        <option value="tmp">TMP</option>
                                    </optgroup>
                                    <optgroup label="Logs">
                                        <option value="log">LOG</option>
                                        <option value="out">OUT</option>
                                        <option value="err">ERR</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="port_number"><i class="fas fa-ethernet"></i> Port Number:</label>
                                <input type="number" name="port_number" id="port_number" placeholder="8080" min="1" max="65535">
                                <small>Common ports: 80, 443, 8080, 3389, 22, 21</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="date_range"><i class="fas fa-calendar"></i> Date After:</label>
                                <input type="date" name="date_range" id="date_range">
                                <small>Find results after this date</small>
                            </div>

                            <div class="form-group">
                                <label for="vulnerability_type"><i class="fas fa-bug"></i> Vulnerability Focus:</label>
                                <select name="vulnerability_type" id="vulnerability_type">
                                    <option value="">Any</option>
                                    <option value="sqli">SQL Injection</option>
                                    <option value="xss">XSS Vulnerable</option>
                                    <option value="lfi">Local File Inclusion</option>
                                    <option value="rfi">Remote File Inclusion</option>
                                    <option value="upload">File Upload</option>
                                    <option value="info_disclosure">Information Disclosure</option>
                                    <option value="auth_bypass">Authentication Bypass</option>
                                    <option value="directory_traversal">Directory Traversal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-group">
                                <button type="submit" class="generate-btn primary">
                                    <i class="fas fa-magic"></i> Generate Advanced Dork
                                </button>
                            </div>
                            <div class="form-group">
                                <button type="button" class="generate-btn secondary" onclick="generateRandomDork()">
                                    <i class="fas fa-random"></i> Random Dork
                                </button>
                            </div>
                            <div class="form-group">
                                <button type="button" class="generate-btn tertiary" onclick="clearForm()">
                                    <i class="fas fa-trash"></i> Clear Form
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <?php if ($generated_dork): ?>
                <div class="result-section" id="results-section">
                    <h3><i class="fas fa-star"></i> Generated Advanced Dork:</h3>
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
                                <span class="value"><?= htmlspecialchars($dork_categories[$selected_category]['name'] ?? 'Unknown') ?></span>
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
