<?php

declare(strict_types=1);

$startCommandText = <<<END
👋 Welcome to Minimalist\!

Your sleek and simple task manager, right here on Telegram\. Manage your tasks effortlessly and stay organized with Minimalist\.

To get started, use the commands below:
**/today**: Manage today's tasks 📅
**/tomorrow**: Plan for tomorrow 🗓️
**/future**: Organize tasks for future dates 📆

🔔 We recommend starting with the /today command to see what's on your agenda for today\.

Here's what you can do:
**➕ Add Tasks**: Create new tasks with a simple command\.
**👀 View Tasks**: See your tasks for today, tomorrow, and the future\.
**🗑️ Delete Tasks**: Remove tasks you no longer need\.
**✅ Complete Tasks**: Mark tasks as completed and track your progress\.

Type /today to see your tasks for today or use the menu buttons below\.

For help with commands, type /help\.

Let's keep things simple and productive\! 🌟
END;


return [
    'commands' => [
        'start' => $startCommandText,
        'add' => [
            'step' => [
                '1' => "Great\n Let's add a new task to your to do list for today\n What's the name of the task? Example",
                '2' => 'What is the priority of the task? Example'
            ],
        ],
    ],
    'validation' => [
        'commands' => [
            'add' => [
                'title' => 'Error\. Min 3\. Max 25\.',
                'priority' => 'Error\. Choose from 1(High) to 3(Low)'
            ],
        ],
    ],
];
