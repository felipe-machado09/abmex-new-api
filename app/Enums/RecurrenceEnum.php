<?php

namespace App\Enums;

enum RecurrenceEnum: string
{
    const NONE = 'none';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const QUARTERLY = 'quarterly';
    const SEMIANNUALLY = 'semiannually';
    const ANNUALLY = 'annually';
    const CUSTOM = 'custom';
}