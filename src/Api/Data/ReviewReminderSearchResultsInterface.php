<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ReviewReminderSearchResultsInterface extends SearchResultsInterface
{
    public function getItems(): array;

    public function setItems(array $items): ReviewReminderSearchResultsInterface;
}
