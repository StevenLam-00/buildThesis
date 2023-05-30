<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['rsLogin']) == 0) {
    header('location:index.php');
} else {
    $msg = "";
    $error = "";

    if (isset($_POST['update'])) {
        $artid = intval($_GET['articleid']);
        $title = $_POST['title'];
        $abstract = $_POST['abstract'];
        $field = $_POST['field'];
        $author = $_POST['author'];
        $journal = $_POST['journal'];
        $volume = $_POST['volume'];

        $sql = "UPDATE article SET title=:title, abstract=:abstract, field=:field, author=:author, journal=:journal, volume=:volume WHERE id=:artid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':abstract', $abstract, PDO::PARAM_STR);
        $query->bindParam(':field', $field, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':journal', $journal, PDO::PARAM_STR);
        $query->bindParam(':volume', $volume, PDO::PARAM_STR);
        $query->bindParam(':artid', $artid, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() > 0) {
            $msg = "Article Detail updated Successfully";

            // Uploads file
            if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {
                $filename = $_FILES['myfile']['name'];
                $tempFilePath = $_FILES['myfile']['tmp_name'];
                $fileSize = $_FILES['myfile']['size'];

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
                            // Update file details in the database
                            $sql = "UPDATE article SET name = :name, size = :size WHERE id = :id";
                            $fileQuery = $dbh->prepare($sql);
                            $fileQuery->bindParam(':name', $filename, PDO::PARAM_STR);
                            $fileQuery->bindParam(':size', $fileSize, PDO::PARAM_INT);
                            $fileQuery->bindParam(':id', $artid, PDO::PARAM_INT);
                            $fileQuery->execute();
                        } else {
                            $error = "Failed to upload file.";
                        }
                    } else {
                        $error = "File size should not exceed 1MB.";
                    }
                } else {
                    $error = "Invalid file type. Only .docx, .pdf, .jpg, .png, .txt files are allowed.";
                }
            } else {
                $error = "File upload is required.";
            }
        } else {
            $error = "Error updating article detail.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>Admin | Update Article</title>

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
                <div class="page-title blue-gray-text text-darken-2">Update Article Detail</div>
                <div class="col s12 m12 25">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <form class="col s12" name="chngpwd" method="post" enctype="multipart/form-data">
                                    <?php
                                    $artid = intval($_GET['articleid']);
                                    $sql = "SELECT * FROM article WHERE id=:artid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':artid', $artid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                    ?>
                                    <div class="row">
                                        <div class="col m12">
                                            <div class="row">
                                                <?php if ($error) { ?>
                                                <script>
                                                $(document).ready(function() {
                                                    M.toast({
                                                        html: '<?php echo htmlentities($error); ?>',
                                                        classes: 'red'
                                                    });
                                                });
                                                </script>
                                                <?php } else if ($msg) { ?>
                                                <script>
                                                $(document).ready(function() {
                                                    M.toast({
                                                        html: '<?php echo htmlentities($msg); ?>',
                                                        classes: 'green'
                                                    });
                                                });
                                                </script>
                                                <?php } ?>

                                                <div class="input-field col s12">
                                                    <label for="author">Authors</label>
                                                    <input name="author" id="author" type="text" autocomplete="off"
                                                        value="<?php echo htmlentities($result->author); ?>" required>
                                                </div>
                                                <div class="input-field col s12">
                                                    <label for="title">Title</label>
                                                    <input name="title" id="title" type="text" autocomplete="off"
                                                        value="<?php echo htmlentities($result->title); ?>" required>
                                                </div>
                                                <div class="input-field col s12">
                                                    <label for="journal">Journal</label>
                                                    <input name="journal" id="journal" type="text" autocomplete="off"
                                                        value="<?php echo htmlentities($result->journal); ?>" required>
                                                </div>
                                                <div class="input-field col s12">
                                                    <label for="volume">Volume</label>
                                                    <input name="volume" id="volume" type="text" autocomplete="off"
                                                        value="<?php echo htmlentities($result->volume); ?>" required>
                                                </div>
                                                <div class="input-field col s12">
                                                    <label for="abstract">Abstract</label>
                                                    <textarea name="abstract" id="abstract" class="materialize-textarea"
                                                        required><?php echo htmlentities($result->abstract); ?></textarea>
                                                </div>
                                                <div class="input-field col  s12">
                                                    <select name="field" id="field" autocomplete="off">
                                                        <option value="">Field...</option>
                                                        <option value="Sport">Sport</option>
                                                        <option value="Science">Science</option>
                                                        <option value="History">History</option>
                                                    </select>
                                                </div>

                                                <div class="input-field col m12 s12">
                                                    <input type="file" name="myfile"><br><br>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <?php }
                                    } ?>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <button type="submit" name="update" id="update"
                                                class="waves-effect waves-light btn indigo m-b-xs">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('includes/footer.php'); ?>

    <!-- Javascripts -->
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>
    <script src="../assets/js/pages/form_layouts.js"></script>
    <script src="../assets/js/pages/form_validations.js"></script>
</body>



</html> <?php } ?>