# Mobile API Troubleshooting Guide

## Issue: "No Products Available" on Mobile

### Quick Diagnosis

1. **Start the server:**
   ```bash
   start-server.bat
   ```

2. **Access diagnostic page on mobile:**
   ```
   http://YOUR_IP:8080/pos/diagnostic
   ```
   Replace `YOUR_IP` with your computer's IP address (e.g., 192.168.254.179)

3. **Check the diagnostic results:**
   - Green ✓ = Working
   - Red ✗ = Problem found

### Common Issues & Solutions

#### Issue 1: Server Not Running
**Symptoms:**
- Can't access any page
- "Connection refused" error

**Solution:**
```bash
cd C:\xampp\htdocs\FjoysPOS
start-server.bat
```

Make sure you see:
```
Server will be accessible at:
  - Local: http://localhost:8080/pos
  - Network: http://YOUR_IP:8080/pos
```

#### Issue 2: Wrong IP Address
**Symptoms:**
- Works on computer but not on mobile
- Timeout on mobile

**Solution:**
1. Find your computer's IP:
   ```bash
   ipconfig
   ```
   Look for "IPv4 Address" under your active network adapter

2. Use that IP on mobile:
   ```
   http://192.168.X.X:8080/pos
   ```

#### Issue 3: Firewall Blocking
**Symptoms:**
- Diagnostic shows connection timeout
- Works on localhost but not on network

**Solution:**
1. Open Windows Firewall
2. Allow port 8080 for PHP
3. Or temporarily disable firewall to test

#### Issue 4: No Products in Database
**Symptoms:**
- API returns empty array
- Diagnostic shows "Products Found: 0"

**Solution:**
```bash
php spark db:seed FjoysMenuSeeder
```

Should see: "Fjoy's Menu loaded successfully! Total items: 17"

#### Issue 5: API Key Mismatch
**Symptoms:**
- Diagnostic shows "401 Unauthorized"
- API returns "Unauthorized" message

**Solution:**
1. Check `.env` file:
   ```
   API_KEY = Fjoy3211
   ```

2. Restart server after changing `.env`

#### Issue 6: CORS Issues
**Symptoms:**
- Console shows CORS error
- "Access-Control-Allow-Origin" error

**Solution:**
Already configured in `app/Config/Cors.php` to allow all origins.
If still having issues, check `app/Config/Filters.php` has:
```php
'before' => [
    'cors',
    ...
]
```

### Step-by-Step Troubleshooting

**Step 1: Test on Desktop First**
1. Start server: `start-server.bat`
2. Open: http://localhost:8080/pos
3. Should see menu items
4. If not working on desktop, fix that first

**Step 2: Test API Directly**
1. Open: http://localhost:8080/api/products
2. Should see JSON with products
3. If empty, run seeder: `php spark db:seed FjoysMenuSeeder`

**Step 3: Test on Mobile**
1. Get computer IP: `ipconfig`
2. On mobile, open: http://YOUR_IP:8080/pos/diagnostic
3. Click "Test API Connection"
4. Check results

**Step 4: Check Console Logs**
On mobile browser:
1. Open: http://YOUR_IP:8080/pos
2. Open browser developer tools (if available)
3. Check console for errors
4. Look for:
   - API_BASE_URL value
   - API_KEY value
   - Fetch errors

### Diagnostic Page Features

The diagnostic page (`/pos/diagnostic`) shows:

1. **Environment Info**
   - Browser details
   - Online status
   - Screen size

2. **API Configuration**
   - API Base URL (should match your access URL)
   - API Key
   - Endpoint URLs

3. **API Test**
   - Tests connection to products API
   - Shows response data
   - Tests with and without API key

4. **Network Info**
   - Current URL details
   - Origin, host, port

### Manual API Test

**Using Browser:**
```
http://YOUR_IP:8080/api/products
```

Should return JSON with products. If you see "Unauthorized", the API key is missing (which is expected in browser).

**Using curl (on computer):**
```bash
curl -H "X-API-Key: Fjoy3211" http://localhost:8080/api/products
```

Should return products JSON.

### Checking Server Logs

Look at console where `start-server.bat` is running:
- Should see requests coming in
- Check for any PHP errors
- Look for 200 (success) or 401/500 (errors)

### Database Check

**Verify products exist:**
```bash
php spark db:table products
```

Should show 17 products.

**Re-seed if needed:**
```bash
php spark db:seed FjoysMenuSeeder
```

### Network Requirements

**Same Network:**
- Computer and mobile must be on same WiFi
- Check both are connected to same network name

**Port Access:**
- Port 8080 must be open
- Firewall must allow incoming connections
- Router must allow local network traffic

### Quick Fixes

**Fix 1: Restart Everything**
```bash
# Stop server (Ctrl+C)
# Restart
start-server.bat
```

**Fix 2: Clear Browser Cache**
On mobile:
- Clear browser cache
- Close and reopen browser
- Try again

**Fix 3: Try Different Browser**
- Chrome
- Firefox
- Safari
- Edge

**Fix 4: Reseed Database**
```bash
php spark migrate:refresh
php spark db:seed FjoysMenuSeeder
```

### Still Not Working?

1. **Check diagnostic page results**
   - Take screenshot of diagnostic page
   - Check what's red/failing

2. **Check browser console**
   - Look for JavaScript errors
   - Check network tab for failed requests

3. **Verify server is accessible**
   ```bash
   # On computer
   curl http://localhost:8080/pos
   
   # Should return HTML
   ```

4. **Test from another device**
   - Try from another phone
   - Try from another computer on same network

### Success Checklist

✅ Server running (`start-server.bat`)
✅ Can access on desktop: http://localhost:8080/pos
✅ Products show on desktop
✅ API works: http://localhost:8080/api/products
✅ Diagnostic page green: http://YOUR_IP:8080/pos/diagnostic
✅ Mobile on same WiFi
✅ Firewall allows port 8080
✅ Products show on mobile: http://YOUR_IP:8080/pos

### Contact Info

If all else fails:
1. Check `writable/logs/log-YYYY-MM-DD.log` for errors
2. Review `POS_STRUCTURE.md` for technical details
3. Check `QUICK_ACCESS.md` for URLs and commands
