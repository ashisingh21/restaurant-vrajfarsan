<?php
$pagename = "Create Product";
$pageDescription = "Admin for Adding Products";
include 'layout/header.php';   ?>





<section class="container create-product">
    <h1>Add Products</h1>
    <!-- <div class="d-flex justify-content-end">
        <form action="productPanelLogout.php" class="logout">
            <button type="submit" class="pull-right product-btn">Logout</button>
        </form>
    </div> -->

    <form action="" method="POST" id="product-form" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>


        <div class="d-flex">
            <div class="w-50">
                <label for="type">Product Type:</label>
                <div>
                    <select name="type" class="w-75">
                                  <option>Snacks</option>
                        <option>Packaged Snacks</option>
                        <option>Sweets</option>
                        <option>Fix Thali</option>
                        <option>Kathiyawadi Thali</option>
                        <option>Unlimited Thali</option>
                        <option>Weekend Special Breakfast</option>
                        <option>Extras</option>
                        <option>Must Try Items</option>
                 

                    </select>
                </div>
            </div>
            <div class="price-group w-25 ">
                <label for="price">Product Price:</label>
                <input type="text" pattern="\d+(\.\d{1,2})?" id="price" name="price" required>
                <span class="dollar">$</span>
            </div>
            <div class="w-25">
                <label for="per">Quantity (Per pack / Each / etc):</label>
                <input type="text" id="per" name="per">
            </div>
        </div>



        <label for="description">Product Description:</label>
        <textarea id="description" name="description" rows="2" required></textarea>



        <label for="photo">Product Image:</label>
        <input type="file" id="photo" name="photo" accept="image/*">
        <div id="existing-photo-container"></div>

        <button class="product-btn" type="submit" name="submit">Update</button>
    </form>
</section>



<?php include 'layout/footer.php';  ?>
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


// Retrieve the product data from localStorage
const updateProductData = localStorage.getItem('updateProductData');
const preFilledData = JSON.parse(updateProductData);
if (updateProductData) {
    // Parse the JSON string to get the product data object

    // Fill the form fields with the pre-filled data
    document.getElementById('name').value = preFilledData.name || '';
    document.querySelector('select[name="type"]').value = preFilledData.type || '';
    document.getElementById('price').value = preFilledData.price || '';
    document.getElementById('per').value = preFilledData.per || '';
    document.getElementById('description').value = preFilledData.description || '';
    // document.getElementById('photo').value = preFilledData.photo || '';

    // Note: You may need to handle the file input differently for security reasons
    // It's usually not possible to pre-fill a file input for security reasons.

    const existingPhoto = preFilledData.photo;
    if (existingPhoto) {
        const photoContainer = document.getElementById('existing-photo-container');
        const img = document.createElement('img');
        img.src = `img/product-photos/${existingPhoto}`;
        img.alt = 'Existing Product Photo';
        photoContainer.appendChild(img);
    }
    // Remove the stored product data from localStorage to avoid conflicts
    // localStorage.removeItem('updateProductData');
}


// product add
$("#product-form").submit(function(e) {
    e.preventDefault();

   var formData = new FormData(this);

// Check if the file input has a file selected and its size is greater than 0
var photoInput = document.getElementById('photo');
if (!photoInput.files || photoInput.files.length === 0) {
    // If there is no file selected, remove the 'photo' key
    formData.delete('photo');
}

    formData.append('id', preFilledData.id);

    

    $.ajax({
        url: "update-product-api.php", // Send to the same file
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
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

            
            
        },
        error: function() {
            alert('An error occurred while submitting the form.');
        }
    });
});
</script>