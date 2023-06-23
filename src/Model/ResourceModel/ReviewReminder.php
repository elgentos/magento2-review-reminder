<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ReviewReminder extends AbstractDb
{
    /** @var string Main table name */
    private const MAIN_TABLE = 'elgentos_reviewreminder';

    /** @var string Main table primary key field name */
    private const ID_FIELD_NAME = 'entity_id';

    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}
