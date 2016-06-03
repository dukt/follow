<?php
/**
 * @link      https://dukt.net/craft/follow/
 * @copyright Copyright (c) 2016, Dukt
 * @license   https://dukt.net/craft/follow/docs/license
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
        return '1.0.0';
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
}