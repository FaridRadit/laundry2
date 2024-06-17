<?php
include("connectdb.php");
session_start();

// Fetch service names and prices from the database
$service_query = "SELECT nama_service, harga_jasa FROM service";
$service_result = $conn->query($service_query);

$services = array();
while ($row = $service_result->fetch_assoc()) {
    $services[] = $row;
}

if (isset($_POST['name'])) {
    // Extract data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $service_name = $_POST['service_name'];
    $harga_jasa = $_POST['harga_jasa'];
    $amount_paid = $_POST['amount_paid'];
    $pickup_date = $_POST['pickup_date'];
    $delivery_date = $_POST['delivery_date'];
    $order_date = $_POST['order_date']; // Corrected this line

    // Prepare and bind parameters to prevent SQL injection
    $sql = "INSERT INTO customer (name, email, phone, address, service_name, price, amount_paid, pickup_date, delivery_date, order_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $name, $email, $phone, $address, $service_name, $harga_jasa, $amount_paid, $pickup_date, $delivery_date, $order_date);

    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully');</script>";
        echo "<script>window.location.href = 'admin_dasboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            margin-top: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container h1 {
            text-align: center;
            color: #333;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="date"],
        .form-container input[type="number"],
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            display: block;
            width: 100%;
            background: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background: #218838;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var services = <?php echo json_encode($services); ?>;
            var serviceSelect = document.getElementById("service_name");
            var hargaJasaInput = document.getElementById("harga_jasa");

            serviceSelect.addEventListener("change", function () {
                var selectedService = serviceSelect.value;
                var selectedHargaJasa = services.find(service => service.nama_service === selectedService).harga_jasa;
                hargaJasaInput.value = selectedHargaJasa;
            });
        });
    </script>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h1>ORDER FORM</h1>
        <form action="add_order.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="service_name">Service Name:</label>
            <select id="service_name" name="service_name" required>
                <?php foreach ($services as $service) { ?>
                    <option value="<?php echo $service['nama_service']; ?>"><?php echo $service['nama_service']; ?></option>
                <?php } ?>
            </select>

            <label for="harga_jasa">Harga Jasa (Rp):</label>
            <input type="number" id="harga_jasa" name="harga_jasa" required readonly>

            <label for="amount_paid">Amount Paid (Rp):</label>
            <input type="number" id="amount_paid" name="amount_paid" required>

            <label for="pickup_date">Pickup Date:</label>
            <input type="date" id="pickup_date" name="pickup_date" required>

            <label for="delivery_date">Delivery Date:</label>
            <input type="date" id="delivery_date" name="delivery_date" required>

            <!-- Automatically filled order_date field -->
            <input type="hidden" name="order_date" value="<?php echo date('Y-m-d'); ?>">

            <input type="submit" value="Submit">
        </form>
    </div>
</div>

</body>
</html>
