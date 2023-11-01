<!DOCTYPE html>
<html>
<head>
    <title>Naru | Profile</title>
    <link rel="icon" href="<?= base_url('/gambar/logonaru.png') ?>">
    <!-- Tambahkan tautan ke file CSS Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
            text-transform: uppercase;
        }

        #sort {
            width: 100%;
            max-width: 200px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 8px;
        }

        #searchInput {
            width: 100%;
            max-width: 300px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 8px;
        }

        .table {
            margin-top: 30px;
        }

        th, td {
            text-align: center;
        }

        thead {
            background-color: #007bff;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('include/header.php'); ?>
    <?php include('include/navbar.php'); ?>
    <div class="container">
        <h1>User Profile</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="sort">Sort by:</label>
                <select id="sort" class="form-control">
                    <option value="az">Name A-Z</option>
                    <option value="za">Name Z-A</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by Username">
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="profileTable">
                <!-- Loop data here -->
            </tbody>
        </table>
        <ul class="pagination justify-content-center" id="pagination"></ul>
    </div>

    <!-- Tambahkan tautan ke file JavaScript Bootstrap dan jQuery jika diperlukan -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        const sortSelect = document.getElementById('sort');
        const profileTable = document.getElementById('profileTable');
        const searchInput = document.getElementById('searchInput');
        const paginationElement = document.getElementById('pagination');
        let users = <?= json_encode($users) ?>;
        const perPage = 5;
        let currentPage = 1;

        function renderTable(data) {
            profileTable.innerHTML = '';
            data.forEach(user => {
                profileTable.innerHTML += `
                    <tr>
                        <td>${user.username}</td>
                        <td>${user.alamat}</td>
                        <td>${user.nohp}</td>
                        <td>${user.email}</td>
                    </tr>
                `;
            });
        }

        function renderTableWithPagination(data, page) {
            const start = (page - 1) * perPage;
            const end = page * perPage;
            const paginatedData = data.slice(start, end);
            renderTable(paginatedData);

            const totalPages = Math.ceil(data.length / perPage);
            let paginationHtml = '';

            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            }

            paginationElement.innerHTML = paginationHtml;
        }

        function changePage(page) {
            currentPage = page;
            renderTableWithPagination(users, page);
        }

        sortSelect.addEventListener('change', function () {
            const value = this.value;
            if (value === 'az') {
                const sortedData = users.sort((a, b) => a.username.localeCompare(b.username));
                renderTableWithPagination(sortedData, currentPage);
            } else if (value === 'za') {
                const sortedData = users.sort((a, b) => b.username.localeCompare(a.username));
                renderTableWithPagination(sortedData, currentPage);
            }
        });

        searchInput.addEventListener('input', function () {
            const searchString = this.value.trim().toLowerCase();
            const filteredData = users.filter(user => user.username.toLowerCase().includes(searchString));
            renderTableWithPagination(filteredData, currentPage);
        });

        // Render initial data with pagination
        renderTableWithPagination(users, 1);
        document.getElementById('totalData').textContent = users.length;
    </script>
</body>
</html>
