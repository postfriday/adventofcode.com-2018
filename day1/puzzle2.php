<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 01.12.2018
 * Time: 17:37
 */

require (__DIR__ . '/shared.php');

$frequency = [$count];
while(true) {
    foreach ($data as $value) {
        $count += (int)$value;
        if (in_array($count, $frequency)) {
            print_r('Frequency reached twice: ' . $count . chr(10));
            print_r('Items in frequency array: ' . count($frequency) . chr(10));
            exit(0);
        }
        $frequency[] = $count;
    }
}