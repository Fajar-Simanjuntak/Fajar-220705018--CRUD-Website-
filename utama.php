<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>CRUD System</title>
</head>
<body>
    <div class="container">
        <h2>Daftar Pengguna</h2>
        <a href="create.php" class="btn">Tambahkan Pengguna</a>
        
        <!-- Form Pencarian -->
        <form method="GET" action="" class="search-form">
            <input type="text" name="search" placeholder="Cari berdasarkan nama" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type ="submit" class="cari">Cari</button>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Dob</th>
                        <th>Gender</th>
                        <th>Package</th>
                        <th>Duration</th>
                        <th>Payment</th>
                        <th>Registration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Koneksi ke database
                    $conn = new mysqli("localhost", "root", "", "crud_db");
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Pengaturan Pagination
                    $limit = 5; // Jumlah data per halaman
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;

                    // Mencari data berdasarkan input pencarian
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $sql = "SELECT * FROM pendaftar WHERE name LIKE '%$search%' LIMIT $limit OFFSET $offset";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["dob"] . "</td>
                                <td>" . $row["gender"] . "</td>
                                <td>" . $row["package"] . "</td>
                                <td>" . $row["duration"] . "</td>
                                <td>" . $row["payment"] . "</td>
                                <td>" . $row["registration_date"] . "</td>
                                <td>
                                    <a href='update.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id=" . $row["id"] . "' class='btn-delete'>Hapus</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                    }

                    // Menghitung total halaman
                    $sql_total = "SELECT COUNT(*) as total FROM pendaftar WHERE name LIKE '%$search%'";
                    $result_total = $conn->query($sql_total);
                    $total_data = $result_total->fetch_assoc()['total'];
                    $total_pages = ceil($total_data / $limit);

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" <?php if ($i == $page) echo 'class="active"'; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
