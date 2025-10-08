# Получение нового токена Telegram бота

## Шаги для создания нового бота

1. **Найти @BotFather**
   - Откройте Telegram
   - Найдите бота @BotFather
   - Отправьте `/start`

2. **Создать нового бота**

   ```
   /newbot
   ```

   - Введите название бота (например: "My Checker Bot")
   - Введите username бота (должен заканчиваться на "bot", например: "mychecker123_bot")

3. **Получить токен**
   - @BotFather отправит токен вида: `1234567890:ABCDEF...`
   - Скопируйте весь токен

4. **Обновить конфигурацию**
   - Откройте файл `config/config.php`
   - Найдите строку: `$config['botToken'] = "..."`
   - Замените старый токен на новый

## Пример обновления config.php

```php
// Старый (недействительный)
$config['botToken'] = "7981870709:AAGqBsEB2A-t5fGLjTN1UmzTwKxZlfvOCCY";

// Новый (замените на ваш токен)
$config['botToken'] = "1234567890:ABCDEF1234567890abcdef1234567890ABC";
```

## Тестирование

После обновления токена:

1. **Проверка токена**:

   ```bash
   wsl -d Ubuntu-22.04 bash -c "cd '/mnt/c/Users/artem/Рабочий стол/figma/SDMN_CheckerBot' && php test_token.php"
   ```

2. **Запуск бота**:

   ```bash
   wsl -d Ubuntu-22.04 bash -c "cd '/mnt/c/Users/artem/Рабочий стол/figma/SDMN_CheckerBot' && sudo service mysql start && php run_bot.php"
   ```

3. **Тестирование команд**:
   - Найдите своего бота в Telegram по username
   - Отправьте `/start`
   - Проверьте работу команд `/cmds`, `/me`, `/stats`

## Безопасность

⚠️ **Важно**:

- Никогда не публикуйте токен в открытых репозиториях
- Храните токен в безопасном месте
- При компрометации токена создайте нового бота
