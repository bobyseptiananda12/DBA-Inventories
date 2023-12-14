<?php
session_start();
include "../config.php";
$username = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$users = $result->fetch_assoc();
$isAdmin = ($usertype === 'admin');
if (!isset($_SESSION['username'])) {
    header("Location: page/login.html");
} else {
}
include "../config.php"


// Rest of your code here
?>
<!DOCTYPE html>
<html lang="en">
<?php $halaman = "Profile" ?>

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
                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-2">
                            <h2 class="h3 mb-0 text-gray-800">Informasi Admin</h2>
                        </div>
                        <div class="card mb-4 py-3 border-left-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control form-control-user" name="username" id="username" value="<?php echo $users['username']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control form-control-user" name="nama" id="nama" value="<?php echo $users['name']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control form-control-user" name="nik" id="nik" value="<?php echo $users['nik']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="telp">No. Telp</label>
                                    <input type="text" class="form-control form-control-user" name="telp" id="telp" value="<?php echo $users['telp']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="usertype">Usertype</label>
                                    <input type="text" class="form-control form-control-user" name="usertype" id="usertype" value="<?php echo $users['usertype']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nomerTelpon">Created At</label>
                                    <input type="text" class="form-control form-control-user" name="nomerTelpon" id="nomerTelpon" value="<?php echo $users['createdAt']; ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="jenisKelamin">Last Updated At</label>
                                    <input type="text" class="form-control form-control-user" name="jenisKelamin" id="jenisKelamin" value="<?php echo $users['lastUpdatedAt']; ?>" readonly>
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

                    </div>
                    <!-- Logout Modal-->
                    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
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