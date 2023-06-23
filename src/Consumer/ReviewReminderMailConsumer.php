<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Consumer;

use Elgentos\ReviewReminder\Api\ReviewReminderRepositoryInterface;
use Elgentos\ReviewReminder\Enum\MailStatus;
use Elgentos\ReviewReminder\Logger\MailLogger;
use Elgentos\ReviewReminder\Model\Config\Config;
use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Store\Model\StoreManagerInterface;

class ReviewReminderMailConsumer
{
    private const MAIL_TEMPLATE = 'elgentos_review_reminder_template';

    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly Json $json,
        private readonly TransportBuilder $transportBuilder,
        private readonly Config $config,
        private readonly MailLogger $mailLogger,
        private readonly ReviewReminderRepositoryInterface $reminderRepository,
        private readonly ShipmentRepositoryInterface $shipmentRepository,
        private readonly StoreManagerInterface $storeManager,
    ) {
    }

    public function processMessage(string $serializedData): void
    {
        $data = $this->json->unserialize($serializedData);

        try {
            /** @var Order $order */
            $order = $this->orderRepository->get($data['order_id']);
            $shipment = $this->shipmentRepository->get((int)$data['shipment_id']);

            $transportBuilder = $this->transportBuilder
                ->setTemplateIdentifier(self::MAIL_TEMPLATE)
                ->setTemplateVars(
                    [
                        'customer' => $order->getCustomerName(),
                        'incrementId' => $order->getIncrementId(),
                        'shipmentId' => $shipment->getEntityId(),
                        'complainUrl' => $this->config->getUrlComplainShop(
                            (int)$this->storeManager->getStore()->getId()
                        )
                    ]
                )
                ->setTemplateOptions(
                    [
                        'area'  => Area::AREA_FRONTEND,
                        'store' => $order->getStoreId(),
                    ]
                )
                ->addTo($order->getCustomerEmail())
                ->setFromByScope(
                    $this->config->getEmailSender((int)$order->getStoreId())
                );

            $transport = $transportBuilder->getTransport();
            $transport->sendMessage();

            $reviewReminder = $this->reminderRepository->get(
                (int)$data['entity_id']
            );

            $this->reminderRepository->save(
                $reviewReminder->setMailStatus(MailStatus::MAIL_SEND)
            );
        } catch (Exception $exception) {
            $this->mailLogger->critical(
                $exception->getMessage()
            );
        }
    }
}
