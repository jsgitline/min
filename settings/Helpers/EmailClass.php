<?php

namespace Settings\Helpers;


use Models\ItemModel;
use Models\Standart;
use Models\UserModel;

class EmailClass
{
    protected $transport;
    protected $mailer;

    public function __construct()
    {
        $this->transport = (new \Swift_SmtpTransport($_ENV['SMTP_SERVER'], $_ENV['SMTP_PORT']))
            ->setUsername($_ENV['SMTP_USER'])
            ->setPassword($_ENV['SMTP_PASS'])
            ;
    }

    /**
     * Создаёт экземпляр mailer
     */
    protected function createMailer()
    {
        $this->mailer = new \Swift_Mailer($this->transport);
    }

    /**
     * @param $setFrom
     * @param $setTo
     * @param $subject
     * @param $body
     * @return mixed
     * Создаёт произвольное сообщение от
     */
    public function setMessage($setFrom, $setTo, $subject, $body)
    {
        $logger = new \Swift_Plugins_Loggers_EchoLogger();
        $mailer = new \Swift_Mailer($this->transport);
        //$mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($logger));

        $this->createMailer();
        // Create a message
        $message = (new \Swift_Message($subject))
            ->setContentType('text/html')
            ->setFrom([$setFrom['email'] => $setFrom['name']])
            ->setTo([$setTo['email'] => $setTo['name']])
            ->setBody($body)
        ;

        echo $logger->dump();
        // Send the message
        return $mailer->send($message);
    }

    /**
     * @param $setTo
     * @param $subject
     * @param $body
     * Отправляет почту от админа
     */
    public function setMessageFromAdmin($setTo, $subject, $body)
    {
        $setFrom['email'] = $_ENV['ADMIN_EMAIL'];
        $setFrom['name'] = $_ENV['ADMIN_NAME'];
        $this->setMessage($setFrom, $setTo, $subject, $body);
    }

}