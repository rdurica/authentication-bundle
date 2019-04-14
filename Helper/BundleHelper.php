<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Helper;

use DateTime;

/**
 * Class BundleHelper
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\Helper
 */
class BundleHelper
{
    const TRANS_DOMAIN = 'rd_authentication';


    /**
     * Generate confirm string
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function generateString(int $length = 70): string
    {
        $dateTime = new DateTime();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString . $dateTime->format('his');
    }
}