# Advanced Dork Search Generator

A comprehensive, modular Google Dorking tool for security researchers, penetration testers, and ethical hackers. This professional web application generates sophisticated search queries (dorks) to find potentially vulnerable systems, exposed files, and sensitive information across the internet.

## ⚠️ Legal Disclaimer

**This tool is for educational and authorized security research purposes only.**

- Only use on systems you own or have explicit permission to test
- Unauthorized access to computer systems is illegal
- Users are responsible for complying with all applicable laws and regulations
- The developers are not responsible for misuse of this tool

## 🚀 Features

### Comprehensive Dork Categories
- **Admin Panels & Login Pages**: Administrative interfaces and authentication portals
- **Cloud Storage & Buckets**: AWS S3, Google Cloud, Azure storage buckets
- **API Endpoints & Documentation**: REST APIs, GraphQL, and API documentation
- **Network Devices & IoT**: Routers, switches, IoT devices, and network equipment
- **Git Repositories & Source Code**: Exposed Git repositories and source code
- **Database Files & Interfaces**: SQL dumps, database interfaces, and connection strings
- **Configuration Files**: Server configs, application settings, and environment files
- **Log Files & Error Pages**: Server logs, error logs, and debug information
- **Backup Files & Archives**: Database backups, file archives, and compressed files
- **Vulnerable Applications**: Known vulnerable web applications and frameworks

### Advanced Operator Support
- **Basic Operators**: site:, inurl:, intitle:, intext:, filetype:, ext:
- **Logical Operators**: AND, OR, NOT, +, - (plus/minus)
- **Wildcard & Range**: *, .., "exact match"
- **Content-Specific**: inanchor:, allinanchor:, allintext:, allintitle:, allinurl:
- **Time-Based**: after:, before:, daterange:
- **Location & Geographic**: location:, near:, weather:, map:
- **Social Media**: @username, #hashtag
- **Specialized**: source:, stocks:, movie:, book:, author:, publisher:
- **Technical**: insubject:, group:, msgid:
- **Network & Security**: ip:, port:, hostname:, ssl:, hash:
- **Database**: db:, table:, schema:

### Enhanced User Experience
- **Smooth Scrolling**: Automatically scroll to results after generation
- **Visual Feedback**: Highlight animations for generated results
- **Custom Search Terms**: Add specific keywords to dorks
- **Target Site Filtering**: Focus searches on specific domains
- **File Type Filtering**: Search for specific file extensions
- **Multiple Search Engines**: Google, Bing, DuckDuckGo, Yandex, and Baidu integration
- **One-Click Copy**: Copy generated dorks to clipboard
- **Export Functionality**: Save dorks to text files
- **Random Dork Generation**: Generate random dorks for exploration
- **Responsive Design**: Works on desktop and mobile devices
- **Dark Mode Support**: Automatic dark theme detection
- **Keyboard Shortcuts**: Efficient navigation and operation
- **Loading States**: Visual feedback during dork generation
## 🏗️ Architecture

### Modular Design
The application follows a clean, modular architecture for maintainability and scalability:

```
Dork-Promt-Gen/
├── index.php              # Main application file
├── config.php             # Application configuration
├── styles.css             # Complete CSS styling
├── script.js              # Interactive JavaScript features
├── data/                  # Modular data files
│   ├── dork_categories.php   # Dork categories and patterns
│   ├── operators.php         # Search operators definitions
│   ├── search_modes.php      # Search mode configurations
│   ├── threat_levels.php     # Risk level definitions
│   └── advanced_options.php  # Advanced search options
└── README.md              # Documentation
```

### Key Components
- **Frontend**: Modern HTML5, CSS3 with Grid/Flexbox, vanilla JavaScript
- **Backend**: PHP 8.x with clean separation of concerns
- **Data Layer**: Modular PHP arrays for easy maintenance and extension
- **Styling**: CSS custom properties for theming, responsive design
- **JavaScript**: ES6+ features, event delegation, modern APIs

## 🛠️ Installation & Deployment

### Requirements
- Docker Engine 20.10+
- Docker Compose 2.0+ or Portainer CE/EE
- 2GB+ RAM recommended
- Port 80 (and optionally 443 for HTTPS) available

### 🐳 Portainer Deployment (Recommended)

**Easiest way to deploy with GUI management:**

1. **Access Portainer** (typically at `http://your-server:9000`)

2. **Create New Stack**:
   - Navigate to **Stacks** → **+ Add stack**
   - Name: `dork-generator`
   - Choose build method:
     - **Web editor**: Copy/paste docker-compose.yml
     - **Repository**: Connect to Git repo
     - **Upload**: Upload docker-compose.yml file

3. **Deploy**: Click "Deploy the stack"

4. **Access**: Open `http://your-server:80`

**See [DOCKER.md](DOCKER.md) for complete Portainer guide including:**
- Step-by-step deployment instructions
- Git repository integration
- Auto-update configuration
- Container management
- Troubleshooting guide

### 🚀 Command Line Deployment

#### Quick Start with Docker
```bash
# Clone repository
git clone https://github.com/yourusername/dork-search-generator.git
cd dork-search-generator

# Deploy with one command
chmod +x docker-deploy.sh
./docker-deploy.sh deploy

# Access at http://localhost
```

#### Manual Docker Compose
```bash
# Build and start
docker-compose up -d --build

# Check status
docker-compose ps

# View logs
docker-compose logs -f

# Stop
docker-compose down
```

### 📚 Complete Documentation
- **[DOCKER.md](DOCKER.md)** - Full Docker & Portainer deployment guide
  - Portainer stack configuration
  - Environment variables
  - SSL/HTTPS setup
  - Monitoring and logging
  - Backup and restore
  - Troubleshooting

## 📖 Usage Guide

### Basic Usage
1. Select a dork category from the dropdown menu
2. Optionally add custom terms, target sites, or file types
3. Choose an advanced operator if needed
4. Click "Generate Dork" to create your search query
5. Use the provided buttons to search on different engines

### Advanced Features
- **Keyboard Shortcuts**:
  - `Ctrl/Cmd + Enter`: Submit form
  - `Escape`: Clear form
  - `Ctrl/Cmd + C`: Copy dork (when focused on result)

- **Context Menu**: Right-click on generated dorks for additional options

- **Random Generation**: Use the "Random Dork" button for exploration

### Example Dorks Generated
```
# Admin panel discovery
inurl:admin site:example.com

# Database file hunting
filetype:sql "password" "username"

# Configuration exposure
filetype:conf "mysql" "password"

# Vulnerable file detection
inurl:shell.php OR inurl:cmd.php

# Document leakage
filetype:pdf "confidential" site:company.com
```

## 🔧 Customization & Extension

### Adding New Dork Categories
Edit `data/dork_categories.php` and add to the array:

```php
'new_category' => [
    'name' => 'Category Display Name',
    'icon' => 'fas fa-icon-name',
    'description' => 'Description of the category',
    'dorks' => [
        'your dork pattern 1',
        'your dork pattern 2',
        'inurl:specific-path',
        'filetype:ext "keyword"',
        // ... more dork patterns
    ]
]
```

### Adding Search Operators
Update `data/operators.php` to add new operators:

```php
'new_operator:' => [
    'name' => 'Operator Name',
    'description' => 'What this operator does',
    'example' => 'new_operator:example'
]
```

### Modifying Search Modes
Edit `data/search_modes.php` for different search behaviors:

```php
'new_mode' => [
    'name' => 'Mode Name',
    'description' => 'Mode description',
    'operators' => ['site:', 'inurl:', 'filetype:']
]
```

### Styling Customization
The application uses CSS custom properties for easy theming:

```css
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --accent-color: #ffd700;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
}
```

### JavaScript Extensions
Add new features in `script.js`:

```javascript
// Custom notification types
showNotification('Message', 'custom-type');

// Additional keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.key === 'n') {
        // Custom shortcut functionality
    }
});

// Custom form validators
function customValidator(form) {
    // Your validation logic
    return true;
}
```

## 🎯 Professional Use Cases

### Penetration Testing
- Reconnaissance phase information gathering
- Identifying potential attack vectors
- Discovering exposed administrative interfaces
- Finding configuration files with credentials

### Security Auditing
- Assessing organizational data exposure
- Identifying sensitive document leakage
- Discovering unsecured network devices
- Evaluating web application security

### Bug Bounty Hunting
- Finding exposed endpoints and files
- Discovering forgotten test environments
- Locating backup files and databases
- Identifying vulnerable web applications

### Red Team Operations
- Intelligence gathering on targets
- Finding lateral movement opportunities
- Discovering credential sources
- Mapping organizational infrastructure

## 🛡️ Security Considerations

### Responsible Usage
- Always obtain proper authorization before testing
- Document and report findings appropriately
- Follow responsible disclosure practices
- Respect rate limits and terms of service

### Privacy Protection
- Clear browser history after sensitive searches
- Use VPN or Tor for anonymity when appropriate
- Be aware of search engine logging
- Consider using alternative search engines

## 📱 Browser Support

- ✅ Chrome 80+
- ✅ Firefox 75+
- ✅ Safari 13+
- ✅ Edge 80+
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

### Development Setup
```bash
# Install development dependencies (if any)
npm install  # if using Node.js tools

# Start development server
php -S localhost:8000
```

## 📝 Changelog

### Version 2.0.0 (Latest)
- ✅ **Modular Architecture**: Separated data into individual files for maintainability
- ✅ **Enhanced Operators**: Added 50+ new search operators including logical, geographic, and security-focused ones
- ✅ **Improved UX**: Auto-scroll to results, smooth animations, visual feedback
- ✅ **Expanded Categories**: Added Cloud Storage, API Endpoints, Network Devices, Git Repositories
- ✅ **Better Error Handling**: Fixed session management and PHP warnings
- ✅ **Professional Styling**: Enhanced CSS with modern design patterns
- ✅ **Performance Optimizations**: Optimized JavaScript and CSS loading

### Version 1.5.0
- ✅ **Advanced Form Features**: Multi-step form with validation
- ✅ **Export Capabilities**: Save dorks to various formats
- ✅ **Keyboard Shortcuts**: Full keyboard navigation support
- ✅ **Mobile Optimization**: Improved responsive design
- ✅ **Dark Mode**: Automatic theme detection and switching

### Version 1.0.0
- ✅ Initial release with basic dork generation
- ✅ Multiple category support
- ✅ Responsive design foundation
- ✅ Basic search engine integration

### Planned Features (Roadmap)
- [ ] **API Integration**: RESTful API for automation and integration
- [ ] **Dork Validation**: Real-time testing of generated dorks
- [ ] **Result Preview**: Live preview of search results
- [ ] **Bulk Generation**: Generate multiple dorks simultaneously
- [ ] **User Accounts**: Save preferences and dork collections
- [ ] **Advanced Analytics**: Dork effectiveness tracking
- [ ] **Security Scanning**: Integration with vulnerability scanners
- [ ] **Custom Templates**: User-defined dork templates
- [ ] **Database Integration**: Store and manage large dork collections
- [ ] **Collaborative Features**: Share and rate dorks with community

## 🔍 Technical Specifications

### Backend (PHP)
- **PHP Version**: 8.0+ (optimized for 8.2)
- **Coding Standards**: PSR-12 compliant
- **Security**: Input sanitization, XSS protection, CSRF prevention
- **Session Management**: Secure session handling
- **Error Handling**: Comprehensive error reporting and logging

### Frontend (HTML/CSS/JavaScript)
- **HTML**: Semantic HTML5 with accessibility features
- **CSS**: Modern CSS3 with Grid, Flexbox, and custom properties
- **JavaScript**: ES6+ with modern APIs (Clipboard, Intersection Observer)
- **Responsive**: Mobile-first design with breakpoints
- **Performance**: Optimized loading and rendering

### Data Structure
- **Modular Design**: Separated data files for scalability
- **Categorized Dorks**: Over 500 pre-built dork patterns
- **Operator Library**: 60+ search operators with examples
- **Extensible**: Easy to add new categories and operators

### Browser Compatibility
- ✅ Chrome 90+ (Recommended)
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+
- ✅ Mobile browsers (iOS Safari 14+, Chrome Mobile 90+)

## 🆘 Troubleshooting

### Common Issues & Solutions

#### PHP Errors
**"Headers already sent" error**
```bash
# Check for whitespace after <?php tags
# Ensure no output before session_start()
# Verify all data files end properly with ?>
```

**"Parse error" or syntax errors**
```bash
# Check PHP syntax
php -l index.php
php -l data/dork_categories.php

# Verify PHP version
php --version
```

#### JavaScript Issues
**Form not submitting or scrolling not working**
```javascript
// Check browser console for errors
// Verify script.js is loading
// Ensure JavaScript is enabled
```

**Copy to clipboard not working**
```javascript
// Requires HTTPS for clipboard API
// Fallback methods available for HTTP
// Check browser permissions
```

#### Styling Issues
**CSS not loading or broken layout**
```css
/* Clear browser cache */
/* Check file paths in HTML */
/* Verify CSS file permissions */
/* Check for CSS syntax errors */
```

#### Performance Issues
**Slow loading times**
```
- Enable gzip compression on server
- Optimize images and assets
- Use browser caching headers
- Consider CDN for static assets
```

### Development Debugging
```bash
# Enable PHP error reporting
echo "display_errors = On" >> php.ini
echo "error_reporting = E_ALL" >> php.ini

# Check error logs
tail -f /var/log/php_errors.log

# Validate HTML
# Use W3C HTML Validator

# Test JavaScript
# Use browser developer tools
```

## 📞 Support

For support, bug reports, or feature requests:
- Open an issue on GitHub
- Contact: [your-email@example.com]
- Documentation: [link to docs]

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Google for providing the search operators
- Security research community for dork patterns
- Open source contributors and testers
- Ethical hacking community for feedback

## ⚡ Performance Tips

- Use specific operators to narrow search results
- Combine multiple operators for precision
- Test dorks on smaller domains first
- Use rate limiting to avoid being blocked
- Cache results when possible

---

**Remember**: With great power comes great responsibility. Use this tool ethically and legally.

Created with ❤️ for the security research community.
