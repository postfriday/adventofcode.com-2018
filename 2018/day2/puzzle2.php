<?php
/**
 * --- Part Two ---
 * Confident that your list of box IDs is complete, you're ready to find the boxes full of prototype fabric.
 *
 * The boxes will have IDs which differ by exactly one character at the same position in both strings. For example,
 * given the following box IDs:
 *
 *    - abcde
 *    - fghij
 *    - klmno
 *    - pqrst
 *    - fguij
 *    - axcye
 *    - wvxyz
 *
 * The IDs abcde and axcye are close, but they differ by two characters (the second and fourth). However, the IDs fghij
 * and fguij differ by exactly one character, the third (h and u). Those must be the correct boxes.
 *
 * What letters are common between the two correct box IDs? (In the example above, this is found by removing the
 * differing character from either ID, producing fgij.)
 *
 * Your puzzle answer was aixwcbzrmdvpsjfgllthdyoqe.
 */

const SCREEN_OUTPUT = false;

/**
 * @param $index
 * @param $string
 * @return string
 */
function removeIndex($index, $string) {
    return substr($string,0, $index++) . substr($string, $index);
}

/**
 * @param $needle
 * @param $input
 * @return array
 */
function getCommonIndex($needle, $array) {
    $result = [];
    $count = 0;
    for ($i = 0; $i < strlen($needle); $i++) {
        foreach ($array as $id) {
            if (constant('SCREEN_OUTPUT')) {
                $string = 'Try #' . $count . ': ' . $id;
                print_r($string . str_repeat(chr(13), strlen($string)));
            }
            if ($needle != $id) {
                if (removeIndex($i, $needle) == removeIndex($i, $id)) {
                    print_r('Found match: ' . $id . chr(10));
                    return [$id => $i];
                }
            }
            $count++;
        }
    }
    return $result;
}

print_r('Day 2 / Puzzle 2:' . chr(10));
$input = explode(chr(10), file_get_contents(__DIR__ . '/input.txt'));
$result = [];
foreach ($input as $idx => $id) {
    $result = array_merge($result, getCommonIndex($id, $input));
}


if (is_array($result) && !empty($result)) {
    foreach ($result as $id => $index) {
        print_r(' - Common letters: ' . removeIndex($index, $id) . chr(10));
    }
} else {
    print_r('Matches not found.' . chr(10));
}