<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-image">
                <img src="assets/images/profile-image.jpg" class="circle" alt="">
            </div>
            <div class="sidebar-profile-info">
                <?php
                $adid = $_SESSION['adid'];
                $sql = "SELECT username,id from admin where id=:adid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':adid', $adid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {               ?>
                <p><?php echo "Hi, " . htmlentities($result->username); ?></p>
                <span><?php echo "ID: " . "Admin" . htmlentities($result->id) ?></span>
                <?php }
                } ?>
            </div>
        </div>

        <?php
        $page = explode("?", array_reverse(explode("/", $_SERVER['PHP_SELF']))[0])[0];
        ?>
        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding <?= $page == 'dashboard.php' ? 'active' : '' ?>"><a class="waves-effect waves-grey"
                    href="dashboard.php"><i class="material-icons">settings_input_svideo</i>Dashboard</a></li>

            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">article</i>Article<i
                        class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="allArticle.php">All Article </a></li>
                        <li><a href="../pendingArticle.php">Pending Article</a></li>
                        <li><a href="../rejectedArticle.php">Rejected Article</a></li>
                    </ul>
                </div>
            </li>
            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">science</i>Researcher<i
                        class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="RSadd.php">Add Account</a></li>
                        <li><a href="RSmanage.php">Manage Account</a></li>
                    </ul>
                </div>
            </li><br><br>

            <li class="no-padding">
                <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons">exit_to_app</i>Log
                    Out</a>
            </li>

    </div>
</aside>
<script>
$(function() {

    var page = '<?= $page ?>';
    if ($('.sidebar-menu a[href="' + page + '"]').length > 0) {
        if ($('.sidebar-menu a[href="' + page + '"]').closest('.collapsible-body').siblings(
                '.collapsible-header').length > 0) {
            $('.sidebar-menu a[href="' + page + '"]').closest('.collapsible-body').siblings(
                '.collapsible-header').trigger('click')
        }

    }
})
</script>