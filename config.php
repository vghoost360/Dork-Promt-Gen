<?php
// Configuration file for Dork Search Generator

// Application settings
define('APP_NAME', 'Advanced Dork Search Generator');
define('APP_VERSION', '1.0.0');
define('APP_DESCRIPTION', 'Professional Google Dorking Tool for Security Research');

// Security settings
define('MAX_DORK_LENGTH', 1000);
define('MAX_CUSTOM_TERM_LENGTH', 200);
define('MAX_SITE_LENGTH', 100);

// Rate limiting (requests per minute)
define('RATE_LIMIT', 60);

// Default search engines
$search_engines = [
    'google' => [
        'name' => 'Google',
        'url' => 'https://www.google.com/search?q=',
        'icon' => 'fab fa-google'
    ],
    'bing' => [
        'name' => 'Bing',
        'url' => 'https://www.bing.com/search?q=',
        'icon' => 'fab fa-microsoft'
    ],
    'duckduckgo' => [
        'name' => 'DuckDuckGo',
        'url' => 'https://duckduckgo.com/?q=',
        'icon' => 'fas fa-search'
    ],
    'yandex' => [
        'name' => 'Yandex',
        'url' => 'https://yandex.com/search/?text=',
        'icon' => 'fab fa-yandex'
    ],
    'baidu' => [
        'name' => 'Baidu',
        'url' => 'https://www.baidu.com/s?wd=',
        'icon' => 'fas fa-search'
    ]
];

// File type mappings
$file_types = [
    'pdf' => 'Adobe PDF Documents',
    'doc' => 'Microsoft Word Documents',
    'docx' => 'Microsoft Word Documents (DOCX)',
    'xls' => 'Microsoft Excel Spreadsheets',
    'xlsx' => 'Microsoft Excel Spreadsheets (XLSX)',
    'ppt' => 'Microsoft PowerPoint Presentations',
    'pptx' => 'Microsoft PowerPoint Presentations (PPTX)',
    'txt' => 'Plain Text Files',
    'rtf' => 'Rich Text Format Files',
    'sql' => 'SQL Database Files',
    'db' => 'Database Files',
    'mdb' => 'Microsoft Access Databases',
    'xml' => 'XML Documents',
    'json' => 'JSON Data Files',
    'csv' => 'Comma Separated Values',
    'log' => 'Log Files',
    'conf' => 'Configuration Files',
    'config' => 'Configuration Files',
    'ini' => 'Initialization Files',
    'cfg' => 'Configuration Files',
    'properties' => 'Properties Files',
    'php' => 'PHP Scripts',
    'asp' => 'ASP Scripts',
    'aspx' => 'ASP.NET Scripts',
    'jsp' => 'Java Server Pages',
    'js' => 'JavaScript Files',
    'html' => 'HTML Documents',
    'htm' => 'HTML Documents',
    'bak' => 'Backup Files',
    'backup' => 'Backup Files',
    'old' => 'Old Files',
    'temp' => 'Temporary Files',
    'tmp' => 'Temporary Files',
    'zip' => 'ZIP Archives',
    'rar' => 'RAR Archives',
    '7z' => '7-Zip Archives',
    'tar' => 'TAR Archives',
    'gz' => 'GZIP Archives'
];

// Advanced dork patterns for professional use
$advanced_patterns = [
    'credential_files' => [
        'filetype:txt "password" "username"',
        'filetype:log "password" "login"',
        'filetype:sql "INSERT INTO" "password"',
        'filetype:xml "password" "username"',
        'filetype:conf "password"',
        'intext:"mysql_connect" "password"',
        'intext:"mysql_pconnect" "password"'
    ],
    'database_exposure' => [
        'inurl:phpmyadmin',
        'intitle:"phpMyAdmin" "Welcome to phpMyAdmin"',
        'inurl:adminer.php',
        'intitle:"Adminer" "Login"',
        'inurl:sql',
        'filetype:sql',
        'intext:"MySQL dump"'
    ],
    'admin_interfaces' => [
        'inurl:admin',
        'inurl:administrator',
        'inurl:admin.php',
        'inurl:admin/login.php',
        'inurl:admin/admin.php',
        'inurl:login.php',
        'intitle:"Admin Login"',
        'intitle:"Administrator Login"'
    ],
    'backup_files' => [
        'filetype:bak',
        'filetype:backup',
        'filetype:old',
        'inurl:backup',
        'inurl:dump',
        'filetype:sql "backup"',
        'intitle:"Index of" "backup"'
    ]
];

// Security headers configuration
$security_headers = [
    'X-Frame-Options' => 'SAMEORIGIN',
    'X-XSS-Protection' => '1; mode=block',
    'X-Content-Type-Options' => 'nosniff',
    'Referrer-Policy' => 'strict-origin-when-cross-origin',
    'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline' cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' cdnjs.cloudflare.com; font-src 'self' cdnjs.cloudflare.com; img-src 'self' data:; connect-src 'self';"
];

// Apply security headers
foreach ($security_headers as $header => $value) {
    header("$header: $value");
}

// Utility functions
function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function validate_domain($domain) {
    return filter_var($domain, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
}

function log_activity($action, $details = '') {
    $log_entry = date('Y-m-d H:i:s') . " - " . $_SERVER['REMOTE_ADDR'] . " - $action";
    if ($details) {
        $log_entry .= " - $details";
    }
    error_log($log_entry . PHP_EOL, 3, 'logs/activity.log');
}

// Error handling
function custom_error_handler($errno, $errstr, $errfile, $errline) {
    $error_message = "Error: [$errno] $errstr - $errfile:$errline";
    error_log($error_message);
    
    if (ini_get('display_errors')) {
        echo "<div style='color: red; font-weight: bold;'>$error_message</div>";
    }
}

set_error_handler('custom_error_handler');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.use_strict_mode', 1);

?>