<?php
/**
 * @link      https://dukt.net/craft/follow/
 * @copyright Copyright (c) 2016, Dukt
 * @license   https://dukt.net/craft/follow/docs/license
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
