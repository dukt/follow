<?php

/**
 * Craft Follow by Dukt
 *
 * @package   Craft Follow
 * @author    Benjamin David
 * @copyright Copyright (c) 2013, Dukt
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

    public function getFollows($elementType = null)
    {
    	return craft()->follow->getFollows($elementType);
    }

    public function getUserFollows($elementType = null, $userId = null)
    {
        return craft()->follow->getUserFollows($elementType, $userId);
    }
}
