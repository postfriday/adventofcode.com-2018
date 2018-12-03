<?php
/**
 * --- Day 3: No Matter How You Slice It ---
 * The Elves managed to locate the chimney-squeeze prototype fabric for Santa's suit (thanks to someone who helpfully
 * wrote its box IDs on the wall of the warehouse in the middle of the night). Unfortunately, anomalies are still
 * affecting them - nobody can even agree on how to cut the fabric.
 *
 * The whole piece of fabric they're working on is a very large square - at least 1000 inches on each side.
 *
 * Each Elf has made a claim about which area of fabric would be ideal for Santa's suit. All claims have an ID and
 * consist of a single rectangle with edges parallel to the edges of the fabric. Each claim's rectangle is defined as
 * follows:
 *
 *    - The number of inches between the left edge of the fabric and the left edge of the rectangle.
 *    - The number of inches between the top edge of the fabric and the top edge of the rectangle.
 *    - The width of the rectangle in inches.
 *    - The height of the rectangle in inches.
 *
 * A claim like #123 @ 3,2: 5x4 means that claim ID 123 specifies a rectangle 3 inches from the left edge, 2 inches
 * from the top edge, 5 inches wide, and 4 inches tall. Visually, it claims the square inches of fabric represented
 * by # (and ignores the square inches of fabric represented by .) in the diagram below:
 *
 *    ...........
 *    ...........
 *    ...#####...
 *    ...#####...
 *    ...#####...
 *    ...#####...
 *    ...........
 *    ...........
 *    ...........
 *
 * The problem is that many of the claims overlap, causing two or more claims to cover part of the same areas. For
 * example, consider the following claims:
 *
 *    #1 @ 1,3: 4x4
 *    #2 @ 3,1: 4x4
 *    #3 @ 5,5: 2x2
 *
 * Visually, these claim the following areas:
 *
 *    ........
 *    ...2222.
 *    ...2222.
 *    .11XX22.
 *    .11XX22.
 *    .111133.
 *    .111133.
 *    ........
 *
 * The four square inches marked with X are claimed by both 1 and 2. (Claim 3, while adjacent to the others, does not
 * overlap either of them.)
 *
 * If the Elves all proceed with their own plans, none of them will have enough fabric. How many square inches of
 * fabric are within two or more claims?
 *
 * Your puzzle answer was 104712.
 */

function parseClaim($string) {
    $arr = explode('@', $string);
    $arr[0] = explode('#', $arr[0]);
    $arr[1] = explode(':', $arr[1]);
    $arr[1][0] = explode(',', $arr[1][0]);
    $arr[1][1] = explode('x', $arr[1][1]);
    return [
        'id'        => (int)$arr[0][1],
        'left'      => (int)$arr[1][0][0],
        'top'       => (int)$arr[1][0][1],
        'width'     => (int)$arr[1][1][0],
        'height'    => (int)$arr[1][1][1],
    ];
}

function fillFabric($claim, $fabric, &$overlap) {
    for ($y = $claim['top']; $y < $claim['top'] + $claim['height']; $y++) {
        for ($x = $claim['left']; $x < $claim['left'] + $claim['width']; $x++) {
            $value = $claim['id'];
            if ($fabric[$y][$x] > 0) {
                $value = -1;
                $overlap[$y][$x]++;
            }
            $fabric[$y][$x] = $value;
        }
    }
    return $fabric;
}


function draw($fabric) {
    foreach ($fabric as $row) {
        foreach ($row as $cell) {
            switch ($cell) {
                case -1:
                    $s = 'X'; break;
                case 0:
                    $s = '.'; break;
                default:
                    $s = $cell; break;
            }
            print_r($s);
        }
        print_r(chr(10));
    }
}


print_r('Day 3 / Puzzle 1:' . chr(10));
$input = explode(chr(10), file_get_contents(__DIR__ . '/input.txt'));
$fabric = [];
$fabric_size = [
    'width'     => 0,
    'height'    => 0,
];
$overlap = [];

foreach ($input as $i => $claim) {
    $claim = parseClaim($claim);
    $input[$i] = $claim;
    if ($claim['left'] + $claim['width'] > $fabric_size['width']) {
        $fabric_size['width'] = $claim['left'] + $claim['width'];
    }
    if ($claim['top'] + $claim['height'] > $fabric_size['height']) {
        $fabric_size['height'] = $claim['top'] + $claim['height'];
    }
}

for ($i = 0; $i <= $fabric_size['width']; $i++) {
    $fabric[$i] = array_fill(0, $fabric_size['height'] + 1, '0');
}

reset($input);
foreach ($input as $claim) {
    $fabric = fillFabric($claim, $fabric, $overlap);
}
print_r(count($overlap, COUNT_RECURSIVE) - count($overlap) . chr(10));
//draw($fabric);

