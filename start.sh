#!/bin/bash

echo "=== CheckerBot Launcher ==="
echo "🤖 Starting Telegram CheckerBot..."
echo "📝 Bot: @jerthkjh9_bot"
echo "⏹️  Press Ctrl+C to stop the bot"
echo ""

# Переходим в директорию бота
cd '/mnt/c/Users/artem/Рабочий стол/figma/SDMN_CheckerBot'

# Запускаем MySQL если не запущен
sudo service mysql start > /dev/null 2>&1

# Запускаем бота
php run_bot.php