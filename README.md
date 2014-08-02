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

```
$clientId    = Banka tarafindan verilen is yeri numarasi
$amount      = Yapılan İşlem tutarı
$oid         = Yapılan işlem numarası, sizdeki sisteme kaydetmek için düşünülmüş birşey
$okUrl       = İşlem yapıldığında yönlenecek adres
$failUrl     = İşlem yapılmadığında yönlenilecek adres
$storeKey    = İş yeri ayiraci (is yeri anahtari)
$rand        = İşlemin micro zamanı
```
