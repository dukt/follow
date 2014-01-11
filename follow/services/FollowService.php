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
    public function startFollowing($elementId)
    {
        $element = craft()->elements->getElementById($elementId);


        // make sure the element we want to follow is a user

        if($element->elementType != 'User') {
            return;
        }


        // get session user

        $userId = craft()->userSession->getUser()->id;

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


            $this->onStartFollowing(new Event($this, array(
                'user' => $element
            )));

        } else {
            // already a fav
        }
    }

    public function actionStopFollowing($elementId)
    {
        $element = craft()->elements->getElementById($elementId);


        // make sure the element we want to follow is a user

        if($element->elementType != 'User') {
            return;
        }

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = FollowRecord::model()->find($conditions, $params);

        if ($record) {

            $record->delete();

            $element = craft()->elements->getElementById($elementId);

            $this->onStopFollowing(new Event($this, array(
                'user' => $element
            )));
        }
    }

    public function getFollowers($userId = null)
    {
        $followers = array();

        if(!$userId && craft()->userSession->isLoggedIn()) {
                $userId = craft()->userSession->getUser()->id;
        }

        if(!$userId) {
            return $followers;
        }

        // find follows

        $conditions = 'elementId=:elementId';

        $params = array(':elementId' => $userId);

        $records = FollowRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {

            $user = craft()->elements->getElementById($record->userId);

            if($user) {
                array_push($followers, $user);
            }
        }

        return $followers;
    }

    public function getFollowing($userId = null)
    {
        $following = array();

        if(!$userId && craft()->userSession->isLoggedIn()) {
                $userId = craft()->userSession->getUser()->id;
        }

        if(!$userId) {
            return $following;
        }


        // find follows

        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => $userId
        );

        $records = FollowRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {

            $followElement = craft()->elements->getElementById($record->elementId, 'User');

            if($followElement) {
                array_push($following, $followElement);
            }
        }

        return $following;
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

    public function onStartFollowing(Event $event)
    {
        $this->raiseEvent('onStartFollowing', $event);
    }

    public function onStopFollowing(Event $event)
    {
        $this->raiseEvent('onStopFollowing', $event);
    }
}