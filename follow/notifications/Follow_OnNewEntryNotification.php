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
            $entry = $event->params['entry'];
            $sender = $entry->getAuthor();

            // data
            $data = array(
                'entryId' => $entry->id
            );


            // get sender's followers

            $follows = craft()->follow->getFollowsByElementId($sender->id);

            foreach($follows as $follow)
            {
                $recipient = $follow->getUser();

                $data['followId'] = $follow->id;

                craft()->notifications->sendNotification($this->getHandle(), $recipient, $sender, $data);
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
            $follow = craft()->follow->getFollowById($data['followId']);

            $variables = array(
                'entry' => $entry,
                'follow' => $follow,
            );

            return $variables;
        }
    }

    /**
     * Default Open Url Format
     */
    public function defaultOpenUrlFormat()
    {
        return '{{entry.url}}';
    }

    /**
     * Default Open CP Url Format
     */
    public function defaultOpenCpUrlFormat()
    {
        return '{{entry.cpEditUrl}}';
    }
}