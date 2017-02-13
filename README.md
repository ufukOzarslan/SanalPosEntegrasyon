
[![Hublabs Yazılım Ofisi](http://www.hublabs.com.tr/images/logo-white.png?v=11323)](http://www.hublabs.com.tr)

[PHP] Kolay Sanal Pos Entegrasyon
========

Türkiye'de kullanılan birçok bankanın sanal POS'larına kolay entegrasyon amacıyla yayınlanmıştır.

##Hangi Bankalarda Geçerlidir ?
Bu entegrasyon Türkiye'de geçerli birçok bankalarda geçerlidir. 
- Ak Bank
- İş Bankası
- Halk Bank
- TEB Bank
- DenizBank
- ING Bankası
- Anadolu Bank
- Ziraat Bankası
- Finans Bankası
- Kuveyt Bankası


## Nasıl Kullanılır? 
Servisi kullanacağınız size birkaç alternatif bilgi vermektedir. Bu bilgiler doğrultusunda sizden onların belirlemiş olduğu bir kombinasyon ile dataları sizden geri ister. Bu form'da gönderilmesi gerekli bilgiler aşağıda ekliyecegim. **index.php** de gerekli olan birkaç bilgileri bakabilirsiniz.

#### index.php (işlem)

```
$clientId    = Banka tarafindan verilen is yeri numarasi
$amount      = Yapılan İşlem tutarı
$oid         = Yapılan işlem numarası, sizdeki sisteme kaydetmek için düşünülmüş birşey
$okUrl       = İşlem yapıldığında yönlenecek adres
$failUrl     = İşlem yapılmadığında yönlenilecek adres
$storeKey    = İş yeri ayiraci (is yeri anahtari)
$rand        = İşlemin micro zamanı
```
#####Gönderilmesi zorunlu keyler

- __pan__ Kart No 16 numeric
- __cv2__ Kartın arka yüzünde bulunan 3-4 numeric
- __Ecom_Payment_Card_ExpDate_Year__ Son kullanım yılı
- __Ecom_Payment_Card_Expdate_Mounth__ Son kullanım ayı
- __cardType__ Kart tipi Visa/Master
- __clientid__
- __amount__
- __oid__
- __okUrl__
- __failUrl__
- __rnd__
- __hash__
- __storetype__
- __lang__ sayfa dili TR--> TÜRKÇE

> __index.php__ form action adresi "https://sunucu_adresi/3dgate_path" bankanızdan istemeyi unutmayınız!

```
$sanalpos = new SanalPOS();
$hash = $sanalpos->estModelHash( $clientId, $amount, $oid, $okUrl, $failUrl, $storeKey, $rand );
```
**hash** değişkenini bu şekilde alabilirsiniz. **index.php** dosyasında herhangi bir text editörü ile açıp bilgileri düzenleyebilirsiniz.

#### return.php (Sonuç)

Banka servisinden dönen sonuçları almak için bu işlemleri yapmak zorundayız. Çünkü herşey bu obje üzerinden dönmektedir.


````
 $name = Üye iş yeri tarafından açılan pos kullanıcısı
 $password = Üye iş yeri tarafından açılan pos kullanıcı şifresi
 $storekey = Yukarıda belirttiğim üzere iş yeri ayiraci (is yeri anahtari)
 $url = "https://sunucu_adresi/apiserver_path" Banka tarafından verilen CURL'un web servisine bağlandığı adres
````

> *"https://sunucu_adresi/apiserver_path"* bu adresi banka yetkililerinden istemeyi unutmayınız. Her banka için bu bilgiler değişiklik gösterebilir. 

````
 require_once ('class.sanalpos.php');
 $sanalpos = new SanalPOS();
 $name = "XXXXXXXX";
 $password = "xxxxxxxxx";
 $storekey = "XXXX";
 $url = "https://sunucu_adresi/apiserver_path";
````

Datayı dizi (array) şeklinde aldırdım. Aşağıda vereceğim kodları kendinize göre uyarlayabilirsiniz. 

````
$data = $sanalpos->estModelProces($storekey,$name,$password,$url);
if ( $data['Response'] == 'Approved' ) {
    echo "Ödeme OK" . $data['TransId'];
}
else {
    echo "Ödeme Alınamadı. Hata" . $data['ErrMsg'];
}
````

#### NOT:

##### Console
````
$str = new SanalPos();
$str->Console("test");
````

## İletişim
[Hublabs Yazılım Ofisi](http://www.hublabs.com.tr)
[GitHub! Ufuk Özarslan](http://www.github.com/ufukOzarslan)
[E-mail:ozarslan@hublabs.com.tr](http://www.github.com/hublabs)

