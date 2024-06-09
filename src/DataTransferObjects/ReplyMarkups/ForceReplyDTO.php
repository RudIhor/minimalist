<?php

declare(strict_types=1);

namespace App\DataTransferObjects\ReplyMarkups;

class ForceReplyDTO implements AbstractReplyMarkup
{
    protected function __construct(public bool $force_reply)
    {
    }

    /**
     * @param bool $isForceReply
     * @return ForceReplyDTO
     */
    public static function make(bool $isForceReply): ForceReplyDTO
    {
        return new self($isForceReply);
    }

    /**
     * @return bool[]
     */
    public function toArray(): array
    {
        return ['force_reply' => $this->force_reply];
    }
}
