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

        if (!$record)
        {
            $model = new FollowModel;
            $model->elementId = $elementId;
            $model->userId = $userId;

            // add fav
            $record = new FollowRecord;
            $record->elementId = $elementId;
            $record->userId = $userId;

            $record->validate();
            $model->addErrors($record->getErrors());

            if(!$model->hasErrors())
            {
                $record->save(false);
                $model->id = $record->id;

                $this->onStartFollowing(new Event($this, array(
                    'follow' => $model
                )));
            }
        }
        else
        {
            // already a fav
        }

        return true;
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

        if ($record)
        {
            $this->deleteFollowById($record->id);
        }
    }

    public function deleteFollowById($id)
    {
        $record = FollowRecord::model()->findByPk($id);

        if($record)
        {
            $follow = FollowModel::populateModel($record);

            // delete record
            $record->delete();

            // fire 'onStopFollowing' event
            $this->onStopFollowing(new Event($this, array(
                'follow' => $follow
            )));

            return true;
        }

        return false;
    }

    public function getFollowById($id)
    {
        $record = FollowRecord::model()->findByPk($id);

        if($record)
        {
            return FollowModel::populateModel($record);
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

        $follows = $this->getFollowsByElementId($userId);

        foreach($follows as $follow)
        {
            $follower = craft()->users->getUserById($follow->userId);

            if($follower)
            {
                array_push($followers, $follower);
            }
        }

        return $followers;
    }

    public function getFollowsByUserId($userId)
    {
        // find follows

        $conditions = 'userId=:userId';

        $params = array(':userId' => $userId);

        $records = FollowRecord::model()->findAll($conditions, $params);

        return FollowModel::populateModels($records);
    }

    public function getFollowsByElementId($elementId)
    {
        // find follows

        $conditions = 'elementId=:elementId';

        $params = array(':elementId' => $elementId);

        $records = FollowRecord::model()->findAll($conditions, $params);

        return FollowModel::populateModels($records);
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

            $element = craft()->elements->getElementById($record->elementId, 'User');

            if($element) {
                array_push($following, $element);
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