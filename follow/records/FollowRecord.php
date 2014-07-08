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

class FollowRecord extends BaseRecord
{
    /**
     * Get Table Name
     */
    public function getTableName()
    {
        return 'follows';
    }

    /**
     * Define Attributes
     */
    public function defineAttributes()
    {
        return array();
    }

    /**
     * @return array
     */
    public function defineIndexes()
    {
        return array(
            array('columns' => array('userId', 'followElementId'), 'unique' => true),
        );
    }

    public function defineRelations()
    {
        return array(
            'element'   => array(static::BELONGS_TO, 'ElementRecord', 'id', 'required' => true, 'onDelete' => static::CASCADE),
            'user' => array(static::BELONGS_TO, 'UserRecord', 'userId', 'required' => true),
            'followElement' => array(static::BELONGS_TO, 'ElementRecord', 'followElementId', 'required' => true)
        );
    }
}