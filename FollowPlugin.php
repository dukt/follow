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
    public function getName()
    {
        return Craft::t('Follow');
    }

    /**
     * Get Version
     */
    public function getVersion()
    {
        return '1.0.1';
    }

    /**
     * Get Developer
     */
    public function getDeveloper()
    {
        return 'Dukt';
    }

    /**
     * Get Developer URL
     */
    public function getDeveloperUrl()
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
     * Get release feed URL
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/dukt/follow/v1/releases.json';
    }
}