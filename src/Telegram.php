<?php

namespace Yevhenii\Telegram;


class Telegram
{
    private string $title;

    /**
     * @var TelegramCore
     */
    private TelegramCore $telegram;

    /**
     * TelegramMessages constructor.
     */
    public function __construct()
    {
        $this->telegram = new TelegramCore();
    }

    /**
     * send single message
     *
     * @param              $message
     * @param array|string $recipients
     */
    public function sendTo($message, array|string $recipients)
    {
        if ($this->title != '') {
            $message = $this->title . $message;
        }

        if (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                $this->telegram->send($message, $recipient);
            }
        } else {
            $this->telegram->send($message, $recipients);
        }
    }

    /**
     * send multiple message
     *
     * @param array $messages
     * @param array|string $recipients
     * @return void
     */
    public function messages(array $messages, array|string $recipients)
    {
        foreach ($messages as $message) {
            $this->sendTo($message, $recipients);
        }
    }

    /**
     * debug message
     * @param array|string $message
     */
    public function info(array|string $message)
    {
        $this->title = 'Info: ' . env('APP_NAME') . ': ';

        if (is_array($message)) {
            $this->messages($message, config('telegram.recipient_debug'));
        } else {
            $this->sendTo($message, config('telegram.recipient_debug'));
        }
    }

    public function error(array|string $message)
    {
        $this->title = 'Error: ' . env('APP_NAME') . ': ';
        if (is_array($message)) {
            $this->messages($message, config('telegram.recipient_debug'));
        } else {
            $this->sendTo($message, config('telegram.recipient_debug'));
        }
    }
}
