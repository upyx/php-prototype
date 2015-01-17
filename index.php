<?php
error_reporting(-1);
require 'Object.php';
require 'Constructor.php';
require 'functions.php';

$Point    = new Object();
$Point->x = 0;
$Point->y = 0;

$Animal = new Constructor(function ($x = 0, $y = 0) {
    $point        = clone this()->point;
    $point->x     = $x;
    $point->y     = $y;
    this()->point = $point;
});

$Animal->prototype->point = $Point;
$Animal->prototype->walk  = function ($direction = 'N') {
    $point     = this()->point;
    $direction = strtoupper($direction);
    switch ($direction) {
        case 'N':
            $point->y++;
            break;
        case 'NE':
        case 'EN':
            $point->x++;
            $point->y++;
            break;
        case 'E':
            $point->x++;
            break;
        case 'SE':
        case 'ES':
            $point->x++;
            $point->y--;
            break;
        case 'S':
            $point->y--;
            break;
        case 'SW':
        case 'WS':
            $point->x--;
            $point->y--;
            break;
        case 'W':
            $point->x--;
            break;
        case 'NW':
        case 'WN':
            $point->x--;
            $point->y++;
            break;
    }

    echo 'Point {', $point->x, '; ', $point->y, '}', PHP_EOL;
    return this();
};
$Animal->prototype->talk  = function () {
    echo 'Shhhh', PHP_EOL;
    return this();
};

$cat       = new Object($Animal);
$cat->talk = function () {
    echo 'Meow', PHP_EOL;
};

$dog       = new Object($Animal);
$dog->talk = function () {
    echo 'Woof!', PHP_EOL;
};

$lion = new Object($cat);
$lion->talk = function () {
    echo 'Rrrrr', PHP_EOL;
};

$cat
    ->walk('NE')
    ->walk('E')
    ->walk('SE');
$dog
    ->walk('N')
    ->walk('N');
$cat->talk();
$dog->talk();
$lion->talk();
