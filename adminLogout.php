<?php 
session_start();

include 'layout/header.php';
session_unset();
session_destroy();
?>
<script src="js/admin.js"></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>
<?php 
echo "<script>window.location.href = 'adminLogin.php';</script>";
        echo "<script>
        Toastify({
                        text: 'Logged Out Successfully!',
                        style: {
                            background: 'green',
                        },

                        duration: 1500

                    }).showToast();
                    </script>";
?><?php
    include 'layout/footer.php';
    ?>