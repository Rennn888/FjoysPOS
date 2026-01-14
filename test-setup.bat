@echo off
echo ========================================
echo   Testing POS Setup
echo ========================================
echo.

cd /d "%~dp0"

echo [1/4] Checking database connection...
php spark db:table products >nul 2>&1
if %errorlevel% equ 0 (
    echo   ✓ Database connected
) else (
    echo   ✗ Database connection failed
    echo   Run: php spark migrate
)

echo.
echo [2/4] Checking if products exist...
php spark db:table products 2>nul | find "rows" >nul
if %errorlevel% equ 0 (
    echo   ✓ Products table exists
) else (
    echo   ✗ No products found
    echo   Run: php spark db:seed ProductSeeder
)

echo.
echo [3/4] Checking API key...
findstr /C:"API_KEY = Fjoy3211" .env >nul
if %errorlevel% equ 0 (
    echo   ✓ API key configured
) else (
    echo   ⚠ API key might not match
)

echo.
echo [4/4] Checking files...
if exist "public\pos-mobile.html" (
    echo   ✓ POS app exists
) else (
    echo   ✗ POS app missing
)

echo.
echo ========================================
echo   Setup Status Complete
echo ========================================
echo.
echo Next step: Run start-server.bat
echo.
pause
