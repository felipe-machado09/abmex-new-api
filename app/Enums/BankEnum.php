<?php

namespace App\Enums;

enum BankEnum: string
{
    case SAVING_ACCOUNT = '1'; // conta poupança
    case CHECKING_ACCOUNT = '2'; // conta corrente
}
