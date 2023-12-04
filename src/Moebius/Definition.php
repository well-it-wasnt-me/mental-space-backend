<?php

namespace App\Moebius;

/**
 * Class Definition
 * @package App\Moebius
 */
final class Definition
{
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
}
