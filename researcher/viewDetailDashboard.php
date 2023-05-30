<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['rsLogin']) == 0) {
    header('location:index.php');
} else {
    // connect to the database
    $conn = mysqli_connect('localhost', 'root', 'root', 'buildThesisDB');

    $sql = "SELECT * FROM article";
    $result = mysqli_query($conn, $sql);

    $files = mysqli_fetch_all($result, MYSQLI_ASSOC);


    if (isset($_GET['file_id'])) {
        $id = $_GET['file_id'];

        // fetch file to download from database
        $sql = "SELECT * FROM article WHERE id=$id";
        $result = mysqli_query($conn, $sql);

        $file = mysqli_fetch_assoc($result);
        $filepath = 'fileArticle/' . $file['name'];

        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize('fileArticle/' . $file['name']));

            //This part of code prevents files from being corrupted after download
            ob_clean();
            flush();

            readfile('fileArticle/' . $file['name']);


            exit;
        }
    }




?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <!-- Title -->
        <title>Admin | Detail of Article</title>

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
                    <div class="page-title blue-gray-text text-darken-2">Detail of Article</div>
                </div>
                <div class="col s12 m12 25">
                    <div class="card">
                        <div class="card-content">

                            <div class="row">
                                <form class="col s12" name="chngpwd" method="post">
                                    <?php
                                    $artid = intval($_GET['articleid']);
                                    $sql = "SELECT * from article WHERE id=:artid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':artid', $artid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {               ?>
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
                                                            <input name="author" id="author" type="text" autocomplete="off" value="<?php echo htmlentities($result->author); ?>" readonly required>
                                                        </div>

                                                        <div class="input-field col s12">
                                                            <label for="title">Title</label>
                                                            <input name="title" id="title" type="text" autocomplete="off" value="<?php echo htmlentities($result->title); ?>" readonly required>
                                                        </div>
                                                        <div class="input-field col s12">
                                                            <label for="journal">Journal</label>
                                                            <input name="journal" id="journal" type="text" autocomplete="off" value="<?php echo htmlentities($result->journal); ?>" readonly required>
                                                        </div>
                                                        <div class="input-field col s12">
                                                            <label for="volume">Volume</label>
                                                            <input name="volume" id="volume" type="text" autocomplete="off" value="<?php echo htmlentities($result->volume); ?>" readonly required>
                                                        </div>

                                                        <div class="input-field col s12">
                                                            <label for="field">Field</label>
                                                            <input name="field" id="field" type="text" autocomplete="off" value="<?php echo htmlentities($result->field); ?>" readonly required>
                                                        </div>

                                                        <div class="input-field col s12">
                                                            <label for="sbmtDate">Publish Date</label>
                                                            <input name="sbmtDate" id="sbmtDate" type="text" autocomplete="off" value="<?php echo substr(htmlentities($result->sbmtDate), 0, 10); ?>" readonly required>
                                                        </div>


                                                        <div class="input-field col m12 s12">
                                                            <label for="abstract">Description</label>
                                                            <textarea id="abstract" name="abstract" class="materialize-textarea" readonly required><?php echo htmlentities($result->abstract); ?></textarea>
                                                        </div>

                                                        <div class="input-field col m12 s12">
                                                            <label for="ref">Reference information</label>


                                                            <textarea id="ref" name="ref" class="materialize-textarea" readonly><?php echo htmlentities($result->author) . ', "' . htmlentities($result->title) . '", ' . htmlentities($result->journal) . ', Vol.' . htmlentities($result->volume) . ', ' . substr(htmlentities($result->sbmtDate), 0, 10); ?></textarea>

                                                            <!-- authors. (year). title. journal, volume(issue), pages -->
                                                        </div>
                                                        <div class="input-field col m12 s12">
                                                            <a href="viewDetail.php?file_id=<?php echo $result->id ?>"> >> Download
                                                                this
                                                                article</a>
                                                        </div>

                                                    </div>
                                                    <?php if ($_SESSION['rsid'] == $result->rsid) { ?>
                                                        <a href="editArticle.php?articleid=<?php echo htmlentities($result->id); ?>" class="btn btn-sm waves-effect waves-light blue-gray lighten-2"><i class="material-icons">mode_edit</i></a>

                                                        <a href="allArticle.php?del=<?php echo htmlentities($result->id); ?>" class="btn btn-sm waves-effect waves-light red lighten-2" onclick="return confirm('Do you want to delete');"> <i class="material-icons">delete_forever</i></a>
                                                    <?php }
                                                    ?>

                                                </div>
                                            </div>

                                </form>
                            </div>
                        </div>
                <?php }
                                    } ?>

                    </div>
                </div>
            </div>

            </div>

        </main>

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