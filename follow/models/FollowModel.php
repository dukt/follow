<?php

/**
 * Craft OAuth by Dukt
 *
 * @package   Craft OAuth
 * @author    Benjamin David
 * @copyright Copyright (c) 2014, Dukt
 * @license   https://dukt.net/craft/oauth/docs/license
 * @link      https://dukt.net/craft/oauth/
 */

namespace Craft;

class FollowModel extends BaseElementModel
{
    protected $elementType = 'Follow_Follow';

    /**
     * Define Attributes
     */
    public function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'id' => AttributeType::Number,
            'followElementId' => AttributeType::Number,
            'userId' => AttributeType::Number,
        ));
    }

    public function getUser()
    {
        if ($this->userId) {
            return craft()->users->getUserById($this->userId);
        }
    }

    public function getElement()
    {
        if($this->followElementId)
        {
            return craft()->elements->getElementById($this->followElementId);
        }
    }
}
