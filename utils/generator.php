<?php
if (isset($_GET['count'])) {
    $count = intval($_GET['count']);
    if ($count > 0) {
        $startTime = microtime(true); 

        $oldFilePath = __DIR__ . '/../people.csv';
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        generateUsers(__DIR__ . '/../people.csv', $count);
        $endTime = microtime(true); 
        $executionTime = $endTime - $startTime; 
        echo "<br>Execution time: " . round($executionTime, 2) . " seconds";
    } else {
        echo "Invalid count value.";
    }
}

function generateUsers($filename, $count) {
    $idPrefix = 0;
    $blockSize = 10000;
    $totalUsers = $count;
    $generatedData = [];

    for ($i = 1; $i <= $totalUsers; $i++) {
        $id = $idPrefix + $i;
        $name = generateRandomName();
        $surname = generateRandomSurname();
        $sex = generateRandomSex();
        $birthDate = generateRandomBirthDate();

        $line = $id . ';' . $name . ';' . $surname . ';' . $sex . ';' . $birthDate . PHP_EOL;
        $generatedData[] = $line;

        if ($i % $blockSize === 0) {
            file_put_contents($filename, implode('', $generatedData), FILE_APPEND);
            $generatedData = []; 
        }
    }

    if (!empty($generatedData)) {
        file_put_contents($filename, implode('', $generatedData), FILE_APPEND);
    }

    echo "Users generated and saved";
}

function generateRandomName() {
    $names = ['Michal', 'Pavla', 'John', 'William', 'Michael', 'David', 'Mary', 'Jennifer', 'Linda', 'Sarah'];
    return $names[array_rand($names)];
}

function generateRandomSurname() {
    $surnames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilson'];
    return $surnames[array_rand($surnames)];
}

function generateRandomSex() {
    $sexes = ['M', 'F'];
    return $sexes[array_rand($sexes)];
}

function generateRandomBirthDate() {
    $startTimestamp = strtotime('01.01.1950');
    $endTimestamp = strtotime('31.12.2000');
    $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);
    return date('d.m.Y', $randomTimestamp);
}

?>