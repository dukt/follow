<?php

namespace Craft;

class Follow_OnNewEntryNotification extends BaseNotification
{
    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone I follow posts new entries";
    }


    /**
     * Send Notification
     */
    public function send()
    {
        craft()->on('entries.onSaveEntry', function(Event $event) {

            if(!$event->params['isNewEntry']) {
                return;
            }

            $author = craft()->userSession->getUser();

            // retrieve followers

            $followers = craft()->follow->getFollowers($author->id);

            craft()->notifications->filterUsersByNotification($followers, $this->getHandle());


            // get the entry

            $entry = craft()->entries->getEntryById($event->params['entry']->id);


            // send email to followers

            foreach($followers as $follower) {

                $variables['author'] = $author;
                $variables['follower'] = $follower;
                $variables['entry'] = $entry;


                craft()->notifications->sendNotification($this->getHandle(), $follower, $variables);
            }
        });
    }
}