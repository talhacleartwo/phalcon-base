<?php
declare(strict_types=1);

/**
 * This file is part of the c2system Base System.
 *
 * (c) cleartwo deployment Team <support@cleartwo.co.uk>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Plugins\Mail;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\View;
use Swift_Mailer;
use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;

/**
 * Sends e-mails based on pre-defined templates
 */
class Mail extends Injectable
{
    /**
     * Sends e-mails based on predefined templates
     *
     * @param array  $to
     * @param string $subject
     * @param string $name
     * @param array  $params
     *
     * @return int
     */
    public function send($to, $subject, $name, $params): int
    {
        // Settings
        $mailSettings = $this->config->mail;
        $template     = $this->getTemplate($name, $params);

        // Create the message
        $message = new Message();
        $message
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom([$mailSettings->fromEmail => $mailSettings->fromName])
            ->setBody($template, 'text/html');

        $transport = new Smtp($mailSettings->smtp->server, $mailSettings->smtp->port, $mailSettings->smtp->security);
        $transport
             ->setUsername($mailSettings->smtp->username)
             ->setPassword($mailSettings->smtp->password);

        return (new Swift_Mailer($transport))->send($message);
    }
    public function sendattach($to, $subject, $name, $params,$foldername,$filename): int
    {
        // Settings
        $mailSettings = $this->config->mail;
        $template     = $this->getTemplate($name, $params);

        // Create the message
        $message = new Message();
        $message
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom([$mailSettings->fromEmail => $mailSettings->fromName])
            ->setBody($template, 'text/html');
        $path=$foldername.'/'.$filename;
        $fileName=$filename;
        $message->attach(
            \Swift_Attachment::fromPath($path)->setFilename($fileName)
        );
        $transport = new Smtp($mailSettings->smtp->server, $mailSettings->smtp->port, $mailSettings->smtp->security);
        $transport
            ->setUsername($mailSettings->smtp->username)
            ->setPassword($mailSettings->smtp->password);

        return (new Swift_Mailer($transport))->send($message);
    }

    /**
     * Applies a template to be used in the e-mail
     *
     * @param string $name
     * @param array  $params
     *
     * @return string
     */
    public function getTemplate(string $name, array $params)
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl,
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function (View $view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });
    }
    public function senddirectmail($to, $subject, $name, $params,$foldername,$filename)
    {
        // Settings
        $mailSettings = $this->config->mail;
        $template     = $this->getTemplate($name, $params);

        // Create the message
        $message = new Message();
        $message
            ->setSubject($subject)
            ->setTo($to)
            ->setFrom([$mailSettings->fromEmail => $mailSettings->fromName])
            ->setBody($template, 'text/html');
        if($filename!="") {
            foreach ($filename as $value) {
                $path ="mailattachments/" .$foldername . '/' . $value;
                $fileName = $value;
                $message->attach(
                    \Swift_Attachment::fromPath($path)->setFilename($fileName)
                );

            }
        }
        $transport = new Smtp($mailSettings->smtp->server, $mailSettings->smtp->port, $mailSettings->smtp->security);
        $transport
            ->setUsername($mailSettings->smtp->username)
            ->setPassword($mailSettings->smtp->password);

        return (new Swift_Mailer($transport))->send($message);
    }
}
