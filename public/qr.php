<?php

require_once __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;

$qrCode = new Endroid\QrCode\QrCode();

$uniqid = uniqid("okl");

$txt = "https://co2app.karlsruhe.de?code=" . $uniqid;

$qrCode->settext($txt);
$qrCode->setSize(300);
$qrCode->setPadding(30);
$qrCode->setErrorCorrection('high');
//$qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
//$qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
$qrCode->setImageType(Endroid\QrCode\QrCode::IMAGE_TYPE_PNG);

// now we can directly output the qrcode
//$qrCode->render();
// // save it to a file
$qrCode->save('qrcode.png');
//
//
?>

