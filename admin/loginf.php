<?php
    include "../lib/Session.php";
    Session::init();
    Session::checkLogin();

?>
<?php include "../lib/config.php";?>
<?php include "../lib/Database.php";?>
<?php include "../lib/Helpers.php";?>

<?php 
    $db = new Database();
    $Helpers = new Helpers();
?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen">
</head>

<body>
    <div class="container">
        <section id="content">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $username = $Helpers->validation($_POST['username']);
                    $password = $Helpers->validation(md5($_POST['password']));

                    $username = mysqli_real_escape_string($db->link, $username);
                    $password = mysqli_real_escape_string($db->link, $password);

                    $sql = "SELECT * FROM user_table WHERE username = '$username' AND password = '$password'";
                    $result = $db->readData($sql);
                    if ($result != false){
                        $value = mysqli_fetch_array($result);
                        $row =mysqli_num_rows($result);
                        if ($row > 0) {
                            Session::set('login', true);
                            Session::set('username', $value['username']);
                            Session::set('userId', $value['id']);
                            Session::set('userRole', $value['role']);
                            header('Location: index.php');
                        }
                        else{
                            echo "No result found...!!";
                        }
                    }
                    else{
                        echo "Username Or password not match....!!";
                    }
                }

            ?>
                <form action="login.php" method="post">
                    <h1>Admin Login</h1>
                    <div>
                        <input type="text" placeholder="Username" name="username" />
                    </div>
                    <div>
                        <input type="password" placeholder="Password" name="password" />
                    </div>
                    <div>
                        <input type="submit" value="Log in" name="submit" />
                    </div>
                </form>
                <!-- form -->
                <div class="button">
                    <a href="forgot.php">Forgot Passowrd</a>
                </div>
                <div class="button">
                    <a href="#">zaman-inc.blogspot.com</a>
                </div>
                <!-- button -->
        </section>
        <!-- content -->
    </div>
    <!-- container -->
</body>

</html>