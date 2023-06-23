<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Observer\Sales;

use Carbon\Carbon;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderInterface;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderInterfaceFactory;
use Elgentos\ReviewReminder\Api\ReviewReminderRepositoryInterface;
use Elgentos\ReviewReminder\Enum\MailStatus;
use Elgentos\ReviewReminder\Logger\MailLogger;
use Elgentos\ReviewReminder\Model\Config\Config;
use Elgentos\ReviewReminder\Model\ReviewReminder;
use Elgentos\ReviewReminder\Model\ReviewReminderFactory;
use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order\Shipment;

class OrderShipmentSaveAfterObserver implements ObserverInterface
{
    private const FORMAT_DATE = 'Y-m-d H:i:s';

    public function __construct(
        private readonly ReviewReminderRepositoryInterface $reviewReminderRepository,
        private readonly Config $config,
        private readonly ReviewReminderInterfaceFactory $reviewReminderDataFactory,
        private readonly MailLogger $logger
    ) {
    }

    private function getMailStatus(?string $expectedDeliveryDate, string $date): int
    {
        if (!$this->config->getExpectedDeliveryDateEnabled() || $expectedDeliveryDate === null) {
            return MailStatus::MAIL_UNPROCESSED;
        }

        $expectedDeliveryDate = Carbon::parse($expectedDeliveryDate);

        $sendDate = Carbon::parse($date);

        return $sendDate->isAfter($expectedDeliveryDate)
            ? MailStatus::MAIL_SKIPPED
            : MailStatus::MAIL_UNPROCESSED;
    }

    public function execute(Observer $observer): void
    {
        if (!$this->config->getExtensionEnabled()) {
            return;
        }

        try {
            /** @var Shipment $shipment */
            $shipment = $observer->getEvent()->getData('shipment');
            $data     = $shipment->getData();
            $sendDate = Carbon::createFromFormat(self::FORMAT_DATE, $data['created_at'])
                ->addDays($this->config->getDelay());

            /** @var ReviewReminder $reviewReminder */
            $reviewReminder = $this->reviewReminderDataFactory->create();
            $reviewReminder->setData(
                [
                    ReviewReminderInterface::SHIPMENT_ID => $data['id'],
                    ReviewReminderInterface::ORDER_ID => $data['order_id'],
                    ReviewReminderInterface::MAIL_STATUS => $this->getMailStatus(
                        $shipment->getOrder()->getData('expected_delivery_date'),
                        $data['created_at']
                    ),
                    ReviewReminderInterface::SEND_DATE => $sendDate->format(self::FORMAT_DATE),
                    ReviewReminderInterface::CREATED_AT => $data['created_at']
                ]
            );

            $this->reviewReminderRepository->save($reviewReminder);
        } catch (NoSuchEntityException | LocalizedException $e) {
            $this->logger->critical($e);
        }
    }
}
