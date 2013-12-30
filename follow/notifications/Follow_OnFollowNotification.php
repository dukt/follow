<?php

namespace Craft;

class Follow_OnFollowNotification extends BaseNotification
{
    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone starts following me";
    }

    /**
     * Notification Action
     */
    public function getAction()
    {
        craft()->on('follow.startFollowing', function(Event $event) {

            $user = craft()->userSession->getUser();

            $notify = craft()->notifications->userHasNotification($user, $this->getHandle());

            if($notify) {

                $toUser = $event->params['element']; // assumes 'element' is an 'User'


                // send email

                $emailModel = new EmailModel;

                $emailModel->toEmail = $toUser->email;

                $emailModel->subject = 'You have a new follower';
                $emailModel->htmlBody = "A user has started following you : {{user.email}}";

                $variables['user'] = $user;

                craft()->email->sendEmail($emailModel, $variables);
            }
        });
    }
}