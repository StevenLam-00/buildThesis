<aside id="slide-out" class="side-nav white fixed">
    <div class="side-nav-wrapper">
        <div class="sidebar-profile">
            <div class="sidebar-profile-image">
                <img src="assets/images/profile-image.jpg" class="circle" alt="">
            </div>
            <div class="sidebar-profile-info">
                <?php
                $rsid = $_SESSION['rsid'];
                $sql = "SELECT fullName,id from researcher where id=:rsid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':rsid', $rsid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $result) {               ?>
                        <p><?php echo "Hi, " . htmlentities($result->fullName); ?></p>
                        <span><?php echo "ID: " . "RS" . htmlentities($result->id) ?></span>
                <?php }
                } ?>
            </div>
        </div>


        <?php
        $page = explode("?", array_reverse(explode("/", $_SERVER['PHP_SELF']))[0])[0];
        ?>
        <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
            <li class="no-padding <?= $page == 'dashboard.php' ? 'active' : '' ?>"><a class="waves-effect waves-grey" href="dashboard.php"><i class="material-icons">settings_input_svideo</i>Dashboard</a></li>



            <li class="no-padding">
                <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">book</i>My
                    Article<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="allArticle.php"><i class="material-icons">shelves</i>All Article </a></li>
                        <li><a href="newArticle.php"><i class="material-icons">post_add</i>New Article </a></li>
                    </ul>
                </div>
            </li><br><br>


            <li class="no-padding">
                <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons">exit_to_app</i>Log
                    Out</a>
            </li>


        </ul>

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