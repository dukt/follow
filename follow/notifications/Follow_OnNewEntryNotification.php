<?php

namespace Craft;

class Follow_OnNewEntryNotification extends BaseNotification
{
    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone I follow posts new entries";
    }

    /**
     * Notification Action
     */
    public function getAction()
    {
        craft()->on('entries.onSaveEntry', function(Event $event) {

            if(!$event->params['isNewEntry']) {
                return;
            }

            $author = craft()->userSession->getUser();

            // retrieve followers

            $followers = craft()->follow->getFollowers($author->id);

            craft()->notifications->filterUsersByNotification($followers, $this->getHandle());


            // send email to followers

            foreach($followers as $follower) {

                // send email

                $emailModel = new EmailModel;

                $emailModel->toEmail = $follower->email;

                $emailModel->subject = 'Someone has posted a new entry';
                $emailModel->htmlBody = "A user that you are following has posted a new entry : {{entry.title}}";

                $variables['author'] = $author;
                $variables['follower'] = $follower;
                $variables['entry'] = $event->params['entry'];

                craft()->email->sendEmail($emailModel, $variables);
            }

        });
    }
}