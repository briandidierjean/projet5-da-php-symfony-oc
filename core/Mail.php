<?php
namespace Core;

use Symfony\Component\Yaml\Yaml;

class Mail
{
    protected $receiver;
    protected $header;
    protected $subject;
    protected $body;

    public function __construct($sender = '', $subject = '', $body = '')
    {
        $emails = Yaml::parseFile(
            __DIR__.'/../config/mail.yaml'
        );

        $this->receiver = $emails['receiptAddress'];
        $this->header = 'De: '.$emails['sendingAddress'];
        $this->header .= 'Répondre à:'.$sender;
        $this->subject = $emails['subject'];
        $this->body = $body;
    }

    /**
     * This method sends a mail.
     *
     * @return null
     */
    public function send()
    {
        mail($receiver, $subject, $body, $header);
    }
}
