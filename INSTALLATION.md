# MinhLocation - Installation Guide

## Prerequisites

- PHP 7.4 or higher
- SQLite3 support
- Web server (Apache with mod_rewrite or Nginx)
- cURL extension (for geolocation)
- Port 80 available
- Domain: minhlocation.dpdns.org with wildcard subdomain support

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/appminh7-hue/MinhLocation.git
cd MinhLocation
```

### 2. Set Permissions

```bash
chmod 755 public
chmod 755 src
mkdir -p data
chmod 777 data
```

### 3. Run Setup Script

```bash
php setup.php
```

This will:
- Create the data directory
- Initialize the SQLite database
- Show configuration details

### 4. Configure Web Server

#### Apache Setup

Your `.htaccess` file is already configured. Just enable mod_rewrite:

```bash
a2enmod rewrite
a2enmod headers
```

Then restart Apache:

```bash
systemctl restart apache2
```

#### Nginx Setup

Create an Nginx configuration file:

```nginx
server {
    listen 80;
    server_name ~^(?<subdomain>.+)\.minhlocation\.dpdns\.org$ minhlocation.dpdns.org;
    
    root /path/to/MinhLocation/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Redirect subdomains to redirect.php
    location ~ \.php$ {
        if ($subdomain != "") {
            rewrite ^(.*)$ /redirect.php?subdomain=$subdomain;
        }
        
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to sensitive files
    location ~ \. {
        deny all;
    }
    
    location ~ ~$ {
        deny all;
    }
    
    location ~ ^/(src|data|setup)/ {
        deny all;
    }
}
```

### 5. Docker Setup (Alternative)

If using Docker:

```bash
docker-compose up -d
```

This will start the application on `http://localhost`

### 6. DNS Configuration

Set up wildcard DNS record:

```
*.minhlocation.dpdns.org  IN  A  your.server.ip.address
minhlocation.dpdns.org    IN  A  your.server.ip.address
```

### 7. Configure Google Maps API (Optional)

For map display in statistics:

1. Go to [Google Cloud Console](https://console.cloud.google.com)
2. Create a new project or select existing
3. Enable Maps JavaScript API
4. Create an API key
5. Update `stats.php` with your API key:

```php
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
```

## Verification

1. Visit `http://minhlocation.dpdns.org`
2. Create a test link
3. Access the short link to verify redirect works
4. Check `http://minhlocation.dpdns.org/stats.php?id=1` for statistics

## Troubleshooting

### Issue: Cannot create links

**Solution**: Check folder permissions
```bash
chmod 777 data
```

### Issue: Subdomain redirect not working

**Solution**: Verify DNS and web server configuration
```bash
nslookup test.minhlocation.dpdns.org
```

### Issue: Database errors

**Solution**: Ensure SQLite extension is installed
```bash
php -m | grep sqlite
```

### Issue: Location not tracking

**Solution**: Verify cURL is installed
```bash
php -m | grep curl
```

## Security Considerations

1. **Database**: The SQLite database is protected by `.htaccess` rules
2. **Setup Script**: Can be deleted after installation
3. **Permissions**: Keep data directory with proper permissions
4. **HTTPS**: Use Let's Encrypt to enable HTTPS

```bash
# Enable Let's Encrypt (Ubuntu/Debian with Apache)
sudo apt-get install certbot python3-certbot-apache
sudo certbot --apache -d minhlocation.dpdns.org -d "*.minhlocation.dpdns.org"
```

## Performance Optimization

1. Enable GZIP compression (included in .htaccess)
2. Use caching headers (included in .htaccess)
3. Consider CDN for static files
4. Monitor database size for cleanup

## Maintenance

### Regular Cleanup

Remove old visits (older than 90 days):

```sql
DELETE FROM visits WHERE visited_at < datetime('now', '-90 days');
```

### Backup Database

```bash
cp data/locations.db data/locations.db.backup
```

## Support

For issues or questions, please refer to the README.md or check the logs in your web server error log.