<?php

include 'redirect_to.php';

// Include the db_connect.php file to connect to the database
require_once 'db_connect.php';

// Define an array of table names and corresponding variables
$tables = [
    'product' => 'totalProducts',
    'category' => 'totalCategories',
];

// Fetch data for each table and assign the values to variables
foreach ($tables as $table => $variable) {
    $query = "SELECT COUNT(*) AS total FROM $table";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $$variable = $result['total'];
}

// Close the database connection
$conn = null;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/common-style.css">
    <link rel="stylesheet" href="css/data-style.css">

    <style>
        .analytics-card {
            background-color: #dbcc79; /* Pastel pink for Total Products */
        }

        .analytics-card.categories {
            background-color: #dbcc79; /* Pastel green for Total Categories */
        }

        .analytics-card.customers {
            background-color: #dbcc79; /* Pastel blue for Total Customers */
        }

        .analytics-card.orders {
            background-color: #dbcc79; /* Pastel yellow for Total Orders */
        }
    </style>
</head>

<body>

<?php include 'common-section.php'; ?>

<h2>Dashboard</h2>

<div class="analytics-section">
  <div class="analytics-cards">
    <div class="analytics-card cursor-pointer" onclick="toProduct()">
      <i class="fas fa-cubes"></i>
      <h3>Total Products</h3>
      <span><?php echo $totalProducts; ?></span>
    </div>
    <div class="analytics-card categories cursor-pointer" onclick="toCat()">
      <i class="fas fa-sitemap"></i>
      <h3>Total Categories</h3>
      <span><?php echo $totalCategories; ?></span>
    </div>

    <div class="analytics-card categories cursor-pointer" id="showModalButton1">
      <i class="fas fa-question-circle"></i>
      <h3>Faq Information</h3>
      <span style="font-size: 20px;">View</span>
    </div>

    <div class="analytics-card categories cursor-pointer" id="showModalButton2">
      <i class="fas fa-book"></i>
      <h3>User Manual</h3>
      <span style="font-size: 20px;">View</span>
    </div>

   

    <div id="manualModal" class="modal">
        <div class="overlay"></div>
        <div class="modal-content">
          <span class="close" id="closeModalButton1">&times;</span>
          <h2>Faq</h2>
          <p  style="text-align: left;  margin-bottom: 20px;">
            1. What is an inventory system? <br>
            - An inventory system is a software tool that helps businesses track and manage their products, supplies, and stock levels in an organized manner. <br><br>

            2. What are the key features of your inventory system?<br>
            - Our system manages inventory, manages stock categories, and can buy and update stock at the same time. <br><br>

            3. Can I integrate this system with other software or platforms?<br>
            - We offer integration options with various software and platforms, such as e-commerce and accounting software. <br>
          </p>
        </div>
    </div>

    <div id="faqModal" class="modal">
        <div class="overlay"></div>
        <div class="modal-content">
          <span class="close" id="closeModalButton2">&times;</span>
          <h2>User Manual</h2>
          <p style="text-align: left;  margin-bottom: 20px;">
              <b>Admin </b><br>
            1. The admin logs in with their email and password.  <br>
            2. On the inventory page, the admin can change, remove, or add items. They can also look for specific products. <br>
            3. When the admin changes the quantity, the total price updates automatically. <br>
            4. The admin can handle categories by entering an ID and name. They can add, modify, delete, or view lists of products in each category. <br>
            5. The admin has the ability to oversee staff members. <br>
          </p>
          <p style="text-align: left; margin-bottom: 20px;">
              <b>Staff</b> <br>
            1. The staff log in with their email and password <br>
            2. On the inventory page, the staff can edit the items. They can also look for specific products <br>
            3. The staff can handle categories by entering an ID and name. They can add, modify, delete, or view lists of products in each category. <br>
          </p>
        </div>
    </div>

  </div>
</div>

<script src="js/modal.js"></script>
<script type="text/javascript">
    function toProduct(){
        window.location.href = 'dash-prod.php';
    }
    function toCat(){
        window.location.href = 'dash-catg.php';
    }
</script>


</body>
</html>
