<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Api\Data;

interface ReviewReminderInterface
{
    public const ENTITY_ID = 'entity_id';
    public const SHIPMENT_ID = 'shipment_id';
    public const ORDER_ID = 'order_id';
    public const MAIL_STATUS = 'mail_status';
    public const SEND_DATE = 'send_date';
    public const CREATED_AT = 'created_at';

    public function getEntityId(): ?string;

    public function setEntityId(int $entityId): ReviewReminderInterface;

    public function getShipmentId(): ?int;

    public function setShipmentId(int $shipmentId): ReviewReminderInterface;

    public function getOrderId(): ?int;

    public function setOrderId(int $orderId): ReviewReminderInterface;

    public function getMailStatus(): ?int;

    public function setMailStatus(int $mailStatus): ReviewReminderInterface;

    public function getSendDate(): ?string;

    public function setSendDate(string $sendDate): ReviewReminderInterface;

    public function getCreatedAt(): ?string;

    public function setCreatedAt(string $createdAt): ReviewReminderInterface;

    public function addData(array $arr);
}
