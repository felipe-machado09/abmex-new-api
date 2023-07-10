<?php

namespace App\Enums;


enum ProductStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BLOCKED = 'blocked';
    case SKETCH = 'sketch';
}