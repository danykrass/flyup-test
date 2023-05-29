<?php
require '../app/classes.php';
$mankind = Mankind::getInstance();
$percentage = $mankind->getPercentageOfMen();

if (is_string($percentage)) {
    echo $percentage; 
} else {
    echo 'Percentage of men: ' . number_format($percentage, 2). '%';
}
?>
