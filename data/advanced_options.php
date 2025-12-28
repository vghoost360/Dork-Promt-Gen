<?php
$advanced_options = [
    'exclude_sites' => [
        'name' => 'Exclude Sites',
        'type' => 'text',
        'placeholder' => 'site1.com,site2.com',
        'description' => 'Comma-separated list of sites to exclude'
    ],
    'date_range' => [
        'name' => 'Date Range',
        'type' => 'select',
        'options' => [
            '' => 'Any time',
            'h' => 'Past hour',
            'd' => 'Past 24 hours',
            'w' => 'Past week',
            'm' => 'Past month',
            'y' => 'Past year',
            'custom' => 'Custom range'
        ],
        'description' => 'Limit results by publication date'
    ],
    'language' => [
        'name' => 'Language',
        'type' => 'select',
        'options' => [
            '' => 'Any language',
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'zh' => 'Chinese',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'ar' => 'Arabic',
            'hi' => 'Hindi'
        ],
        'description' => 'Search in specific language'
    ],
    'country' => [
        'name' => 'Country',
        'type' => 'select',
        'options' => [
            '' => 'Any country',
            'us' => 'United States',
            'uk' => 'United Kingdom',
            'ca' => 'Canada',
            'au' => 'Australia',
            'de' => 'Germany',
            'fr' => 'France',
            'es' => 'Spain',
            'it' => 'Italy',
            'nl' => 'Netherlands',
            'se' => 'Sweden',
            'jp' => 'Japan',
            'kr' => 'South Korea',
            'cn' => 'China',
            'in' => 'India',
            'br' => 'Brazil',
            'mx' => 'Mexico',
            'ru' => 'Russia'
        ],
        'description' => 'Search within specific country'
    ],
    'file_size' => [
        'name' => 'File Size',
        'type' => 'select',
        'options' => [
            '' => 'Any size',
            'small' => 'Small (< 1MB)',
            'medium' => 'Medium (1-10MB)',
            'large' => 'Large (10-100MB)',
            'huge' => 'Huge (> 100MB)'
        ],
        'description' => 'Filter by file size'
    ],
    'exact_phrase' => [
        'name' => 'Exact Phrase',
        'type' => 'text',
        'placeholder' => 'exact phrase here',
        'description' => 'Search for exact phrase match'
    ],
    'any_words' => [
        'name' => 'Any of These Words',
        'type' => 'text',
        'placeholder' => 'word1 word2 word3',
        'description' => 'Search for any of these words'
    ],
    'none_words' => [
        'name' => 'None of These Words',
        'type' => 'text',
        'placeholder' => 'word1 word2 word3',
        'description' => 'Exclude these words from results'
    ],
    'numbers_range' => [
        'name' => 'Numbers Range',
        'type' => 'text',
        'placeholder' => '100..200',
        'description' => 'Search within numeric range'
    ],
    'usage_rights' => [
        'name' => 'Usage Rights',
        'type' => 'select',
        'options' => [
            '' => 'Not filtered by license',
            'free' => 'Free to use or share',
            'commercial' => 'Free to use commercially',
            'modify' => 'Free to use, share or modify'
        ],
        'description' => 'Filter by usage rights'
    ],
    'safe_search' => [
        'name' => 'Safe Search',
        'type' => 'select',
        'options' => [
            'moderate' => 'Moderate',
            'strict' => 'Strict',
            'off' => 'Off'
        ],
        'description' => 'Safe search filtering level'
    ],
    'region' => [
        'name' => 'Region',
        'type' => 'select',
        'options' => [
            '' => 'Any region',
        ],
        'description' => 'Search in specific region'
    ]
];
?>
