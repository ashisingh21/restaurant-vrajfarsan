<?php 

session_start();
$pageTitle ="Login | Lead Panel VrajFarsan";
        $pageDescription ="Login";
    include 'layout/header.php';?>
 <div id="loader-overlay">
    <div class="loader"></div>
  </div>
<div class="login-wrapper">

    <h1 class='mb-20 text-primary'>Login</h1>

    <form action='adminLogin.php' method='POST'>
        <div class="row">
            <label for="email">Username</label>
            <input type="text" name="username" required>
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" name="submit">Login</button>
    </form>


</div>

<style>
.login-wrapper {
    min-height: 80vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

h1.text-primary {
    margin-top: 48px;
    font-size:60px;
    color: var(--brand-primary-color);
}

form {
    background: #fff;
    max-width: 360px;
    width: 100%;
    padding: 58px 44px;
    border: 1px solid #e1e2f0;
    border-radius:
        4px;
    box-shadow: 0 0 5px 0 rgba(42, 45, 48, 0.12);
    transition: all 0.3s ease;
}

.row {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.row label {
    font-size: 13px;
    color: #8086a9;
}

.row input {
    flex: 1;
    padding: 13px;
    border: 1px solid #d6d8e6;
    border-radius: 4px;
    font-size: 16px;
    transition: all 0.2s ease-out;
}

.row input:focus {
    outline: none;
    box-shadow: inset 2px 2px 5px 0 rgba(42, 45, 48, 0.12);
}

.row input::placeholder {
    color: #C8CDDF;
}

button {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    background:
        var(--brand-secondary-color);
    color: #fff;
    border: none;
    border-radius: 100px;
    cursor: pointer;
    font-family: 'Raleway',
        sans-serif;
    margin-top: 15px;
}

button:hover {
    background: var(--brand-primary-color);
       color: #000;
}

@media(max-width: 600px) {

.topnav .btn-secondary{
    display:none;
}
    form {
        background: #f9faff;
        border: none;
        box-shadow: none;
        padding: 20px 0;
    }
}
</style>
<script src="js/admin.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    var toasterLink = document.createElement('link');

// Set attributes for the link element
toasterLink.setAttribute('rel', 'stylesheet');
toasterLink.setAttribute('href', 'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css');


// Append the link element to the head of the document
document.head.appendChild(toasterLink);
</script>
<?php
$login = false;
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
    $servername = "localhost";
    $username = $authdatabasename_username;
    $password = $authdatabasename_password;
    $dbname = $authdatabasename;   

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM $authdatabasename_table WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $num = $result->num_rows;

    if ($num == 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;

        echo "<script>window.location.href = 'admin.php';</script>";
        echo "<script>
     Toastify({
                        text: 'Wohoo! Successfully logged in!',
                        style: {
                            background: 'green',
                        },

                        duration: 1500

                    }).showToast();
                    
                    </script>";
        
    } else {
        echo "<script>
        Toastify({
                        text: 'Oops! Invalid Credentials!',
                        style: {
                            background: 'red',
                        },

                        duration: 1500

                    }).showToast();
        </script>";
        
    }

    $stmt->close();
    $conn->close();
    }
}


include 'layout/footer.php';  ?>