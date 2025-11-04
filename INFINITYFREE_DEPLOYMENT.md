# 🚀 InfinityFree Deployment Guide - Githunguri Bridgeway School

## 📋 Pre-Deployment Setup

### ✅ Your InfinityFree Details
- **Domain**: https://githunguribridgewaypreparatoryschool.ct.ws
- **Database Host**: sql206.infinityfree.com
- **Database Name**: if0_40322936_bridgeway_school
- **Username**: if0_40322936
- **Password**: B1ljovew

## 📁 Files Ready for Upload

### 🔧 Step 1: Prepare Configuration
1. **Copy config content**: 
   - Take content from `INFINITYFREE_CONFIG.php`
   - Create `includes/config.php` on InfinityFree server
   - Paste the configuration content

### 📂 Step 2: Upload These Files to InfinityFree htdocs

```
📁 Upload to htdocs/
├── 📄 index.php                    # Homepage
├── 📄 about.php                   # About page  
├── 📄 academics.php               # Academics page
├── 📄 admissions.php              # Admissions page
├── 📄 student-life.php            # Student Life page
├── 📄 careers.php                 # Careers page
├── 📄 contact.php                 # Contact page
├── 📄 custom-admin.php            # Admin entry point
├── 📄 cookies-policy.php          # Cookie policy
├── 📄 privacy-policy.php          # Privacy policy
├── 📄 terms-of-service.php        # Terms of service
├── 📄 downloads.php               # Downloads page
├── 📄 .htaccess                   # Security & redirects
├── 📁 admin/                      # Complete admin folder
│   ├── 📄 *.php                   # All admin PHP files
│   └── 📁 includes/               # Admin includes
├── 📁 includes/                   # Core includes
│   ├── 📄 config.php              # Create this with INFINITYFREE_CONFIG.php content
│   ├── 📄 header.php              # Site header
│   └── 📄 footer.php              # Site footer
├── 📁 assets/                     # Static assets
│   ├── 📁 css/
│   │   └── 📄 style.css
│   ├── 📁 js/
│   │   └── 📄 main.js
│   └── 📁 images/                 # School images
└── 📁 uploads/                    # Create empty folder (755 permissions)
```

### 🚫 DO NOT Upload These Files:
- ❌ `README.md`
- ❌ `LICENSE`
- ❌ `SETUP.md`
- ❌ `INFINITYFREE_CONFIG.php` (use content only)
- ❌ `INFINITYFREE_DEPLOYMENT.md` (this file)
- ❌ `.git/` folder
- ❌ `.gitignore`
- ❌ `includes/config.example.php`

## 🔐 Step 3: Set Permissions on InfinityFree

### File Permissions:
- **All PHP files**: 644
- **All directories**: 755
- **uploads/ folder**: 755 (important for file uploads)

### Create uploads folder:
```bash
mkdir uploads
chmod 755 uploads
```

## 🌐 Step 4: First Visit & Testing

### 1. Visit Your Website
**URL**: https://githunguribridgewaypreparatoryschool.ct.ws

**What happens on first visit:**
- ✅ Auto-initialization creates all database tables
- ✅ Creates default admin account
- ✅ Sets up sample content

### 2. Access Admin Panel
**Admin URL**: https://githunguribridgewaypreparatoryschool.ct.ws/custom-admin.php

**Default Login:**
- Username: `admin`
- Password: `admin123`

**⚠️ IMPORTANT**: Change admin password immediately after first login!

## 🧪 Testing Checklist

After deployment, verify:
- [ ] Homepage loads correctly
- [ ] All navigation links work
- [ ] Admin panel accessible at /custom-admin.php
- [ ] Can login to admin with default credentials
- [ ] Enhanced Content Manager works
- [ ] Events and Gallery admin pages load
- [ ] Contact form submits (check Messages in admin)
- [ ] Images display properly
- [ ] Mobile responsiveness works
- [ ] HTTPS is active (InfinityFree provides SSL)

## 🔧 Admin Panel Features to Test

### Content Management:
- [ ] Enhanced Content Manager (edit homepage content)
- [ ] Banner Management (homepage slider)
- [ ] Notices System (announcements)
- [ ] Events Management (add/edit events)
- [ ] Gallery Management (add images)
- [ ] Leadership Management (staff profiles)
- [ ] Messages (contact form submissions)
- [ ] Settings (social media, contact info)

### User Management:
- [ ] Create new admin account
- [ ] Change default admin password
- [ ] Test logout functionality

## 🚨 Troubleshooting

### Common Issues:

**Database Connection Error:**
- Check config.php credentials match InfinityFree exactly
- Ensure database name includes the prefix: `if0_40322936_bridgeway_school`

**Images Not Loading:**
- Check file paths in assets/images/
- Verify image files uploaded correctly
- Check file permissions (644 for files, 755 for directories)

**Admin Panel 404:**
- Ensure all admin/ folder files uploaded
- Check custom-admin.php exists in root
- Verify .htaccess uploaded correctly

**Contact Form Not Working:**
- Check database connection
- Verify Messages table created (auto-initialization)
- Test form submission and check admin Messages

## 📊 Post-Deployment Tasks

### Immediate Tasks:
1. **Change admin password** (Security → Admin Management)
2. **Update school content** (Enhanced Content Manager)
3. **Add school images** (Gallery Management)
4. **Create school events** (Events Management)
5. **Add staff profiles** (Leadership Management)
6. **Test contact form** (submit test message)

### Content Updates:
1. **Homepage**: Update hero text, statistics, welcome message
2. **About Page**: Add school history, mission, vision
3. **Academics**: Update curriculum information
4. **Contact**: Verify contact details are correct
5. **Gallery**: Upload school photos
6. **Events**: Add upcoming school events

## 🎉 Success Indicators

Your deployment is successful when:
- ✅ Website loads at https://githunguribridgewaypreparatoryschool.ct.ws
- ✅ Admin panel accessible and functional
- ✅ All pages display correctly
- ✅ Content management works
- ✅ Contact form submits to database
- ✅ Mobile responsive design works
- ✅ HTTPS certificate active

## 📞 Support Resources

**InfinityFree Support:**
- Forum: https://forum.infinityfree.net/
- Documentation: https://docs.infinityfree.net/
- Control Panel: https://app.infinityfree.net/

**Website Features:**
- All admin features documented in admin panel
- Enhanced Content Manager for easy updates
- Professional design ready for school use

---

**🎓 Your school website will be live at:**
**https://githunguribridgewaypreparatoryschool.ct.ws**

**🔐 Admin access:**
**https://githunguribridgewaypreparatoryschool.ct.ws/custom-admin.php**
