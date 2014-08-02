<?php
/**
 * Created by PhpStorm.
 * User: ufuk Özarslan
 * Date: 02.08.2014
 * Time: 16:56
 * Email: phpyazilim@outlook.com
 */

 require_once ('class.sanalpos.php');

 $sanalpos = new SanalPOS();
 $name = "XXXXXXXX"; //İş yeri kullanic adi
 $password = "xxxxxxxxx"; //İş yeri sifresi
 $storekey = "XXXX";
 $url = "https://sunucu_adresi/apiserver_path";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Sanal POS Dönen Değerler</title>
</head>
<body>
    <div style="background: lightblue;">
        <?php
            $data = $sanalpos->estModelProces($storekey,$name,$password,$url);
            if ( $data['Response'] == 'Approved' ) {
                echo "Ödeme OK" . $data['TransId'];
            }
            else {
                echo "Ödeme Alınamadı. Hata" . $data['ErrMsg'];
            }
        ?>
    </div>

    <div style="background: lightyellow; border-left: 8px solid yellow; padding: 15px 10px">
        <h3>Gelen değerler</h3>
        <table cellspacing="0" cellpadding="0" style="border: 1px solid #ddd">
            <tr>
                <td><b>Parametre Ismi</b></td>
                <td><b>Parametre Degeri</b></td>
            </tr>
            <?php echo $sanalpos->estModelReturnKey(); ?>
        </table>

    </div>

</body>
</html>