<?php

/**
 * Craft Follow by Dukt
 *
 * @package   Craft Follow
 * @author    Benjamin David
 * @copyright Copyright (c) 2013, Dukt
 * @license   http://dukt.net/craft/follow/docs#license
 * @link      http://dukt.net/craft/follow/
 */

namespace Craft;

class FollowPlugin extends BasePlugin
{
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
        return '0.9.0';
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
        return 'http://dukt.net/';
    }
}