<?php

/**
 * Craft Follow by Dukt
 *
 * @package   Craft Follow
 * @author    Benjamin David
 * @copyright Copyright (c) 2015, Dukt
 * @link      https://dukt.net/craft/follow/
 * @license   https://dukt.net/craft/follow/docs/license
 */

namespace Craft;

class Follow_CountFieldType extends BaseFieldType
{
    /**
     * Block type name
     */
    public function getName()
    {
        return Craft::t('Follow Count');
    }

    /**
     * Show field
     */
    public function getInputHtml($name, $value)
    {
        $followers = craft()->follow->getFollowers($this->element->id);

        return craft()->templates->render('follow/countField', array(
            'element' => $this->element,
            'totalFollowers' => count($followers)
        ));
    }


    public function prepValue($value)
    {
        $followers = craft()->follow->getFollowers($this->element->id);

        return count($followers);
    }

    /**
     * Modifies an element query
     *
     * @param DbCommand $query
     * @param mixed     $value
     * @return null|false
     */
    public function modifyElementsQuery(DbCommand $query, $value)
    {
        $handle = $this->model->handle;

        $query->addSelect('count(follows.id) AS '.craft()->content->fieldColumnPrefix.$handle);
        $query->leftJoin('follows follows', 'follows.elementId = elements.id');
    }
}
