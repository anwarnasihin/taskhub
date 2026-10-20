@echo off
cd /d C:\TaskHub\app
"C:\laragon6-test\bin\php\php-8.3.35-Win32-vs16-x64\php.exe" artisan serve --host=0.0.0.0 --port=8000
