//Product modal
var modal2 = document.getElementById("product-modal");
var selectProductButton = document.querySelector("#product-modal-btn");
var closeProductButton = document.getElementById("close-product");
var closeico = document.getElementById("closeico");
selectProductButton.onclick = function() {
  modal2.style.display = "block";
}
closeProductButton.onclick = function() {
  modal2.style.display = "none";
}
closeico.onclick = function() {
  modal2.style.display = "none";
}



//table

var productTable = document.getElementById('productTable');
var stockTable = document.getElementById('stockTable');

var totalValueSpan = document.getElementById("total-value");
var totalValueInput = document.getElementById("total-value-2");

// Attach a click event listener to the source table
productTable.addEventListener('click', function(event) {
  // Check if a row was clicked
  if (event.target.tagName === 'TD') {
    // Get the selected row
    var selectedRow = event.target.parentNode;
    
    // Get the data from the cells of the selected row
    var productId = selectedRow.cells[0].textContent;
    var productImg = selectedRow.cells[1].querySelector('img');



    var productName = selectedRow.cells[2].textContent;
    var quantity = 1;
    var price = selectedRow.cells[5].textContent;
    // Parse the price as a number (assuming it's a valid numeric value)
    var numericPrice = parseFloat(price);
    // Calculate the total amount
    var totalAmount = quantity * 1;

    // Check if the product is already added to the stock table
    var isProductAdded = false;
    var stockRows = stockTable.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    for (var i = 0; i < stockRows.length; i++) {
      var row = stockRows[i];
      var productNameInOrder = row.cells[0].querySelector("input").value;

      if (productNameInOrder === productId) {
        isProductAdded = true;
        break;
      }
    }

    if (isProductAdded) {
      // Product already added, display a message or perform any other action
      alert("Product is already added to the stock table.");
      return;
    }

    // Create a new row in the target table
    var newRow = stockTable.getElementsByTagName("tbody")[0].insertRow();
    
    // Create cells for the new row
    var productIdCell = newRow.insertCell();
    var productImageCell = newRow.insertCell();
    var productNameCell = newRow.insertCell();
    var quantityCell = newRow.insertCell();
    var priceCell = newRow.insertCell();
    var totalAmountCell = newRow.insertCell();
    var removeRowCell = newRow.insertCell();
    
    // Set the values in the new row cells
    productIdCell.innerHTML = '<input type="text" name="id[]" value="'+productId+'" readonly>';
    var newImg = document.createElement('img');
    newImg.width = 100;
    newImg.src = productImg.src; // Set the source from the selected row's image
    productImageCell.appendChild(newImg);

    productNameCell.innerHTML = '<input type="text" name="name[]" value="'+productName+'" readonly>';
    quantityCell.innerHTML = `
      <div class="quantity-container">
        <div class="quantity-buttons">
          <button type="button" class="minus-button">-</button>
          <button type="button" class="plus-button">+</button>
        </div>
        <input name="quantity[]" class="quantity" type="number" value="${quantity}" readonly>
      </div>
    `;
    // priceCell.innerHTML = '<input type="number" name="price[]" value="'+numericPrice+'" step="0.01" readonly>';
    priceCell.innerHTML = '<input type="number" name="price[]" value="1" step="0.01" class="inputprice">';
    totalAmountCell.innerHTML = '<input type="number" name="totalAmount[]" value="'+parseFloat(totalAmount).toFixed(2)+'" step="0.01" readonly>';
    removeRowCell.innerHTML = "<button class='remove-btn'>Remove</button>";

    // update the total stock value
    updateTotalOrderValue();

    // Update quantity when plus or minus buttons are clicked
    var plusButtons = newRow.querySelectorAll(".plus-button");
    var minusButtons = newRow.querySelectorAll(".minus-button");

    var priceInput = newRow.querySelectorAll(".inputprice");
    priceInput.forEach(function(pInput) {
      pInput.addEventListener('keyup', function() {
        updateValue();
      });
    });
    plusButtons.forEach(function(plusBtn) {
      plusBtn.addEventListener('click', function() {
        quantity++;
        updateQuantity();
      });
    });

    minusButtons.forEach(function(minusBtn) {
      minusBtn.addEventListener('click', function() {
        if (quantity > 1) {
          quantity--;
          updateQuantity();
        }
      });
    });

    function updateValue(){

       // Update the quantity cell content
      var quantityInput = newRow.querySelector(".quantity");
      var priceInput = newRow.querySelector(".inputprice");

      if(priceInput.value == ''){
          price = 0;
      }else{
          price =  priceInput.value;
      }

      // // Calculate the total amount
      totalAmount = quantityInput.value * price;

      // // Display the total amount
      totalAmountCell.innerHTML = '<input type="number" name="totalAmount[]" value="'+totalAmount.toFixed(2)+'" step="0.01">'

      updateTotalOrderValue();


    }

    // Function to update the quantity cell
    function updateQuantity() {
      // Update the quantity cell content
      var quantityInput = newRow.querySelector(".quantity");
      var priceInput = newRow.querySelector(".inputprice");

      quantityInput.value = quantity; 

      // // Calculate the total amount
      totalAmount = quantity * priceInput.value;

      // // Display the total amount
      totalAmountCell.innerHTML = '<input type="number" name="totalAmount[]" value="'+totalAmount.toFixed(2)+'" step="0.01">'

      updateTotalOrderValue();
    }
  }
});


// Attach a click event listener to the stock table for the remove button
stockTable.addEventListener('click', function(event) {
  if (event.target.classList.contains('remove-btn')) {
    // Get the parent row and remove it from the stock table
    var selectedRow = event.target.parentNode.parentNode;
    stockTable.deleteRow(selectedRow.rowIndex);
    
    // Update the total stock value
    updateTotalOrderValue();
  }
});

// Get the button element
var clearButton = document.getElementById('clear');
var totalValueSpan = document.getElementById("total-value");
var totalValueInput = document.getElementById("total-value-2");
var customerIdInput = document.getElementById("customerIdInput");
var customerId = document.getElementById("customerId");
var customerName = document.getElementById("customerName");
// Select the table rows and remove them
var tableBody = document.getElementById('stockTableBody');
// Add click event listener to the clear button
clearButton.addEventListener('click', function() {
  // Clear the table body by setting innerHTML to an empty string
  tableBody.innerHTML = '';
  totalValueSpan.textContent = "$0.00";
  totalValueInput.value = "0.00";
  customerIdInput.value = "00";
  customerId.textContent = "00";
  customerName.textContent = "### ###";
});


// Function to update the total stock value
function updateTotalOrderValue() {
  var stockRows = stockTable.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
  var stockTotal = 0;

  for (var i = 0; i < stockRows.length; i++) {
    var row = stockRows[i];
    var inputValue = parseFloat(row.cells[5].querySelector("input").value);
    console.log(inputValue);

   if (!isNaN(inputValue)) {
      stockTotal += inputValue;
    }
  }

  totalValueSpan.textContent ="RM" + stockTotal.toFixed(2);
  totalValueInput.value = stockTotal.toFixed(2); 
}
