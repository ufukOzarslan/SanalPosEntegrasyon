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
    public $rnd = microtime();
    public $storeKey = null;
    public $storeType = '3d';

    public function __constract()
    {

    }

    public function __estModelHash( $clientID, $amount, $oid, $okUrl, $failUrl, $storeKey )
    {
        return base64_encode( pack( 'H*', sha1( $clientID . $oid . $amount . $okUrl . $failUrl . $this->rnd . $storeKey ) ) );
    }

}