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
        if(!$event->params['isNewEntry']) {
            return;
        }

        $user = craft()->userSession->getUser();


        // retrieve followers

        if(!$user) {
            return;
        }

        $followers = craft()->follow->getFollowers($user->id);

        craft()->notifications->filterUsersByNotification($followers, $this->getHandle());


        // get the entry

        $entry = craft()->entries->getEntryById($event->params['entry']->id);

        // data
        $data = array(
            'userId' => $user->id,
            'entryId' => $entry->id,
        );

        // send email to followers
        foreach($followers as $recipient)
        {
            craft()->notifications->sendNotification($this->getHandle(), $recipient, $data);
        }
    }

    public function getVariables($data = array())
    {
        $variables = $data;

        if(!empty($data['userId']))
        {
            $variables['user'] = craft()->elements->getElementById($data['userId']);
        }

        if(!empty($data['entryId']))
        {
            $variables['entry'] = craft()->elements->getElementById($data['entryId']);
        }

        return $variables;
    }
}