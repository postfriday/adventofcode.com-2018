<?php
/**
 * Created by PhpStorm.
 * User: m
 * Date: 01.12.2018
 * Time: 17:37
 */

require (__DIR__ . '/shared.php');

foreach ($data as $item) {
    $count += (int)$item;
}
print_r('Frequency count: ' . $count . chr(10));