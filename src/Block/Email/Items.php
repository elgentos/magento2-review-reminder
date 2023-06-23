<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Block\Email;

use Elgentos\ReviewReminder\Logger\MailLogger;
use Elgentos\ReviewReminder\Model\Config\Config;
use Exception;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\ShipmentItemInterface;
use Magento\Sales\Model\Order\ShipmentRepository;
use Magento\Store\Model\StoreManagerInterface;

class Items extends Template
{
    public function __construct(
        Context $context,
        private readonly ShipmentRepository $shipmentRepository,
        private readonly MailLogger $logger,
        private readonly Config $config,
        private readonly StoreManagerInterface $storeManager,
    ) {
        parent::__construct($context);
    }

    /**
     * @return ShipmentItemInterface[]
     */
    public function getItems(int $shipmentId): array
    {
        try {
            return $this->shipmentRepository->get($shipmentId)->getItems();
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            return [];
        }
    }

    public function getReviewUrl(): string
    {
        try {
            return $this->config->getUrlReviewShop(
                (int)$this->storeManager->getStore()->getId()
            );
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            return '';
        }
    }

    public function getComplainUrl(): string
    {
        try {
            return $this->config->getUrlComplainShop(
                (int)$this->storeManager->getStore()->getId()
            );
        } catch (Exception $exception) {
            $this->logger->critical($exception->getMessage());
            return '';
        }
    }
}
