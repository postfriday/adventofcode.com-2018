<?php
$DOCUMENT_ROOT = empty($_SERVER['DOCUMENT_ROOT']) ? '/var/www/html' : $_SERVER['DOCUMENT_ROOT'];
$data = explode(chr(10), file_get_contents($DOCUMENT_ROOT . '/day1/data.txt'));
$count = 0;
