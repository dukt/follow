<?php

namespace Craft;

class Follow_OnNewEntryNotification extends BaseNotification
{
    /**
     * Event
     */
    public function event()
    {
        return 'entries.onSaveEntry';
    }

    /**
     * Action
     */
    public function action(Event $event)
    {
        if($event->params['isNewEntry'])
        {
            $data = $this->getDataFromEvent($event);
            $variables = $this->getVariables($data);

            $followers = craft()->follow->getFollowers($variables['sender']->id);
            // var_dump($variables['sender']->id, $followers);

            craft()->notifications->filterUsersByNotification($followers, $this->getHandle());

            $follows = craft()->follow->getFollowsByUserId($variables['sender']->id);

            // send email to followers
            foreach($followers as $recipient)
            {
                foreach($follows as $follow)
                {
                    if($follow->userId == $recipient->id)
                    {
                        $data['followId'] = $follow->id;
                    }
                }

                craft()->notifications->sendNotification($this->getHandle(), $recipient, $data);
            }
        }
    }

    /**
     * Get variables
     */
    public function getVariables($data = array())
    {
        if(!empty($data['entryId']))
        {
            $entry = craft()->entries->getEntryById($data['entryId']);
            $sender = $entry->author;

            return array(
                'sender' => $sender,
                'entry' => $entry,
            );
        }
    }

    /**
     * Get data from event
     */
    public function getDataFromEvent(Event $event)
    {
        return array(
            'entryId' => $event->params['entry']->id,
            'senderId' => $event->params['entry']->authorId
        );
    }

    public function defaultOpenUrlFormat()
    {
        return '{{entry.url}}';
    }

    public function defaultOpenCpUrlFormat()
    {
        return '{{entry.cpEditUrl}}';
    }
}