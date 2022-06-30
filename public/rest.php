<?php
header("Access-Control-Allow-Methods: GET, HEAD, POST, CONNECT, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access-control-allow-origin, headers, origin, callback, content-type");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: */*;encoding=gzip, deflate, br");
//https://ionicframework.com/docs/troubleshooting/cors



// --------------------------------------------------
  // log function
  // --------------------------------------------------

  define("LOG", "rest.log");
  define("LPRIO", 0); // minimal log priority
  // log function to file
  function mlog($msg, $prio = 0)
  {
      if ($prio >= LPRIO) {
          $ts = date(DATE_RFC2822);
          file_put_contents(LOG, $ts . " : " . $msg . PHP_EOL, FILE_APPEND);
      }
  }


// --------------------------------------------------
  // function
  // --------------------------------------------------


function readTable($table){
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
		mlog("Invalid config");
		header('HTTP/1.0 501 Server Error');
		die("Config Error");
	}

	mlog("Config: " . json_encode($cfg));

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
		mlog("PDO error" . $e->getMessage());
		header('HTTP/1.0 501 Server Error');
		die();
	}
	mlog("DB open");

	// code requested?
	if ($table == "qr") {
		$qr = file_get_contents(__DIR__ . "/qrcode.b64");
		return array("qr" => $qr);
	}

	if ($table == "defaults") {
		$sql =  "select sector1,sector2,sector3,sector4,sector5 from defaults";
	} else {
		$sql = "select * from " . $table;
	}
	$query = $pdo->prepare( $sql);
	$query->execute();
	$result = $query->fetchAll();

	if (count($result) == 1) {
		return $result[0];
	} else {
		return $result;
	}

}



// --------------------------------------------------
  // start ...
  // --------------------------------------------------


$meth = $_SERVER["REQUEST_METHOD"];

$result = array();

switch ($meth) {
    case "GET":
        mlog("GET");
        $parms = array("table" => FILTER_SANITIZE_STRING);
        $args = filter_input_array(INPUT_GET, $parms, true);

        if ($args & ($args["table"] !== null)) {
            $table = $args["table"];
        }
        // code is no table but b64
        define("TABLES", array("balance","districts","defaults","qr"));
        
        if (array_search($table, TABLES) === false) {
            mlog("Invalid table");
            header("HTTP/1.1 400 Bad request");
        }  else {
            $result = readTable($table);
        }
        break;

    default:
        mlog("Other");
		header('HTTP/1.0 409 Bad Request');
		die();
        break;
}

header('HTTP/1.0 200 OK');
echo json_encode($result);
ob_end_flush();


/*

header('HTTP/1.0 200 OK');
header('HTTP/1.0 403 Invalid ID');
header('HTTP/1.0 409 Bad Request');

*/

?>
