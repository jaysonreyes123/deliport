<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
</head>
<body>
    <h1>Order System</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the order
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        $total = $quantity * $price;

        // Create order summary
        $orderSummary = "Product: $product\n";
        $orderSummary .= "Quantity: $quantity\n";
        $orderSummary .= "Price per unit: $price\n";
        $orderSummary .= "Total: $total\n";

        // Write order summary to a file
        $filename = 'order_summary.txt';
        file_put_contents($filename, $orderSummary);

        // Display download link
        echo '<p>Order placed successfully!</p>';
        echo '<p>Download your order summary: <a href="download.php?filename=' . $filename . '">Download</a></p>';
    }
    ?>

    <h2>Place an Order</h2>
    <form method="post" action="">
        <label for="product">Product:</label>
        <input type="text" name="product" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label for="price">Price per unit:</label>
        <input type="number" name="price" step="0.01" required><br>

        <input type="submit" value="Place Order">
    </form>
</body>
</html>
