<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 ¡Bienvenido a Minimalist!

Tu gestor de tareas simple y delgado, aquí mismo en Telegram. Gestiona tus tareas sin esfuerzo y mantente organizado con Minimalist.

Para comenzar, utiliza los comandos a continuación:
**/today**: Gestiona las tareas de hoy 📅
**/tomorrow**: Planea para mañana 🗓️
**/future**: Organiza las tareas para fechas futuras 📆

🔔 Recomendamos comenzar con el comando /today para ver lo que tienes en tu agenda para hoy.

Esto es lo que puedes hacer:
➕: Crea nuevas tareas con un simple comando.
🗑️: Elimina las tareas que ya no necesitas.
✅: Marca las tareas como completadas y sigue tu progreso.

Para obtener ayuda con los comandos, escribe /help.

Priorizamos tu *privacidad* 🔒. Por eso, todos los nombres de tus tareas están cifrados de manera segura utilizando AES (Advanced Encryption Standard).

En términos simples, AES es uno de los métodos de cifrado más avanzados, lo que hace que sea prácticamente imposible que alguien piratee y acceda a los detalles de tus tareas.

¡Mantengamos las cosas simples y productivas! 🌟

Hecho con ❤️ en 🇺🇦
END;

$helpCommandText = <<<EOF
Minimalista es un administrador de tareas simple y conciso en Telegram. Aquí hay una lista de comandos para comenzar:

Comandos:

/start: Comienza con Minimalist y aprende a usar el bot.
/today: Gestiona tus tareas para hoy 📅
/tomorrow: Planea tus tareas para mañana 🗓️
/future: Organiza las tareas para fechas futuras 📆

¿Necesitas más ayuda?
Si necesitas más asistencia o tienes alguna pregunta, no dudes en pedir ayuda: @ihorrud.
EOF;

$eveningReminderText = <<<EOF
¡Buenas noches! 🌇

A medida que el día termina, es un buen momento para reflexionar sobre lo que has logrado y prepararte para mañana.

✅ Completa las tareas de hoy
Tómate un momento para revisar y completar tus tareas de hoy.

🔮 Planea para mañana y el futuro

/tomorrow: Programa tus tareas para mañana y prepárate para un día exitoso.
/future: Organiza tus tareas para fechas futuras y asegúrate de que nada importante se te escape.

Estar organizado ahora hace que todo sea más fácil mañana. ¡Tú puedes hacerlo! 💪✨
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 Todavía no hay tareas. ¡Comienza a agregar algunas para mantenerte organizado!',
        ],
        'specify-task-to' => [
            'complete' => 'Por favor, especifique el nombre de la tarea que desea completar.',
            'move' => 'Por favor, especifique el nombre de la tarea que desea mover a mañana.',
            'copy' => 'Por favor, especifique el nombre de la tarea que desea copiar para mañana.',
            'delete' => 'Por favor, especifique el nombre de la tarea que desea eliminar.',
        ],
        'no-tasks-to' => [
            'complete' => '📅 No hay tareas programadas para completar.',
            'move' => '📅 No hay tareas programadas para mover a mañana.',
            'copy' => '📅 No hay tareas programadas para copiar para mañana.',
            'delete' => '📅 No hay tareas programadas para eliminar.',
        ],
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Error: El título de la tarea debe tener entre 3 y 100 caracteres.",
                    'characters' => "||(QID: 6)||\n 🚫 Error: El título de la tarea no puede contener caracteres especiales como guiones bajos (_) o asteriscos (*)."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Error: Formato de fecha inválido. Por favor, utiliza el formato DD.MM (por ejemplo, 12.01 para el 12 de enero).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Error: La fecha es inválida o está en el pasado. Por favor, introduce una fecha futura válida dentro del año. " . date('Y'),
            ],
        ],
        'business' => [
            'user-exceeded-daily-limit' => sprintf(
                '🚫 Lo siento, has excedido tu límite de %d tareas por día. ¿Quieres agregar más? ¡Pasa a Premium! /premium',
                TaskLimit::DefaultUser->value
            ),
        ]
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ]
];
