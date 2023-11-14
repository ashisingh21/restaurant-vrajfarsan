<?php
$pagename = "Admin";
$pageDescription = "Admin for Adding Products";
include 'layout/header.php';   ?>



<div id="pjax-container" class="action container-fluid">

    <div class="row">


        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h2>Product List</h2>
            <div><a class="product-btn" href="admin-product-create">Create Product</a></div>
        </div>

        <div id="type-buttons-container">
         
        </div>


        <table class="view-product" border="1">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Product Name</th>
                    <th>Product Type</th>
                    <th>Product Price</th>
                    <th>Quantity (Per Pack)</th>
                    <th>Product Description</th>

                    <th>Product Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>

</div>

<?php include 'layout/footer.php';  ?>
<script src="https://cdn.jsdelivr.net/npm/jquery.pjax.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js">
</script>
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


// api call to fetch products



fetch('all-products-api.php')
    .then(response => response.json())
    .then(data => {
        const uniqueTypes = ["All Products",...new Set(data.map(product => product.type))];
        const typeButtonsContainer = document.getElementById('type-buttons-container');
   

         typeButtonsContainer.innerHTML = '';

        // Create buttons for each product type
        uniqueTypes.forEach(type => {
            const button = document.createElement('button');
            button.textContent = type;
            button.addEventListener('click', () => filterProductsByType(type));
            typeButtonsContainer.appendChild(button);
        });

        // Initial rendering of all products
        renderProducts(data);
    })
    .catch(error => {
        console.error('Error fetching product types:', error);
});


function renderProductRow(item, serialNumber) {
    const row = document.createElement('tr');

    const columnOrder = ['sr', 'name', 'type', 'price', 'per', 'description', 'photo'];

    // Iterate over each property in the item and create a table data (td) for each
    columnOrder.forEach(key => {
        const cell = document.createElement('td');

        if (key === 'sr') {
            cell.textContent = serialNumber;
        } else if (key === 'photo') {
            const img = document.createElement('img');
            img.src = `img/product-photos/${item[key]}` || '';
            img.alt = 'Product Photo';
            cell.appendChild(img);
        } else if (key === 'price') {
             const div = document.createElement('div');
        
        // Add a dollar sign to the div
        const dollarSign = document.createTextNode('$ ');
        div.appendChild(dollarSign);

        // Create a text node for the price and append it to the div
        const priceText = document.createTextNode(item[key] || '');
        div.appendChild(priceText);

        // Append the div to the cell
        cell.appendChild(div);
        }
        else {
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


      function getProductById(id) {
                    // Make an API call or fetch the data from wherever it is stored
                    // Return the product details as an object
                    // Modify this based on your actual data structure
                    return {
                        id: item.id,
                        name: item.name,
                        type: item.type,
                        price: item.price,
                        per: item.per,
                        description: item.description,
                        photo: item.photo,
                    };
                }

    // Add click event listener to the delete button
    actionsCell.querySelector('.delete-btn').addEventListener('click', () => {
        deleteProduct(item.id);
    });

    // Add click event listener to the delete button
    actionsCell.querySelector('.update-btn').addEventListener('click', () => {
        const productToUpdate = getProductById(item.id);
        // Store the product data in localStorage
        localStorage.setItem('updateProductData', JSON.stringify(productToUpdate));
        // Redirect to the Create Product page
        window.location.href = 'admin-product-update';
    });

    // Append the row to the table
    return row;
}


function filterProductsByType(selectedType) {
    fetch('all-products-api.php')
        .then(response => response.json())
        .then(data => {
            if(selectedType == "All Products"){
                renderProducts(data);
            } else {
        const filteredProducts = data.filter(product => product.type === selectedType);
            renderProducts(filteredProducts);
            }
    
        })
        .catch(error => {
            console.error('Error fetching filtered products:', error);
        });
}

function renderProducts(data) {
    const tableBody = document.querySelector('.view-product tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    let serialNumber = 1;

    data.forEach(item => {
        const row = renderProductRow(item, serialNumber);
        tableBody.appendChild(row);
        serialNumber++;
    });
}

function deleteProduct(id) {
    $.ajax({
        url: 'delete-product-api.php',
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
                window.location.href = "admin"
            }, 1000);

            // You can update the UI or perform other actions based on the response
        },
        error: function(error) {
            console.error('Error deleting product:', error);
        }
    })
}


function updateProduct(id) {
    $.ajax({
        url: 'update-product-api.php',
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
                window.location.href = "admin"
            }, 1000);

            // You can update the UI or perform other actions based on the response
        },
        error: function(error) {
            console.error('Error deleting product:', error);
        }
    })
}
</script>