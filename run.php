<?php

include 'balisereader.php';

use jin\log\Debug;

$baliseReader = new BaliseReader();
$balises = $baliseReader->getBalises();

Debug::dump($balises);