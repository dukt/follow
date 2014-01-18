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

        $contextUser = craft()->userSession->getUser();


        // retrieve followers

        if(!$contextUser) {
            return;
        }

        $followers = craft()->follow->getFollowers($contextUser->id);

        craft()->notifications->filterUsersByNotification($followers, $this->getHandle());


        // get the entry

        $entry = craft()->entries->getEntryById($event->params['entry']->id);


        // send email to followers

        foreach($followers as $user) {

            $variables['user'] = $user;
            $variables['contextUser'] = $contextUser;
            $variables['entry'] = $entry;


            craft()->notifications->sendNotification($this->getHandle(), $user, $variables);
        }
    }
}