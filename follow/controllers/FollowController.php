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
    public function actionAdd(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');
    	$userId = craft()->userSession->getUser()->id;

    	craft()->follow->add($elementId, $userId);

    	$this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionRemove(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');
    	$userId = craft()->userSession->getUser()->id;

    	craft()->follow->remove($elementId, $userId);

    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
}