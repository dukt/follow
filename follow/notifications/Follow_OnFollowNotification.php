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
     * Send Notification
     */
    public function send()
    {
        craft()->on('follow.startFollowing', function(Event $event) {

            $user = craft()->userSession->getUser();

            $notify = craft()->notifications->userHasNotification($user, $this->getHandle());

            $to = $event->params['element']; // assumes 'element' is an 'User'


            // send

            $variables['user'] = $user;

            craft()->notifications->sendNotification($this->getHandle(), $to, $variables);
        });
    }
}