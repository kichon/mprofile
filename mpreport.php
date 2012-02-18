<?php

$sql_cnt = array();
$samples = 0;

$file = $argv[1];

$fh = fopen($file, 'r');

$line = '';
while (! feof($fh)) {
    $samples++;
    $line = fgets($fh);
    $rows = json_decode($line);

    if (is_null($rows)) break;

    foreach ($rows as $row) {
        if ($row->Info) {
            if (! isset($sql_cnt[$row->Info])) {
                $sql_cnt[$row->Info] = 0;
            } else {
                $sql_cnt[$row->Info]++;
            }
        }
    }
}
fclose($fh);

arsort($sql_cnt);
//print_r($sql_cnt);


foreach ($sql_cnt as $k=>$v) {
    printf(
        "%.3f: %s\n",
        $sql_cnt[$k] / $samples * 100,
        $k
    );
}
