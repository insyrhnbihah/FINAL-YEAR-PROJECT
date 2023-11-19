<?php

// Include the necessary files
include 'redirect_to.php'; // Redirect helper function
require_once 'db_connect.php'; // Database connection
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Retrieve all orders with customer information
$sql = "SELECT stock.stock_id AS stockId, user.id, user.fullname, user.email, user.user_role, stock.total_amount AS stock_total, stock.buy_date
        FROM stock
        INNER JOIN user ON stock.user_id = user.id
        INNER JOIN stock_details ON stock.stock_id = stock_details.stock_id
        GROUP BY stock.stock_id  ORDER by stock.stock_id desc"; 

$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the search dates
    $startDate = $_POST['start-date'];
    $endDate = $_POST['end-date'];


    // Prepare the SQL query
    $sql = "SELECT stock.stock_id AS stockId, user.id, user.fullname, user.email, user.user_role, stock.total_amount AS stock_total, stock.buy_date 
        FROM stock
        INNER JOIN user ON stock.user_id = user.id
        INNER JOIN stock_details ON stock.stock_id = stock_details.stock_id ";

    // Check if dates are provided
    if ($startDate && $endDate) {
       
        $sql .= " WHERE";
        $sql .= " stock.buy_date BETWEEN :start_date AND :end_date";
    }

    $sql .= " GROUP BY stock.stock_id desc";

    // Execute the query with the provided start and end dates
    $stmt = $conn->prepare($sql);
 
    if ($startDate && $endDate) {
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
    }
    $stmt->execute();

    // Fetch the results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>



<!DOCTYPE html>
<html>
<head>
    <title>Stock List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/common-style.css">
    <link rel="stylesheet" href="css/print-stock-style.css">
</head>

<body>

<?php include 'common-section.php'; ?>

<div class="stocktop">
  <h2>Stock List</h2>
  <a type="button" href="dash-stock.php" class="btn-addstock">Add Stock</a>
</div>
<hr>


<div class="stock-section">

    <form action="dash-stock-list.php" method="post" class="search-form">
        <div class="stock-buttons">
            <div id="search-box">
                <label for="start-date">Start Date:</label>
                <input type="date" name="start-date" id="start-date">
                <label for="end-date">End Date:</label>
                <input type="date" name="end-date" id="end-date">
                <button id="search-button" name="search-button">Search</button>
            </div>
        </div>
    </form>


    <table class="stock-products-table" id="stockTable" name="tableData">
      <thead>
        <tr>
          <th>Stock ID</th>
          <th>Added By User</th>
          <th>Total Amount</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Order rows here -->
        <?php
        // Generate table rows
        foreach ($results as $row) {
            echo "<tr>";
            echo "<td>".$row['stockId']."</td>";
            echo "<td>User Id: ".$row['id']."<br> Email: ".$row['email']." <br> Fullname: ".$row['fullname']."</td>";
            echo "<td>RM". $row['stock_total']."</td>";
            echo "<td>".$row['buy_date']."</td>";
            echo "<td><button class='details-btn generate-btn' data-stock-id='".$row['stockId']."'  data-total='".$row['stock_total']."' data-user-id='" . $row['id'] . "' data-buy-date='" . $row['buy_date'] ."'>View Details</button></td>";
            echo "</tr>";
        }
        ?>

        </tbody>
      </table>

      <h3 style="margin-top:20px; margin-bottom: 20px;">Stock ID: <span id="stockid"></span> | Total Amount: RM <span id="stockamount">0</span> | Buy Date:  <span id="stockdate"></span></h3>
      <hr>

      <table id="stockDetailsTable">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Quantity x Price</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <span id="stock-total-value"></span>

      <button id="generate-invoice">Generate Invoice</button>

      <script>

    // Get the button element
    var generateInvoiceButton = document.getElementById('generate-invoice');

// Add a click event listener to the button
generateInvoiceButton.addEventListener('click', function() {
  // Get the table element
  var orderTable = document.getElementById('stockTable');
  var orderDetailsTable = document.getElementById('stockDetailsTable');

  // Define the rows for the table
  var rows = [];

// Iterate through the table rows and extract the data
  var tableRows = orderDetailsTable.getElementsByTagName('tr');
  for (var i = 1; i < tableRows.length; i++) {
    var row = tableRows[i];
    var rowData = [];

    for (var j = 0; j < row.cells.length; j++) {
      rowData.push(row.cells[j].textContent);
    }

    rows.push(rowData);
  } 


  // Get the order details
  var stockid = document.getElementById('stockid').textContent;
  var stockamount = document.getElementById('stockamount').textContent;
  var stockdate = document.getElementById('stockdate').textContent;


  var url = "invoice.php" + "?stockId=" + encodeURIComponent(stockid) + "&stockDate=" + encodeURIComponent(stockdate) +  "&stockAmount=" + encodeURIComponent(stockamount) + "&rows=" + encodeURIComponent(JSON.stringify(rows));

  window.location.href = url;

});


</script>

<script>
  // Function to fetch and display order details
  function fetchStockDetails(stockID) {
    // Create an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "fetch_stock_details.php?stock_id=" + stockID, true);

    // Set the response type to JSON
    xhr.responseType = "json";

    // Handle the AJAX response
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Request was successful
          var stockDetails = xhr.response;
          displayStockDetails(stockDetails);
        } else {
          // Request failed
          console.log("Error: " + xhr.status);
        }
      }
    };

    // Send the AJAX request
    xhr.send();
  }

  // Function to display order details in an HTML table
  function displayStockDetails(stockDetails) {
    // Get the table element
    var table = document.getElementById("stockDetailsTable");

    // Clear the table body
    table.tBodies[0].innerHTML = "";

    // Loop through the order details and generate table rows
    for (var i = 0; i < stockDetails.length; i++) {
        var row = table.tBodies[0].insertRow();
      row.insertCell().textContent = stockDetails[i].product_id;
      row.insertCell().innerHTML = `<img src="${stockDetails[i].picture}" width="80"/>`;
      row.insertCell().textContent = stockDetails[i].name;
      row.insertCell().textContent = stockDetails[i].quantity;
      row.insertCell().textContent = "RM"+stockDetails[i].price;
      row.insertCell().textContent = "RM"+stockDetails[i].price_x_quantity;
    }

  }

  // Attach a click event listener to the parent element of the "View Details" buttons
  var table = document.querySelector("table");
  table.addEventListener("click", function(event) {
    if (event.target.classList.contains("details-btn")) {
      event.preventDefault();

      var stockID = event.target.dataset.stockId;
      var userId = event.target.dataset.userId;
      var total = event.target.dataset.total;
      var buyDate = event.target.dataset.buyDate;
      fetchStockDetails(stockID);
      var stockid = document.getElementById("stockid");
      var stockamount = document.getElementById("stockamount");
      var stockdate = document.getElementById("stockdate");
      stockid.textContent = stockID;
      stockamount.textContent = total;
      stockdate.textContent = buyDate;

      // Scroll to the products table
      document.querySelector('#stockDetailsTable').scrollIntoView({
        behavior: 'smooth'
      });

    }
  });
</script>





<script src="js/pagination.js"></script>

<script>
  handlePagination('stockTable', 5);
</script>




<script src="js/close-msg.js"></script>






</body>
</html>
