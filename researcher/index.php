<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (isset($_POST['signin'])) {
    $uname = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT username,password,id, status FROM researcher WHERE username=:uname and password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $status = $result->status;
            $_SESSION['rsid'] = $result->id;
        }
        if ($status == 0) {
            $msg = "Your account is Inactive. Please contact admin";
        } else {
            $_SESSION['rsLogin'] = $_POST['username'];
            echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
        }
    } else {

        echo "<script>alert('Wrong email or password');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Login | Researcher</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">


    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light py-3" style="background:#546e7a !important">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center align-items-center" id="navbarNavAltMarkup">
            <div class="navbar-nav d-flex justify-content-center align-items-center">
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="../admin/">Admin Login</a>
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="../researcher/">Researcher Login</a>
            </div>
        </div>
    </nav>
    <main class="mn-inner mt-5">
        <div class="row d-flex justify-content-center align-items-center">
            <h4 class="font-weight-bold text-center blue-gray-text text-darken-2">Article Management System</h4>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="card white darken-1">
                            <div class="card-content">
                                <span class="card-title blue-gray-text text-darken-2" style="font-size:20px;">Researcher
                                    Login</span>
                                <?php if ($msg) { ?><div class="errorWrap"><strong>Error</strong> :
                                        <?php echo htmlentities($msg); ?> </div><?php } ?>
                                <div class="row">
                                    <form class="col s12" name="signin" method="post">
                                        <div class="input-field col s12">
                                            <input id="username" type="text" name="username" class="validate" autocomplete="off" required>
                                            <label for="email">Enter Username</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                            <label for="password">Enter Password</label>
                                        </div>

                                        <div class="col col-md-12 center m-t-sm">
                                            <input type="submit" name="signin" value="Login" class=" waves-effect waves-light btn blue-gray darken-4">
                                            <a class="waves-effect waves-grey" href="signUp.php" style="margin-bottom: 10px; margin-left: 10px;">Create new Account</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>


    <!-- Javascripts -->
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    </section>
</body>

</html>