<?php

include 'redirect_to.php';

require_once 'db_connect.php';

$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<!DOCTYPE html>
<html>
<head>
    <title>Stock</title>
    <!-- jsPDF CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <!-- Include jsPDF-AutoTable plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/common-style.css">
    <link rel="stylesheet" href="css/stock-style.css">    
</head>
<body>

    <?php include 'common-section.php'; ?>
    <h2>Add Stock</h2>

    <div class="stock-section">

        <?php include 'alert-file.php'; ?>

        <div class="stock-buttons">
          <button id="product-modal-btn">Select Product</button>
          <button id="clear">Clear</button>
          <a href="dash-stock-list.php" id="stocks-list-a">Back</a>
        </div>

        <form action="_stock_.php" method="post">
          
           
              <table class="stock-products-table" id="stockTable" name="tableData">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Buy In Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="stockTableBody">
                  <!-- Order products rows here -->
                </tbody>
              </table>

              <div class="stock-total">
                    Total Buying Amount: <span id="total-value">RM0.00</span>
                    <input type="hidden" name="stockTotalAmount" id="total-value-2" value="0.00">
                    <button type="submit" name="add_stock" id="create-stock-btn">Buy Stock</button>          
              </div>

        </form>

    </div>

    <!-- Product Modal -->
    <div class="modal" id="product-modal">
        <div class="modal-content">
          <span class="close" id="closeico">&times;</span>
          <h3>Select Product</h3>
          <table class="product-table" id="productTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Picture</th>
                <th>Name</th>
                <th>Category</th>
                <th>Qty Remaining</th>
                <th>Description</th>
              </tr>
            </thead>
            <tbody>
                <?php
                    foreach($results as $row)
                    {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td style='width:75px; height:75px;'><img src='".$row['picture']."' style='width:100%; height:100%;'></td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['quantity']."</td>";
                        echo "<td>".$row['description']."</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
          </table>
    
          <button type="button" class="close-modal-btn" id="close-product">Close</button>

        </div>
    </div>




<script src="js/stock.js"></script>
<script src="js/pagination.js"></script>
<script src="js/close-msg.js"></script>

<script>
  // Call handlePagination() for "productTable"
  handlePagination('productTable', 3);
</script>



</body>

</html>
