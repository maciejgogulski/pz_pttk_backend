<?php

namespace App\Enums;

enum GotBookEntryStatus
{
    case WAITING_FOR_LEADER_VERIFICATION;
    case VERIFIED_BY_LEADER;
    case WAITING_FOR_TRW_VERIFICATION;
    case VERIFIED_BY_TRW;
    case DECLINED_BY_LEADER;
    case DECLINED_BY_TRW;
}
