<?php
require 'vendor/autoload.php';

// $app = new \Slim\Slim();
$app = new \Slim\Slim(array(
    'debug' => true
));


$app->get('/stats', 'getStats');

$app->get('/stat/server', 'getServerStats');
$app->get('/stat/varnish', 'getVarnishStats');
$app->get('/stat/cachhits/month', 'getCacheHitsMonth');
$app->get('/stat/cachhits/hour', 'getCacheHitHour');

$app->get('/status/website/:websiteName', 'statusWebsite');
$app->get('/status/varnish', 'statusVarnish');

$app->get('/bans', 'banList');
$app->post('/ban', 'addBan');

$app->get('/vcls', 'getVCLs');
$app->get('/vcl/snippet/:snippet', 'getVCLSnippet');
$app->get('/vcl/snippets', 'getVCLSnippets');
$app->post('/vcl/:vclName',  'putVCLnew' );
$app->post('/vcl/delete/:vclName', 'deleteVCL') ;
$app->post('/vcl/activate/:vclName', 'activateVCL');



$app->run();

$log = $app->getLog();

header('Content-Type: application/json');


function addBan() {
        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        $newContent = json_decode($request->getBody());

        exec('/usr/bin/varnishadm ban "' . $newContent->{'banRegex'}.'"',$banOut );

        echo json_encode($banOut);

}

function banList() {
        $banEntries = array();
        exec('/usr/bin/varnishadm ban.list',$banList );

        foreach ($banList as $banEntry) {
                if ($banEntry == "Present bans:") { continue; }
                if (preg_match('/^(\S+)\s+(\S+)\s+(.+)$/', $banEntry, $banMatches) ) {
                        array_push($banEntries, array($banMatches[1],$banMatches[2],$banMatches[3]));
                }
        }
        echo json_encode($banEntries);

}

function deleteVCL($vclName) {
        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        $newContent = json_decode($request->getBody());

        if ($newContent->{'vclType'} == 'file') {
            try {
                unlink('./resources/vcl/full/' . $newContent->{'vclName'});
            } catch(PDOException $e) {
                echo json_encode('ERROR');
            }
                echo json_encode('OK');
        } else {
                echo json_encode('TO DO DELETE VARNISH DETAILS');
        }

}

function activateVCL($vclName) {
        exec('/usr/bin/varnishadm vcl.use '+ $vclName,$vclOut );

        echo json_encode($vclOut);
}

function loadVCL($vclName) {
        exec('/usr/bin/varnishadm vcl.load '+$vclName+' ./resources/vcl/full/'+$vclName,$vclOut );

        echo json_encode($vclOut);

}

function putVCLnew($vclName)  {

        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        $newContent = json_decode($request->getBody());

    try {
        file_put_contents('./resources/vcl/full/' . $newContent->{'vclName'},$newContent->{'vclContent'});
    } catch(PDOException $e) {
        echo json_encode('ERROR');
    }

        echo json_encode('OK');
}

function getVCLs() {
        $vclEntries = array();

        $directory = 'resources/vcl/full';
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));

        foreach($scanned_directory as $fullVclEntry) {
                $vclText = file_get_contents('resources/vcl/full/'.$fullVclEntry);
                array_push($vclEntries, array('file', 0, $fullVclEntry, $vclText ));
        }


        exec('/usr/bin/varnishadm vcl.list',$vclList );

        foreach ($vclList as $vclEntry) {
                if ($vclEntry == "") { continue; }
                if (preg_match('/^(\w+)\s+(\d+)\s+(\w+)$/', $vclEntry, $vclMatches) ) {
                        $vclDetails = shell_exec('/usr/bin/varnishadm vcl.show ' . $vclMatches[3]);
                        array_push($vclEntries, array($vclMatches[1],$vclMatches[2],$vclMatches[3], $vclDetails));
                }
        }
        echo json_encode($vclEntries);
}

function getVCLSnippet($snippetName) {
        $snippetText = file_get_contents('resources/vcl/snippets/'.$snippetName);

        echo json_encode($snippetText);
}

function getVCLSnippets() {
        $directory = 'resources/vcl/snippets';
        $scanned_directory = array_diff(scandir($directory), array('..', '.'));
        echo json_encode($scanned_directory);
}

function getStats() {
        $sql = "call get_hitratio_current";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $hitratio = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo  json_encode($hitratio) ;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function statusWebsite($websiteName) {
        $website_down = is_website_down($websiteName, $http_code);
        if (!$website_down){
                echo json_encode(array(array($websiteName,'available')));
        }
        else{
                echo json_encode(array(array($websiteName,'down')));
        }
}


function getVarnishStats() {
        $varnishstatout =  shell_exec('/usr/bin/varnishstat -j');
        echo $varnishstatout;
}


function statusVarnish() {
        echo json_encode(array("VarnishStatus" => "Running"));
}

function getServerStats() {

        $host = "localhost";
        $community = "binaryforest";

        $sysTotalMemory[0] = snmpget("$host","$community",".1.3.6.1.4.1.2021.4.5.0");
        $sysTotalMemory[1] = eregi_replace("INTEGER: ","", $sysTotalMemory[0]);
        $sysFreeMemory[0] = snmpget("$host","$community",".1.3.6.1.4.1.2021.4.11.0");
        $sysFreeMemory[1] = eregi_replace("INTEGER: ","", $sysFreeMemory[0]);

        $sysCPUIdlePct[0] = snmpget("$host","$community",".1.3.6.1.4.1.2021.11.11.0");
        $sysCPUIdlePct[1] = eregi_replace("INTEGER: ","", $sysCPUIdlePct[0]);

        $diskUsedPct[0] = snmpget("$host","$community",".1.3.6.1.4.1.2021.9.1.9.1");
        $diskUsedPct[1] = eregi_replace("INTEGER: ","", $diskUsedPct[0]);

        $FreeMemory = 100 - ($sysFreeMemory[1] / $sysTotalMemory[1] * 100);
        $CPUUsed = 100 - $sysCPUIdlePct[1];

        $serverStats = array('CPU'=>$CPUUsed, 'Memory'=>$FreeMemory, 'Disk'=>$diskUsedPct[1]);
        echo json_encode($serverStats);
}

function getCacheHitsMonth() {
        $sql = "call get_hitratio_last_month";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $cachehitsMonth = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
                echo  json_encode($cachehitsMonth) ;

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}

function getCacheHitHour() {
        $sql = "call get_hitratio_last_hour";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $cachehitsHour = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
                 echo  json_encode($cachehitsHour) ;

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function is_website_down($url, &$http_code) {
        //initialize curl
        $handle = curl_init($url);
        curl_setopt($handle,CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle,CURLOPT_HEADER,true);
        curl_setopt($handle,CURLOPT_NOBODY,true);
        curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
        //invoke curl to check the page return
        $response = curl_exec($handle);

        //optional: you may get the http status code for custom implementation
        $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($http_code == 404){
                //TODO
        }

        //close the curl handle
        curl_close($handle);
        //return the status to caller
        if ($response)
                return false;
        else
                return true;
}

function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="dbuser";
    $dbpass="dbpassword";
    $dbname="dbname";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>

