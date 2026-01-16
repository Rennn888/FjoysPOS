@echo off
echo ========================================
echo   FJOY'S POS - Starting Server
echo ========================================
echo.
echo Server will be accessible at:
echo   - Local: http://localhost:8080/pos
echo   - Network: http://YOUR_IP:8080/pos
echo.
echo Press Ctrl+C to stop the server
echo ========================================
echo.

cd /d "%~dp0"
cd public
php -S 0.0.0.0:8080 router.php
