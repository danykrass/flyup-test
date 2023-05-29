<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>People App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }
            html {
                line-height: 1.4;
            }
            body {
                background: #f7f7f7;
                color: #363636;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 16px;
            }
            a, a:focus {
                text-decoration: none;
            }
            h1 {
                font-size: 36px;
                text-transform: uppercase;
            }
            h2 {
                font-size: 16px;
                text-transform: capitalize;
            }
            section {
                margin: 25px 0;
            }
            .wrapper {
                max-width: 1170px;
                padding-left: 15px;
                padding-right: 15px;
                margin-left: auto;
                margin-right: auto;
                height: 100%;
            }
            .row {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
            }
            .jcsb {
                -webkit-box-pack: justify;
                -ms-flex-pack: justify;
                justify-content: space-between;
            }
            input {
                border-radius: 3px;
                height: 40px;
                border: 1px solid #e3e3e3e3;
                padding: 5px;
                box-shadow: 0 1px 5px 1px rgb(17 17 17 / 4%);
            }
            input:focus {
                border: 1px solid #c8c8c8;
                outline: none;
            }
            #fileInput {
                width: 235px;
                vertical-align: middle;
            }
            #generatorInfo {
                font-size: 12px;
            }
            .load, .user, .percent {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                height: 360px;
                background: #fff;
                min-width: 300px;
                width: 100%;
                max-width: 370px;
                padding: 25px;
                margin: 10px 0px;
                box-shadow: 0 1px 5px 1px rgb(17 17 17 / 5%);
            }
            .info {
                display: flex;
                justify-content: center;
                width: 100%;
                height: 120px;
            }
            button {
                border-radius: 3px;
                border: none;
                box-shadow: 0 1px 5px 1px rgb(17 17 17 / 5%);
                color: #fff;
                text-transform: uppercase;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                margin: 15px 0;
                height: 40px;
                width: auto;
                background: #07a556;
                padding: 10px 15px;
            }
            button:hover {
                cursor: pointer;
                background: #069b50;
                transition: 0.5s;
            }
            table {
                border: 1px solid #ccc;
                border-collapse: collapse;
                margin: 0;
                padding: 0;
                width: 100%;
                table-layout: fixed;
            }

            table tr {
                background-color: #f8f8f8;
                border: 1px solid #ddd;
                padding: .35em;
            }

            table th,
            table td {
                padding: .625em;
                text-align: center;
            }

            table th {
                font-size: .85em;
                letter-spacing: .1em;
                text-transform: uppercase;
            }
            #pagination {
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 25px 0;
                flex-wrap: wrap;
            }
            #pagination a {
                text-decoration: none;
                width: auto;
                border: 1px solid;
                text-align: center;
                margin: 5px;
                padding: 10px;
                color: #363636;
            }
            #pagination a.active{
                color: #009DE0;
            }
            #pagination a:hover{
                color: #009DE0;
            }
            #loadingIndicator {
                text-align: center;
                font-weight: 700;
                font-size: 21px;
            }
            @media screen and (max-width: 770px) {
                .load, .user, .percent {
                    flex: 1 0 30%;
                    margin: 10px 5px;
                    max-width: inherit;
                }
                .table {
                    margin: 0 5px;
                }
                .percent {
                    height: 200px;
                }
            }
            @media screen and (max-width: 600px) {
                table {
                    border: 0;
                }
                
                table thead {
                    border: none;
                    clip: rect(0 0 0 0);
                    height: 1px;
                    margin: -1px;
                    overflow: hidden;
                    padding: 0;
                    position: absolute;
                    width: 1px;
                }
                
                table tr {
                    border-bottom: 3px solid #ddd;
                    display: block;
                    margin-bottom: .625em;
                }
                table tr:first-of-type {
                    display: none;
                }
                
                table td {
                    border-bottom: 1px solid #ddd;
                    display: block;
                    font-size: .8em;
                    text-align: right;
                }
                
                table td::before {
                    content: attr(data-label);
                    float: left;
                    font-weight: bold;
                    text-transform: uppercase;
                }
                
                table td:last-child {
                    border-bottom: 0;
                }
            }
    </style>
</head>
<body>
<section>
    <div class="wrapper">
        <h1>People App</h1>
        <div class="row jcsb">
            <div class="load">
                <h2>Load people from file / Generate</h2>
                <input type="file" id="fileInput">
                <button onclick="loadPeople()">Load</button>
                <input type="text" id="count" placeholder="Enter the number of users">
                <button onclick="generatePeople()">Generate</button>
                <div id="generatorInfo"></div>
            </div>

            <div class="user">
                <h2>Get person by ID</h2>
                <div class="field-group">
                    <input type="text" id="idInput" placeholder="Enter ID">
                    <button onclick="getPerson()">Get</button>
                </div>
                <div class="info">
                    <div id="personInfo"></div>
                </div>
            </div>

            <div class="percent">
                <h2>Percentage of men</h2>
                <button onclick="getPercentage()">Get</button>
                <div class="info"><div id="percentageInfo"></div></div>
            </div>

            <div class="table">
                <table>
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date of birth</th>
                    </tr>
                    </thead>
                        <tbody id="tableContainer">
                    </tbody>
                </table>
                <div id="pagination"></div>
                <div id="loadingIndicator" style="display: none;">Loading...</div>
            </div>
        </div>
    </div>
</section>

    <script>

        function loadPeople() {
            const fileInput = document.getElementById('fileInput');
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
                        const generatorInfo = document.getElementById('generatorInfo');
                        generatorInfo.innerHTML = response;
                        fetchPeople();
                    }
                });
            }
        }

        function getPerson() {
            const idInput = document.getElementById('idInput');
            const id = idInput.value;

            if (id) {
                $.ajax({
                    url: 'utils/get_person.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        const personInfo = document.getElementById('personInfo');
                        personInfo.innerHTML = response;
                    }
                });
            }
        }
        function generatePeople() {
        let count = document.getElementById('count').value;
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
                    const generatorInfo = document.getElementById('generatorInfo');
                    generatorInfo.innerHTML = response;
                    fetchPeople();
                }
            });
        }


        function getPercentage() {
            $.ajax({
                url: 'utils/get_percentage.php',
                type: 'GET',
                success: function(response) {
                    const percentageInfo = document.getElementById('percentageInfo');
                    percentageInfo.innerHTML = response;
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
                    let totalPages = response.totalPages;
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


    </script>
</body>
</html>
