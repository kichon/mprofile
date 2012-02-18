<?php

$user = 'root';
$password = '';
$host = 'localhost';
$dsn = 'mysql:host='.$host;

$dbh = new PDO($dsn, $user, $password);

$samples = 1000;
$interval = 0.1;


for ($i = 0; $i < $samples; $i++) {
    $sth = $dbh->prepare('SHOW FULL PROCESSLIST');
    $sth->execute();

    $json = json_encode(array_filter($sth->fetchAll(PDO::FETCH_ASSOC), function($v) {
                if ($v['Command'] == 'Query' && $v['Info'] != 'SHOW FULL PROCESSLIST')
                    return $v;
            }));

    echo $json, PHP_EOL;

    sleep($interval);
}
