<?php
namespace Core;

use Symfony\Component\Yaml\Yaml;

class Mail
{
    protected $receiver;
    protected $header;
    protected $subject;
    protected $body;

    public function __construct($sender, $subject = '', $body = '')
    {
        $config = Yaml::parseFile(
            __DIR__.'/../config/mail.yaml'
        );

        $this->receiver = $config['receiver'];
        $this->header = 'De: '.$config['senddingAddress'];
        $this->header .= 'Répondre à:'.$sender;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Send an email
     *
     * @return void
     */
    public function send()
    {
        mail($this->receiver, $this->subject, $this->body, $this->header);
    }
}
