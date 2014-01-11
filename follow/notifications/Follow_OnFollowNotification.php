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
        $contextUser = craft()->userSession->getUser();

        $notify = craft()->notifications->userHasNotification($contextUser, $this->getHandle());

        $user = $event->params['user'];


        // send

        $variables['user'] = $user;
        $variables['contextUser'] = $contextUser;

        craft()->notifications->sendNotification($this->getHandle(), $user, $variables);
    }
}