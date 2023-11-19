<?php

require_once 'db_connect.php';

$stockID = $_GET['stock_id']; 

try {
    // Prepare the SQL statement to retrieve order details based on the order ID
    $stmt = $conn->prepare("SELECT product_id, name, stock_details.quantity, stock_details.price, price_x_quantity, product.picture
                            FROM stock_details 
                            INNER JOIN product 
                            ON stock_details.product_id = product.id 
                            WHERE stock_id = :stockID");

    $stmt->bindParam(':stockID', $stockID, PDO::PARAM_INT); // Bind the order ID parameter to the prepared statement

    $stmt->execute(); // Execute the SQL statement

    $storeDetails = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all the resulting rows as an associative array

    $stockDetailsJSON = json_encode($storeDetails); // Encode the order details array as JSON

    echo $stockDetailsJSON; // Output the JSON response

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); // Display an error message if an exception occurs during the database operation
}

?>
