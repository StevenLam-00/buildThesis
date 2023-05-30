<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['rsLogin']) == 0) {
    header('location:index.php');
} else {
    $msg = "";
    $error = "";

    if (isset($_POST['submit'])) {
        $rsid = $_SESSION['rsid'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $journal = $_POST['journal'];
        $volume = $_POST['volume'];
        $field = $_POST['field'];
        $abstract = $_POST['abstract'];
        $sbmtDate = $_POST['sbmtDate'];


        $sql = "INSERT INTO article(title, abstract, field, author, journal, volume, rsid, sbmtDate) VALUES(:title, :abstract, :field, :author, :journal, :volume, :rsid, :sbmtDate)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':abstract', $abstract, PDO::PARAM_STR);
        $query->bindParam(':field', $field, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':journal', $journal, PDO::PARAM_STR);
        $query->bindParam(':volume', $volume, PDO::PARAM_STR);
        $query->bindParam(':rsid', $rsid, PDO::PARAM_STR);
        $query->bindParam(':sbmtDate', $sbmtDate, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Submit article successfully";

            // Uploads file
            if (isset($_FILES['myfile'])) {
                $filename = $_FILES['myfile']['name'];
                $tempFilePath = $_FILES['myfile']['tmp_name'];
                $fileSize = $_FILES['myfile']['size'];
                $fileType = $_FILES['myfile']['type'];

                // Allowed file types
                $allowedExtensions = array('docx', 'pdf', 'jpg', 'png', 'txt');
                $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

                // Check if the file type is allowed
                if (in_array($fileExtension, $allowedExtensions)) {
                    // Check file size
                    if ($fileSize <= 1048576) { // 1 MB (1 MB = 1048576 bytes)
                        // Specify the desired destination for the file
                        $destination = "fileArticle/" . $filename;

                        // Move the uploaded file to the destination directory
                        if (move_uploaded_file($tempFilePath, $destination)) {
                            // Insert file details into the database
                            $sql = "UPDATE article SET name = :name, size = :size WHERE id = :id";
                            $fileQuery = $dbh->prepare($sql);
                            $fileQuery->bindParam(':name', $filename, PDO::PARAM_STR);
                            $fileQuery->bindParam(':size', $fileSize, PDO::PARAM_INT);
                            $fileQuery->bindParam(':id', $lastInsertId, PDO::PARAM_INT);
                            $fileQuery->execute();
                        } else {
                            $error = "Failed to upload file.";
                            // Delete the inserted article record from the database
                            $deleteQuery = $dbh->prepare("DELETE FROM article WHERE id = :id");
                            $deleteQuery->bindParam(':id', $lastInsertId, PDO::PARAM_INT);
                            $deleteQuery->execute();
                        }
                    } else {
                        $error = "File size should not exceed 1MB.";
                        // Delete the inserted article record from the database
                        $deleteQuery = $dbh->prepare("DELETE FROM article WHERE id = :id");
                        $deleteQuery->bindParam(':id', $lastInsertId, PDO::PARAM_INT);
                        $deleteQuery->execute();
                    }
                } else {
                    $error = "Invalid file type. Only .docx, .pdf, .jpg, .png, .txt files are allowed.";
                    // Delete the inserted article record from the database
                    $deleteQuery = $dbh->prepare("DELETE FROM article WHERE id = :id");
                    $deleteQuery->bindParam(':id', $lastInsertId, PDO::PARAM_INT);
                    $deleteQuery->execute();
                }
            } else {
                $error = "File upload is required.";
            }
        } else {
            if ($query->errorCode() != "00000") {
                $errorInfo = $query->errorInfo();
                $error = "Error inserting data into article table: " . $errorInfo[2];
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Researcher | Submit Article</title>

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



</head>

<body>
    <?php include('includes/header.php'); ?>

    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title blue-gray-text text-darken-2">UPLOAD ARTICLE</div>
            </div>
            <div class="col s12 m12 25">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="submitArticle" enctype="multipart/form-data">
                            <div>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m12">
                                                <div class="row">
                                                    <?php if ($error) { ?><div class="errorWrap"><strong>ERROR
                                                            </strong>:<?php echo htmlentities($error); ?> </div>
                                                    <?php } else if ($msg) { ?><div class="succWrap">
                                                            <strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?>
                                                        </div><?php } ?>
                                                    <div class="input-field col s12">
                                                        <label for="author">Authors</label>
                                                        <input name="author" id="author" type="text" autocomplete="off" required>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <label for="title">Title</label>
                                                        <input name="title" id="title" type="text" autocomplete="off" required>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <label for="journal">Journal/ Conference</label>
                                                        <input name="journal" id="journal" type="text" autocomplete="off" required>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <label for="volume">Volume</label>
                                                        <input name="volume" id="volume" type="text" autocomplete="off" required>
                                                    </div>
                                                    <div class="input-field col  s12">
                                                        <select name="field" id="field" autocomplete="off">
                                                            <option value="">Field...</option>
                                                            <option value="Architecture">Architecture</option>
                                                            <option value="Mediterranean Studies">Mediterranean Studies
                                                            </option>
                                                            <option value="Business & Economics">Business & Economics
                                                            </option>
                                                            <option value="Philology">Philology</option>
                                                            <option value="Education">Education</option>
                                                            <option value="Philosophy">Philosophy</option>
                                                            <option value="Health and Medical Sciences">Health and
                                                                Medical Sciences</option>
                                                            <option value="Sciences">Sciences</option>
                                                            <option value="History">History</option>
                                                            <option value="Social Sciences">Social Sciences</option>
                                                            <option value="Humanities & Arts">Humanities & Arts</option>
                                                            <option value="Sports">Sports</option>
                                                            <option value="Law">Law</option>
                                                            <option value="Technology & Engineering">Technology &
                                                                Engineering</option>
                                                            <option value="Computer Science">Computer Science</option>
                                                            <option value="Mass Media and Communications">Mass Media and
                                                                Communications</option>
                                                            <option value="Tourism">Tourism</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-field col m12 s12">
                                                        <label for="abstract">Abstract</label>
                                                        <textarea id="textarea" name="abstract" class="materialize-textarea" length="10000" required></textarea>
                                                    </div>


                                                    <div class="input-field col m12 s12">
                                                        <input type="date" name="sbmtDate" id="sbmtDate" required>
                                                    </div>

                                                    <div class="input-field col m12 s12">
                                                        <input type="file" name="myfile" id="myfile" required>
                                                    </div>

                                                </div>

                                                <div align="center">
                                                    <button type="submit" name="submit" id="submit" class="waves-effect waves-light btn indigo m-b-xs">Upload</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <script src="../assets/js/pages/form-input-mask.js"></script>
    <script src="../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
</body>

</html>