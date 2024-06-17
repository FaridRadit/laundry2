<?php
include("connectdb.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $update_sql = "UPDATE customer SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating status');</script>";
    }

    $stmt->close();
}

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
        <a href="package.php" class="nav-link"><i class="fas fa-box"></i> Paket</a>
        <a href="transaksi.php" class="nav-link active"><i class="fas fa-exchange-alt"></i> Transaksi</a>
        <a href="logout.php" class="nav-link logout"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <div class="header" style="text-align: right;">
        <img src="logo.png" alt="Luxury Laundry Logo" style="object-fit: cover;width: 150px;height: auto;">
    </div>
    <div class="content">
        <h1>Customer Orders</h1>
        <form action="add_order.php" method="post">
            <button class="btn btn-success mb-3" type="submit">Add Order</button>
        </form>
        
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Service</th>
                    <th>Pickup Date</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT order_id, name AS customer_name, email, phone, address, service_name, price, amount_paid, pickup_date, delivery_date, order_date, status 
                        FROM customer";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['service_name'] . "</td>";
                        echo "<td>" . $row['pickup_date'] . "</td>";
                        echo "<td>" . $row['delivery_date'] . "</td>";
                        echo "<form method='POST' action=''>";
                        echo "<td>
                                <input type='hidden' name='order_id' value='" . $row['order_id'] . "'>
                                <select class='form-control' name='status'>
                                    <option value='Closed'" . ($row['status'] == 'Closed' ? ' selected' : '') . ">Closed</option>
                                    <option value='On Process'" . ($row['status'] == 'On Process' ? ' selected' : '') . ">On Process</option>
                                    <option value='Open'" . ($row['status'] == 'Open' ? ' selected' : '') . ">Open</option>
                                    <option value='Sudah Diambil'" . ($row['status'] == 'Sudah Diambil' ? ' selected' : '') . ">Sudah Diambil</option>
                                </select>
                              </td>";
                        echo "<td><button class='btn btn-primary' type='submit' name='update_status'>Update</button></td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No orders found</td></tr>";
                }
                $conn->close();
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
