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

        $recipient = $event->params['user'];


        // send

        $variables['recipient'] = $recipient;
        $variables['contextUser'] = $contextUser;
        $variables['user'] = $contextUser;

        craft()->notifications->sendNotification($this->getHandle(), $recipient, $variables);
    }

    public function getOpenCpUrl()
    {
        return "{{ user.cpEditUrl }}";
    }
}