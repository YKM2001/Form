<?php
    require_once('db.php');



    if(isset($_POST['Registration'])) {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password = md5($password);
        $date = $_POST['date'];
        // ? получаем файл через глобальную переменную
        $file = $_FILES['img'];
        // ? отправляем в нашу папку с названием картинки и случайным временем
        $path = "images/" .time() .basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'],$path);

        $sqlTestEmail = mysqli_query($con, "SELECT * FROM `users` WHERE `email` = '$email'");

        if(mysqli_num_rows($sqlTestEmail) > 0) {
            echo ' Пользователь с такой почтой уже зарегистрирован !';
        } else {
            $sql = mysqli_query($con, "INSERT INTO `users`(`id`, `name`, `password`, `email`, `date`, `logo`) VALUES (NULL,'$name','$password','$email','$date','$path')");
            setcookie('user', $name);
            $new_user = $_COOKIE['user'];
        }
    }

    if(isset($_POST['Auth'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $password = md5($password);

        $sql = mysqli_query($con, "SELECT * FROM users WHERE name = '$name' AND password = '$password'");

        if(mysqli_num_rows($sql) > 0) {
            setcookie('user', $name);
            $new_user = $_COOKIE['user'];
        } else {
            echo 'Неккоректно!';
        }
    }

    if(isset($_GET['logout'])) {
        unset($_COOKIE['user']);
        // header('location: index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    

    <?php
    if($_COOKIE['user']) {
        $user_again = $_COOKIE['user'];
        $sql = mysqli_query($con, "SELECT * FROM users WHERE name = '$user_again'");
        while($row = mysqli_fetch_assoc($sql)) {
            echo '
            <div>'.$row['name'].'</div>
            <div>'.$row['email'].'</div>
            <div>'.$row['date'].'</div>
            <img src="./'.$row['logo'].'">
            <a href="index.php?logout">Logout</a>
            ';
        }
    } else {
        echo '
        <div class="wrapper">

            <div class="tab">

                <div class="tab-controllers">
                    <div class="tab-controller">Регистрация</div>
                    <div class="tab-controller">Авторизация</div>    
                </div>

                <div class="tab-content active">
                    <form action="index.php" method="post" enctype="multipart/form-data" class="form">
                        <label>
                            <input type="email" name="email" class="email" required placeholder="Email">
                        </label>

                        <label>
                            <input type="text" name="name" class="name" required placeholder="Name">
                        </label>

                            <input type="date" name="date" class="date" required placeholder="Date">

                        <label>
                            <input type="password" name="password" class="password" required placeholder="Password">
                        </label>

                        <label>
                            <input type="password" name="password_confirm" class="password_confirm" required placeholder="Password confirm">
                        </label>

                        <label>
                            <input type="file" name="img" id="file" required>
                        </label>
                        <img src="" alt="your future logo..." id="myimg">

                        <label>
                            <input type="submit" value="Зарегистрироваться" name="Registration" class="Submit reg">
                        </label>
                    </form>
                </div>

                <div class="tab-content">
                    <form action="index.php" method="post" enctype="multipart/form-data" class="form">
                        <label>
                            <input type="text" name="name" class="name" placeholder="Name" required>
                        </label>

                        <label>
                            <input type="password" name="password" class="password" placeholder="Password" required> 
                        </label>

                        <input type="submit" value="Войти" name="Auth" class="Submit auth">
                    </form>
                </div>
                
            </div>
                
        </div>
        ';
    }
    ?>







    <script src="script.js"></script>
</body>
</html>