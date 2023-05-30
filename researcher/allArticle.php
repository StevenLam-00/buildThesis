<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('includes/searchConfig.php');

if (strlen($_SESSION['rsLogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "delete from  article  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $msg = "Article deleted";
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>Admin | Manage Departments</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css" />
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css" />
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">


    <!-- Theme Styles -->
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

    .test1 .dataTables_filter {
        display: none !important;
    }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>

    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <!-- ################################################################################################################################################ DATA -->
        <div class="row">
            <div class="col s12">
                <div class="page-title blue-gray-text text-darken-2">publications</div>
            </div>
            <div class="col s12 m12 l6">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <form class="col s12" name="searchArticle.php" method="post">
                                <div class="row">
                                    <!-- search ################################################################################################################################################ DATA -->
                                    <!-- search ################################################################################################################################################ DATA -->
                                    <div class="input-field col s12">
                                        <input id="author" type="text" name="author" class="validate" autocomplete="off"
                                            value="<?php echo htmlentities($result->author); ?>">
                                        <label for="author">Authors</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="title" type="text" name="title" class="validate" autocomplete="off"
                                            value="<?php echo htmlentities($result->title); ?>">
                                        <label for="title">Title</label>
                                    </div>
                                    <div class="input-field col s12">
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
                                    <div class="input-field col s12">
                                        <button type="submit" name="search"
                                            class="waves-effect waves-light btn indigo m-b-xs">SEARCH</button>
                                        <a class="waves-effect waves-grey" href="allArticle.php"
                                            style="margin-bottom: 10px; margin-left: 10px;"> or Show full</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ################################################################################################################################################ DATA -->
            <div class="row">
                <div class="col s12">
                    <div class="page-title blue-gray-text text-darken-2">Manage Articles</div>
                </div>
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content test1">
                            <table id="example" class="display responsive-table">
                                <thead>
                                    <tr>
                                        <th class="blue-gray-text text-darken-3">No.</th>
                                        <th class="blue-gray-text text-darken-3">ID</th>
                                        <th class="blue-gray-text text-darken-3">Authors</th>
                                        <th class="blue-gray-text text-darken-3">Title</th>
                                        <th class="blue-gray-text text-darken-3">Field</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include('searchConfig/db.php');
                                        if (!isset($_POST['search'])) {

                                            $rsid = $_SESSION['rsid'];
                                            $sql = "SELECT * from article where rsid = :rsid ";
                                            $query = $dbh->prepare($sql);
                                            $query->bindParam(':rsid', $rsid, PDO::PARAM_STR);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {
                                        ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo "A" . htmlentities($result->id); ?></td>
                                        <td><?php echo htmlentities($result->author); ?></td>
                                        <td><a href="viewDetail.php?articleid=<?php echo htmlentities($result->id); ?>">
                                                <?php echo htmlentities($result->title); ?> </a></td>
                                        <td><?php echo htmlentities($result->field); ?></td>
                                    </tr>
                                    <?php $cnt++;
                                                }
                                            }
                                        } else {

                                            $author = $_POST['author'];
                                            $title = $_POST['title'];
                                            $field = $_POST['field'];


                                            if ($author != '' || $title != '' || $field != '') {
                                                $rsid = $_SESSION['rsid'];
                                                $searchQuery = "SELECT * FROM `article` WHERE `title` LIKE '%$title%' AND `author` LIKE '%$author%' AND `field` LIKE '%$field%' AND `rsid` = :rsid";


                                                $searchData = $dbh->prepare($searchQuery);
                                                $searchData->execute();
                                                $searchResults = $searchData->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($searchData->rowCount() > 0) {
                                                    foreach ($searchResults as $searchResult) {
                                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo "A" . htmlentities($searchResult->id); ?></td>
                                        <td><?php echo htmlentities($searchResult->author); ?></td>
                                        <td><a
                                                href="viewDetail.php?articleid=<?php echo htmlentities($searchResult->id); ?>">
                                                <?php echo htmlentities($searchResult->title); ?> </a></td>
                                        <td><?php echo htmlentities($searchResult->field); ?></td>
                                    </tr>
                                    <?php $cnt++;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
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
    <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/table-data.js"></script>
</body>

</html>
<?php } ?>