<?php
$operators = [
    // Basic Operators
    'site:' => [
        'name' => 'Site',
        'description' => 'Search within a specific website',
        'example' => 'site:example.com'
    ],
    'inurl:' => [
        'name' => 'In URL',
        'description' => 'Search for terms in the URL',
        'example' => 'inurl:admin'
    ],
    'intitle:' => [
        'name' => 'In Title',
        'description' => 'Search for terms in the page title',
        'example' => 'intitle:login'
    ],
    'intext:' => [
        'name' => 'In Text',
        'description' => 'Search for terms in the page content',
        'example' => 'intext:password'
    ],
    'filetype:' => [
        'name' => 'File Type',
        'description' => 'Search for specific file types',
        'example' => 'filetype:pdf'
    ],
    'ext:' => [
        'name' => 'Extension',
        'description' => 'Search by file extension',
        'example' => 'ext:pdf'
    ],
    
    // Advanced Operators
    'cache:' => [
        'name' => 'Cache',
        'description' => 'Show cached version of a page',
        'example' => 'cache:example.com'
    ],
    'link:' => [
        'name' => 'Link',
        'description' => 'Find pages linking to a URL',
        'example' => 'link:example.com'
    ],
    'related:' => [
        'name' => 'Related',
        'description' => 'Find sites related to a URL',
        'example' => 'related:example.com'
    ],
    'info:' => [
        'name' => 'Info',
        'description' => 'Get information about a URL',
        'example' => 'info:example.com'
    ],
    'define:' => [
        'name' => 'Define',
        'description' => 'Get definition of a term',
        'example' => 'define:cybersecurity'
    ],
    
    // Logical Operators
    'AND' => [
        'name' => 'AND',
        'description' => 'All terms must be present',
        'example' => 'admin AND login'
    ],
    'OR' => [
        'name' => 'OR',
        'description' => 'Either term can be present',
        'example' => 'admin OR administrator'
    ],
    'NOT' => [
        'name' => 'NOT',
        'description' => 'Exclude terms from results',
        'example' => 'admin NOT demo'
    ],
    '+' => [
        'name' => 'Plus',
        'description' => 'Term must be present',
        'example' => '+admin +login'
    ],
    '-' => [
        'name' => 'Minus',
        'description' => 'Exclude term from results',
        'example' => 'admin -demo'
    ],
    
    // Wildcard and Range Operators
    '*' => [
        'name' => 'Wildcard',
        'description' => 'Match any word or phrase',
        'example' => 'admin * panel'
    ],
    '..' => [
        'name' => 'Range',
        'description' => 'Search within a numeric range',
        'example' => '2020..2023'
    ],
    '"' => [
        'name' => 'Exact Match',
        'description' => 'Search for exact phrase',
        'example' => '"admin panel"'
    ],
    
    // Location and Geographic Operators
    'location:' => [
        'name' => 'Location',
        'description' => 'Search by geographic location',
        'example' => 'location:london'
    ],
    'near:' => [
        'name' => 'Near',
        'description' => 'Search near a location',
        'example' => 'restaurant near:paris'
    ],
    'weather:' => [
        'name' => 'Weather',
        'description' => 'Get weather information',
        'example' => 'weather:newyork'
    ],
    'map:' => [
        'name' => 'Map',
        'description' => 'Show map of location',
        'example' => 'map:tokyo'
    ],
    
    // Time-based Operators
    'after:' => [
        'name' => 'After Date',
        'description' => 'Content published after date',
        'example' => 'after:2023-01-01'
    ],
    'before:' => [
        'name' => 'Before Date',
        'description' => 'Content published before date',
        'example' => 'before:2023-12-31'
    ],
    'daterange:' => [
        'name' => 'Date Range',
        'description' => 'Content within date range',
        'example' => 'daterange:2023-01-01..2023-12-31'
    ],
    
    // Content-specific Operators
    'inanchor:' => [
        'name' => 'In Anchor',
        'description' => 'Search in link anchor text',
        'example' => 'inanchor:download'
    ],
    'allinanchor:' => [
        'name' => 'All In Anchor',
        'description' => 'All terms in anchor text',
        'example' => 'allinanchor:free download'
    ],
    'allintext:' => [
        'name' => 'All In Text',
        'description' => 'All terms in page text',
        'example' => 'allintext:admin login'
    ],
    'allintitle:' => [
        'name' => 'All In Title',
        'description' => 'All terms in page title',
        'example' => 'allintitle:admin panel'
    ],
    'allinurl:' => [
        'name' => 'All In URL',
        'description' => 'All terms in URL',
        'example' => 'allinurl:admin login'
    ],
    
    // Social Media Operators
    '@' => [
        'name' => 'Social Media',
        'description' => 'Search social media mentions',
        'example' => '@username'
    ],
    '#' => [
        'name' => 'Hashtag',
        'description' => 'Search hashtags',
        'example' => '#cybersecurity'
    ],
    
    // Specialized Operators
    'source:' => [
        'name' => 'Source',
        'description' => 'Search by news source',
        'example' => 'source:reuters'
    ],
    'stocks:' => [
        'name' => 'Stocks',
        'description' => 'Get stock information',
        'example' => 'stocks:aapl'
    ],
    'movie:' => [
        'name' => 'Movie',
        'description' => 'Get movie information',
        'example' => 'movie:inception'
    ],
    'book:' => [
        'name' => 'Book',
        'description' => 'Search for books',
        'example' => 'book:cybersecurity'
    ],
    'author:' => [
        'name' => 'Author',
        'description' => 'Search by author',
        'example' => 'author:"Bruce Schneier"'
    ],
    'publisher:' => [
        'name' => 'Publisher',
        'description' => 'Search by publisher',
        'example' => 'publisher:oreilly'
    ],
    
    // Technical Operators
    'insubject:' => [
        'name' => 'In Subject',
        'description' => 'Search email subjects',
        'example' => 'insubject:security'
    ],
    'group:' => [
        'name' => 'Group',
        'description' => 'Search newsgroups',
        'example' => 'group:security'
    ],
    'msgid:' => [
        'name' => 'Message ID',
        'description' => 'Search by message ID',
        'example' => 'msgid:12345'
    ],
    
    // Network and Security Operators
    'ip:' => [
        'name' => 'IP Address',
        'description' => 'Search by IP address',
        'example' => 'ip:192.168.1.1'
    ],
    'port:' => [
        'name' => 'Port',
        'description' => 'Search by port number',
        'example' => 'port:80'
    ],
    'hostname:' => [
        'name' => 'Hostname',
        'description' => 'Search by hostname',
        'example' => 'hostname:server'
    ],
    'ssl:' => [
        'name' => 'SSL',
        'description' => 'Search SSL certificates',
        'example' => 'ssl:example.com'
    ],
    'hash:' => [
        'name' => 'Hash',
        'description' => 'Search by file hash',
        'example' => 'hash:md5:abc123'
    ],
    
    // Database Operators
    'db:' => [
        'name' => 'Database',
        'description' => 'Search database content',
        'example' => 'db:users'
    ],
    'table:' => [
        'name' => 'Table',
        'description' => 'Search database tables',
        'example' => 'table:passwords'
    ],
    'schema:' => [
        'name' => 'Schema',
        'description' => 'Search database schemas',
        'example' => 'schema:public'
    ],
    
    // Additional Advanced Operators
    'define:' => [
        'name' => 'Define',
        'description' => 'Get definition of a term',
        'example' => 'define:cybersecurity'
    ],
    
    // Logical Operators
    'AND' => [
        'name' => 'AND',
        'description' => 'All terms must be present',
        'example' => 'admin AND login'
    ],
    'OR' => [
        'name' => 'OR',
        'description' => 'Either term can be present',
        'example' => 'admin OR administrator'
    ],
    'NOT' => [
        'name' => 'NOT',
        'description' => 'Exclude terms from results',
        'example' => 'admin NOT demo'
    ],
    '+' => [
        'name' => 'Plus',
        'description' => 'Term must be present',
        'example' => '+admin +login'
    ],
    '-' => [
        'name' => 'Minus',
        'description' => 'Exclude term from results',
        'example' => 'admin -demo'
    ],
    
    // Wildcard and Range Operators
    '*' => [
        'name' => 'Wildcard',
        'description' => 'Match any word or phrase',
        'example' => 'admin * panel'
    ],
    '..' => [
        'name' => 'Range',
        'description' => 'Search within a numeric range',
        'example' => '2020..2023'
    ],
    '"' => [
        'name' => 'Exact Match',
        'description' => 'Search for exact phrase',
        'example' => '"admin panel"'
    ],
    
    // Location and Geographic Operators
    'location:' => [
        'name' => 'Location',
        'description' => 'Search by geographic location',
        'example' => 'location:london'
    ],
    'near:' => [
        'name' => 'Near',
        'description' => 'Search near a location',
        'example' => 'restaurant near:paris'
    ],
    'weather:' => [
        'name' => 'Weather',
        'description' => 'Get weather information',
        'example' => 'weather:newyork'
    ],
    'map:' => [
        'name' => 'Map',
        'description' => 'Show map of location',
        'example' => 'map:tokyo'
    ],
    
    // Time-based Operators
    'after:' => [
        'name' => 'After Date',
        'description' => 'Content published after date',
        'example' => 'after:2023-01-01'
    ],
    'before:' => [
        'name' => 'Before Date',
        'description' => 'Content published before date',
        'example' => 'before:2023-12-31'
    ],
    'daterange:' => [
        'name' => 'Date Range',
        'description' => 'Content within date range',
        'example' => 'daterange:2023-01-01..2023-12-31'
    ],
    
    // Content-specific Operators
    'ext:' => [
        'name' => 'Extension',
        'description' => 'Search by file extension',
        'example' => 'ext:pdf'
    ],
    'inanchor:' => [
        'name' => 'In Anchor',
        'description' => 'Search in link anchor text',
        'example' => 'inanchor:download'
    ],
    'allinanchor:' => [
        'name' => 'All In Anchor',
        'description' => 'All terms in anchor text',
        'example' => 'allinanchor:free download'
    ],
    'allintext:' => [
        'name' => 'All In Text',
        'description' => 'All terms in page text',
        'example' => 'allintext:admin login'
    ],
    'allintitle:' => [
        'name' => 'All In Title',
        'description' => 'All terms in page title',
        'example' => 'allintitle:admin panel'
    ],
    'allinurl:' => [
        'name' => 'All In URL',
        'description' => 'All terms in URL',
        'example' => 'allinurl:admin login'
    ],
    
    // Social Media Operators
    '@' => [
        'name' => 'Social Media',
        'description' => 'Search social media mentions',
        'example' => '@username'
    ],
    '#' => [
        'name' => 'Hashtag',
        'description' => 'Search hashtags',
        'example' => '#cybersecurity'
    ],
    
    // Specialized Operators
    'source:' => [
        'name' => 'Source',
        'description' => 'Search by news source',
        'example' => 'source:reuters'
    ],
    'stocks:' => [
        'name' => 'Stocks',
        'description' => 'Get stock information',
        'example' => 'stocks:aapl'
    ],
    'movie:' => [
        'name' => 'Movie',
        'description' => 'Get movie information',
        'example' => 'movie:inception'
    ],
    'book:' => [
        'name' => 'Book',
        'description' => 'Search for books',
        'example' => 'book:cybersecurity'
    ],
    'author:' => [
        'name' => 'Author',
        'description' => 'Search by author',
        'example' => 'author:"Bruce Schneier"'
    ],
    'publisher:' => [
        'name' => 'Publisher',
        'description' => 'Search by publisher',
        'example' => 'publisher:oreilly'
    ],
    
    // Technical Operators
    'insubject:' => [
        'name' => 'In Subject',
        'description' => 'Search email subjects',
        'example' => 'insubject:security'
    ],
    'group:' => [
        'name' => 'Group',
        'description' => 'Search newsgroups',
        'example' => 'group:security'
    ],
    'msgid:' => [
        'name' => 'Message ID',
        'description' => 'Search by message ID',
        'example' => 'msgid:12345'
    ],
    
    // Network and Security Operators
    'ip:' => [
        'name' => 'IP Address',
        'description' => 'Search by IP address',
        'example' => 'ip:192.168.1.1'
    ],
    'port:' => [
        'name' => 'Port',
        'description' => 'Search by port number',
        'example' => 'port:80'
    ],
    'hostname:' => [
        'name' => 'Hostname',
        'description' => 'Search by hostname',
        'example' => 'hostname:server'
    ],
    'ssl:' => [
        'name' => 'SSL',
        'description' => 'Search SSL certificates',
        'example' => 'ssl:example.com'
    ],
    'hash:' => [
        'name' => 'Hash',
        'description' => 'Search by file hash',
        'example' => 'hash:md5:abc123'
    ],
    
    // Database Operators
    'db:' => [
        'name' => 'Database',
        'description' => 'Search database content',
        'example' => 'db:users'
    ],
    'table:' => [
        'name' => 'Table',
        'description' => 'Search database tables',
        'example' => 'table:passwords'
    ],
    'schema:' => [
        'name' => 'Schema',
        'description' => 'Search database schemas',
        'example' => 'schema:public'
    ],
    
    // Additional Advanced Operators
    'define:' => [
        'name' => 'Define',
        'description' => 'Get definition of a term',
        'example' => 'define:cybersecurity'
    ],
    
    // Logical Operators
    'AND' => [
        'name' => 'AND',
        'description' => 'All terms must be present',
        'example' => 'admin AND login'
    ],
    'OR' => [
        'name' => 'OR',
        'description' => 'Either term can be present',
        'example' => 'admin OR administrator'
    ],
    'NOT' => [
        'name' => 'NOT',
        'description' => 'Exclude terms from results',
        'example' => 'admin NOT demo'
    ],
    '+' => [
        'name' => 'Plus',
        'description' => 'Term must be present',
        'example' => '+admin +login'
    ],
    '-' => [
        'name' => 'Minus',
        'description' => 'Exclude term from results',
        'example' => 'admin -demo'
    ],
    
    // Wildcard and Range Operators
    '*' => [
        'name' => 'Wildcard',
        'description' => 'Match any word or phrase',
        'example' => 'admin * panel'
    ],
    '..' => [
        'name' => 'Range',
        'description' => 'Search within a numeric range',
        'example' => '2020..2023'
    ],
    '"' => [
        'name' => 'Exact Match',
        'description' => 'Search for exact phrase',
        'example' => '"admin panel"'
    ],
    
    // Location and Geographic Operators
    'location:' => [
        'name' => 'Location',
        'description' => 'Search by geographic location',
        'example' => 'location:london'
    ],
    'near:' => [
        'name' => 'Near',
        'description' => 'Search near a location',
        'example' => 'restaurant near:paris'
    ],
    'weather:' => [
        'name' => 'Weather',
        'description' => 'Get weather information',
        'example' => 'weather:newyork'
    ],
    'map:' => [
        'name' => 'Map',
        'description' => 'Show map of location',
        'example' => 'map:tokyo'
    ],
    
    // Time-based Operators
    'after:' => [
        'name' => 'After Date',
        'description' => 'Content published after date',
        'example' => 'after:2023-01-01'
    ],
    'before:' => [
        'name' => 'Before Date',
        'description' => 'Content published before date',
        'example' => 'before:2023-12-31'
    ],
    'daterange:' => [
        'name' => 'Date Range',
        'description' => 'Content within date range',
        'example' => 'daterange:2023-01-01..2023-12-31'
    ],
    
    // Content-specific Operators
    'ext:' => [
        'name' => 'Extension',
        'description' => 'Search by file extension',
        'example' => 'ext:pdf'
    ],
    'inanchor:' => [
        'name' => 'In Anchor',
        'description' => 'Search in link anchor text',
        'example' => 'inanchor:download'
    ],
    'allinanchor:' => [
        'name' => 'All In Anchor',
        'description' => 'All terms in anchor text',
        'example' => 'allinanchor:free download'
    ],
    'allintext:' => [
        'name' => 'All In Text',
        'description' => 'All terms in page text',
        'example' => 'allintext:admin login'
    ],
    'allintitle:' => [
        'name' => 'All In Title',
        'description' => 'All terms in page title',
        'example' => 'allintitle:admin panel'
    ],
    'allinurl:' => [
        'name' => 'All In URL',
        'description' => 'All terms in URL',
        'example' => 'allinurl:admin login'
    ],
    
    // Social Media Operators
    '@' => [
        'name' => 'Social Media',
        'description' => 'Search social media mentions',
        'example' => '@username'
    ],
    '#' => [
        'name' => 'Hashtag',
        'description' => 'Search hashtags',
        'example' => '#cybersecurity'
    ],
    
    // Specialized Operators
    'source:' => [
        'name' => 'Source',
        'description' => 'Search by news source',
        'example' => 'source:reuters'
    ],
    'stocks:' => [
        'name' => 'Stocks',
        'description' => 'Get stock information',
        'example' => 'stocks:aapl'
    ],
    'movie:' => [
        'name' => 'Movie',
        'description' => 'Get movie information',
        'example' => 'movie:inception'
    ],
    'book:' => [
        'name' => 'Book',
        'description' => 'Search for books',
        'example' => 'book:cybersecurity'
    ],
    'author:' => [
        'name' => 'Author',
        'description' => 'Search by author',
        'example' => 'author:"Bruce Schneier"'
    ],
    'publisher:' => [
        'name' => 'Publisher',
        'description' => 'Search by publisher',
        'example' => 'publisher:oreilly'
    ],
    
    // Technical Operators
    'insubject:' => [
        'name' => 'In Subject',
        'description' => 'Search email subjects',
        'example' => 'insubject:security'
    ],
    'group:' => [
        'name' => 'Group',
        'description' => 'Search newsgroups',
        'example' => 'group:security'
    ],
    'msgid:' => [
        'name' => 'Message ID',
        'description' => 'Search by message ID',
        'example' => 'msgid:12345'
    ],
    
    // Network and Security Operators
    'ip:' => [
        'name' => 'IP Address',
        'description' => 'Search by IP address',
        'example' => 'ip:192.168.1.1'
    ],
    'port:' => [
        'name' => 'Port',
        'description' => 'Search by port number',
        'example' => 'port:80'
    ],
    'hostname:' => [
        'name' => 'Hostname',
        'description' => 'Search by hostname',
        'example' => 'hostname:server'
    ],
    'ssl:' => [
        'name' => 'SSL',
        'description' => 'Search SSL certificates',
        'example' => 'ssl:example.com'
    ],
    'hash:' => [
        'name' => 'Hash',
        'description' => 'Search by file hash',
        'example' => 'hash:md5:abc123'
    ],
    
    // Database Operators
    'db:' => [
        'name' => 'Database',
        'description' => 'Search database content',
        'example' => 'db:users'
    ],
    'table:' => [
        'name' => 'Table',
        'description' => 'Search database tables',
        'example' => 'table:passwords'
    ],
    'schema:' => [
        'name' => 'Schema',
        'description' => 'Search database schemas',
        'example' => 'schema:public'
    ],
    
    // Additional Advanced Operators
    'define:' => [
        'name' => 'Define',
        'description' => 'Get definition of a term',
        'example' => 'define:cybersecurity'
    ],
    
    // Logical Operators
    'AND' => [
        'name' => 'AND',
        'description' => 'All terms must be present',
        'example' => 'admin AND login'
    ],
    'OR' => [
        'name' => 'OR',
        'description' => 'Either term can be present',
        'example' => 'admin OR administrator'
    ],
    'NOT' => [
        'name' => 'NOT',
        'description' => 'Exclude terms from results',
        'example' => 'admin NOT demo'
    ],
    '+' => [
        'name' => 'Plus',
        'description' => 'Term must be present',
        'example' => '+admin +login'
    ],
    '-' => [
        'name' => 'Minus',
        'description' => 'Exclude term from results',
        'example' => 'admin -demo'
    ],
    
    // Wildcard and Range Operators
    '*' => [
        'name' => 'Wildcard',
        'description' => 'Match any word or phrase',
        'example' => 'admin * panel'
    ],
    '..' => [
        'name' => 'Range',
        'description' => 'Search within a numeric range',
        'example' => '2020..2023'
    ],
    '"' => [
        'name' => 'Exact Match',
        'description' => 'Search for exact phrase',
        'example' => '"admin panel"'
    ],
    
    // Location and Geographic Operators
    'location:' => [
        'name' => 'Location',
        'description' => 'Search by geographic location',
        'example' => 'location:london'
    ],
    'near:' => [
        'name' => 'Near',
        'description' => 'Search near a location',
        'example' => 'restaurant near:paris'
    ],
    'weather:' => [
        'name' => 'Weather',
        'description' => 'Get weather information',
        'example' => 'weather:newyork'
    ],
    'map:' => [
        'name' => 'Map',
        'description' => 'Show map of location',
        'example' => 'map:tokyo'
    ],
    
    // Time-based Operators
    'after:' => [
        'name' => 'After Date',
        'description' => 'Content published after date',
        'example' => 'after:2023-01-01'
    ],
    'before:' => [
        'name' => 'Before Date',
        'description' => 'Content published before date',
        'example' => 'before:2023-12-31'
    ],
    'daterange:' => [
        'name' => 'Date Range',
        'description' => 'Content within date range',
        'example' => 'daterange:2023-01-01..2023-12-31'
    ],
    
    // Content-specific Operators
    'ext:' => [
        'name' => 'Extension',
        'description' => 'Search by file extension',
        'example' => 'ext:pdf'
    ],
    'inanchor:' => [
        'name' => 'In Anchor',
        'description' => 'Search in link anchor text',
        'example' => 'inanchor:download'
    ],
    'allinanchor:' => [
        'name' => 'All In Anchor',
        'description' => 'All terms in anchor text',
        'example' => 'allinanchor:free download'
    ],
    'allintext:' => [
        'name' => 'All In Text',
        'description' => 'All terms in page text',
        'example' => 'allintext:admin login'
    ],
    'allintitle:' => [
        'name' => 'All In Title',
        'description' => 'All terms in page title',
        'example' => 'allintitle:admin panel'
    ],
    'allinurl:' => [
        'name' => 'All In URL',
        'description' => 'All terms in URL',
        'example' => 'allinurl:admin login'
    ],
    
    // Social Media Operators
    '@' => [
        'name' => 'Social Media',
        'description' => 'Search social media mentions',
        'example' => '@username'
    ],
    '#' => [
        'name' => 'Hashtag',
        'description' => 'Search hashtags',
        'example' => '#cybersecurity'
    ],
    
    // Specialized Operators
    'source:' => [
        'name' => 'Source',
        'description' => 'Search by news source',
        'example' => 'source:reuters'
    ],
    'stocks:' => [
        'name' => 'Stocks',
        'description' => 'Get stock information',
        'example' => 'stocks:aapl'
    ],
    'movie:' => [
        'name' => 'Movie',
        'description' => 'Get movie information',
        'example' => 'movie:inception'
    ],
    'book:' => [
        'name' => 'Book',
        'description' => 'Search for books',
        'example' => 'book:cybersecurity'
    ],
    'author:' => [
        'name' => 'Author',
        'description' => 'Search by author',
        'example' => 'author:"Bruce Schneier"'
    ],
    'publisher:' => [
        'name' => 'Publisher',
        'description' => 'Search by publisher',
        'example' => 'publisher:oreilly'
    ],
    
    // Technical Operators
    'insubject:' => [
        'name' => 'In Subject',
        'description' => 'Search email subjects',
        'example' => 'insubject:security'
    ],
    'group:' => [
        'name' => 'Group',
        'description' => 'Search newsgroups',
        'example' => 'group:security'
    ],
    'msgid:' => [
        'name' => 'Message ID',
        'description' => 'Search by message ID',
        'example' => 'msgid:12345'
    ],
    
    // Network and Security Operators
    'ip:' => [
        'name' => 'IP Address',
        'description' => 'Search by IP address',
        'example' => 'ip:192.168.1.1'
    ],
    'port:' => [
        'name' => 'Port',
        'description' => 'Search by port number',
        'example' => 'port:80'
    ],
    'hostname:' => [
        'name' => 'Hostname',
        'description' => 'Search by hostname',
        'example' => 'hostname:server'
    ],
    'ssl:' => [
        'name' => 'SSL',
        'description' => 'Search SSL certificates',
        'example' => 'ssl:example.com'
    ],
    'hash:' => [
        'name' => 'Hash',
        'description' => 'Search by file hash',
        'example' => 'hash:md5:abc123'
    ],
    
    // Database Operators
    'db:' => [
        'name' => 'Database',
        'description' => 'Search database content',
        'example' => 'db:users'
    ],
    'table:' => [
        'name' => 'Table',
        'description' => 'Search database tables',
        'example' => 'table:passwords'
    ],
    'schema:' => [
        'name' => 'Schema',
        'description' => 'Search database schemas',
        'example' => 'schema:public'
    ]
];
?>