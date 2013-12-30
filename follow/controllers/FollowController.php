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

class FollowController extends BaseController
{
    public function actionStartFollowing(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');

    	craft()->follow->startFollowing($elementId);

    	$this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionStopFollowing(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');

    	craft()->follow->actionStopFollowing($elementId);

    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
}