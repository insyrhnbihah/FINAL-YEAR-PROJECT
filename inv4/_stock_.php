<?php

// Include the db_connect.php file to connect to the database
require_once 'db_connect.php';

// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve the table data from the form
    if(isset($_POST['id'])){

            $ids = $_POST['id'];
            $names = $_POST['name'];
            $quantities = $_POST['quantity'];
            $prices = $_POST['price'];
            $totalAmounts = $_POST['totalAmount'];
            $orderTotalAmount = $_POST['stockTotalAmount'];

            // Start a transaction
            $conn->beginTransaction();


    try {
        // Insert the order into the "orders" table
        $stockData = [
            'user_id' => $_SESSION['loginid'],
            'total_amount' => $orderTotalAmount
        ];
        $stockInsertStmt = $conn->prepare("INSERT INTO `stock`(`user_id`, `buy_date`, `total_amount`) VALUES (:user_id, NOW(), :total_amount)");
        $stockInsertStmt->execute($stockData);

        // Retrieve the last inserted order ID
        $stockId = $conn->lastInsertId();

        // Insert the order details into the "order_details" table
        // Process the table data
        $rowCount = count($ids);
        for ($i = 0; $i < $rowCount; $i++) {
            $productId = $ids[$i];
            $name = $names[$i];
            $quantity = $quantities[$i];
            $price = $prices[$i];
            $totalAmount = $totalAmounts[$i];

            // Check if the product quantity in the order is valid
            $checkQuantityStmt = $conn->prepare("SELECT `quantity` FROM `product` WHERE `id` = :product_id");
            $checkQuantityStmt->bindParam(':product_id', $productId);
            $checkQuantityStmt->execute();
            $product = $checkQuantityStmt->fetch(PDO::FETCH_ASSOC);

            if ($product && $product['quantity'] >= $quantity) {
                $stockDetailData = [
                    'stock_id' => $stockId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'price_x_quantity' => $totalAmount
                ];

                $stockDetailInsertStmt = $conn->prepare("INSERT INTO `stock_details`(`stock_id`, `product_id`, `quantity`, `price`, `price_x_quantity`) VALUES (:stock_id, :product_id, :quantity, :price, :price_x_quantity)");
                $stockDetailInsertStmt->execute($stockDetailData);

                // Update the product quantity
                $updateProductQuantityStmt = $conn->prepare("UPDATE `product` SET `quantity` = `quantity` + :quantity WHERE `id` = :product_id");
                $updateProductQuantityStmt->bindParam(':quantity', $quantity);
                $updateProductQuantityStmt->bindParam(':product_id', $productId);
                $updateProductQuantityStmt->execute();
            } else {
                // Rollback the transaction if the product quantity is not valid
                $conn->rollBack();

                // Display an error message
                $_SESSION['error'] = "Invalid product quantity for product with ID: $productId";
                header('Location: dash-stock.php');
                exit();
            }
        }

        // Commit the transaction if all queries succeed
        $conn->commit();

        // Success message or further processing
        $_SESSION['success'] = "Stock updated successfully!";
        header('Location: dash-stock.php');
        exit();
    } catch (PDOException $e) {
        // Rollback the transaction if any query fails
        $conn->rollBack();

        // Error handling
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header('Location: dash-stock.php');
        exit();
    }
}
    else{
        $_SESSION['error'] = "You need to select products";
        header('Location: dash-stock.php');
    }

    header('Location: dash-stock.php');

}

?>
