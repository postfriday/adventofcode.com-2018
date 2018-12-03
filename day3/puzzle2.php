<?php
/**
 * --- Part Two ---
 * Amidst the chaos, you notice that exactly one claim doesn't overlap by even a single square inch of fabric with any
 * other claim. If you can somehow draw attention to it, maybe the Elves will be able to make Santa's suit after all!
 *
 * For example, in the claims above, only claim 3 is intact after all claims are made.
 *
 * What is the ID of the only claim that doesn't overlap?
 *
 * Your puzzle answer was 840.
 */

function parseClaim($string) {
    $result = [];
    $arr = explode('@', $string);
    $arr[0] = explode('#', $arr[0]);
    $arr[1] = explode(':', $arr[1]);
    $arr[1][0] = explode(',', $arr[1][0]);
    $arr[1][1] = explode('x', $arr[1][1]);
    $result = [
        'id'    => (int)$arr[0][1],
        'x1'    => (int)$arr[1][0][0],
        'x2'    => (int)$arr[1][0][0] + (int)$arr[1][1][0],
        'y1'    => (int)$arr[1][0][1],
        'y2'    => (int)$arr[1][0][1] + (int)$arr[1][1][1],
    ];
    return $result;
}

print_r('Day 3 / Puzzle 2:' . chr(10));
$input = explode(chr(10), file_get_contents(__DIR__ . '/input.txt'));

foreach ($input as $i => $claim) {
    $input[$i] = parseClaim($claim);
}

$input2 = $input;
$intersects = [];
foreach ($input as $RectA) {
    $intersects = false;
    foreach ($input2 as $RectB) {
        if (
            $RectA['id'] != $RectB['id'] &&
            $RectA['x1'] < $RectB['x2'] &&
            $RectA['x2'] > $RectB['x1'] &&
            $RectA['y1'] < $RectB['y2'] &&
            $RectA['y2'] > $RectB['y1']
        ) {
            $intersects = true;
            break;
        }
    }
    if (!$intersects) {
        print_r('Found match: ' . $RectA['id'] . chr(10));
    }
}
