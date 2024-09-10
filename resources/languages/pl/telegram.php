<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 Witaj w Minimalist!

Twój prosty i zgrabny menedżer zadań, tutaj na Telegramie. Zarządzaj swoimi zadaniami bez wysiłku i bądź zorganizowany z Minimalist.

Aby rozpocząć, użyj poniższych poleceń:
**/today**: Zarządzaj zadaniami na dziś 📅
**/tomorrow**: Planuj na jutro 🗓️
**/future**: Organizuj zadania na przyszłe daty 📆

🔔 Zalecamy rozpoczęcie od polecenia /today, aby zobaczyć, co masz w planach na dziś.

Oto, co możesz zrobić:
➕: Twórz nowe zadania za pomocą prostego polecenia.
🗑️: Usuwaj zadania, których już nie potrzebujesz.
✅: Oznaczaj zadania jako ukończone i śledź swój postęp.

Aby uzyskać pomoc dotyczącą poleceń, wpisz /help.

Priorytetem jest dla nas Twoja *prywatność* 🔒. Dlatego nazwy wszystkich zadań są bezpiecznie szyfrowane za pomocą AES (Advanced Encryption Standard).

Mówiąc prościej, AES to jedna z najbardziej zaawansowanych metod szyfrowania, co sprawia, że praktycznie niemożliwe jest zhakowanie i dostęp do szczegółów Twoich zadań.

Trzymajmy wszystko prosto i produktywnie! 🌟

Zrobione z ❤️ w 🇺🇦
END;

$helpCommandText = <<<EOF
Minimalist to prosty i zwięzły menedżer zadań w Telegramie. Oto lista poleceń ułatwiających rozpoczęcie pracy:

Polecenia:

/start: Rozpocznij z Minimalist i dowiedz się, jak korzystać z bota.
/today: Zarządzaj swoimi zadaniami na dziś 📅
/tomorrow: Planuj swoje zadania na jutro 🗓️
/future: Organizuj zadania na przyszłe daty 📆

Potrzebujesz więcej pomocy?
Jeśli potrzebujesz więcej wsparcia lub masz jakieś pytania, skontaktuj się z nami: @ihorrud.
EOF;

$eveningReminderText = <<<EOF
Dobry wieczór! 🌇

Kiedy dzień dobiega końca, to dobry moment, aby zastanowić się nad tym, co udało Ci się osiągnąć, i przygotować się na jutro.

✅ Ukończ dzisiejsze zadania
Poświęć chwilę, aby przejrzeć i ukończyć swoje dzisiejsze zadania.

🔮 Planuj na jutro i na przyszłość

/tomorrow: Zaplanuj swoje zadania na jutro i przygotuj się na udany dzień.
/future: Organizuj swoje zadania na przyszłe daty i upewnij się, że nic ważnego Ci nie umknie.

Bycie zorganizowanym teraz sprawia, że wszystko jest łatwiejsze jutro. Dasz radę! 💪✨
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 Nie ma jeszcze zadań. Zacznij dodawać, aby być zorganizowanym!',
        ],
        'specify-task-to' => [
            'complete' => 'Proszę podać nazwę zadania, które chcesz ukończyć.',
            'move' => 'Proszę podać nazwę zadania, które chcesz przenieść na jutro.',
            'copy' => 'Proszę podać nazwę zadania, które chcesz skopiować na jutro.',
            'delete' => 'Proszę podać nazwę zadania, które chcesz usunąć.',
        ],
        'no-tasks-to' => [
            'complete' => '📅 Brak zaplanowanych zadań do ukończenia.',
            'move' => '📅 Brak zaplanowanych zadań do przeniesienia na jutro.',
            'copy' => '📅 Brak zaplanowanych zadań do skopiowania na jutro.',
            'delete' => '📅 Brak zaplanowanych zadań do usunięcia.',
        ],
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Błąd: Tytuł zadania musi mieć od 3 do 100 znaków.",
                    'characters' => "||(QID: 6)||\n 🚫 Błąd: Tytuł zadania nie może zawierać znaków specjalnych, takich jak podkreślenia (_) czy gwiazdki (*)."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Błąd: Nieprawidłowy format daty. Proszę użyj formatu DD.MM (np. 12.01 dla 12 stycznia).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Błąd: Data jest nieprawidłowa lub jest z przeszłości. Proszę podaj prawidłową przyszłą datę w roku ." . date('Y'),
            ],
        ],
        'business' => [
            'user-exceeded-daily-limit' => sprintf(
                '🚫 Przepraszam, przekroczyłeś swój limit %d zadań na dzień. Chcesz dodać więcej? Przejdź na Premium! /premium',
                TaskLimit::DefaultUser->value
            ),
        ]
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ]
];
