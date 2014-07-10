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
    public function startFollowing($followElementId)
    {
        $validateContent = false;

        $element = craft()->elements->getElementById($followElementId);

        // make sure the element we want to follow is a user
        if($element->elementType != 'User') {
            return;
        }


        // get session user

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'followElementId=:followElementId and userId=:userId';

        $params = array(
            ':followElementId' => $followElementId,
            ':userId' => $userId
        );

        $record = FollowRecord::model()->find($conditions, $params);

        if (!$record)
        {
            $model = new FollowModel;
            $model->followElementId = $followElementId;
            $model->userId = $userId;

            // add fav
            $record = new FollowRecord;
            $record->followElementId = $followElementId;
            $record->userId = $userId;

            $record->validate();
            $model->addErrors($record->getErrors());

            if(!$model->hasErrors())
            {
                if(craft()->elements->saveElement($model, $validateContent))
                {
                    $record->id = $model->id;
                    $record->save(false);

                    $this->onStartFollowing(new Event($this, array(
                        'follow' => $model
                    )));

                    return true;
                }
            }
        }
        else
        {
            // already a fav
        }

        return true;
    }

    public function actionStopFollowing($followElementId)
    {
        $element = craft()->elements->getElementById($followElementId);


        // make sure the element we want to follow is a user

        if($element->elementType != 'User') {
            return;
        }

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'followElementId=:followElementId and userId=:userId';

        $params = array(
            ':followElementId' => $followElementId,
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
        $follow = $this->getFollowById($id);

        if($follow)
        {
            if(isset(craft()->notifications))
            {
                // remove notifications related to this follow

                $notifications = array();

                $notifications = array_merge($notifications, craft()->notifications->findNotificationsByData('follow.onfollow', 'followId', $follow->id));

                // alternate solution: retrieve all entries en followed user
                // foreach entry remove notification of follower user

                $notifications = array_merge($notifications, craft()->notifications->findNotificationsByData('follow.onnewentry', 'followId', $follow->id));

                foreach($notifications as $notification)
                {
                    craft()->notifications->deleteNotificationById($notification->id);
                }
            }

            craft()->elements->deleteElementById($follow->id);

            $this->onStopFollowing(new Event($this, array(
                'follow' => $follow
            )));
        }
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

        $conditions = 'followElementId=:followElementId';

        $params = array(':followElementId' => $elementId);

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

            $followElement = craft()->elements->getElementById($record->followElementId, 'User');

            if($followElement) {
                array_push($following, $followElement);
            }
        }

        return $following;
    }

    public function isFollow($followElementId)
    {
        if(craft()->userSession->isLoggedIn()) {
            $userId = craft()->userSession->getUser()->id;
        } else {
            return false;
        }

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'followElementId=:followElementId and userId=:userId';

        $params = array(
            ':followElementId' => $followElementId,
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