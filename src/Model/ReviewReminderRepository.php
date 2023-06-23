<?php

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Model;

use Elgentos\ReviewReminder\Api\Data\ReviewReminderSearchResultsInterface;
use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderInterface;
use Elgentos\ReviewReminder\Api\Data\ReviewReminderSearchResultsInterfaceFactory;
use Elgentos\ReviewReminder\Api\ReviewReminderRepositoryInterface;
use Elgentos\ReviewReminder\Model\ResourceModel\ReviewReminder as ResourceReviewReminder;
use Elgentos\ReviewReminder\Model\ResourceModel\ReviewReminder\CollectionFactory as ReviewReminderCollectionFactory;

class ReviewReminderRepository implements ReviewReminderRepositoryInterface
{
    public function __construct(
        private readonly ResourceReviewReminder $resource,
        private readonly ReviewReminderFactory $reviewReminderFactory,
        private readonly ReviewReminderCollectionFactory $reviewReminderCollectionFactory,
        private readonly ReviewReminderSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor
    ) {
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(
        ReviewReminderInterface $entity
    ): ReviewReminderInterface {
        try {
            $this->resource->save($entity);
        } catch (Exception $e) {
            throw new CouldNotSaveException(
                __(
                    'Could not save the ReviewReminder: %1',
                    $e->getMessage()
                )
            );
        }

        return $entity;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function get(int $id): ReviewReminderInterface
    {
        $reviewReminder = $this->reviewReminderFactory->create();
        $this->resource->load($reviewReminder, $id);

        if (!$reviewReminder->getId()) {
            throw new NoSuchEntityException(
                __('ReviewReminder with id "%1" does not exist.', $id)
            );
        }

        return $reviewReminder;
    }

    public function getList(SearchCriteriaInterface $criteria): ReviewReminderSearchResultsInterface
    {
        $collection = $this->reviewReminderCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(ReviewReminderInterface $entity): ReviewReminderInterface
    {
        try {
            $this->resource->delete($entity);
        } catch (Exception $e) {
            throw new CouldNotDeleteException(
                __(
                    'Could not delete the ReviewReminder: %1',
                    $e->getMessage()
                )
            );
        }

        return $entity;
    }

    public function deleteById(int $id): ReviewReminderInterface
    {
        return $this->delete($this->get($id));
    }
}
