@echo off
for /f "tokens=2 delims=:" %%A in ('ipconfig ^| findstr "IPv4 Address"') do set IP=%%A
set IP=%IP:~1%
rem Ganti nilai API_BASE_URL dalam .env
powershell -Command "(Get-Content .env) -replace 'API_BASE_URL=.*', 'API_BASE_URL=http://%IP%:3000' | Set-Content .env"
php artisan serve --host=0.0.0.0 --port=8000
