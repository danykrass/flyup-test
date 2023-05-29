<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

require '../app/classes.php';

function generateTableRows($people) {
    $rows = '';
    foreach ($people as $person) {

        $rows .= '<tr>';
        $rows .= '<td data-label="id">' . $person->getId() . '</td>';
        $rows .= '<td data-label="name">' . $person->getName() . '</td>';
        $rows .= '<td data-label="surname">' . $person->getSurname() . '</td>';
        $rows .= '<td data-label="gender">' . $person->getSex() . '</td>';
        $rows .= '<td data-label="birthday">' . $person->getBirthDate() . '</td>';
        $rows .= '</tr>';

    }
    return $rows;
}

$peoplePerPage = 100;

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;

$mankind = Mankind::getInstance();

$offset = ($page - 1) * $peoplePerPage;

$people = array_slice($mankind->people, $offset, $peoplePerPage);

$tableRows = generateTableRows($people);

$totalPeople = count($mankind->people);
$totalPages = ceil($totalPeople / $peoplePerPage);

$pagination = '';

$pagination .= ($page > 10) ? '<a href="#" onclick="fetchPeople(1)">1</a> ... ' : '';

$startPage = max(1, $page - 10);
$endPage = min($page + 10, $totalPages);

for ($i = $startPage; $i <= $endPage; $i++) {
    $activeClass = ($i === $page) ? 'active' : '';
    $pagination .= '<a href="#" onclick="fetchPeople(' . $i . ')" class="' . $activeClass . '">' . $i . '</a>';
    if ($i !== $endPage) {
        $pagination .= ' ';
    }
}

$pagination .= ($page + 10 < $totalPages) ? ' ... <a href="#" onclick="fetchPeople(' . $totalPages . ')">' . $totalPages . '</a>' : '';


$response = [
    'rows' => $tableRows,
    'pagination' => $pagination,
    'totalPages' => $totalPages
];

header('Content-Type: application/json');
echo json_encode($response);
?>
