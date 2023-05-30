<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $id = intval($_GET['id']);
    if (isset($_POST['update'])) {

        $fName = $_POST['fullname'];
        $field = $_POST['field'];
        $aRank = $_POST['academicrank'];
        $pNumber = $_POST['phonenumber'];
        $newPassword = md5($_POST['newPassword']);

        $sql = "update boardeditor set fullname=:fName,field=:field, phonenumber=:pNumber, academicrank=:aRank, password=:newPassword where id=:id";
        $query = $dbh->prepare($sql);

        $query->bindParam(':fName', $fName, PDO::PARAM_STR);
        $query->bindParam(':field', $field, PDO::PARAM_STR);
        $query->bindParam(':pNumber', $pNumber, PDO::PARAM_STR);
        $query->bindParam(':aRank', $aRank, PDO::PARAM_STR);
        $query->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_STR);

        $query->execute();
        $msg = "Updated Successfully";
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Admin | Update BE</title>

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
        if (document.update.newPassword.value != document.update.newPassConf.value) {
            alert("New Password and Confirm Password Field does not match  !!");
            document.update.newPassConf.focus();
            return false;
        }
        return true;
    }
    </script>



</head>

<body>
    <?php include('includes/header.php'); ?>

    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Update Board Editor</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="updateBE">
                            <div>
                                <h4 style="color: green;">Update Board Editor Details</h4>
                                <?php if ($error) { ?><div class="errorWrap">
                                    <strong>ERROR</strong>:<?php echo htmlentities($error); ?>
                                </div>
                                <?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong> :
                                    <?php echo htmlentities($msg); ?> </div><?php } ?>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php
                                                        $id = intval($_GET['id']);
                                                        $sql = "SELECT * from boardeditor where id=:id";
                                                        $query = $dbh->prepare($sql);
                                                        $query->bindParam(':id', $id, PDO::PARAM_STR);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $result) {               ?>
                                                    <div class="input-field col m6 s12">
                                                        <label for="becode">Board Editor ID</label>
                                                        <input name="becode" id="becode"
                                                            value="<?php echo "BE - " . htmlentities($result->id); ?>"
                                                            type="text" autocomplete="off" readonly required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="fullname">Full name</label>
                                                        <input id="fullname" name="fullname"
                                                            value="<?php echo htmlentities($result->fullname); ?>"
                                                            type="text" required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="username">User name</label>
                                                        <input id="username" name="username"
                                                            value="<?php echo htmlentities($result->username); ?>"
                                                            type="text" readonly required>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="email">Email</label>
                                                        <input id="email" name="email"
                                                            value="<?php echo htmlentities($result->email); ?>"
                                                            type="text" autocomplete="off" readonly required>
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="newPassword">New Password</label>
                                                        <input name="newPassword" type="password" id="newPassword"
                                                            autocomplete="off">
                                                    </div>

                                                    <div class="input-field col s12">
                                                        <label for="newPassConf">Confirm Password</label>
                                                        <input id="newPassConf" name="newPassConf" type="password"
                                                            autocomplete="off">
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col m6">
                                                <div class="row">
                                                    <div class="input-field col m6 s12">
                                                        <select name="field" autocomplete="off">
                                                            <option value="<?php echo htmlentities($result->field); ?>">
                                                                <?php echo "Current Field: " . htmlentities($result->field); ?>
                                                            </option>
                                                            <option value="Sport">Sport</option>
                                                            <option value="Science">Science</option>
                                                            <option value="History">History</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <select name="academicrank" autocomplete="off">
                                                            <option
                                                                value="<?php echo htmlentities($result->academicrank); ?>">
                                                                <?php echo "Current Title: " . htmlentities($result->academicrank); ?>
                                                            </option>
                                                            <option value="PhD">PhD</option>
                                                            <option value="Dr">Dr</option>
                                                            <option value="Prof.">Prof.</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m6 s12">
                                                        <label for="phonenumber">Phone number</label>
                                                        <input id="phonenumber" name="phonenumber"
                                                            value="<?php echo htmlentities($result->phonenumber); ?>"
                                                            type="text" autocomplete="off" required>
                                                    </div>


                                                    <?php }
                                                        } ?>

                                                    <div class="input-field col s12">
                                                        <button type="submit" name="update" id="update"
                                                            class="waves-effect waves-light btn indigo m-b-xs">UPDATE</button>
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