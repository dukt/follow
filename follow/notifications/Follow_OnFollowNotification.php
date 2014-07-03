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

        // recipient
        $recipient = $event->params['user'];

        // data
        $data = array(
            'userId' => $user->id
        );

        // send notification
        craft()->notifications->sendNotification($this->getHandle(), $recipient, $data);
    }

    public function getVariables($data = array())
    {
        $variables = $data;

        if(!empty($data['userId']))
        {
            $variables['user'] = craft()->elements->getElementById($data['userId']);
        }

        return $variables;
    }
}