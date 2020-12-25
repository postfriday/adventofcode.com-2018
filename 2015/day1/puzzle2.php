<?php

$data = file_get_contents(__DIR__ . '/input.txt');
$floor = 0;

for ($i = 0; $i < strlen($data); $i++) {
    if ($data[$i] == '(') {
        $floor++;
    }
    if ($data[$i] == ')') {
        $floor--;
    }
    if ($floor == -1) {
        break;
    }
}
print_r('Character: ' . ($i + 1) . chr(10));

