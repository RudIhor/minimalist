<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 Добро пожаловать в Minimalist!

Ваш простой и лаконичный менеджер задач прямо здесь, в Telegram. Управляйте своими задачами без усилий и оставайтесь организованными с Minimalist.

Чтобы начать, используйте команды ниже:
**/today**: Управляйте задачами на сегодня 📅
**/tomorrow**: Планируйте задачи на завтра 🗓️
**/future**: Организуйте задачи на будущие даты 📆

🔔 Рекомендуем начать с команды /today, чтобы увидеть, что у вас запланировано на сегодня.

Вот что вы можете сделать:
➕: Создавайте новые задачи с помощью простой команды.
🗑️: Удаляйте задачи, которые вам больше не нужны.
✅: Отмечайте задачи как выполненные и отслеживайте свой прогресс.

Для помощи с командами введите /help.

Мы ставим вашу *конфиденциальность* на первое место 🔒. Поэтому все названия ваших задач надежно зашифрованы с использованием AES (Advanced Encryption Standard).

Проще говоря, AES – это один из самых передовых методов шифрования, что делает практически невозможным взлом и доступ к деталям ваших задач.

Давайте держать все просто и продуктивно! 🌟

Сделано с ❤️ в 🇺🇦
END;

$helpCommandText = <<<EOF
Minimalist это простой и лаконичный менеджер задач в Telegram. Вот список команд, которые помогут вам начать:

Команды:

/start: Начните использовать Minimalist и узнайте, как использовать бота.
/today: Управляйте задачами на сегодня 📅
/tomorrow: Планируйте задачи на завтра 🗓️
/future: Организуйте задачи на будущие даты 📆

Нужна дополнительная помощь?
Если вам нужна дополнительная помощь или у вас есть вопросы, обращайтесь за поддержкой: @ihorrud.
EOF;

$eveningReminderText = <<<EOF


*Сделано сегодня: %d*
*Не сделано сегодня: %d*

/tomorrow — запланируйте свои задачи на завтра.
/future — организуйте свои задачи на будущие даты.
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 Задач пока нет. Начните добавлять их, чтобы оставаться организованными!',
        ],
        'specify-task-to' => [
            'complete' => 'Пожалуйста, укажите название задачи, которую вы хотите завершить.',
            'move' => 'Пожалуйста, укажите название задачи, которую вы хотите переместить на завтра.',
            'copy' => 'Пожалуйста, укажите название задачи, которую вы хотите скопировать на завтра.',
            'delete' => 'Пожалуйста, укажите название задачи, которую вы хотите удалить.',
        ],
        'no-tasks-to' => [
            'complete' => '📅 Нет запланированных задач для завершения.',
            'move' => '📅 Нет запланированных задач для перемещения на завтра.',
            'copy' => '📅 Нет запланированных задач для копирования на завтра.',
            'delete' => '📅 Нет запланированных задач для удаления.',
        ],
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Ошибка: Название задачи должно содержать от 3 до 100 символов.",
                    'characters' => "||(QID: 6)||\n 🚫 Ошибка: Название задачи не может содержать специальных символов, таких как подчеркивания или звездочки."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Ошибка: Неправильный формат даты. Пожалуйста, используйте формат ДД.ММ (например, 12.01 для 12 января).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Ошибка: Дата является либо недействительной, либо в прошлом. Пожалуйста, введите действительную будущую дату в пределах этого года. " . date(
                        'Y'
                    ),
            ],
            'business' => [
                'user-exceeded-daily-limit' => sprintf(
                    '🚫 Извините, вы превысили свой лимит в %d задач в день. Хотите добавить больше? Перейдите на Premium! /premium',
                    TaskLimit::DefaultUser->value
                ),
            ],
        ],
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ],
    'exceptions' => [
        'text' => 'В вашем запросе нет текста, вероятно, вы отправили что-то, в чем нет текста.',
    ],
];
