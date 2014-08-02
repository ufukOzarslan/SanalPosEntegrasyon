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

    public function Console( $e )
    {
        echo '<script>console.log("' . $e . '");</script>';
    }

    public function estModelHash( $clientID, $amount, $oid, $okUrl, $failUrl, $storeKey, $rnd )
    {
        return base64_encode( pack( 'H*', sha1( $clientID . $oid . $amount . $okUrl . $failUrl . $rnd . $storeKey ) ) );
    }

    public function estModelReturnKey()
    {
        foreach ( $_POST as $key => $value ) {
            echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
        }
    }

    public function estModelResponse( $result )
    {

        $response_tag = "Response";
        $posf = strpos( $result, ("<" . $response_tag . ">") );
        $posl = strpos( $result, ("</" . $response_tag . ">") );
        $posf = $posf + strlen( $response_tag ) + 2;
        $Response = substr( $result, $posf, $posl - $posf );

        $response_tag = "OrderId";
        $posf = strpos( $result, ("<" . $response_tag . ">") );
        $posl = strpos( $result, ("</" . $response_tag . ">") );
        $posf = $posf + strlen( $response_tag ) + 2;
        $OrderId = substr( $result, $posf, $posl - $posf );

        $response_tag = "AuthCode";
        $posf = strpos( $result, "<" . $response_tag . ">" );
        $posl = strpos( $result, "</" . $response_tag . ">" );
        $posf = $posf + strlen( $response_tag ) + 2;
        $AuthCode = substr( $result, $posf, $posl - $posf );

        $response_tag = "ProcReturnCode";
        $posf = strpos( $result, "<" . $response_tag . ">" );
        $posl = strpos( $result, "</" . $response_tag . ">" );
        $posf = $posf + strlen( $response_tag ) + 2;
        $ProcReturnCode = substr( $result, $posf, $posl - $posf );

        $response_tag = "ErrMsg";
        $posf = strpos( $result, "<" . $response_tag . ">" );
        $posl = strpos( $result, "</" . $response_tag . ">" );
        $posf = $posf + strlen( $response_tag ) + 2;
        $ErrMsg = substr( $result, $posf, $posl - $posf );

        $response_tag = "HostRefNum";
        $posf = strpos( $result, "<" . $response_tag . ">" );
        $posl = strpos( $result, "</" . $response_tag . ">" );
        $posf = $posf + strlen( $response_tag ) + 2;
        $HostRefNum = substr( $result, $posf, $posl - $posf );

        $response_tag = "TransId";
        $posf = strpos( $result, "<" . $response_tag . ">" );
        $posl = strpos( $result, "</" . $response_tag . ">" );
        $posf = $posf + strlen( $response_tag ) + 2;
        $TransId = substr( $result, $posf, $posl - $posf );

        return array('Response' => $Response, 'Orderid' => $OrderId, 'AuthCode' => $AuthCode, 'ProcReturnCode' => $ProcReturnCode, 'HostRefNum' => $HostRefNum, 'TransId' => $TransId, 'ErrMsg' => $ErrMsg);

    }

    public function estModelProces( $storekey, $name, $password, $url )
    {
        $hashparams = $_POST["HASHPARAMS"];
        $hashparamsval = $_POST["HASHPARAMSVAL"];
        $hashparam = $_POST["HASH"];
        $paramsval = "";
        $index1 = 0;
        $index2 = 0;

        while ( $index1 < strlen( $hashparams ) ) {
            $index2 = strpos( $hashparams, ":", $index1 );
            $vl = $_POST[substr( $hashparams, $index1, $index2 - $index1 )];

            if ( $vl == null ) {
                $vl = "";
            }

            $paramsval = $paramsval . $vl;
            $index1 = $index2 + 1;
        }

        $hashval = $paramsval . $storekey;
        $hash = base64_encode( pack( 'H*', sha1( $hashval ) ) );

        if ( $paramsval != $hashparamsval || $hashparam != $hash ) {
            self::Console( "Güvenlik Uyarisi. Sayisal Imza Geçerli Degil" );
            exit();
        }

        $clientid = $_POST["clientid"];
        $mode = "P";
        $type = "Auth";
        $expires = $_POST["Ecom_Payment_Card_ExpDate_Month"] . "/" . $_POST["Ecom_Payment_Card_ExpDate_Year"];
        $cv2 = $_POST['cv2'];
        $tutar = $_POST["amount"];
        $taksit = "";
        $oid = $_POST['oid'];
        $lip = $_SERVER['REMOTE_ADDR'];
        $email = null;
        $mdStatus = $_POST['mdStatus'];
        $xid = $_POST['xid'];
        $eci = $_POST['eci'];
        $cavv = $_POST['cavv'];
        $md = $_POST['md'];

        if ( $mdStatus == "1" || $mdStatus == "2" || $mdStatus == "3" || $mdStatus == "4" ) {

            self::Console( "3D işlemi başarılı işleme devam ediliyor" );

            $request = "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>" . "<CC5Request>" . "<Name>{NAME}</Name>" . "<Password>{PASSWORD}</Password>" . "<ClientId>{CLIENTID}</ClientId>" . "<IPAddress>{IP}</IPAddress>" . "<Email>{EMAIL}</Email>" . "<Mode>P</Mode>" . "<OrderId>{OID}</OrderId>" . "<GroupId></GroupId>" . "<TransId></TransId>" . "<UserId></UserId>" . "<Type>{TYPE}</Type>" . "<Number>{MD}</Number>" . "<Expires></Expires>" . "<Cvv2Val></Cvv2Val>" . "<Total>{TUTAR}</Total>" . "<Currency>949</Currency>" . "<Taksit>{TAKSIT}</Taksit>" . "<PayerTxnId>{XID}</PayerTxnId>" . "<PayerSecurityLevel>{ECI}</PayerSecurityLevel>" . "<PayerAuthenticationCode>{CAVV}</PayerAuthenticationCode>" . "<CardholderPresentCode>13</CardholderPresentCode>" . "<BillTo>" . "<Name></Name>" . "<Street1></Street1>" . "<Street2></Street2>" . "<Street3></Street3>" . "<City></City>" . "<StateProv></StateProv>" . "<PostalCode></PostalCode>" . "<Country></Country>" . "<Company></Company>" . "<TelVoice></TelVoice>" . "</BillTo>" . "<ShipTo>" . "<Name></Name>" . "<Street1></Street1>" . "<Street2></Street2>" . "<Street3></Street3>" . "<City></City>" . "<StateProv></StateProv>" . "<PostalCode></PostalCode>" . "<Country></Country>" . "</ShipTo>" . "<Extra></Extra>" . "</CC5Request>";

            $request = str_replace( array('{NAME}', '{PASSWORD}', '{CLIENTID}', '{IP}', '{OID}', '{TYPE}', '{XID}', '{ECI}', '{CAVV}', '{MD}', '{TUTAR}', '{TAKSIT}'), array($name, $password, $clientid, $lip, $oid, $type, $xid, $eci, $cavv, $md, $tutar, $taksit), $request );


            /*
             *  CURL Library
             * */

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 1 );
            curl_setopt( $ch, CURLOPT_SSLVERSION, 3 );
            curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_TIMEOUT, 90 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $request );
            $result = curl_exec( $ch );

            if ( curl_errno( $ch ) ) {
                print curl_error( $ch );
            }
            else {
                curl_close( $ch );
            }

            $data = self::estModelResponse( $result );

            self::Console( $data );

            return $data;

        }
        else {
            self::Console( "3D işlemi başarısız" );
            exit();
        }

    }

}