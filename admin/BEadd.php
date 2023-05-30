<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location: index.php');
} else {
    if (isset($_POST['addBE'])) {
        $fName = $_POST['fullname'];
        $uName = $_POST['username'];
        $password = md5($_POST['password']);
        $email = $_POST['email'];
        $field = $_POST['field'];
        $aRank = $_POST['academicrank'];
        $pNumber = $_POST['phonenumber'];
        $status = 1;

        $sql = "INSERT INTO boardeditor(fullname, username, password, email, field, academicrank, phonenumber, status) VALUES(:fName, :uName, :password, :email, :field, :aRank, :pNumber, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fName', $fName, PDO::PARAM_STR);
        $query->bindParam(':uName', $uName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':field', $field, PDO::PARAM_STR);
        $query->bindParam(':aRank', $aRank, PDO::PARAM_STR);
        $query->bindParam(':pNumber', $pNumber, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "New Board Editor added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Admin | Add Account</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <style>
    .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }
    </style>
    <script type="text/javascript">
    function valid() {
        if (document.addBE.password.value != document.addBE.confirmpassword.value) {
            alert("New Password and Confirm Password Field do not match  !!");
            document.addBE.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>

    <script>
    function BEcheckAvailabilityUName() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "BEcheck_availability.php",
            data: 'username=' + $("#username").val(),
            type: "POST",
            success: function(data) {
                $("#uName-availability").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>

    <script>
    function BEcheckAvailabilityEmailid() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "BEcheck_availability.php",
            data: 'email=' + $("#email").val(),
            type: "POST",
            success: function(data) {
                $("#email-availability").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>



</head>

<body>
    <?php include('includes/header.php'); ?>

    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title blue-gray-text text-darken-2">REGISTER FOR BOARD EDITOR </div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addBE">
                            <div>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php if ($error) { ?><div class="errorWrap">
                                                        <strong>ERROR</strong>:<?php echo htmlentities($error); ?>
                                                    </div><?php } else if ($msg) { ?><div class="succWrap">
                                                        <strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?>
                                                    </div><?php } ?>


                                                    <div class="input-field col  s12">
                                                        <label for="fullname">Full Name</label>
                                                        <input name="fullname" id="fullname" type="text"
                                                            autocomplete="off" required>
                                                    </div>


                                                    <div class="input-field col m6 s12">
                                                        <label for="username">User Name</label>
                                                        <input id="username" name="username"
                                                            onBlur="BEcheckAvailabilityUName()" type="text"
                                                            autocomplete="off" required>
                                                        <span id="uName-availability" style="font-size:12px;"></span>
                                                    </div>


                                                    <div class="input-field col s12">
                                                        <label for="email">Email</label>
                                                        <input name="email" type="email" id="email"
                                                            onBlur="BEcheckAvailabilityEmailid()" autocomplete="off"
                                                            required>
                                                        <span id="email-availability" style="font-size:12px;"></span>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="password">Password</label>
                                                        <input id="password" name="password" type="password"
                                                            autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="confirm">Confirm password</label>
                                                        <input id="confirm" name="confirmpassword" type="password"
                                                            autocomplete="off" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col m6">
                                                <div class="row">
                                                    <div class="input-field col m6 s12">
                                                        <select name="field" autocomplete="off">
                                                            <option value="">Field...</option>
                                                            <option value="Sport">Sport</option>
                                                            <option value="Science">Science</option>
                                                            <option value="History">History</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <select name="academicrank" autocomplete="off">
                                                            <option value="">Title...</option>
                                                            <option value="PhD">PhD</option>
                                                            <option value="Dr">Dr</option>
                                                            <option value="Prof.">Prof.</option>
                                                        </select>
                                                    </div>


                                                    <div class="input-field col s12">
                                                        <label for="phone">Mobile number</label>
                                                        <input id="phone" name="phonenumber" type="tel" maxlength="10"
                                                            autocomplete="off" required>
                                                    </div>

                                                    <div class="input-field col s12" style="margin-top: 30px;">
                                                        <button type="submit" name="addBE" onclick="return valid();"
                                                            id="addBE"
                                                            class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>


                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>
    <div class="left-sidebar-hover"></div>

    <!-- Javascripts -->
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>

</body>

</html>
<?php } ?>