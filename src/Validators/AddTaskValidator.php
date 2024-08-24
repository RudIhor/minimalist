<?php

declare(strict_types=1);

namespace App\Validators;

use App\Models\TemporaryLog;
use App\Services\AddTaskService;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;

class AddTaskValidator extends AbstractValidator
{
    protected AddTaskService $addTaskService;

    /**
     * @param ContainerInterface $container
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->addTaskService = new AddTaskService($container);
    }

    /**
     * @param string $text
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function title(string $text): void
    {
        $title = trim($text);
        $validator = Validation::createValidator();
        $errors = $validator->validate($title, [
            new Length(['min' => 3, 'max' => 100]),
            new NotBlank(),
        ]);
        if ($this->hasErrors($errors)) {
            $this->throwValidationErrorMessage('title.length');

            return;
        }

        preg_match_all('/(_)|(\*)/', $title, $matches);
        if (!empty(array_filter($matches))) {
            $this->throwValidationErrorMessage('title.characters');

            return;
        }

        // TODO: Rewrite the code below
        $temporaryLog = TemporaryLog::byChatId($_SESSION['chat_id'])->first();
        if (empty($temporaryLog)) {
            return;
        }
        $temporaryLog->data = ['title' => $title];
        $temporaryLog->save();

        $this->addTaskService->save($temporaryLog);
    }
}
