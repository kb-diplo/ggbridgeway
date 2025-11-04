# 🚀 InfinityFree Deployment Guide for Githunguri Bridgeway School Website

## 📋 Pre-Deployment Checklist

### ✅ Database Setup (COMPLETED)
Your InfinityFree database details:
- **Host**: sql206.infinityfree.com
- **Database**: if0_40322936_bridgeway_school
- **Username**: if0_40322936
- **Password**: B1ljovew
- **Port**: 3306

## 📁 Files to Upload to InfinityFree

### 🔧 Step 1: Prepare Configuration
1. **Rename config file**: 
   - Copy `includes/config_infinityfree.php` to `includes/config.php`
   - Update `SITE_URL` in config.php with your actual domain

### 📂 Step 2: Upload File Structure
Upload these files/folders to your InfinityFree `htdocs` directory:

```
htdocs/
├── index.php                    # Homepage
├── about.php                   # About page
├── academics.php               # Academics page
├── admissions.php              # Admissions page
├── student-life.php            # Student Life page
├── careers.php                 # Careers page
├── contact.php                 # Contact page
├── custom-admin.php            # Admin entry point
├── cookies-policy.php          # Cookie policy
├── privacy-policy.php          # Privacy policy
├── terms-of-service.php        # Terms of service
├── downloads.php               # Downloads page
├── .htaccess                   # URL rewriting (create if needed)
├── admin/                      # Admin panel directory
│   ├── *.php                   # All admin PHP files
│   └── includes/               # Admin includes
├── includes/                   # Core includes
│   ├── config.php              # Database config (from config_infinityfree.php)
│   ├── header.php              # Site header
│   └── footer.php              # Site footer
├── assets/                     # Static assets
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   └── images/                 # School images
└── uploads/                    # File uploads (create empty folder)
```

### 🔐 Step 3: Security Setup
1. **Set folder permissions**:
   - `uploads/` folder: 755 or 777 (for file uploads)
   - All PHP files: 644
   - All directories: 755

2. **Create .htaccess file** in root directory:
```apache
# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"

# Hide sensitive files
<Files "config.php">
    Order allow,deny
    Deny from all
</Files>

<Files "*.log">
    Order allow,deny
    Deny from all
</Files>

# Enable HTTPS redirect (InfinityFree supports SSL)
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Pretty URLs (optional)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^admin$ admin/ [L,R=301]
```

## 🌐 Step 4: Update Configuration

### Update config.php with your domain:
```php
define('SITE_URL', 'https://githunguribridgewaypreparatoryschool.ct.ws');
```

## 🎯 Step 5: First Visit Setup

1. **Visit your website**: `https://githunguribridgewaypreparatoryschool.ct.ws`
2. **Auto-initialization** will create all database tables
3. **Access admin panel**: `https://githunguribridgewaypreparatoryschool.ct.ws/custom-admin.php`
4. **Login credentials**: 
   - Username: `admin`
   - Password: `admin123`

## ⚠️ Important Notes for InfinityFree

### 🚫 Files NOT to Upload:
- `README.md`
- `SETUP.md` 
- `LICENSE`
- `includes/config.example.php`
- Any `.git` folders
- Development files like `create_admin.php`

### 🔧 InfinityFree Limitations:
- **File Upload Size**: Max 10MB per file
- **Database Size**: 400MB limit
- **Bandwidth**: 5GB/month
- **Email**: Limited SMTP (use external service for contact forms)

### 📧 Email Configuration:
For contact forms to work, you may need to:
1. Use InfinityFree's SMTP settings, or
2. Integrate with external email service (Gmail SMTP, SendGrid, etc.)

## 🧪 Testing Checklist

After deployment, test:
- [ ] Homepage loads correctly
- [ ] All navigation links work
- [ ] Admin panel accessible
- [ ] Content management works
- [ ] Contact form submits (check database)
- [ ] Images display properly
- [ ] Mobile responsiveness
- [ ] SSL certificate active

## 🔧 Troubleshooting

### Common Issues:
1. **Database Connection Error**: Check config.php credentials
2. **Images Not Loading**: Check file paths and permissions
3. **Admin Panel 404**: Ensure all admin files uploaded
4. **Contact Form Not Working**: Configure email settings

### Support:
- InfinityFree Forum: https://forum.infinityfree.net/
- Documentation: https://docs.infinityfree.net/

## 🎉 Post-Deployment

1. **Change default admin password** immediately
2. **Add school content** through admin panel
3. **Upload school images** to gallery
4. **Test all functionality**
5. **Set up regular backups**

---

**Your website will be live at**: `https://githunguribridgewaypreparatoryschool.ct.ws`

**Admin access**: `https://githunguribridgewaypreparatoryschool.ct.ws/custom-admin.php`
