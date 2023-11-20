<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
echo "<script>window.location.href = 'adminLogin.php';</script>";
exit;
}
$pageTitle = "Create Product";
$pageDescription = "Panel for Creating Products";
include 'layout/header.php';   ?>



 <div id="loader-overlay">
    <div class="loader"></div>
  </div>

<section class="container create-product">
    <div class="d-flex justify-content-between align-items-center">
    <h1>Add Product</h1>
    <a class="go-back" href="admin"><i class="fa-solid fa-arrow-left"></i> Go back to Products List</a>
   
    </div>
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
                    <select id="category" name="type" class="w-75">
                    
                    </select>
                </div>
            </div>
            <div class=" w-25 ">
                <label for="price">Product Price:</label>
                <div class="price-group" >
                <input type="text" pattern="\d+(\.\d{1,2})?" id="price" name="price" required><span class="dollar">$</span>
                </div>
                
            </div>
            <div class="w-25">
                <label for="per">Quantity (Per pack / Each / etc):</label>
                <input type="text" id="per" name="per">
            </div>
        </div>



        <label for="description">Product Description:</label>
        <textarea id="description" name="description" rows="2" required></textarea>



        <label for="photo">Product Image:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>


        <button class="product-btn" type="submit" name="submit">Create Product</button>
        
    
    </form>
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
        
      data.forEach(c => {
           var option = $('<option>').text(c.name).val(c.name);
            $('#category').append(option);
        });
    })
    .catch(error => {
        console.error('Error fetching product types:', error);
});



// product add
$("#product-form").submit(function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    console.log(formData)
    $.ajax({
        url: "add-product-api.php", // Send to the same file
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(xhr) {
       $('#loader-overlay').show()
         },
        success: function(response) {
            if (response.success) {
                $('#loader-overlay').hide()
                Toastify({
                        text: 'Product Created Successfully!',
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },

                        duration: 1500

                    }).showToast();
                    setTimeout(() => {
                         window.location.href = 'admin';
                    }, 1000);
               
            } else {
                alert('An error occurred while submitting the form.');
            }
        },
        error: function() {
            alert('An error occurred while submitting the form.');
        }
    });
});
</script>