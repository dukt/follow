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
        $follow = $event->params['follow'];
        $sender = $follow->getUser();
        $recipient = $follow->getElement();

        // data
        $data = array(
            'followId' => $follow->id
        );

        // send notification
        craft()->notifications->sendNotification($this->getHandle(), $recipient, $sender, $data);
    }

    /**
     * Get variables
     */
    public function getVariables($data = array())
    {
        if(!empty($data['followId']))
        {
            $follow = craft()->follow->getFollowById($data['followId']);

            return array(
                'follow' => $follow
            );
        }
    }

    /**
     * Default Open CP Url Format
     */
    public function defaultOpenCpUrlFormat()
    {
        return '{{sender.cpEditUrl}}';
    }
}