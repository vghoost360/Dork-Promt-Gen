<?php
$search_modes = [
    'standard' => [
        'name' => 'Standard Search',
        'icon' => 'fas fa-search',
        'description' => 'Basic Google dorking with simple operators',
        'features' => ['Basic operators', 'Single site targeting', 'Simple file type searches']
    ],
    'advanced' => [
        'name' => 'Advanced Search',
        'icon' => 'fas fa-search-plus',
        'description' => 'Complex queries with multiple operators and logic',
        'features' => ['Multiple operators', 'Boolean logic', 'Range searches', 'Complex targeting']
    ],
    'stealth' => [
        'name' => 'Stealth Mode',
        'icon' => 'fas fa-user-ninja',
        'description' => 'Subtle searches designed to avoid detection',
        'features' => ['Randomized queries', 'Delayed execution', 'Proxy rotation', 'Anti-fingerprinting']
    ],
    'aggressive' => [
        'name' => 'Aggressive Search',
        'icon' => 'fas fa-rocket',
        'description' => 'Intensive searches for maximum coverage',
        'features' => ['High-volume queries', 'Deep site crawling', 'Multiple engines', 'Comprehensive scans']
    ],
    'recon' => [
        'name' => 'Reconnaissance',
        'icon' => 'fas fa-binoculars',
        'description' => 'Intelligence gathering and target enumeration',
        'features' => ['Subdomain discovery', 'Technology stack identification', 'Employee enumeration', 'Social media intel']
    ],
    'vulnerability' => [
        'name' => 'Vulnerability Research',
        'icon' => 'fas fa-bug',
        'description' => 'Searches focused on finding security vulnerabilities',
        'features' => ['CVE searches', 'Exploit discovery', 'Patch level detection', 'Misconfiguration hunting']
    ],
    'osint' => [
        'name' => 'OSINT Collection',
        'icon' => 'fas fa-eye',
        'description' => 'Open source intelligence gathering',
        'features' => ['Public data mining', 'Social media monitoring', 'Document discovery', 'People search']
    ]
];
?>
