<?php

namespace App\Moebius;

/**
 * Class Definition
 * @package App\Moebius
 */
final class Definition
{
    /**
     * Error Messages
     */

    const ERR_ADD_SMB = "Error while adding smartbox";
    const ERR_ADD_GH  = "Error while adding gaming hall";
    const ERR_RESET_SB = "Error while resetting smartbox";
    const ERR_DEL_SB = "Error while deleting smartbox";
    const RESET_SB_OFFLINE = 'Warning, the smartbox is offline. All data has been deleted, remember to do a physical reset on the board';

    /**
     * API Error Messages
     */
    const INVALID_API_KEY   = 'API KEY IS NOT VALID';
    const MISSING_API_KEY   = 'API KEY IS MISSING';
    const WRONG_PARAM       = 'Wrong Parameter received';

    /**
     * USER LEVEL
     */
    const ADMIN         = 3;
    const DOCTOR        = 2;
    const PATIENT       = 1;
    const GAMING_HALL   = 4;
    const USER          = 5;
}
