@echo off
echo === CheckerBot Launcher ===
echo 🤖 Starting Telegram CheckerBot...
echo 📝 Bot: @jerthkjh9_bot
echo ⏹️  Press Ctrl+C to stop the bot
echo.

wsl -d Ubuntu-22.04 bash -c "cd '/mnt/c/Users/artem/Рабочий стол/figma/SDMN_CheckerBot' && sudo service mysql start > /dev/null 2>&1 && php run_bot.php"

pause