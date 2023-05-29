<?php
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $startTime = microtime(true);

    $filename = $_FILES['file']['name'];
    $tmpFilePath = $_FILES['file']['tmp_name'];

    $uploadPath = __DIR__ . '../../' . $filename;
    move_uploaded_file($tmpFilePath, $uploadPath);

    require '../app/classes.php';
    
    $mankind = Mankind::getInstance();
    $mankind->loadPeopleFromFile($uploadPath);

    $endTime = microtime(true);
    $executionTime = $endTime - $startTime;
    echo 'People loaded successfully.';
    echo '<br>Execution time: ' . round($executionTime, 2) . ' seconds';
} else {
    echo 'File upload failed.';
}
?>
