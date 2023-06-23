<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Model\ResourceModel\ReviewReminder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Elgentos\ReviewReminder\Model\ReviewReminder;
use Elgentos\ReviewReminder\Model\ResourceModel\ReviewReminder as ResourceReviewReminder;

// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(ReviewReminder::class, ResourceReviewReminder::class);
    }
}
