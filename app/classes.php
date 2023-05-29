<?php

class Person {
    private $id;
    private $name;
    private $surname;
    private $sex;
    private $birthDate;

    public function __construct($id, $name, $surname, $sex, $birthDate) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->sex = $sex;
        $this->birthDate = $birthDate;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getSex() {
        return $this->sex;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function getAgeInDays() {
        $birthTimestamp = strtotime($this->birthDate);
        $currentTimestamp = time();
        $ageInSeconds = $currentTimestamp - $birthTimestamp;
        return floor($ageInSeconds / (60 * 60 * 24));
    }
}

class Mankind implements ArrayAccess, IteratorAggregate, Countable {
    private static $instance;
    public $people;

    private function __construct() {
        $this->people = [];
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // First method
    // This solution is not optimal for loading large files over 100 MiB. 
    // In the current implementation of the method, the entire file is read into the buffer and then divided into lines for further processing. 
    // This can lead to memory problems when processing very large files, since the entire file will be loaded into RAM.
    // But with small amounts of data, it handles faster than the second option.

    public function loadPeopleFromFile($filename) {
        try {
            if (!file_exists($filename)) {
                throw new Exception("File does not exist or cannot be accessed.");
            }
    
            $newFilePath = __DIR__ . "/../people.csv";

            if (!rename($filename, $newFilePath)) {
                throw new Exception("Failed to rename the file.");
            }


            $file = fopen($newFilePath, 'r');
    
            if (!$file) {
                throw new Exception("Unable to read the file contents.");
            }
    
            $bufferSize = 32768; //bytes
            $buffer = '';
    
            while (!feof($file)) {
                $buffer .= fread($file, $bufferSize);
                $lines = explode(PHP_EOL, $buffer);
                $buffer = array_pop($lines);
    
                foreach ($lines as $line) {
                    $personData = explode(';', trim($line));
                    if (count($personData) === 5) {
                        $id = intval($personData[0]);
                        $name = $personData[1];
                        $surname = $personData[2];
                        $sex = $personData[3];
                        $birthDate = $personData[4];
                        $person = new Person($id, $name, $surname, $sex, $birthDate);
                        $this[$id] = $person;
                    }
                }
            }
    
            fclose($file);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // The second implementation, with a line-by-line reading of the file.
    // Advantages of this approach:
    // The file is read line by line, which allows you to process large files without loading them completely into memory. 
    // This reduces memory consumption and allows for more efficient processing of large amounts of data. 
    // The sequential reading and processing of each line of the file allows to achieve higher performance when loading large files.
    // Thus, the proposed method using fgetcsv() is a better solution for handling large files

    // public function loadPeopleFromFile($filename) {
    //     try {
    //      if (!file_exists($filename)) {
    //          throw new Exception("File does not exist or cannot be accessed.");
    //      }
    
    //      $newFilePath = __DIR__ . "/../people.csv";
    
    //      if (!rename($filename, $newFilePath)) {
    //          throw new Exception("Failed to rename the file.");
    //      }
    //      $file = fopen($newFilePath, 'r');
    //     if (!$file) {
    //         throw new Exception("Unable to read the file contents.");
    //     }
    
    //         while (($personData = fgetcsv($file, 0, ';')) !== false) {
    //             if (count($personData) === 5) {
    //                 $id = intval($personData[0]);
    //                 $name = $personData[1];
    //                 $surname = $personData[2];
    //                 $sex = $personData[3];
    //                 $birthDate = $personData[4];
    //                 $person = new Person($id, $name, $surname, $sex, $birthDate);
    //                 $this[$id] = $person;
    //             }
    //         }
    
    //         fclose($file);
    //     } catch (Exception $e) {
    //         echo $e->getMessage();
    //     }
    // }
    
    private function addPeopleToMankind($people) {
        $this->people += $people;
    }

    public function getPersonById($id) {
        return isset($this->people[$id]) ? $this->people[$id] : null;
    }

    public function getPercentageOfMen() {
        $totalPeople = count($this->people);
        if ($totalPeople === 0) {
            return "No data available for comparison.";
        }
    
        $menCount = 0;
        foreach ($this->people as $person) {
            if ($person->getSex() === 'M') {
                $menCount++;
            }
        }
    
        if ($menCount === 0) {
            return "No data available for comparison.";
        }
    
        return ($menCount / $totalPeople) * 100;
    }
    
    
    

    public function offsetExists($offset): bool {
        return isset($this->people[$offset]);
    }

    public function offsetGet($offset): mixed {
        return isset($this->people[$offset]) ? $this->people[$offset] : null;
    }

    public function offsetSet($offset, $value): void {
        if ($offset === null) {
            $this->people[] = $value;
        } else {
            $this->people[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void {
        unset($this->people[$offset]);
    }

    public function getIterator(): Traversable {
        return new ArrayIterator($this->people);
    }
    public function count(): int {
        return count($this->people);
    }
}

$mankind = Mankind::getInstance();
$mankind->loadPeopleFromFile('../people.csv');

?>