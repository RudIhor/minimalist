<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 Willkommen bei Minimalist!

Ihr einfacher und schlanker Aufgabenmanager direkt hier auf Telegram. Verwalten Sie Ihre Aufgaben mühelos und bleiben Sie organisiert mit Minimalist.

Um loszulegen, verwenden Sie die folgenden Befehle:
**/today**: Verwalten Sie die Aufgaben von heute 📅
**/tomorrow**: Planen Sie für morgen 🗓️
**/future**: Organisieren Sie Aufgaben für zukünftige Daten 📆

🔔 Wir empfehlen, mit dem Befehl /today zu beginnen, um zu sehen, was heute auf Ihrer Agenda steht.

Das können Sie tun:
➕: Erstellen Sie neue Aufgaben mit einem einfachen Befehl.
🗑️: Entfernen Sie Aufgaben, die Sie nicht mehr benötigen.
✅: Markieren Sie Aufgaben als erledigt und verfolgen Sie Ihren Fortschritt.

Für Hilfe bei den Befehlen geben Sie /help ein.

Wir legen großen Wert auf Ihre *Privatsphäre* 🔒. Deshalb werden alle Ihre Aufgabennamen sicher mit AES (Advanced Encryption Standard) verschlüsselt.

Einfach ausgedrückt ist AES eine der fortschrittlichsten Verschlüsselungsmethoden, wodurch es nahezu unmöglich wird, Ihre Aufgabendetails zu hacken und zu lesen.

Lassen Sie uns die Dinge einfach und produktiv halten! 🌟

Hergestellt mit ❤️ in 🇺🇦
END;

$helpCommandText = <<<EOF
Minimalist ist ein einfacher und übersichtlicher Task-Manager in Telegram. Hier ist eine Liste von Befehlen, die Ihnen den Einstieg erleichtern sollen:

Befehle:

/start: Starten Sie mit Minimalist und lernen Sie, wie man den Bot benutzt.
/today: Verwalten Sie Ihre Aufgaben für heute 📅
/tomorrow: Planen Sie Ihre Aufgaben für morgen 🗓️
/future: Organisieren Sie Aufgaben für zukünftige Daten 📆

Brauchen Sie mehr Hilfe?
Wenn Sie weitere Unterstützung benötigen oder Fragen haben, wenden Sie sich bitte an den Support: @ihorrud.
EOF;

$eveningReminderText = <<<EOF
Guten Abend! 🌇

Wenn der Tag zu Ende geht, ist es eine gute Zeit, über das Erreichte nachzudenken und sich auf morgen vorzubereiten.

✅ Erledigen Sie die Aufgaben von heute
Nehmen Sie sich einen Moment Zeit, um Ihre Aufgaben für heute zu überprüfen und abzuschließen.

🔮 Planen Sie für morgen und die Zukunft

/tomorrow: Planen Sie Ihre Aufgaben für morgen und bereiten Sie sich auf einen erfolgreichen Tag vor.
/future: Organisieren Sie Ihre Aufgaben für zukünftige Daten und stellen Sie sicher, dass nichts Wichtiges übersehen wird.

Organisiert zu sein, macht alles morgen einfacher. Sie schaffen das! 💪✨
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 Es gibt noch keine Aufgaben. Fangen Sie an, einige hinzuzufügen, um organisiert zu bleiben!',
        ],
        'specify-tasks-to' => [
            'complete' => 'Bitte geben Sie den Namen der Aufgabe an, die Sie abschließen möchten.',
            'move' => 'Bitte geben Sie den Namen der Aufgabe an, die Sie auf morgen verschieben möchten.',
            'copy' => 'Bitte geben Sie den Namen der Aufgabe an, die Sie auf morgen kopieren möchten.',
            'delete' => 'Bitte geben Sie den Namen der Aufgabe an, die Sie löschen möchten.',
        ],
        'no-tasks-to' => [
            'complete' => '📅 Es gibt keine geplanten Aufgaben zum Abschließen.',
            'move' => '📅 Es gibt keine geplanten Aufgaben, die auf morgen verschoben werden können.',
            'copy' => '📅 Es gibt keine geplanten Aufgaben zum Kopieren auf morgen.',
            'delete' => '📅 Es gibt keine geplanten Aufgaben zum Löschen.',
        ],
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Fehler: Der Titel der Aufgabe muss zwischen 3 und 100 Zeichen lang sein.",
                    'characters' => "||(QID: 6)||\n 🚫 Fehler: Der Titel der Aufgabe darf keine Sonderzeichen wie Unterstriche (_) oder Sternchen (*) enthalten."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Fehler: Ungültiges Datumsformat. Bitte verwenden Sie das Format TT.MM (z. B. 12.01 für den 12. Januar).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Fehler: Das Datum ist entweder ungültig oder liegt in der Vergangenheit. Bitte geben Sie ein gültiges zukünftiges Datum innerhalb des Jahres ein." . date('Y'),
            ],
        ],
        'business' => [
            'user-exceeded-daily-limit' => sprintf(
                '🚫 Entschuldigung, Sie haben Ihr Limit von %d Aufgaben pro Tag überschritten. Möchten Sie mehr hinzufügen? Upgrade auf Premium! /premium',
                TaskLimit::DefaultUser->value
            ),
        ]
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ]
];
