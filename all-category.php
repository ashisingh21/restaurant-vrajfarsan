<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
echo "<script>window.location.href = 'adminLogin.php';</script>";
exit;
}
$pageTitle = "All Category";
$pageDescription = "Category";
include 'layout/header.php';   ?>



 <div id="loader-overlay">
    <div class="loader"></div>
  </div>

 <section style="min-height:70vh;" class="container create-category">
    <div id="pjax-container" class="action container-fluid">

    <div class="row">
        <div class="head col-md-12 d-flex justify-content-between align-items-center">
            <h2>Category List</h2>
            
            <div><a class="product-btn" href="admin-category-create"><i class="fa-solid fa-plus"></i> New Category</a>
            <a class="product-btn" href="admin"><i class="fa-solid fa-list"></i> All Products</a></div>
        </div>

      
      
        <div class="col-md-12" style="overflow:auto;">

           <table class="view-product view-category" border="1">
            <thead>
                <tr>
                    <th>S. No</th>
                    <th>Name</th>
                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
           </table>
        </div>
    </div>
</div>
  

</section>



<?php include 'layout/footer.php';  ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="js/admin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
    integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
var metaTag = document.createElement('meta');

// Set attributes for the meta element
metaTag.setAttribute('name', 'robots');
metaTag.setAttribute('content', 'noindex');

document.head.appendChild(metaTag);




var bootstrapLink = document.createElement('link');

// Set attributes for the link element
bootstrapLink.setAttribute('rel', 'stylesheet');
bootstrapLink.setAttribute('href', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css');
bootstrapLink.setAttribute('integrity', 'sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm');
bootstrapLink.setAttribute('crossorigin', 'anonymous');

// Append the link element to the head of the document
document.head.appendChild(bootstrapLink);

var toasterLink = document.createElement('link');

// Set attributes for the link element
toasterLink.setAttribute('rel', 'stylesheet');
toasterLink.setAttribute('href', 'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css');


// Append the link element to the head of the document
document.head.appendChild(toasterLink);

fetch('all-category-api.php')
    .then(response => response.json())
    .then(data => {
        
        renderCategory(data);
    })
    .catch(error => {
        console.error('Error fetching product types:', error);
});

function renderCategoryRow(item, serialNumber) {
    const row = document.createElement('tr');

    const columnOrder = ['sr', 'name'];

  
    // Iterate over each property in the item and create a table data (td) for each
    columnOrder.forEach(key => {
        const cell = document.createElement('td');

          if (key === 'sr') {
            cell.textContent = serialNumber;} else{
        cell.textContent = item[key] || '';
}
        // Append the cell to the row
        row.appendChild(cell);
    });

    const actionsCell = document.createElement('td');
    actionsCell.innerHTML = `
        <button class="action-btn update-btn" data-id="${item.id}"><i class="fas fa-edit"></i> Update</button>
        <button class="action-btn delete-btn" data-id="${item.id}"><i class="fa-regular fa-trash-can"></i> Delete</button>
    `;

    row.appendChild(actionsCell);


      function getCategoryById(id) {
                    // Make an API call or fetch the data from wherever it is stored
                    // Return the category details as an object
                    // Modify this based on your actual data structure
                    return {
                        id: item.id,
                        name: item.name,    
                  
                    };
                }

    // Add click event listener to the delete button
    actionsCell.querySelector('.delete-btn').addEventListener('click', () => {
        deleteCategory(item.id);
    });

    // Add click event listener to the delete button
    actionsCell.querySelector('.update-btn').addEventListener('click', () => {
        const categoryToUpdate = getCategoryById(item.id);
        // Store the category data in localStorage
        localStorage.setItem('updatecategoryData', JSON.stringify(categoryToUpdate));
        // Redirect to the Create category page
        window.location.href = 'admin-category-update';
    });

    // Append the row to the table
    return row;
}




function renderCategory(data) {
    const tableBody = document.querySelector('.view-category tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    let serialNumber = 1;

    data.forEach(item => {
        const row = renderCategoryRow(item, serialNumber);
        tableBody.appendChild(row);
        serialNumber++;
    });
}

function deleteCategory(id) {
    $.ajax({
        url: 'delete-category-api.php',
        type: 'DELETE',
        contentType: 'application/json',
        data: JSON.stringify({
            id: id
        }),
        success: function(data) {



            Toastify({
                text: `${data.message}`,
                className: "info",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                }
            }).showToast();

            setTimeout(() => {
                window.location.href = "all-category"
            }, 1000);

            // You can update the UI or perform other actions based on the response
        },
        error: function(error) {
            console.error('Error deleting category:', error);
        }
    })
}


function updateCategory(id) {
    $.ajax({
        url: 'update-category-api.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            id: id
        }),
        success: function(data) {
          Toastify({
                text: `${data.message}`,
                className: "info",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                }
            }).showToast();

            setTimeout(() => {
                window.location.href = "all-category"
            }, 1000);

            // You can update the UI or perform other actions based on the response
        },
        error: function(error) {
            console.error('Error deleting category:', error);
        }
    })
}

</script>