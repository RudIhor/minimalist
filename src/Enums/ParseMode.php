<?php

declare(strict_types=1);

namespace App\Enums;

enum ParseMode: string
{
    case MarkdownV2 = 'MarkdownV2';
    case Markdown = 'Markdown';
    case HTML = 'HTML';
}
