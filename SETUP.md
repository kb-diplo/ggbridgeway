# Quick Setup Guide - Githunguri Bridgeway Preparatory School Website

## 🚀 Quick Start (5 Minutes)

### Step 1: Setup Local Server
If you don't have a local server, download and install:
- **XAMPP** (recommended): https://www.apachefriends.org/
- **WAMP**: http://www.wampserver.com/
- **MAMP**: https://www.mamp.info/

### Step 2: Place Files
1. Copy the entire `bridgeway` folder to your web server directory:
   - **XAMPP**: `C:\xampp\htdocs\bridgeway`
   - **WAMP**: `C:\wamp64\www\bridgeway`
   - **MAMP**: `/Applications/MAMP/htdocs/bridgeway`

### Step 3: Create Database
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Create a new database named `bridgeway_school`
3. Import the database schema:
   - Click on the `bridgeway_school` database
   - Go to "Import" tab
   - Choose file: `database.sql`
   - Click "Go"

### Step 4: Configure Database Connection
1. Open `includes/config.php`
2. Update database settings if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'bridgeway_school');
   define('DB_USER', 'root');
   define('DB_PASS', ''); // Usually empty for local development
   ```

### Step 5: Access the Website
- **Public Website**: http://localhost/bridgeway
- **Admin Panel**: http://localhost/bridgeway/admin
- **Default Admin Login**:
  - Username: `admin`
  - Password: `admin123`

## 🔧 Configuration Options

### Update School Information
Edit `includes/config.php`:
```php
define('SCHOOL_PHONE', '+254 700 000 000');
define('SCHOOL_EMAIL', 'info@bridgewayschool.ac.ke');
define('SCHOOL_ADDRESS', 'Githunguri, Kiambu County, Kenya');
define('WHATSAPP_NUMBER', '254700000000');
```

### Change Colors
Edit `assets/css/style.css`:
```css
:root {
    --navy-blue: #001F3F;    /* Main color */
    --maroon: #800000;       /* Secondary color */
    --white: #FFFFFF;        /* Background */
}
```

## 📱 Testing

### Test These Features:
1. **Homepage**: Hero slider, statistics animation
2. **Forms**: Contact form, admission application
3. **Admin**: Login, dashboard, message management
4. **Responsive**: Test on mobile/tablet sizes
5. **WhatsApp**: Click the floating WhatsApp button

### Browser Testing:
- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers

## 🛠️ Troubleshooting

### Common Issues:

**Database Connection Error**
- Check database credentials in `config.php`
- Ensure MySQL service is running
- Verify database name exists

**Page Not Found (404)**
- Check file permissions
- Ensure files are in correct directory
- Verify web server is running

**Admin Login Not Working**
- Default credentials: admin/admin123
- Check if database was imported correctly
- Clear browser cache

**Images Not Loading**
- Check `uploads/` directory exists
- Verify file permissions (755)
- Use placeholder images for testing

## 📞 Need Help?

1. Check the main `README.md` for detailed documentation
2. Verify all files are in place
3. Check browser console for JavaScript errors
4. Ensure PHP and MySQL are running

## 🎯 Next Steps

After setup:
1. Login to admin panel
2. Add/edit homepage banners
3. Customize school information
4. Test contact and admission forms
5. Update colors and branding as needed

---

**🎉 Your school website is ready!**
