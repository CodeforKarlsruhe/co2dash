<?php

require_once __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\QrCode;

// ini file on server is elsewhere
$cfg = array();
try {
    if (!isset($_SERVER['HTTP_HOST']) or !isset($_SERVER['HTTPS'])) {
        $cfg = parse_ini_file("config.ini", false);
        $cfg["local"] = true;
    } else {
		// server
        $cfg = parse_ini_file("/var/www/files/co2/config.ini", false);
        $cfg["local"] = false;
    }

} catch (Exception $e) {
    die("Config Error");
}

// open db 
$dsn = "mysql:host=" .$cfg["dbhost"] . ";dbname=" . $cfg["dbname"];
$attr = array(
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

try {
    $pdo = new PDO($dsn, $cfg["dbuser"], $cfg["dbpass"],$attr);
 } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
 }

// read codes

try {
	$queryCodes = $pdo->prepare('SELECT code1,code2 FROM defaults');
} catch (Exception $e) {
	die("Error: " . print_r($pdo->errorInfo(), true));
}

try {
	$queryCodes->execute();
	$codes = $queryCodes->fetchAll();
    /*
	echo "Data: " . PHP_EOL;
	print_r($codes);
    */
    if (count($codes) != 1) {
        echo "Wrong size" . PHP_EOL;
        die("Invalid data size");
    }
} catch (Exception $e) {
	die("Error: " . print_r($queryCodes->errorInfo(), true));
}


// create new code
try {
    $qrCode = new Endroid\QrCode\QrCode();
    $newCode = uniqid($cfg["qprefix"]);
    
    $url = "https://co2app.karlsruhe.de?code=" . $newCode;
    
    $qrCode->settext($url);
    $qrCode->setSize(300);
    $qrCode->setPadding(30);
    $qrCode->setErrorCorrection('high');
    $qrCode->setImageType(Endroid\QrCode\QrCode::IMAGE_TYPE_PNG);
    
    // now we can directly output the qrcode
    //$qrCode->render();
    // // save it to a file
    $qrCode->save('qrcode.png');
    
} catch (Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
	die("QR Error: ");
}

// update codes
try {
	$updateCodes = $pdo->prepare("update defaults set code1 = ?, code2 = ?");
} catch (Exception $e) {
	die("Error: " . print_r($pdo->errorInfo(), true));
}

try {
	$pdo->beginTransaction();
	$updateCodes->execute([$newCode,$codes[0]["code1"]]);
	$pdo->commit();
} catch (Exception $e) {
	$pdo->rollBack();
	die("Failed: " . $e->getMessage());
}


?>

