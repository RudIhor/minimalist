<?php

declare(strict_types=1);

use App\Enums\TaskLimit;

$startCommandText = <<<END
👋 Welcome to Minimalist!

Your simple and slim task manager, right here on Telegram. Manage your tasks effortlessly and stay organized with Minimalist.

To get started, use the commands below:
**/today**: Manage today's tasks 📅
**/tomorrow**: Plan for tomorrow 🗓️
**/future**: Organize tasks for future dates 📆

🔔 We recommend starting with the /today command to see what's on your agenda for today.

Here's what you can do:
➕: Create new tasks with a simple command.
🗑️: Remove tasks you no longer need.
✅: Mark tasks as completed and track your progress.

For help with commands, type /help.

Let's keep things simple and productive! 🌟

Made with ❤️ in 🇺🇦 
END;

$helpCommandText = <<<EOF
Welcome to Minimalist! Your simple and slim task manager on Telegram. Here’s a list of commands to help you get the most out of your experience:

Commands:

/start: Get started with Minimalist and learn how to use the bot.
/today: Manage your tasks for today 📅
/tomorrow: Plan your tasks for tomorrow 🗓️
/future: Organize tasks for future dates 📆

Need More Help?
If you need more assistance or have any questions, feel free to reach out for support: @ihorrud.
EOF;

$eveningReminderText = <<<EOF
Good evening! 🌇

As the day winds down, it's a great time to reflect on what you've accomplished and get ready for tomorrow.

✅ Complete Today's Tasks
Take a moment to review and complete your tasks for today.

🔮 Plan for Tomorrow and the Future

/tomorrow: Schedule your tasks for tomorrow and set yourself up for a successful day.
/future: Organize your tasks for future dates and ensure nothing important slips through the cracks.

Keeping things organized now makes everything easier tomorrow. You've got this! 💪✨
EOF;


return [
    'commands' => [
        'start' => $startCommandText,
        'help' => $helpCommandText,
        'view' => [
            'header' => "📅 *%s*\n\n",
            'body-no-tasks' => '📝 There are no tasks yet. Start adding some to stay organized!',
        ],
        'specify-task-number' => '🔢 Please specify the task number you want to %s.',
        'no-tasks' => '📅 No tasks scheduled for this date.',
    ],
    'validation' => [
        'errors' => [
            'invalid' => [
                'title' => [
                    'length' => "||(QID: 2)||\n 🚫 Error: The task title must be between 3 and 100 characters.",
                    'characters' => "||(QID: 6)||\n 🚫 Error: The task title cannot contain special characters like underscores (_) or asterisks (*)."
                ],
                'date-format' => "||(QID: 4)||\n 🚫 Error: Invalid date format. Please use the format DD MM (e.g., 12 01 for January 12th).",
                'date-in-past-or-invalid' => "||(QID: 5)||\n 🚫 Error: The date is either invalid or in the past. Please enter a valid future date within the year ." . date('Y'),
            ],
        ],
        'business' => [
            'user-exceeded-daily-limit' => sprintf(
                '🚫 Sorry, you have exceeded your limit of %d tasks per day. Want to add more? Upgrade to Premium! /premium',
                TaskLimit::DefaultUser->value
            ),
        ]
    ],
    'reminders' => [
        'evening' => $eveningReminderText,
    ]
];
