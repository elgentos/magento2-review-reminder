<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Model\Config;

use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    private const XML_PATH_ENABLED = 'elgentos/review_reminder/enabled';
    private const XML_PATH_EXPECTED_DELIVERY_DATE = 'elgentos/review_reminder/expected_delivery_date';
    private const XML_PATH_DELAY = 'elgentos/review_reminder/delay';
    private const XML_URL_REVIEW_SHOP = 'elgentos/review_reminder/url_review_shop';
    private const XML_EMAIL_SENDER = 'elgentos/review_reminder/email_sender';
    private const XML_URL_COMPLAIN_SHOP = 'elgentos/review_reminder/url_complain_shop';

    public function __construct(private readonly ScopeConfigInterface $scopeConfig)
    {
    }

    public function getExtensionEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED
        );
    }

    public function getExpectedDeliveryDateEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_EXPECTED_DELIVERY_DATE
        );
    }

    /**
     * @throws LocalizedException
     */
    public function getDelay(): int
    {
        $delay = $this->scopeConfig->getValue(
            self::XML_PATH_DELAY
        );

        if (empty($delay)) {
            throw new LocalizedException(
                __('Delay has not been configured.')
            );
        }

        return (int)$delay;
    }

    /**
     * @throws LocalizedException
     */
    public function getUrlComplainShop(int $storeId = 0): string
    {
        $urlComplainShop = $this->scopeConfig->getValue(
            self::XML_URL_COMPLAIN_SHOP,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (empty($urlComplainShop)) {
            throw new LocalizedException(
                __('Url complain shop has not been configured.')
            );
        }

        return $urlComplainShop;
    }

    /**
     * @throws LocalizedException
     */
    public function getUrlReviewShop(int $storeId = 0): string
    {
        $urlReviewShop = $this->scopeConfig->getValue(
            self::XML_URL_REVIEW_SHOP,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (empty($urlReviewShop)) {
            throw new LocalizedException(
                __('Url review shop has not been configured.')
            );
        }

        return $urlReviewShop;
    }

    /**
     * @throws LocalizedException
     */
    public function getEmailSender(int $storeId = 0): string
    {
        $emailSender = $this->scopeConfig->getValue(
            self::XML_EMAIL_SENDER,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (empty($emailSender)) {
            throw new LocalizedException(
                __('Email sender has not been configured.')
            );
        }

        return $emailSender;
    }
}
