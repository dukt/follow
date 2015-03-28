<?php

/**
 * Craft Follow by Dukt
 *
 * @package   Craft Follow
 * @author    Benjamin David
 * @copyright Copyright (c) 2015, Dukt
 * @link      http://dukt.net/craft/follow/
 * @license   http://dukt.net/craft/follow/docs/license
 */

namespace Craft;

class FollowVariable
{
    public function isFollow($elementId)
    {
        return craft()->follow->isFollow($elementId);
    }

    public function getFollowers($userId = null)
    {
    	return craft()->follow->getFollowers($userId);
    }

    public function getFollowing($userId = null)
    {
        return craft()->follow->getFollowing($userId);
    }
}
