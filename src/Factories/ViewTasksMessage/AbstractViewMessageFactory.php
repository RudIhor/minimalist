<?php

declare(strict_types=1);

namespace App\Factories\ViewTasksMessage;

use App\Core\GrowthMindsetService;
use App\Enums\Emoji;
use App\Models\Task;
use App\Services\HashService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractViewMessageFactory
{
    public const DATE_FORMAT = 'l jS F Y';
    public const NORMAL_FORMAT = "*%s %s* \n\n";
    public const COMPLETED_FORMAT = "~*%s %s*~ \n\n";

    public function __construct(
        protected Carbon $date,
        protected TranslatorInterface $translator,
        protected HashService $hashService,
        protected string $locale = 'en'
    ) {
    }

    /**
     * @param Collection $tasks
     * @return string
     */
    public function getText(Collection $tasks): string
    {
        return $this->header() . $this->body($tasks) . $this->footer($tasks);
    }

    /**
     * @return string
     */
    protected function header(): string
    {
        return sprintf(
            $this->translator->trans('commands.view.header', locale: $this->locale),
            $this->date->translatedFormat(self::DATE_FORMAT),
        );
    }

    /**
     * @param Collection $tasks
     * @return string
     */
    protected function body(Collection $tasks): string
    {
        $body = '';
        if ($tasks->count() === 0) {
            return $this->translator->trans('commands.view.body-no-tasks', locale: $this->date->locale);
        }
        foreach ($tasks as $task) {
            $body .= $this->generateTaskLine($task);
        }

        return rtrim($body);
    }

    /**
     * @param Task $task
     * @return string
     */
    private function generateTaskLine(Task $task): string
    {
        $format = self::NORMAL_FORMAT;
        if ($task->is_completed) {
            $format = self::COMPLETED_FORMAT;
        }

        return sprintf(
            $format,
            Emoji::getEmojiNumberByIndex($task->index),
            $this->hashService->decrypt($task->title),
        );
    }

    /**
     * @param Collection $tasks
     * @return string
     */
    protected function footer(Collection $tasks): string
    {
        $growthMindsetService = new GrowthMindsetService($_ENV['GROWTH_MINDSET_TOKEN']);

        return sprintf("\n\n_%s_", $growthMindsetService->getRandomQuoteWithTranslation($this->locale));
    }
}
