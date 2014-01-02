<?php

namespace Craft;

class Follow_OnFollowNotification extends BaseNotification
{
    /**
     * Event
     */
    public function event()
    {
        return 'follow.startFollowing';
    }


    /**
     * Action
     */
    public function action(Event $event)
    {
        $user = craft()->userSession->getUser();

        $notify = craft()->notifications->userHasNotification($user, $this->getHandle());

        $to = $event->params['element']; // assumes 'element' is an 'User'


        // send

        $variables['user'] = $user;

        craft()->notifications->sendNotification($this->getHandle(), $to, $variables);
    }
}