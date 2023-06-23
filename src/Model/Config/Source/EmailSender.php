<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class EmailSender implements ArrayInterface
{
    private const XML_PATH_GENERAL_CONTACT = 'general';
    private const XML_PATH_SALES_REPRESENTATIVE = 'sales';
    private const XML_PATH_CUSTOMER_SUPPORT = 'support';

    /**
     * Return array of options as value-label pairs
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::XML_PATH_GENERAL_CONTACT,
                'label' => __('General Contact')
            ],
            [
                'value' => self::XML_PATH_CUSTOMER_SUPPORT,
                'label' => __('Customer Support')
            ],
            [
                'value' => self::XML_PATH_SALES_REPRESENTATIVE,
                'label' => __('Sales Representative')
            ]
        ];
    }
}
