<?php
    try{
        $db     =   new PDO("mysql:host=localhost;dbname=classicmodels;charset=UTF8", "root", "");
    }catch(PDOException $hata){
        echo "HATA! " . $hata->getMessage();
        die();
    }

    if(isset($_REQUEST["Sayfa"])){
         $GelenSayfaDegeri   =   $_REQUEST["Sayfa"];
    }else{
        $GelenSayfaDegeri   =   1;
    }

    $SayfalamaIcinSagdaVeSoldaBulunanButonSayisi    =   3;
    $GosterilecekKayitSayisi                        =   20;
    $SayfalamayaBaslanacakKayitSayisi               =  ($GelenSayfaDegeri*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
    $KayitSorgusu                                   =   $db->prepare("SELECT * FROM products");
    $KayitSorgusu->execute();
    $ToplamKayitSayisi                              =   $KayitSorgusu->rowCount(); //110
    $BulunanSayfaSayisi                             =   ceil($ToplamKayitSayisi/$GosterilecekKayitSayisi);
   
?>
<!DOCTYPE html>
<html lang="tr-TR">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-language" content="tr">
<title>Sayfalama Uygulaması</title>
<style>
    .SayfalamaAlaniKapsayicisi{
        display: block;
        width: 100%;
        height: auto;
        margin: 0;
        padding: 10px 0 10px 0;
        border: none;
        outline: none;
        text-align: center;
        text-decoration: none;
    }
    .SayfalamaAlaniMetinKapsayicisi{
        display: block;
        width: 100%;
        height: auto;
        margin: 0;
        padding: 5px 0 5px 0;
        border: none;
        outline: none;
        text-align: center;
        text-decoration: none;
    }
    .SayfalamaAlaniButonKapsayicisi{
        display: block;
        width: 100%;
        height: auto;
        margin: 0;
        padding: 5px 0 5px 0;
        border: none;
        outline: none;
        text-align: center;
        text-decoration: none;
    }
    .Pasif{
        display: inline-block;
        width: auto;
        height: 20px;
        margin: 0px 0.5px;
        padding: 5px 7.5px;
        background: #FFFFFF;
        border: none;
        border: 1px solid #DADADA;
        outline: none;
        color: #646464;
        font-size: 14px;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        line-height: 20px;
        text-align: center;
        text-decoration: none;
    }
    .Pasif a:link, a:visited, a:hover{
        text-decoration: none;
        color: #646464;

    }
    .Aktif{
        display: inline-block;
        width: auto;
        height: 20px;
        margin: 0px 0.5px;
        padding: 5px 7.5px;
        background: #f6f6f6;
        border: none;
        border: 1px solid #dadada;
        outline: none;
        color: #f00;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        font-variant: normal;
        line-height: 20px;
        text-align: center;
        text-decoration: none;
    }
</style>
</head>
<body>
    <table width="500px" cellpadding="0" cellspacing="0" border=0 align="center">
        <tr height="30" bgcolor="#000000">
            <td width="100px" align="left" style="color:white;">&nbsp;Ürün Kodu</td>
            <td width="300px" align="center" style="color:white;">Ürün Adı</td>
            <td width="100px" align="right" style="color:white;">Ürün Fiyatı&nbsp;</td>
        </tr>

    <?php
        $UrunSorgusu    =   $db->prepare("SELECT * FROM products ORDER BY productCode ASC LIMIT $SayfalamayaBaslanacakKayitSayisi , $GosterilecekKayitSayisi");
        $UrunSorgusu->execute();
        $UrunSorgusuKayitSayisi     =   $UrunSorgusu->rowCount();
        $UrunSorgusuKayitlari       =   $UrunSorgusu->fetchAll(PDO::FETCH_ASSOC);

        $BirinciRenk    =   "#dfdfdf";
        $IkinciRenk     =   "#FFFFFF";
        $RenkIcinSayi   =   0;

        foreach($UrunSorgusuKayitlari as $Degerler){
            if($RenkIcinSayi%2==0){
                $ArkaPlanRengi  =   $BirinciRenk;
            }else{
                $ArkaPlanRengi  =   $IkinciRenk;
            }
    ?>           
        <tr  height="30" bgcolor="<?php echo $ArkaPlanRengi; ?>" onMouseOver="this.bgColor='#c2cedb';" onMouseOut="this.bgColor='<?php echo $ArkaPlanRengi; ?>';">
            <td width="100px" align="left"><?php echo $Degerler["productCode"] . "<br/>"; ?></td>
            <td width="300px" align="left"><?php echo $Degerler["productName"] . "<br/>"; ?></td>
            <td width="100px" align="right"><?php echo $Degerler["buyPrice"] . "<br/>"; ?></td>
        </tr>
        <?php
        $RenkIcinSayi++;
        }
        ?>
        </table>

        <div class="SayfalamaAlaniKapsayicisi">
            <div class="SayfalamaAlaniMetinKapsayicisi">
                Toplam <?php echo $BulunanSayfaSayisi; ?> sayfada, <?php echo $ToplamKayitSayisi; ?> adet kayıt bulunmaktadır.
            </div>

            <div class="SayfalamaAlaniButonKapsayicisi">
                <?php
                if($GelenSayfaDegeri>1){
                    echo "<span class='Pasif'><a href='index.php?Sayfa=1'><<</a></span>";
                    $GelenSayfaDegeriniBirGeriAl    =   $GelenSayfaDegeri-1;
                    echo " <span class='Pasif'><a href='index.php?Sayfa=" . $GelenSayfaDegeriniBirGeriAl . "'><</a></span>";
                }
                for($SayfalamaIcinSayfaIndexDegeri=$GelenSayfaDegeri-$SayfalamaIcinSagdaVeSoldaBulunanButonSayisi; $SayfalamaIcinSayfaIndexDegeri<=$GelenSayfaDegeri+$SayfalamaIcinSagdaVeSoldaBulunanButonSayisi;
                $SayfalamaIcinSayfaIndexDegeri++){
                    if(($SayfalamaIcinSayfaIndexDegeri>0) and ($SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi)){
                     if($GelenSayfaDegeri==$SayfalamaIcinSayfaIndexDegeri){
                        echo " <span class='Aktif'>" . $SayfalamaIcinSayfaIndexDegeri . " </span>";
                     }else{
                        echo " <span class='Pasif'><a href='index.php?Sayfa=" .$SayfalamaIcinSayfaIndexDegeri."'> ". $SayfalamaIcinSayfaIndexDegeri ."</a></span>";
                     }
                    }
                }
                if($GelenSayfaDegeri!=$BulunanSayfaSayisi){
                    $GelenSayfaDegeriniBirIleriAl    =   $GelenSayfaDegeri+1;
                    echo " <span class='Pasif'><a href='index.php?Sayfa=" . $GelenSayfaDegeriniBirIleriAl . "'>></a></span>";
                    echo " <span class='Pasif'><a href='index.php?Sayfa=". $BulunanSayfaSayisi ."'>>></a></span>";
                }
                ?>
            </div>
        </div>
</body>
</html>
<?php
    $db     =   null;
?>