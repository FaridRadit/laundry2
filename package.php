<?php
include("connectdb.php");
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            transition: left 0.3s;
        }
        .sidebar h2 {
            color: limegreen;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }
        
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .header {
            background-color: #00aeef;
            padding: 10px 20px;
            text-align: center;
            margin-left: 220px;
        }
       
        .footer {
            background-color: limegreen;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            margin-left: 220px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #c2e48d;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a {
                float: left;
            }
            .content, .header, .footer {
                margin-left: 0;
            }
            .footer {
                position: relative;
            }
            .navbar-toggler {
                display: block;
            }
        }
        @media (max-width: 768px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
            .sidebar {
                left: -9999999999px;
            }
            .sidebar.active {
                left: 0;
            }
            .header {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">Luxury Laundry</a>
    </nav>
    <div class="sidebar" id="sidebar">
        <h2><i>ADMINISTRATOR<br><span style="color: white;">DASHBOARD</span></i></h2>
        <a href="admin_dasboard.php" class="nav-link"><i class="fas fa-home"></i> Home</a>
        <a href="package.php" class="nav-link active"><i class="fas fa-box"></i> Paket</a>
        <a href="transaksi.php" class="nav-link"><i class="fas fa-exchange-alt"></i> Transaksi</a>
        <a href="logout.php" class="nav-link logout"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <div class="header" style="text-align: right;">
        <img src="logo.png" alt="Luxury Laundry Logo" style="object-fit: cover;width: 150px;height: auto;">
    </div>
    <div class="content">
        <h1>Service Packages</h1>
        <a href="add_package.php" class="btn btn-success mb-3">Add Package</a>
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID Service</th>
                    <th>Service Name</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id_service, nama_service, harga_jasa FROM service";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id_service'] . "</td>
                                <td>" . $row['nama_service'] . "</td>
                                <td>" . $row['harga_jasa'] . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No services found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="footer">
        &copy; 2024 Luxury Laundry. All rights reserved.
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.querySelector('.navbar-toggler').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
