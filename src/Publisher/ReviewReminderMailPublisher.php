<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Publisher;

use Elgentos\ReviewReminder\Model\ReviewReminder;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Framework\Serialize\Serializer\Json;

class ReviewReminderMailPublisher
{
    private const TOPIC_NAME = "elgentos.review.reminder.push";

    public function __construct(
        private readonly PublisherInterface $publisher,
        private readonly Json $json
    ) {
    }

    public function execute(ReviewReminder $reviewReminder): void
    {
        $this->publisher->publish(
            self:: TOPIC_NAME,
            $this->json->serialize($reviewReminder->getData())
        );
    }
}
