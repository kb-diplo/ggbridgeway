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
- **Content Management** - Edit all website text and information
- **Banner Management** - Homepage slider with school images
- **Events System** - School activities and calendar
- **Photo Gallery** - School photos and memories
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
- **Gallery** - School photos and event memories

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
- **PHP 7.0+** (Recommended: PHP 8.0+)
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
6. **Access Admin** - Visit `yoursite.com/custom-admin.php` (admin/admin123)

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
**Default Credentials:**
- Username: `admin`
- Password: `admin123`

**Security Note:** Change default credentials immediately after installation.

## 🎨 Customization

### School Branding
- **Logo:** Replace `assets/images/githunguri_bridgewaylogo.jpeg`
- **Colors:** Modify CSS variables in `assets/css/style.css`
- **Content:** All text editable through admin panel

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
```

**ALWAYS:**
- Use `config.example.php` as template
- Change default admin credentials immediately
- Keep `.gitignore` updated
- Review commits before pushing
- Use environment variables for production secrets

### 🔍 **Git Guardian Protection**
This repository is configured to prevent common security issues:
- Database credentials are never committed
- API keys and secrets are excluded
- Backup files are ignored
- Temporary files are excluded
- Development utilities are not included in production

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

- **Content Updates:** Real-time through admin panel
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

---

**Githunguri Bridgeway Preparatory School** - *Building Bright Futures with Strong Foundations*

*Excellence and Integrity - Lead with Values*

## 📄 Website Pages

### Public Pages
- **Home** - Hero slider, mission statement, statistics, and call-to-action
- **About Us** - Mission, vision, history, leadership team, and facilities
- **Academics** - KCPE curriculum, programs, subjects, and teaching methodology
- **Admissions** - Application process, online form, requirements, and fee structure
- **Student Life** - Co-curricular activities, events, gallery, and achievements
- **Contact Us** - Contact information, map, contact form, and FAQ

### Admin Dashboard
- **Dashboard** - Statistics overview and quick actions
- **Messages** - View and manage contact/admission form submissions
- **Banners** - Manage homepage slider banners
- **Events** - Manage school events and news (placeholder)
- **Gallery** - Manage photo gallery (placeholder)
- **Settings** - System configuration (placeholder)

## 🗂️ File Structure

```
bridgeway/
├── index.php                 # Homepage
├── about.php                # About Us page
├── academics.php            # Academics page
├── admissions.php           # Admissions page
├── student-life.php         # Student Life page
├── contact.php              # Contact page
├── database.sql             # Database schema
├── README.md               # This file
├── admin/                   # Admin dashboard
│   ├── index.php           # Admin redirect
│   ├── login.php           # Admin login
│   ├── logout.php          # Admin logout
│   ├── dashboard.php       # Main dashboard
│   ├── messages.php        # Message management
│   ├── banners.php         # Banner management
│   ├── events.php          # Events management (placeholder)
│   ├── gallery.php         # Gallery management (placeholder)
│   ├── settings.php        # Settings (placeholder)
│   └── includes/           # Admin shared components
│       ├── admin_header.php
│       ├── admin_sidebar.php
│       └── admin_footer.php
├── includes/               # Shared components
│   ├── config.php          # Database configuration
│   ├── header.php          # Site header
│   └── footer.php          # Site footer
├── assets/                 # Static assets
│   ├── css/
│   │   └── style.css       # Main stylesheet
│   ├── js/
│   │   └── main.js         # JavaScript functionality
│   └── images/             # Image assets
└── uploads/                # File uploads directory
```

## 🧩 Database Schema

### Tables
- **admins** - Admin user accounts
- **banners** - Homepage slider banners
- **events** - School events and news
- **gallery** - Photo gallery images
- **messages** - Contact and admission form submissions

## 🚀 Installation Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

### Setup Steps

1. **Clone/Download the project**
   ```bash
   # Place files in your web server directory
   # e.g., C:\xampp\htdocs\bridgeway (for XAMPP)
   ```

2. **Database Setup**
   ```sql
   # Import the database schema
   mysql -u root -p < database.sql
   ```

3. **Configuration**
   - Edit `includes/config.php` with your database credentials
   - Update site URL and contact information

4. **Permissions**
   ```bash
   # Set write permissions for uploads directory
   chmod 755 uploads/
   ```

5. **Access the Website**
   - Public site: `http://localhost/bridgeway`
   - Admin panel: `http://localhost/bridgeway/admin`

### Default Admin Login
- **Username**: `admin`
- **Password**: `admin123`

## 🔐 Security Features

- **Password Hashing**: Uses PHP's `password_hash()` and `password_verify()`
- **SQL Injection Protection**: PDO prepared statements
- **XSS Protection**: Input sanitization with `htmlspecialchars()`
- **Session Management**: Secure admin authentication
- **Input Validation**: Server-side form validation

## 📱 Features

### Public Website
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Hero image slider with overlay content
- ✅ Contact form with database storage
- ✅ Admission application form
- ✅ WhatsApp floating chat button
- ✅ SEO-optimized pages
- ✅ Social media integration
- ✅ Google Maps integration
- ✅ FAQ accordion
- ✅ Smooth scrolling and animations

### Admin Dashboard
- ✅ Secure login system
- ✅ Dashboard with statistics
- ✅ Message management (view, mark as read, delete)
- ✅ Banner management (add, edit, delete, toggle status)
- ✅ Responsive admin interface
- ✅ Mobile-friendly sidebar
- 🔄 Events management (placeholder)
- 🔄 Gallery management (placeholder)
- 🔄 File upload system (placeholder)

## 🛠️ Customization

### Colors
Edit CSS variables in `assets/css/style.css`:
```css
:root {
    --navy-blue: #001F3F;
    --maroon: #800000;
    --white: #FFFFFF;
}
```

### Contact Information
Update constants in `includes/config.php`:
```php
define('SCHOOL_PHONE', '+254 700 000 000');
define('SCHOOL_EMAIL', 'info@bridgewayschool.ac.ke');
define('SCHOOL_ADDRESS', 'Githunguri, Kiambu County, Kenya');
define('WHATSAPP_NUMBER', '254700000000');
```

### Content
- Homepage banners: Admin Dashboard → Banners
- School information: Edit respective PHP pages
- Images: Replace placeholder images in `assets/images/`

## 🔧 Technical Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL with PDO
- **Frontend**: HTML5, CSS3, JavaScript (ES6)
- **Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.4.0
- **Fonts**: Google Fonts (Poppins)

## 📞 Support & Contact

For technical support or customization requests:
- Review the code documentation
- Check the database schema in `database.sql`
- Ensure proper file permissions
- Verify database connection settings

## 🔄 Future Enhancements

Planned features for future versions:
- Complete file upload system for banners and gallery
- Email notification system
- Advanced user roles and permissions
- Online fee payment integration
- Student portal
- Parent communication system
- Academic records management
- Attendance tracking
- Report generation

## 📄 License

This project is created for educational purposes. Feel free to modify and use according to your needs.

## 🎯 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

---

**Built with ❤️ for Githunguri Bridgeway Preparatory School**
