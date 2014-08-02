<?php

/**
 * Created by PhpStorm.
 * User: ufuk Özarslan
 * Date: 02.08.2014
 * Email: phpyazilim@outlook.com
 * Time: 15:33
 */
class SanalPOS
{

    public $clientid = null;
    public $amount = null;
    public $oid = null; //rand number / şipariş numarası
    public $okUrl = null;
    public $failUrl = null;
    public $rnd = null;
    public $storeKey = null;
    public $storeType = '3d';

    public function __constract()
    {

    }

    public function estModelHash( $clientID, $amount, $oid, $okUrl, $failUrl, $storeKey, $rnd )
    {
        return base64_encode( pack( 'H*', sha1( $clientID . $oid . $amount . $okUrl . $failUrl . $rnd . $storeKey ) ) );
    }

}