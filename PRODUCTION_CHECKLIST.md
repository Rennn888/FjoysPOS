# Production Deployment Checklist

Use this checklist before deploying to production.

## 🔒 Security

- [ ] Change default API key to strong random value
  - [ ] Update in `.env`
  - [ ] Update in `public/pos-app.js`
- [ ] Set `CI_ENVIRONMENT = production` in `.env`
- [ ] Generate encryption key: `php spark key:generate`
- [ ] Remove or secure `test-api.html` (delete or password protect)
- [ ] Verify database user has minimal required permissions
- [ ] Enable HTTPS/SSL certificate
- [ ] Update `app.baseURL` in `.env` to HTTPS URL
- [ ] Update `API_BASE_URL` in `pos-app.js` to HTTPS URL

## 🗄️ Database

- [ ] Create production database
- [ ] Run migrations: `php spark migrate`
- [ ] Seed initial products: `php spark db:seed ProductSeeder`
- [ ] Setup automated daily backups
- [ ] Test database backup restoration
- [ ] Configure database connection pooling (if needed)
- [ ] Optimize database indexes
- [ ] Set appropriate `max_connections` in MySQL

## 🌐 Web Server

- [ ] Configure Apache/Nginx properly
- [ ] Point document root to `public/` folder
- [ ] Enable mod_rewrite (Apache) or configure rewrites (Nginx)
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Make `writable/` folder writable (775)
- [ ] Configure PHP-FPM (if using Nginx)
- [ ] Set appropriate PHP memory limit (128MB minimum)
- [ ] Enable OPcache for PHP
- [ ] Configure gzip compression
- [ ] Setup log rotation

## 📱 PWA Configuration

- [ ] Update `manifest.json` with production URLs
- [ ] Create proper app icons (192x192, 512x512)
- [ ] Test PWA installation on Android device
- [ ] Verify service worker registration
- [ ] Test offline functionality thoroughly
- [ ] Verify auto-sync works after reconnection
- [ ] Test on multiple Android devices/versions

## 🔍 Testing

- [ ] Test all API endpoints with `test-api.html`
- [ ] Complete test transaction in POS
- [ ] Verify transaction appears in dashboard
- [ ] Test offline mode (airplane mode)
- [ ] Verify sync after coming back online
- [ ] Test with multiple simultaneous transactions
- [ ] Test payment calculations with various amounts
- [ ] Verify reports generate correctly
- [ ] Test on actual Android device
- [ ] Test with poor/intermittent connection

## 📊 Monitoring

- [ ] Setup error logging
- [ ] Configure log rotation for `writable/logs/`
- [ ] Setup server monitoring (CPU, RAM, disk)
- [ ] Configure database monitoring
- [ ] Setup uptime monitoring
- [ ] Configure email alerts for critical errors
- [ ] Setup analytics (optional)

## 🚀 Performance

- [ ] Enable OPcache
- [ ] Configure database query caching
- [ ] Optimize images (if using product images)
- [ ] Minify CSS/JS (optional for production)
- [ ] Enable browser caching
- [ ] Configure CDN (optional)
- [ ] Test page load times
- [ ] Verify API response times

## 💾 Backup Strategy

- [ ] Setup automated database backups
- [ ] Test backup restoration process
- [ ] Setup file system backups
- [ ] Configure off-site backup storage
- [ ] Document backup restoration procedure
- [ ] Set backup retention policy (30 days recommended)
- [ ] Schedule regular backup tests

## 📝 Documentation

- [ ] Document custom products added
- [ ] Create staff training materials
- [ ] Document troubleshooting procedures
- [ ] Create admin user guide
- [ ] Document backup/restore procedures
- [ ] Create incident response plan
- [ ] Document API endpoints for future reference

## 👥 Training

- [ ] Train staff on POS usage
- [ ] Train on offline mode behavior
- [ ] Train on payment process
- [ ] Train on basic troubleshooting
- [ ] Create quick reference guide
- [ ] Conduct practice sessions
- [ ] Prepare support contact information

## 🔧 Configuration Files

### .env Production Settings
```env
CI_ENVIRONMENT = production
app.baseURL = 'https://yourdomain.com/'
database.default.hostname = localhost
database.default.database = food_stand_pos
database.default.username = pos_user
database.default.password = [STRONG_PASSWORD]
API_KEY = [STRONG_RANDOM_KEY]
```

### Apache .htaccess (already included)
Verify it's working and mod_rewrite is enabled.

### Nginx Configuration
```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /var/www/food-stand-pos/public;
    index index.php;

    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🚨 Emergency Procedures

### If POS Goes Down
1. Check server status
2. Check database connection
3. Review error logs: `writable/logs/`
4. Verify network connectivity
5. Restart web server if needed
6. Contact technical support

### If Sync Fails
1. Verify internet connection
2. Check API endpoint accessibility
3. Verify API key is correct
4. Check server logs
5. Transactions remain safe in local storage
6. Will auto-retry every 30 seconds

### Database Issues
1. Check MySQL service status
2. Verify credentials
3. Check disk space
4. Review MySQL error logs
5. Restore from backup if needed

## 📞 Support Contacts

- [ ] Document server hosting provider contact
- [ ] Document database administrator contact
- [ ] Document technical support contact
- [ ] Document emergency escalation procedure

## 🎯 Go-Live Plan

### Day Before
- [ ] Final backup of all data
- [ ] Verify all checklist items complete
- [ ] Test all functionality one final time
- [ ] Prepare rollback plan
- [ ] Notify staff of go-live time

### Go-Live Day
- [ ] Deploy to production server
- [ ] Verify deployment successful
- [ ] Test POS on actual device
- [ ] Complete test transaction
- [ ] Monitor for first hour
- [ ] Be available for support

### Day After
- [ ] Review logs for errors
- [ ] Check all transactions synced
- [ ] Verify reports accurate
- [ ] Gather staff feedback
- [ ] Address any issues

## ✅ Final Verification

Before going live, verify:

1. **POS App Works**
   - [ ] Opens on mobile device
   - [ ] Menu loads correctly
   - [ ] Can add items to cart
   - [ ] Payment completes successfully
   - [ ] Transaction syncs to server

2. **Dashboard Works**
   - [ ] Shows today's sales
   - [ ] Displays transactions
   - [ ] Reports generate correctly

3. **Offline Mode Works**
   - [ ] POS works without internet
   - [ ] Transactions save locally
   - [ ] Auto-syncs when online

4. **Security Works**
   - [ ] Wrong API key rejected
   - [ ] HTTPS enabled
   - [ ] Database secured

5. **Backups Work**
   - [ ] Automated backup runs
   - [ ] Can restore from backup
   - [ ] Backup stored securely

## 📈 Post-Launch

### Week 1
- [ ] Monitor daily for issues
- [ ] Review all transactions
- [ ] Check sync status
- [ ] Gather user feedback
- [ ] Address any bugs

### Month 1
- [ ] Review sales reports
- [ ] Optimize based on usage
- [ ] Update products as needed
- [ ] Plan enhancements
- [ ] Review backup logs

### Ongoing
- [ ] Monthly backup tests
- [ ] Quarterly security review
- [ ] Regular software updates
- [ ] Performance monitoring
- [ ] User training refreshers

---

**Remember:** Always test in a staging environment before deploying to production!

**Rollback Plan:** Keep previous version available for quick rollback if issues occur.

**Support:** Document everything and keep this checklist updated as you learn from production experience.
