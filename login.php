<?php
session_start();
    include("inc/connect.php");

    if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);


        $query = $conn->prepare("SELECT COUNT(`id`) FROM `users` WHERE `username`= :username AND `password` = :password");
        $query->execute(array('username'=>$username, 'password'=>$password));

        $count = $query->fetchColumn();
        if($count == "1"){
            $_SESSION['login_user'] = $username;
        }else{
            echo"Wrong username or password";
        }
    }
?>
<html>
    <?php
        include("inc/head.php");
    ?>
    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <?php
                include("inc/loginmenu.php");
            ?>
            <div class="mdl-dialog__content"><br/>
                <h4 class="mdl-dialog__title"><img src="img/logo.png">Create account</h4><br/><br/>
                <?php
                    if(!isset($_SESSION['login_user'])){
                ?>
                <form action="" method="post">
                    <div class="mdl-textfield textfieldPadding mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" name="username" required autofocus>
                        <label class="mdl-textfield__label">Username</label>
                    </div>
                    <div class="mdl-textfield textfieldPadding mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="password" name="password" required>
                        <label class="mdl-textfield__label">Password</label>
                    </div>
                    <div class="mdl-dialog__actions">
                        <button type="submit" name="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect">Login</button>
                    </div>
                </form>
                <?php
                    }
                    else{
                        header('Location: main.php');
                    }
             ?>
            </div>
        </div>
    </body>
</html>
