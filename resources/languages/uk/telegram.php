<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 Ласкаво просимо до Minimalist!

Ваш простий та лаконічний менеджер завдань прямо тут, у Telegram. Керуйте своїми завданнями без зусиль і залишайтеся організованими з Minimalist.

Щоб почати, використовуйте команди нижче:
**/today**: Керуйте завданнями на сьогодні 📅
**/tomorrow**: Плануйте завдання на завтра 🗓️
**/future**: Організовуйте завдання на майбутні дати 📆

🔔 Рекомендуємо почати з команди /today, щоб побачити, що у вас заплановано на сьогодні.

Ось що ви можете зробити:
➕: Створюйте нові завдання за допомогою простої команди.
🗑️: Видаляйте завдання, які вам більше не потрібні.
✅: Відзначайте завдання як виконані та відстежуйте свій прогрес.

Для допомоги з командами введіть /help.

Давайте тримати все просто і продуктивно! 🌟

Зроблено з ❤️ в 🇺🇦
END;

$helpCommandText = <<<EOF
Ласкаво просимо до Minimalist! Ваш простий та лаконічний менеджер завдань у Telegram. Ось список команд, які допоможуть вам отримати максимум від цього досвіду:

Команди:

/start: Почніть використовувати Minimalist та дізнайтеся, як використовувати бота.
/today: Керуйте завданнями на сьогодні 📅
/tomorrow: Плануйте завдання на завтра 🗓️
/future: Організовуйте завдання на майбутні дати 📆

Потрібна додаткова допомога?
Якщо вам потрібна додаткова допомога або у вас є запитання, звертайтеся за підтримкою: @ihorrud.
EOF;

$eveningReminderText = <<<EOF
Добрий вечір! 🌇

Як день наближається до завершення, саме час подумати про те, що ви досягли, і підготуватися до завтрашнього дня.

✅ Завершіть завдання на сьогодні
Виділіть момент, щоб переглянути та завершити свої завдання на сьогодні.

🔮 Плануйте на завтра та на майбутнє

/tomorrow: Заплануйте свої завдання на завтра і налаштуйте себе на успішний день.
/future: Організовуйте свої завдання на майбутні дати і переконайтеся, що нічого важливого не пропущено.

Організованість зараз робить все простішим завтра. У вас все вийде! 💪✨
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 Завдань поки немає. Почніть додавати їх, щоб залишатися організованими!',
        ],
        'specify-task-number' => '🔢 Будь ласка, вкажіть номер завдання, яке ви хочете %s.',
        'no-tasks' => '📅 На цю дату немає запланованих завдань.',
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Помилка: Назва завдання має містити від 3 до 100 символів.",
                    'characters' => "||(QID: 6)||\n 🚫 Помилка: Назва завдання не може містити спеціальних символів, таких як підкреслення (_) або зірочки (*)."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Помилка: Неправильний формат дати. Будь ласка, використовуйте формат ДД ММ (наприклад, 12 01 для 12 січня).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Помилка: Дата є або недійсною, або в минулому. Будь ласка, введіть дійсну майбутню дату протягом цього року." . date('Y'),
            ],
        ],
        'business' => [
            'user-exceeded-daily-limit' => sprintf(
                '🚫 Вибачте, ви перевищили свій ліміт у %d завдань на день. Хочете додати більше? Перейдіть на Premium! /premium',
                TaskLimit::DefaultUser->value
            ),
        ]
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ]
];
