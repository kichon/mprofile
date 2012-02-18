<?php

$file = $argv[1];

$fh = fopen($file, 'r');

$line = '';
while (! feof($fh)) {
    $line = fgets($fh);
    $rows = json_decode($line);

    if (is_null($rows)) break;

    foreach ($rows as $row) {
        $pattern1 = '/(?<=\W)-?(?:0x[0-9a-f]+|[0-9\.]+)|\'.*?|\".*?\"/i';
        $replacement1 = '?';
        $row->Info = preg_replace($pattern1, $replacement1, $row->Info);

        $pattern2 = '/(\s+IN\s+)\([\?,\s]+\)/i';
        $replacement2 = '$1(...)';
        $row->Info = preg_replace($pattern2, $replacement2, $row->Info);

        $pattern3 = '/(\s+VALUES\s+)\(.*\)+/i';
        $replacement3 = '$1(...)';
        $row->Info = preg_replace($pattern3, $replacement3, $row->Info);
    }
    echo json_encode($rows), "\n";
}
fclose($fh);
