<?php
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    require '../app/classes.php';
    $mankind = Mankind::getInstance();
    $person = $mankind->getPersonById($id);

    if ($person !== null) {
        $text = 'ID: ' . $person->getId() . '<br>';
        $text .= 'Name: ' . $person->getName() . '<br>';
        $text .= 'Surname: ' . $person->getSurname() . '<br>';
        $text .= 'Birthday: ' . $person->getBirthDate() . '<br>';
        $text .= 'Age (in days): ' . $person->getAgeInDays();

        echo $text;
    } else {
        echo 'Person not found.';
    }
}
?>