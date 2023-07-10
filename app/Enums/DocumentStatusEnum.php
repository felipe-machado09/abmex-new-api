<?php

namespace App\Enums;

enum DocumentStatusEnum: string
{
    case APPROVED = 'approved'; // aprovado
    case REJECTED = 'rejected'; // rejeitado
}
