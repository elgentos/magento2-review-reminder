<?php

/**
 * Copyright Elgentos BV. All rights reserved.
 * https://www.elgentos.nl/
 */

declare(strict_types=1);

namespace Elgentos\ReviewReminder\Enum;

class MailStatus
{
    public const MAIL_UNPROCESSED = 0;
    public const MAIL_PROCESSED = 1;
    public const MAIL_SEND = 2;
    public const MAIL_SKIPPED = 3;
}
