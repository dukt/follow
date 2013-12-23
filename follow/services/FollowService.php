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

class FollowService extends BaseApplicationComponent
{
    public function add($elementId, $userId)
    {
        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = FollowRecord::model()->find($conditions, $params);

        if (!$record) {

            // add fav

            $record = new FollowRecord;
            $record->elementId = $elementId;
            $record->userId = $userId;
            $record->save();

        } else {
            // already a fav
        }
    }

    public function remove($elementId, $userId)
    {
        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = FollowRecord::model()->find($conditions, $params);

        if ($record) {
            $record->delete();
        }
    }



    public function getFollows($elementId = null)
    {
        $follows = array();


        // find follows

        $conditions = 'elementId=:elementId';

        $params = array(':elementId' => $elementId);

        $records = FollowRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {
            array_push($follows, $record);
        }

        return $follows;
    }

    public function getUserFollows($elementType = null, $userId = null)
    {
        $follows = array();

        if(!$userId && craft()->userSession->isLoggedIn()) {
                $userId = craft()->userSession->getUser()->id;
        }

        if(!$userId) {
            return $follows;
        }


        // find follows

        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => $userId
        );

        $records = FollowRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {

            $followElement = craft()->elements->getElementById($record->elementId, $elementType);

            if($followElement) {
                array_push($follows, $followElement);
            }
        }

        return $follows;
    }

    public function isFollow($elementId)
    {
        if(craft()->userSession->isLoggedIn()) {
            $userId = craft()->userSession->getUser()->id;
        } else {
            return false;
        }

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = FollowRecord::model()->find($conditions, $params);

        if($record) {
            return true;
        }

        return false;
    }
}