<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderInterface;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderSearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ReviewReminderRepositoryInterface
{
    /**
     * @throws NoSuchEntityException
     */
    public function get(int $id): ReviewReminderInterface;

    public function getList(SearchCriteriaInterface $criteria): ReviewReminderSearchResultsInterface;

    public function save(ReviewReminderInterface $entity): ReviewReminderInterface;

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(ReviewReminderInterface $entity): ReviewReminderInterface;

    /**
     * @throws CouldNotDeleteException|NoSuchEntityException
     */
    public function deleteById(int $id): ReviewReminderInterface;
}
