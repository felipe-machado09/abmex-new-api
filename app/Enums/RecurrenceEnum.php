<?php

namespace App\Enums;

enum RecurrenceEnum: string
{
    case NONE = 'none';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case SEMIANNUALLY = 'semiannually';
    case ANNUALLY = 'annually';
    case CUSTOM = 'custom';
}