function loadPeople() {
    const fileInput = $('#fileInput')[0];
    const file = fileInput.files[0];

    if (file) {
        const formData = new FormData();
        formData.append('file', file);

        $.ajax({
            url: 'utils/load_people.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#generatorInfo').html(response);
                fetchPeople();
            }
        });
    }
}

function getPerson() {
    const idInput = $('#idInput');
    const id = idInput.val();

    if (id) {
        $.ajax({
            url: 'utils/get_person.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                $('#personInfo').html(response);
            }
        });
    }
}

function generatePeople() {
    let count = $('#count').val();
    if (count === '') {
        alert('Please enter the number of users to generate.');
        return;
    }
    
    $.ajax({
        url: 'utils/generator.php',
        type: 'GET',
        data: {
            count: count
        },
        success: function(response) {
            $('#generatorInfo').html(response);
            fetchPeople();
        }
    });
}

function getPercentage() {
    $.ajax({
        url: 'utils/get_percentage.php',
        type: 'GET',
        success: function(response) {
            $('#percentageInfo').html(response);
        }
    });
}

let currentPage = 1;
let totalPages;

function fetchPeople(page) {
    if (page < 1 || page > totalPages) {
        return;
    }
    
    $('#tableContainer').empty();
    $('#pagination').empty();

    $.ajax({
        url: 'utils/fetch_people.php',
        method: 'POST',
        data: { page: page },
        dataType: 'json',
        beforeSend: function() {
            $('#loadingIndicator').show();
        },
        success: function(response) {
            let tableRows = response.rows;
            $('#tableContainer').html(response.rows);
            $('#pagination').html(response.pagination);
            totalPages = response.totalPages;
            currentPage = page;
            $('#loadingIndicator').hide();
        },
        error: function() {
            $('#loadingIndicator').hide();
        }
    });
}

$(document).on('click', '.pagination-link', function(e) {
    e.preventDefault();
    let page = $(this).data('page');
    fetchPeople(page);
});

fetchPeople(currentPage);
