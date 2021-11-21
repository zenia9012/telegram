<?php

namespace Yevhenii\Telegram;


class TelegramCore
{
    /**
     * send request via curl
     * @param $url
     * @return string
     */
    private function curlHandler($url)
    {
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * handle send message
     *
     * @param $message
     * @param $recipient
     * @return bool
     */
    public function send(string $message, string $recipient)
    {
        $url = $this->generateUrl($message, $recipient);

        try {
            $result = $this->curlHandler($url);
            $result = json_decode($result);
            $result = $result->ok;
        } catch (\Exception $exception) {
            $result = false;
        }

        return $result;
    }

    /**
     * generate request url
     *
     * @param $message
     * @param $recipient
     * @return string
     */
    private function generateUrl($message, $recipient)
    {
        $url = config('telegram.domain') . config('telegram.token_bot') . "/sendMessage?chat_id=" . $recipient;
        $url = $url . "&text=" . urlencode($message);

        return $url;
    }
}
