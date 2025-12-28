<?php
$threat_levels = [
    'informational' => [
        'name' => 'Informational',
        'color' => '#17a2b8',
        'icon' => 'fas fa-info-circle',
        'description' => 'General information gathering, low risk'
    ],
    'low' => [
        'name' => 'Low Risk',
        'color' => '#28a745',
        'icon' => 'fas fa-shield-alt',
        'description' => 'Minor security concerns, publicly available data'
    ],
    'medium' => [
        'name' => 'Medium Risk',
        'color' => '#ffc110',
        'icon' => 'fas fa-exclamation-triangle',
        'description' => 'Moderate security implications, sensitive data exposure'
    ],
    'high' => [
        'name' => 'High Risk',
        'color' => '#fd7e14',
        'icon' => 'fas fa-fire',
        'description' => 'Significant security vulnerabilities, confidential data'
    ],
    'critical' => [
        'name' => 'Critical Risk',
        'color' => '#dc3545',
        'icon' => 'fas fa-skull-crossbones',
        'description' => 'Severe security breaches, immediate action required'
    ],
    'illegal' => [
        'name' => 'Potentially Illegal',
        'color' => '#6f42c1',
        'icon' => 'fas fa-ban',
        'description' => 'Content that may violate laws or regulations'
    ]
];
?>
