# 🎓 Githunguri Bridgeway Preparatory School Website

A comprehensive, modern website solution for **Githunguri Bridgeway Preparatory School** - Building Bright Futures with Strong Foundations.

![School Website](assets/images/githunguri_bridgewaylogo.jpeg)

## 📍 Repository Information

**GitHub Repository:** [https://github.com/kb-diplo/ggbridgeway.git](https://github.com/kb-diplo/ggbridgeway.git)  
**Clone URL:** `git clone https://github.com/kb-diplo/ggbridgeway.git`  
**Developer:** kb-diplo  
**License:** Exclusive License (See LICENSE file)

## 🌟 About the School

**Githunguri Bridgeway Preparatory School** is a quality primary education institution located in Githunguri, Kiambu County, Kenya. We are committed to providing excellent education following the KCPE curriculum while instilling strong values of excellence and integrity in our students.

**School Motto:** *Excellence and Integrity - Lead with Values*

## 🚀 Website Features

### 📱 **Modern & Responsive Design**
- Mobile-first responsive layout
- Beautiful gradient color scheme (Navy Blue & Maroon)
- Professional typography and animations
- Bootstrap 5 framework for consistency

### 🎛️ **Complete Admin Management System**
- **Dashboard** - Overview and analytics
- **Enhanced Content Manager** - Edit all website text and information
- **Banner Management** - Homepage slider with school images
- **Events System** - School activities and calendar management
- **Photo Gallery** - School photos and memories management
- **Notices System** - Important announcements
- **Leadership Management** - Staff and administration profiles
- **Settings** - Social media, contact info, school details
- **Messages** - Contact form submissions
- **User Management** - Admin accounts and permissions

### 📄 **Website Pages**
- **Homepage** - Hero section with school statistics
- **About Us** - School history, mission, vision, leadership
- **Academics** - KCPE curriculum and educational approach
- **Admissions** - Enrollment process and requirements
- **Student Life** - Events, activities, and school culture
- **Careers** - Job opportunities and applications
- **Contact** - Location, contact details, and inquiry form

### 🔧 **Technical Features**
- **PHP Backend** - Secure server-side processing
- **MySQL Database** - Reliable data storage
- **Security** - Input sanitization and SQL injection prevention
- **SEO Optimized** - Search engine friendly URLs and meta tags
- **Cookie Compliance** - GDPR-compliant cookie consent
- **Performance** - Optimized loading and caching

## 📍 School Location

**Address:** Githunguri, Kiambu County, Kenya  
**Landmark:** Behind Githunguri Holy Family Catholic Church  
**Contact:** +254 20 3318581  

## 🛠️ Installation & Setup

### Prerequisites
- **PHP 7.4+** (Recommended: PHP 8.0+)
- **MySQL 5.7+** or **MariaDB 10.2+**
- **Web Server** (Apache/Nginx)
- **Modern Browser** for admin panel

### Quick Setup
1. **Clone Repository** 
   ```bash
   git clone https://github.com/kb-diplo/ggbridgeway.git
   cd ggbridgeway
   ```
2. **Upload** to your web server directory
3. **Create MySQL Database** for the school website
4. **Configure Database** - Copy `includes/config.example.php` to `includes/config.php` and update with your details
5. **First Visit** - Auto-initialization will set up everything
6. **Access Admin** - Visit `yoursite.com/custom-admin.php`

### Database Configuration
```php
// Copy includes/config.example.php to includes/config.php
// Update with your database credentials (NEVER commit config.php)
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### ⚠️ **SECURITY WARNING**
- **NEVER commit `includes/config.php`** - Contains sensitive database credentials
- **Always use `config.example.php`** as template for new installations
- **Database credentials are excluded** from version control via .gitignore

## 🔐 Admin Access

**Custom Admin URL:** `yoursite.com/custom-admin.php`  
**Initial Setup:** First visit creates default admin account automatically
**Security Note:** Change default credentials immediately after installation.

## 🎨 Customization

### School Branding
- **Logo:** Replace `assets/images/githunguri_bridgewaylogo.jpeg`
- **Colors:** Modify CSS variables in `assets/css/style.css`
- **Content:** All text editable through Enhanced Content Manager

### Adding Content
- **School Photos:** Upload through Gallery management
- **Events:** Add through Events management
- **Notices:** Create through Notices system
- **Staff:** Manage through Leadership section

## 📊 Statistics & Analytics

The website tracks:
- Student enrollment (Currently: ~40 students)
- Qualified teachers (8 professional educators)
- Success rate (95% KCPE performance)
- Years of experience (5+ years of excellence)

## 🔒 Security Features & Best Practices

### 🛡️ **Application Security**
- **Input Sanitization** - All user inputs are cleaned and validated
- **SQL Injection Prevention** - PDO prepared statements used throughout
- **XSS Protection** - Output encoding with `htmlspecialchars()`
- **Session Security** - Secure admin authentication with proper session management
- **File Upload Security** - Restricted file types and validation
- **Password Hashing** - PHP's `password_hash()` with strong algorithms

### 🔐 **Repository Security (Git Guardian Compliant)**
- **No Hardcoded Credentials** - All sensitive data in config files
- **Comprehensive .gitignore** - Prevents accidental credential commits
- **Config Template System** - `config.example.php` for safe distribution
- **Environment Separation** - Development files excluded from production
- **Database Security** - Credentials never committed to version control

### ⚠️ **Critical Security Warnings**

**NEVER COMMIT THESE FILES:**
```
includes/config.php          # Contains database credentials
.env files                   # Environment variables
uploads/ directory           # User uploaded content
*.log files                  # May contain sensitive information
backup_*.sql                 # Database dumps with data
*config_production.php       # Production configurations
DEPLOYMENT_GUIDE.md          # Host-specific deployment info
```

**ALWAYS:**
- Use `config.example.php` as template
- Change default admin credentials immediately
- Keep `.gitignore` updated
- Review commits before pushing
- Use environment variables for production secrets

## 📱 Mobile Optimization

- Responsive design for all screen sizes
- Touch-friendly navigation
- Optimized images for mobile data
- Fast loading on mobile networks

## 🌐 SEO & Performance

- **Meta Tags** - Proper page titles and descriptions
- **Schema Markup** - Structured data for search engines
- **Image Optimization** - Compressed images for fast loading
- **Clean URLs** - SEO-friendly page structure

## 🎯 Target Audience

- **Parents** - Seeking quality primary education
- **Students** - Current and prospective learners
- **Community** - Local Githunguri residents
- **Educators** - Teaching professionals

## 📞 Support & Contact

**School Contact:**
- **Phone:** +254 20 3318581 (Voice & WhatsApp)
- **Location:** Githunguri, Kiambu County
- **Landmark:** Behind Githunguri Holy Family Catholic Church

**Technical Support:**
- **Website Issues:** Contact through admin panel
- **Updates:** Managed through admin system

## 🔄 Updates & Maintenance

- **Content Updates:** Real-time through Enhanced Content Manager
- **Security Updates:** Regular PHP and database maintenance
- **Feature Additions:** Expandable architecture
- **Backup:** Regular database and file backups recommended

## 📈 Future Enhancements

- Online fee payment system
- Student portal for grades and assignments
- Parent communication system
- Mobile app development
- Advanced analytics and reporting

## 🏆 Why Choose This Website Solution

- **School-Specific Design** - Built specifically for educational institutions
- **Easy Management** - Non-technical staff can update content
- **Professional Appearance** - Builds trust with parents and community
- **Mobile-Ready** - Accessible to all users
- **Secure & Reliable** - Protects school and user data
- **Cost-Effective** - One-time setup with ongoing admin control

## 🔧 Technical Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL with PDO
- **Frontend**: HTML5, CSS3, JavaScript (ES6)
- **Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Poppins)

## 📄 License

This project is created for educational purposes. See LICENSE file for details.

## 🎯 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

---

**Built with ❤️ for Githunguri Bridgeway Preparatory School**

*Excellence and Integrity - Lead with Values*
