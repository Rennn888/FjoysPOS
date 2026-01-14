@echo off
echo ========================================
echo   Food Stand POS - Starting Server
echo ========================================
echo.
echo Server will be accessible at:
echo   - Local: http://localhost:8080
echo   - Network: http://192.168.254.179:8080
echo.
echo Press Ctrl+C to stop the server
echo ========================================
echo.

cd /d "%~dp0"
cd public
php -S 0.0.0.0:8080 router.php
