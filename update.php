<?php
$conn = new mysqli("localhost", "root", "", "crud_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pendaftar WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan nilai dari input form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE pendaftar SET name='$name', email='$email', phone='$phone' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengguna</title>
    <style>
        /* Mengatur gaya umum untuk body */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #544878 0%, #00ddff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Mengatur gaya container form */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        /* Mengatur label input dan spasi antar elemen */
        form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Mengatur gaya tombol submit */
        form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Mengatur gaya tombol submit saat di-hover */
        form button:hover {
            background-color:  #0056b3;
        }

        /* Mengatur gaya teks label */
        form label {
            font-weight: bold;
        }
    </style>
</head>
<body>

</body>
</html>

<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Nama: <input type="text" name="name" value="<?php echo $name; ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo $email; ?>" required><br>
    Telepon: <input type="text" name="phone" value="<?php echo $phone; ?>" required><br>
    <button type="submit">Update</button>
</form>
