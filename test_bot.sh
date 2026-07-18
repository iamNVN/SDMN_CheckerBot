#!/bin/bash

# Тест всех команд CheckerBot

echo "🚀 Запуск бота в фоне..."
cd "/mnt/c/Users/artem/Рабочий стол/figma/SDMN_CheckerBot"
sudo service mysql start > /dev/null 2>&1

# Запускаем бота в фоне
php run_bot.php &
BOT_PID=$!

echo "🤖 Бот запущен с PID: $BOT_PID"
echo "📱 Теперь можно тестировать команды в Telegram:"
echo ""
echo "✅ Команды для тестирования:"
echo "   /start - Приветственное сообщение"
echo "   /cmds - Список команд"
echo "   /admin - Админ панель (только для админа)"
echo "   /me - Информация о пользователе" 
echo "   /stats - Статистика бота"
echo ""
echo "💳 Чекеры:"
echo "   /ss 4111111111111111|12|2025|123 - Stripe Auth"
echo "   /sm 4111111111111111|12|2025|123 - Stripe Merchant"
echo "   /schk 4111111111111111|12|2025|123 - User Stripe"
echo ""
echo "🔧 Утилиты:"
echo "   /bin 411111 - BIN Lookup"
echo "   /iban DE89370400440532013000 - IBAN проверка"
echo "   /sk sk_test_... - Проверка Stripe ключа"
echo ""
echo "⏹️  Нажмите Ctrl+C для остановки бота"

# Ждем сигнала завершения
trap "echo '🛑 Остановка бота...'; kill $BOT_PID; exit 0" INT

wait $BOT_PID