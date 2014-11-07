<?php

/**
 * Craft Follow by Dukt
 *
 * @package   Craft Follow
 * @author    Benjamin David
 * @copyright Copyright (c) 2014, Dukt
 * @link      http://dukt.net/craft/follow/
 * @license   http://dukt.net/craft/follow/docs/license
 */

namespace Craft;

class FollowPlugin extends BasePlugin
{
    /**
     * Init: Listen to events
     */
    public function init()
    {
        craft()->on('users.onBeforeDeleteUser', function(Event $event) {

            $user = $event->params['user'];


            // delete user followers

            $follows = craft()->follow->getFollowsByElementId($user->id);

            foreach($follows as $follow)
            {
                craft()->follow->deleteFollowById($follow->id);
            }


            // delete user followings

            $follows = craft()->follow->getFollowsByUserId($user->id);

            foreach($follows as $follow)
            {
                craft()->follow->deleteFollowById($follow->id);
            }
        });

        if(isset(craft()->notifications))
        {
            craft()->on('entries.onBeforeDeleteEntry', function(Event $event) {

                $entry = $event->params['entry'];

                $notifications = craft()->notifications->findNotificationsByData('follow.onnewentry', 'entryId', $entry->id);

                foreach($notifications as $notification)
                {
                    craft()->notifications->deleteNotificationById($notification->id);
                }
            });
        }
    }

    /**
     * Get Name
     */
    function getName()
    {
        return Craft::t('Follow');
    }

    /**
     * Get Version
     */
    function getVersion()
    {
        return '0.9.3';
    }

    /**
     * Get Developer
     */
    function getDeveloper()
    {
        return 'Dukt';
    }

    /**
     * Get Developer URL
     */
    function getDeveloperUrl()
    {
        return 'https://dukt.net/';
    }

    /**
     * Has CP Section
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     * Enable notifications
     */
    public function enableNotifications()
    {
        return true;
    }
}