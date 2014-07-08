<?php

namespace Craft;

class Follow_FollowElementType extends BaseElementType
{
    /**
     * Returns the element type name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Follow');
    }

    public function populateElementModel($row)
    {
        return Follow_FollowModel::populateModel($row);
    }

    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
        $query
            ->addSelect('follow.followElementId, follow.userId')
            ->join('follow follow', 'follow.id = elements.id');
    }
}
