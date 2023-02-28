<?php

use App\People;
use App\Person;

$person = new Person([
    'id' => 1,
    'first_name' => 'test',
    'last_name' => 'test',
    'birthday' => '28-02-2023',
    'city_birthday' => 'Minsk',
    'gender' => 1
]);

$people = new People([1], '=');

