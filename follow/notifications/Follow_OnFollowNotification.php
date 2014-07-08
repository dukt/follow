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
        // data
        $data = $this->getDataFromEvent($event);

        // variables
        $variables = $this->getVariables($data);

        // recipient
        $recipient = $event->params['follow']->getElement();

        $sender = $variables['sender'];
        $relatedElement = $variables['follow'];

        // send notification
        craft()->notifications->sendNotification($this->getHandle(), $recipient, $sender, $relatedElement, $data);
    }

    /**
     * Get variables
     */
    public function getVariables($data = array())
    {
        if(!empty($data['followId']))
        {
            $follow = craft()->follow->getFollowById($data['followId']);
            $sender = $follow->getUser();

            return array(
                'sender' => $sender,
                'follow' => $follow
            );
        }
    }

    /**
     * Get data from event
     */
    public function getDataFromEvent(Event $event)
    {
        $follow = $event->params['follow'];
        $sender = $follow->getUser();

        return array(
            'followId' => $follow->id,
            'senderId' => $sender->id
        );
    }


    public function defaultOpenCpUrlFormat()
    {
        return '{{sender.cpEditUrl}}';
    }
}