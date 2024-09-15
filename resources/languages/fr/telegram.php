<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 Bienvenue chez Minimalist!

Votre gestionnaire de tâches simple et épuré, directement sur Telegram. Gérez vos tâches sans effort et restez organisé avec Minimalist.

Pour commencer, utilisez les commandes ci-dessous :
**/today**: Gérez les tâches d'aujourd'hui 📅
**/tomorrow**: Planifiez pour demain 🗓️
**/future**: Organisez les tâches pour les dates futures 📆

🔔 Nous recommandons de commencer par la commande /today pour voir ce qui est à l'ordre du jour aujourd'hui.

Voici ce que vous pouvez faire :
➕: Créez de nouvelles tâches avec une simple commande.
🗑️: Supprimez les tâches dont vous n'avez plus besoin.
✅: Marquez les tâches comme terminées et suivez votre progression.

Pour obtenir de l'aide avec les commandes, tapez /help.

Nous priorisons votre *confidentialité* 🔒. C'est pourquoi tous les noms de vos tâches sont sécurisés par chiffrement avec AES (Advanced Encryption Standard).

En termes simples, AES est l'une des méthodes de cryptage les plus avancées, rendant pratiquement impossible pour quiconque de pirater et d'accéder aux détails de vos tâches.

Gardons les choses simples et productives! 🌟

Fait avec ❤️ en 🇺🇦
END;

$helpCommandText = <<<EOF
Minimalist est un gestionnaire de tâches simple et concis dans Telegram. Voici une liste de commandes pour vous aider à démarrer :

Commandes :

/start: Commencez avec Minimalist et apprenez à utiliser le bot.
/today: Gérez vos tâches pour aujourd'hui 📅
/tomorrow: Planifiez vos tâches pour demain 🗓️
/future: Organisez les tâches pour les dates futures 📆

Besoin de plus d'aide ?
Si vous avez besoin de plus d'assistance ou si vous avez des questions, n'hésitez pas à demander du soutien : @ihorrud.
EOF;

$eveningReminderText = <<<EOF
Bonsoir! 🌇

Alors que la journée se termine, c'est un bon moment pour réfléchir à ce que vous avez accompli et vous préparer pour demain.

✅ Terminez les tâches d'aujourd'hui
Prenez un moment pour revoir et terminer vos tâches d'aujourd'hui.

🔮 Planifiez pour demain et l'avenir

/tomorrow: Planifiez vos tâches pour demain et préparez-vous à une journée réussie.
/future: Organisez vos tâches pour les dates futures et assurez-vous que rien d'important ne passe à travers les mailles du filet.

Être organisé maintenant rend tout plus facile demain. Vous pouvez le faire! 💪✨
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 Il n\'y a pas encore de tâches. Commencez à en ajouter pour rester organisé!',
        ],
        'specify-task-to' => [
            'complete' => 'Veuillez spécifier le nom de la tâche que vous souhaitez terminer.',
            'move' => 'Veuillez spécifier le nom de la tâche que vous souhaitez déplacer à demain.',
            'copy' => 'Veuillez spécifier le nom de la tâche que vous souhaitez copier pour demain.',
            'delete' => 'Veuillez spécifier le nom de la tâche que vous souhaitez supprimer.',
        ],
        'no-tasks-to' => [
            'complete' => '📅 Il n\'y a pas de tâches planifiées à terminer.',
            'move' => '📅 Il n\'y a pas de tâches planifiées à déplacer à demain.',
            'copy' => '📅 Il n\'y a pas de tâches planifiées à copier pour demain.',
            'delete' => '📅 Il n\'y a pas de tâches planifiées à supprimer.',
        ],
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Erreur : Le titre de la tâche doit comporter entre 3 et 100 caractères.",
                    'characters' => "||(QID: 6)||\n 🚫 Erreur : Le titre de la tâche ne peut pas contenir de caractères spéciaux tels que des soulignements (_) ou des astérisques (*)."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Erreur : Format de date invalide. Veuillez utiliser le format JJ.MM (par exemple, 12.01 pour le 12 janvier).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Erreur : La date est soit invalide, soit passée. Veuillez entrer une date future valide dans l'année. " . date('Y'),
            ],
        ],
        'business' => [
            'user-exceeded-daily-limit' => sprintf(
                '🚫 Désolé, vous avez dépassé votre limite de %d tâches par jour. Vous voulez en ajouter plus? Passez à Premium! /premium',
                TaskLimit::DefaultUser->value
            ),
        ]
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ],
    'exceptions' => [
        'text' => "Il n'y a pas de texte dans votre demande, vous avez probablement envoyé quelque chose qui n'a pas de texte."
    ],
];
