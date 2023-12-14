<?php
session_start();
// Continue with the rest of your code here (without using exit())
$usertype = $_SESSION['usertype'];
$isAdmin = ($usertype === 'admin');

if (!isset($_SESSION['username'])) {
    header("Location: page/login.html");
} else {
    // Redirect based on user type
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'admin') {
        // Admins can stay on this page
    } else {
        header("Location: ./dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php $halaman = "Users" ?>

<head>
    <?php include "components/header.php"; ?>
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php include "components/navigasi.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <?php include "components/topbar.php"; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">List Pengguna</h1>
                    <!-- DataTables -->
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    ini_set('max_execution_time', 0);
                    date_default_timezone_set('Asia/Jakarta');
                    include "../config.php";

                    // Assuming these are the fields for the user table
                    $username = $_POST['username'];
                    $name = $_POST['name'];
                    $usertype = $_POST['usertype'];
                    $password = $_POST['password'];
                    $nik = $_POST['nik'];
                    $telp = $_POST['telp'];


                    if (isset($_POST['tambah'])) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
                        $query = "INSERT INTO users (username, name, password, usertype, createdAt, lastUpdatedAt) VALUES ('$username', '$name', '$hashed_password', '$usertype', NOW(), NOW())";

                        $result = mysqli_query($conn, $query);

                        if ($result) {
                            $nilaihasil = "User added successfully.";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }

                    if (isset($_POST['edit'])) {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
                        $sql = "UPDATE users SET name = ?, usertype = ?, password = ?, nik = ?, telp = ?, lastUpdatedAt = CURRENT_TIMESTAMP WHERE username = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "ssssss", $name, $usertype, $hashed_password, $nik, $telp, $username);

                            if (mysqli_stmt_execute($stmt)) {
                                $nilaihasil = "User information updated successfully.";
                            } else {
                                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                            }

                            mysqli_stmt_close($stmt);
                        } else {
                            echo "ERROR: Could not prepare $sql. " . mysqli_error($conn);
                        }
                    }


                    if (isset($_POST['delete'])) {
                        // Delete user
                        $sql = "DELETE FROM users WHERE username = '$username'";
                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "User deleted successfully.";
                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    }
                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <h6 class="m-0 font-weight-bold text-primary">List Inventory DB Oracle</h6> -->
                            <a href="#addUsersModal" class="btn btn-success" data-toggle="modal">New Record</a>
                            <?php echo "$nilaihasil"; ?>
                        </div>
                        <!-- Tabel -->
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabel-data" method="post" action=""
                                        width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>User Type</th>
                                                <th>NIK</th>
                                                <th>No. Telp</th>
                                                
                                                <!-- Add other user-related columns as needed -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM users";
                                            $query = $conn->query($sql);
                                            while ($row = mysqli_fetch_array($query)) {
                                                $i++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="checkbox<?php echo $i; ?>"
                                                            name="pilih[]" value="<?php echo $row['username']; ?>">
                                                        <label for="checkbox<?php echo $i; ?>"></label>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#viewUserModal<?php echo $row['username']; ?>" class="view"
                                                        data-toggle="modal"><i class="fas fa-search"
                                                            data-toggle="tooltip" title="View">&#xE254;</i></a>
                                                    <a href="#editUserModal<?php echo $row['username']; ?>" class="edit"
                                                        data-toggle="modal"><i class="fas fa-edit" data-toggle="tooltip"
                                                            title="Edit">&#xE254;</i></a>
                                                    <a href="#deleteUserModal<?php echo $row['username']; ?>"
                                                        class="delete" data-toggle="modal"><i class="fas fa-trash-alt"
                                                            data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                                </td>
                                                <td><?php echo $row['username']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['usertype']; ?></td>
                                                <td><?php echo $row['nik']; ?></td>
                                                <td><?php echo $row['telp']; ?></td>
                                            </tr>
                                            <!-- View Modal HTML -->
                                            <div id="viewUserModal<?php echo $row['username']; ?>" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="">
                                                            <input type="hidden" class="form-control"
                                                                value="<?php echo $row['username']; ?>" name="username"
                                                                required>
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">View User</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['name']; ?>" name="name"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>User Type</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['usertype']; ?>"
                                                                        name="usertype" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>NIK</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['nik']; ?>"
                                                                        name="nik" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>No. Telp</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['telp']; ?>"
                                                                        name="telp" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default"
                                                                    data-dismiss="modal" value="Back">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Modal HTML -->
                                            <div id="editUserModal<?php echo $row['username']; ?>" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="">
                                                            <input type="hidden" class="form-control"
                                                                value="<?php echo $row['username']; ?>" name="username"
                                                                required>
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit User</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['name']; ?>" name="name"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>User Type</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['usertype']; ?>"
                                                                        name="usertype" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>NIK</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['nik']; ?>"
                                                                        name="nik" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>No. Telp</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['telp']; ?>"
                                                                        name="telp" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Password</label>
                                                                    <input type="password" class="form-control"
                                                                        name="password" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default"
                                                                    data-dismiss="modal" value="Cancel">
                                                                <input type="submit" class="btn btn-info" value="Save"
                                                                    name="edit">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Modal HTML -->
                                            <div id="deleteUserModal<?php echo $row['username']; ?>" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="">
                                                            <input type="hidden" class="form-control"
                                                                value="<?php echo $row['username']; ?>" name="username"
                                                                required>
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete User</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete the user
                                                                    <?php echo $row['name']; ?>?</p>
                                                                <p class="text-warning"><small>This action cannot be
                                                                        undone.</small></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="button" class="btn btn-default"
                                                                    data-dismiss="modal" value="Cancel">
                                                                <input type="submit" class="btn btn-danger"
                                                                    value="Delete" name="delete">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            }
                                            // Close connection
                                            mysqli_close($conn);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <?php include "components/footer.php" ?>
                    <!-- End of Footer -->

                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>

                    <!-- Add Modal HTML -->
                    <div id="addUsersModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add User</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select class="form-control" name="usertype" required>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>NIK</label>
                                            <input type="text" class="form-control" name="nik" required>
                                        </div>
                                        <div class="form-group">
                                            <label>No. Telp</label>
                                            <input type="text" class="form-control" name="telp" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal"
                                            value="Cancel">
                                        <input type="submit" class="btn btn-success" value="Add User" name="tambah">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Logout Modal-->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-primary" href="login.html">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bootstrap core JavaScript-->
                <script src="../vendor/jquery/jquery.min.js"></script>
                <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                <!-- Core plugin JavaScript-->
                <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

                <!-- Custom scripts for all pages-->
                <script src="../js/sb-admin-2.min.js"></script>

                <!-- Page level custom scripts -->
                <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
                <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
                <script src="../js/demo/datatables-demo.js"></script>

                <script>
                $(document).ready(function() {
                    $('#tabel-data').DataTable();
                });
                </script>

</body>

</html>