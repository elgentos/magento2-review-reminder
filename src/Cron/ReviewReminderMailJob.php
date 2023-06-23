<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Cron;

use Carbon\Carbon;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderInterface;
use Elgentos\ReviewReminder\Api\ReviewReminderRepositoryInterface;
use Elgentos\ReviewReminder\Enum\MailStatus;
use Elgentos\ReviewReminder\Logger\MailLogger;
use Elgentos\ReviewReminder\Model\ResourceModel\ReviewReminder\CollectionFactory;
use Elgentos\ReviewReminder\Model\ReviewReminder;
use Elgentos\ReviewReminder\Publisher\ReviewReminderMailPublisher;
use Exception;

class ReviewReminderMailJob
{
    public function __construct(
        private readonly ReviewReminderRepositoryInterface $reminderRepository,
        private readonly ReviewReminderMailPublisher $mailPublisher,
        private readonly CollectionFactory $collectionFactory,
        private readonly MailLogger $logger,
    ) {
    }

    public function execute(): void
    {
        $today = Carbon::now('utc');

        $reviewCollection = $this->collectionFactory->create()
            ->addFilter(
                ReviewReminderInterface::MAIL_STATUS,
                MailStatus::MAIL_UNPROCESSED
            )
            ->addFieldToFilter(
                ReviewReminderInterface::SEND_DATE,
                ['from' => $today->format('Y-m-d H:i:s')]
            )
            ->addFieldToFilter(
                ReviewReminderInterface::SEND_DATE,
                ['to' => $today->addHours(2)->format('Y-m-d H:i:s')]
            );

        /** @var ReviewReminder $item */
        foreach ($reviewCollection->getItems() as $item) {
            try {
                $reviewReminder = $this->reminderRepository->get(
                    (int)$item->getEntityId()
                );

                $this->mailPublisher->execute($item);

                $this->reminderRepository->save(
                    $reviewReminder->setMailStatus(MailStatus::MAIL_PROCESSED)
                );
            } catch (Exception $e) {
                $this->logger->critical(
                    $e->getMessage()
                );
            }
        }
    }
}
