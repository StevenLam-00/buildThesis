<?php
require_once 'controllers/authController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Sign Up | Researcher</title>
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center align-items-center" id="navbarNavAltMarkup">
            <div class="navbar-nav d-flex justify-content-center align-items-center">
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="../admin/">Admin Login</a>
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="../index.php">Employee Login</a>
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="#">Researcher Login</a>
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="../reviewer/">Reviewer Login</a>
                <a class="nav-item text-white font-weight-bold nav-link ml-3" href="../appraiser/">Appraiser Login</a>

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
                                    Sign Up</span>
                                <div class="row">
                                    <form class="col s12" name=" signUp" method="post">
                                        <div class="input-field col s12">
                                            <input id="fullname" type="text" name="fullname" class="validate"
                                                autocomplete="off" required>
                                            <label for="fullname">Enter Your Full Name</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="username" type="text" name="username" class="validate"
                                                autocomplete="off" required>
                                            <label for="email">Enter Username</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="password" type="password" class="validate" name="password"
                                                autocomplete="off" required>
                                            <label for="password">Enter Password</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="passwordconf" type="password" class="validate"
                                                name="passwordconf" autocomplete="off" required>
                                            <label for="passwordconf">Enter Password Confirm</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="email" type="text" name="email" class="validate"
                                                autocomplete="off" required>
                                            <label for="email">Enter Email</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <input id="phonenumber" type="number" name="phonenumber" class="validate"
                                                autocomplete="off" required>
                                            <label for="phonenumber">Enter Phone Number</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <select id="field" name="field" class="validate">
                                                <option value="">Field</option>
                                                <option value="Business & Economy">Business & Economy</option>
                                                <option value="Sports">Sports</option>
                                                <option value="Technology & Engineering">Technology & Engineering
                                                </option>
                                                <option value="Tourism">Tourism</option>
                                            </select>
                                            <label for="field">Enter Your Field</label>
                                        </div>

                                        <div class="input-field col s12">
                                            <select id="academicrank" name="academicrank" class="validate" required>
                                                <option value="">Title</option>
                                                <option value="PhD">PhD</option>
                                                <option value="Dr">Dr</option>
                                                <option value="Assoc. Prof.">Assoc. Prof.</option>
                                                <option value="Professor">Professor</option>
                                            </select>
                                            <label for="academicrank">Enter Your Academic Title</label>
                                        </div>

                                        <div class="col col-md-12 center m-t-sm">
                                            <button type="submit" name="signUp-btn"
                                                class=" waves-effect waves-light btn blue-gray darken-4">Sign
                                                Up</button>

                                            <a class="waves-effect waves-grey" href="index.php"
                                                style="margin-bottom: 10px; margin-left: 10px;">Already have an
                                                account?</a>
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