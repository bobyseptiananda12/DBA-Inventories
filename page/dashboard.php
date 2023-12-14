<?php
session_start();

$name = $_SESSION['name'];
$usertype = $_SESSION['usertype']; // Adjust this line based on your session variable

// Check if the user is an admin
$isAdmin = ($usertype === 'admin');
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
}

include "../config.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Query for table3
$sql4 = "SELECT COUNT(*) AS total_rows FROM inventorydba WHERE Jenis_DB = 'Oracle'";
$result4 = $conn->query($sql4);
$row4 = $result4->fetch_assoc();
$total_dboracle = $row4['total_rows'];


// Query for table3
$sql3 = "SELECT COUNT(*) AS total_rows FROM inventorydba";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();
$inventorydba = $row3['total_rows'];

$total_dbnonoracle = $inventorydba - $total_dboracle;


// Display the result
// echo "Total database rows: " . $totaldatabase;


?>

<!DOCTYPE html>
<html lang="en">
<?php $halaman = "Dashboard" ?>
<?php include "components/header.php"; ?>

<head>
    <link rel="stylesheet" href="cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">    
<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "components/navigasi.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include "components/topbar.php"; ?>
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                  <!-- Content Row -->
                  <div class="row">

                <!-- Display Total DB -->
                <div class="col-xl-2 mb-4"> <!-- Added 'text-center' class to center align content -->
                    <div class="card border-left-warning shadow h-100 py-1">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2"> <!-- Added 'mx-auto' class for centering within the column -->
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total DB
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalDb">
                                        <?php echo $inventorydba; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-database fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="col-xl-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <canvas id="dbChart"></canvas>
                        </div>
                    </div>
                </div>

                </div>

<!-- ... (your existing content) ... -->

                    <!-- Content Row -->
                    <div class="row">

                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total DB Oracle</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_dboracle; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total DB Non-Oracle</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_dbnonoracle; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total DB Non-Oracle</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dbnonoracle; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Pending Requests Card Example -->

                        <!-- <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total DB</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $inventorydba; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <!-- Content Row -->
                    <h1 class="h3 mb-2 text-gray-800">Log Activities</h1>
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabel-data" method="post" action="" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Database</th>
                                                <th>Update Log</th>
                                                <th>Activity By</th>
                                                <!-- Add other user-related columns as needed -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM log_activities ORDER BY dateTime DESC";
                                            $query = $conn->query($sql);
                                            if ($query->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($query)) {
                                                    $i++;
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row['dateTime']; ?></td>
                                                        <td><?php echo $row['database_name']; ?></td>
                                                        <td><?php echo $row['update_log']; ?></td>
                                                        <td><?php echo $row['users']; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>

                                                <tr>
                                                    <td colspan='4'>No recent updates found</td>
                                                </tr>

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

                    <!-- Content Row -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
            <?php include "components/footer.php" ?>
            <!-- Footer -->
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#tabel-data').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "fetchLog.php",
                    order: [[0, 'desc']],
                });

                $(document).ready(function(){
                    // Draw the table
                    table.draw();
                });

            // Create a bar chart for Oracle and Non-Oracle DBs
            var ctx = document.getElementById('dbChart').getContext('2d');
            var totalDbOracle = <?php echo $total_dboracle; ?>;
            var totalDbNonOracle = <?php echo $total_dbnonoracle; ?>;

            var dbChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Oracle', 'Non-Oracle'],
                    datasets: [{
                        label: 'Number of Databases',
                        data: [totalDbOracle, totalDbNonOracle],
                        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                        borderColor: ['rgba(255,99,132,1)', 'rgba(54, 162, 235, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Display total DB above the chart
            var totalDbElement = document.getElementById('totalDb');
            totalDbElement.innerHTML = totalDbOracle + totalDbNonOracle;
        });
    </script>

</body>

</html>