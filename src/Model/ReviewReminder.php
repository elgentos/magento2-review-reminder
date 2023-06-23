<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Model;

use Elgentos\ReviewReminder\Model\ResourceModel\ReviewReminder as ResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderInterface;

class ReviewReminder extends AbstractModel implements ReviewReminderInterface, IdentityInterface
{
    public const CACHE_TAG = 'review_reminder';

    /**
     * @var string
     */
    // phpcs:ignore
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    // phpcs:ignore
    protected $_eventPrefix = 'review_reminder';

    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    public function getEntityId(): ?string
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int $entityId
     *
     * @return ReviewReminderInterface
     */
    public function setEntityId($entityId): ReviewReminderInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    public function getShipmentId(): ?int
    {
        return $this->getData(self::SHIPMENT_ID);
    }

    public function setShipmentId(int $shipmentId): ReviewReminderInterface
    {
        return $this->setData(self::SHIPMENT_ID, $shipmentId);
    }

    public function getOrderId(): ?int
    {
        return $this->getData(self::ORDER_ID);
    }

    public function setOrderId(int $orderId): ReviewReminderInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getMailStatus(): ?int
    {
        return $this->getData(self::MAIL_STATUS);
    }

    public function setMailStatus(int $mailStatus): ReviewReminderInterface
    {
        return $this->setData(self::MAIL_STATUS, $mailStatus);
    }

    public function getSendDate(): ?string
    {
        return $this->getData(self::SEND_DATE);
    }

    public function setSendDate(string $sendDate): ReviewReminderInterface
    {
        return $this->setData(self::SEND_DATE, $sendDate);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): ReviewReminderInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getIdentities(): array
    {
        return [$this->_cacheTag . '_' . $this->getId()];
    }
}
