<?php // include('authentication.php'); ?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <!-- Logo -->
    <div class="d-flex align-items-center">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/mcc-logo.png" alt="logo" class="mx-2" />
            <span class="d-none d-lg-block mx-2">MCC <span class="text-info d-block fs-6">Learning Resource Center</span></span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <?php 
    if (isset($_SESSION['auth_admin']['admin_id'])) {
        $id_session = $_SESSION['auth_admin']['admin_id'];
    }
    ?>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown me-3">
                <a class="nav-link nav-icon fs-4" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <?php
                    $query = "SELECT COUNT(*) AS total_borrowers FROM holds WHERE hold_status = 'Hold'";
                    $query_run = mysqli_query($con, $query);
                    $total_borrowers = $query_run ? mysqli_fetch_assoc($query_run)['total_borrowers'] : 0;
                    echo '<span class="badge bg-primary badge-number">'.$total_borrowers.'</span>';
                    ?>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        You have <?=$total_borrowers?> notifications
                    </li>
                    <?php 
                    $query_notif = "SELECT 
                                        u.user_id, u.firstname AS user_firstname, u.lastname AS user_lastname, 
                                        f.faculty_id, f.firstname AS faculty_firstname, f.lastname AS faculty_lastname,
                                        COUNT(h.hold_id) AS num_hold_books
                                    FROM holds h
                                    LEFT JOIN user u ON u.user_id = h.user_id
                                    LEFT JOIN faculty f ON f.faculty_id = h.faculty_id
                                    WHERE h.hold_status = 'Hold'
                                    GROUP BY u.user_id, f.faculty_id
                                    ORDER BY h.hold_id DESC";
                    $query_run = mysqli_query($con, $query_notif);

                    if (mysqli_num_rows($query_run) > 0) {
                        while ($holdlist = mysqli_fetch_assoc($query_run)) {
                            $name = $holdlist['user_id'] ? $holdlist['user_firstname'].' '.$holdlist['user_lastname'] : $holdlist['faculty_firstname'].' '.$holdlist['faculty_lastname'];
                            $id = $holdlist['user_id'] ? $holdlist['user_id'] : $holdlist['faculty_id'];
                    ?>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li class="notification-item">
                        <div>
                            <h4><?=$name;?></h4>
                            <p>hold <span><?=$holdlist['num_hold_books'];?></span> book(s).</p>
                            <br>
                            <form action="" method="POST">
                                <button type="submit" value="<?=$holdlist['num_hold_books'];?>" class="btn btn-primary btn-sm" name="done">Accept</button>
                                <button type="submit" value="<?=$holdlist['num_hold_books'];?>" class="btn btn-danger btn-sm" name="cancel">Deny</button>
                            </form>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <?php
                        }
                    }
                    ?>
                    <li>
                        <a href="hold_list.php" style="text-decoration:underline;font-size:13px;margin-left:10px;">Show all notifications</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown pe-3">
                <?php
                $query = "SELECT * FROM admin WHERE admin_id = '$id_session'";
                $query_run = mysqli_query($con, $query);
                $row = mysqli_fetch_array($query_run);
                ?>
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:;" data-bs-toggle="dropdown">
                    <img src="<?= $row['admin_image'] ? '../uploads/admin_profile/'.$row['admin_image'] : 'assets/img/admin.png'; ?>" alt="" width="30px" height="30px" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['auth_admin']['admin_name']; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $_SESSION['auth_admin']['admin_name'];?></h6>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="admin_profile.php">
                            <i class="bi bi-person"></i> <span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="account_settings.php">
                            <i class="bi bi-gear"></i> <span>Account Settings</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="admin.php">
                            <i class="bi bi-person-workspace"></i><span>Admin</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="circulation_settings.php">
                            <i class="bi bi-journal-album"></i><span>Circulation Settings</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <form action="allcode.php" method="POST">
                            <button class="dropdown-item d-flex align-items-center" name="logout_btn" type="submit">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cancel'])) {
        $holdbook_id = mysqli_real_escape_string($con, $_POST['cancel']);
        $query = "UPDATE holds SET hold_status = 'Deny' WHERE hold_id = '$holdbook_id'";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Denied book successfully'); window.location='index.php'</script>";
        } else {
            $_SESSION['message_error'] = 'There is something wrong';
            header("Location: hold.php");
            exit(0);
        }
    }

    if (isset($_POST['done'])) {
        $holdbook_id = mysqli_real_escape_string($con, $_POST['done']);
        $query = "UPDATE holds SET hold_status='Accept' WHERE hold_id = '$holdbook_id'";
        if (mysqli_query($con, $query)) {
            echo "<script>alert('Book accepted successfully'); window.location='index.php'</script>";
        } else {
            $_SESSION['message_error'] = 'Hold book not approved';
            header("Location: index.php");
            exit(0);
        }
    }
}
?>
