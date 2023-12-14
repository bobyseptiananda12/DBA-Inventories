<?php
session_start();
$name = $_SESSION['name'];
$usertype = $_SESSION['usertype']; // Adjust this line based on your session variable
$username = $_SESSION['username'];
// Check if the user is an admin
$isAdmin = ($usertype === 'admin');

if (!isset($_SESSION['username'])) {
    header("Location: page/login.html");
} ?>
<!DOCTYPE html>
<html lang="en">
<?php $halaman = "DB Oracle-Prod" ?>

<head>
    <?php include "components/header.php"; ?>
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script type="text/javascript">
    $(document).ready(function() {
        var checkbox = $('table tbody input[type="checkbox"]');
        $("#selectAll").click(function() {
            if (this.checked) {
                checkbox.each(function() {
                    this.checked = true;
                });
            } else {
                checkbox.each(function() {
                    this.checked = false;
                });
            }
        });
        checkbox.click(function() {
            if (!this.checked) {
                $("#selectAll").prop("checked", false);
            }
        });
    });
    </script>
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
                    <h1 class="h3 mb-2 text-gray-800">DB Non-Oracle</h1>
                    <!-- DataTables -->
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    ini_set('max_execution_time', 0);
                    date_default_timezone_set('Asia/Jakarta');
                    include "../config.php";
                    $id = $_POST['id'];
                    $Tanggal = $_POST['Tanggal'];
                    $IP = $_POST['IP'];
                    $Server_Name = $_POST['Server_Name'];
                    $DB_Type = $_POST['DB_Type'];
                    $Versi_DB = $_POST['Versi_DB'];
                    $DATA_DIR = $_POST['DATA_DIR'];
                    $LOG_AUDIT = $_POST['LOG_AUDIT'];
                    $BACKUP_DR = $_POST['BACKUP_DR'];
                    $WHITELIST = $_POST['WHITELIST'];
                    $KET_MANAGE_DB = $_POST['KET_MANAGE_DB'];
                    $KET_DARI_SYSADMIN = $_POST['KET_DARI_SYSADMIN'];
                    $Kategori_DB = $_POST['Kategori_DB'];
                    $PIC = $_POST['PIC'];
                    $NOTE = $_POST['NOTE'];
                    $binlog = $_POST['binlog'];
                    $Tujuan_Penggunaan = $_POST['Tujuan_Penggunaan'];

                    if (isset($_POST['tambah'])) {
                        //tambah
                        $sql = "INSERT INTO dbnonoracle VALUES ('', '$Tanggal', '$IP', '$Server_Name', '$DB_Type', '$Versi_DB', '$DATA_DIR', '$LOG_AUDIT', '$BACKUP_DR', '$WHITELIST', '$KET_MANAGE_DB', '$KET_DARI_SYSADMIN', '$Kategori_DB', '$PIC', '$NOTE', '$binlog', '$Tujuan_Penggunaan', CURRENT_TIMESTAMP(), '$username', CURRENT_TIMESTAMP(), '$username')";
                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "Records inserted successfully.";

                            // Menambahkan log ke dalam tabel log activities
                            $timestamp = date("Y-m-d H:i:s");
                            $database = "dbnonoracle";
                            $update_log = "Added record with Server_Name: $Server_Name";

                            $sql_log = "INSERT INTO log_activities (`dateTime`, `database_name`, `update_log`, `users`) 
                            VALUES ('$timestamp', '$database', '$update_log', '$username')";

                            if (mysqli_query($conn, $sql_log)) {
                                // Berhasil mencatat log aktivitas
                            } else {
                                echo "ERROR: Could not able to execute $sql_log. " . mysqli_error($conn);
                            }

                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    }

                    if (isset($_POST['edit'])) {
                        // Retrieve current values before the update
                        $sql_before_update = "SELECT * FROM dbnonoracle WHERE id = '$id'";
                        $result_before_update = mysqli_query($conn, $sql_before_update);
                        $row_before_update = mysqli_fetch_assoc($result_before_update);
                    
                        // Update the record
                        $sql = "UPDATE dbnonoracle SET Tanggal = '$Tanggal', IP = '$IP', Server_Name = '$Server_Name', DB_Type = '$DB_Type', Versi_DB = '$Versi_DB', DATA_DIR = '$DATA_DIR', `LOG_AUDIT` = '$LOG_AUDIT', BACKUP_DR = '$BACKUP_DR', WHITELIST = '$WHITELIST', KET_MANAGE_DB = '$KET_MANAGE_DB', KET_DARI_SYSADMIN = '$KET_DARI_SYSADMIN', Kategori_DB = '$Kategori_DB', PIC = '$PIC', NOTE = '$NOTE', binlog = '$binlog', Tujuan_Penggunaan = '$Tujuan_Penggunaan', lastUpdatedAt = CURRENT_TIMESTAMP() WHERE id = '$id'";
                    
                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "Records updated successfully.";
                    
                            // Retrieve updated values after the update
                            $sql_after_update = "SELECT * FROM dbnonoracle WHERE id = '$id'";
                            $result_after_update = mysqli_query($conn, $sql_after_update);
                            $row_after_update = mysqli_fetch_assoc($result_after_update);
                    
                            // Compare the values and create a log message
                            $update_log = "Edited record with Server_Name: $Server_Name. Changes:";
                            foreach ($row_before_update as $key => $value_before) {
                                $value_after = $row_after_update[$key];
                                if ($value_before != $value_after) {
                                    $update_log .= " $key: $value_before to $value_after,";
                                }
                            }
                    
                            // Remove the trailing comma
                            $update_log = rtrim($update_log, ',');
                    
                            // Insert the log into the log activities table
                            $timestamp = date("Y-m-d H:i:s");
                            $database = "dbnonoracle";
                            $sql_log = "INSERT INTO log_activities (`dateTime`, `database_name`, `update_log`, `users`) 
                                        VALUES ('$timestamp', '$database', '$update_log', '$username')";
                    
                            if (mysqli_query($conn, $sql_log)) {
                                // Successfully logged the activity
                            } else {
                                echo "ERROR: Could not able to execute $sql_log. " . mysqli_error($conn);
                            }
                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    }

                    if (isset($_POST['delete'])) {
                        // Mengambil data sebelum dihapus
                        $sql_select = "SELECT * FROM dbnonoracle WHERE id = '$id'";
                        $result = mysqli_query($conn, $sql_select);
                        $deleted_data = mysqli_fetch_assoc($result);
                    
                        // Operasi DELETE
                        $sql_delete = "DELETE FROM dbnonoracle WHERE id = '$id'";
                        if (mysqli_query($conn, $sql_delete)) {
                            $nilaihasil = "Records deleted successfully.";
                    
                            // Menambahkan log ke dalam tabel log activities
                            $timestamp = date("Y-m-d H:i:s");
                            $database = "dbnonoracle";
                    
                            // Modify this line to include information about the deleted record
                            $update_log = "Deleted record with ID: $id, Server_Name: {$deleted_data['Server_Name']}, IP: {$deleted_data['IP']}";
                    
                            $sql_log = "INSERT INTO log_activities (`dateTime`, `database_name`, `update_log`, `users`) 
                                        VALUES ('$timestamp', '$database', '$update_log', '$username')";
                    
                            if (mysqli_query($conn, $sql_log)) {
                                // Berhasil mencatat log aktivitas
                            } else {
                                echo "ERROR: Could not able to execute $sql_log. " . mysqli_error($conn);
                            }
                        } else {
                            echo "ERROR: Could not able to execute $sql_delete. " . mysqli_error($conn);
                        }
                    }

                    if (isset($_POST['deleteall'])) {
                        //delete
                        $pilih = $_POST['pilih'];
                        $sql = "DELETE FROM dbnonoracle WHERE id IN (" . implode(",", $pilih) . ")";
                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "Records deleted successfully.";
                        } else {
                            // echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    }

                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List Inventory DB Non-Oracle</h6>
                            <a href="#addDbModal" class="btn btn-success" data-toggle="modal">New Record</a>
                            <input type="submit" name="deleteall" value="Delete Selected" class="btn btn-danger"
                                onclick="return confirm('Are you sure delete selected records?')">
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
                                                <th>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="selectAll">
                                                        <label for="selectAll"></label>
                                                    </span>
                                                </th>
                                                <th>Action</th>
                                                <th>IP</th>
                                                <th>Server_Name</th>
                                                <th>DB_Type</th>
                                                <th>Versi_DB</th>
                                                <th>Tujuan Penggunaan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM dbnonoracle";
                                            $query = $conn->query($sql);
                                            while ($row = mysqli_fetch_array($query)) {
                                                $i++;
                                            ?>
                                            <tr>
                                                <td>
                                                    <span class="custom-checkbox">
                                                        <input type="checkbox" id="checkbox5" name="pilih[]"
                                                            value="<?php echo $row['id']; ?>">
                                                        <label for="checkbox5"></label>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#viewDbModal<?php echo $row['id']; ?>" class="view"
                                                        data-toggle="modal"><i class="fas fa-search"
                                                            data-toggle="tooltip" title="View">&#xE254;</i></a>
                                                    <a href="#editDbModal<?php echo $row['id']; ?>" class="edit"
                                                        data-toggle="modal"><i class="fas fa-edit" data-toggle="tooltip"
                                                            title="Edit">&#xE254;</i></a>
                                                    <a href="#deleteDbModal<?php echo $row['id']; ?>" class="delete"
                                                        data-toggle="modal"><i class="fas fa-trash-alt"
                                                            data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                                                </td>
                                                <td><?php echo $row['IP']; ?></td>
                                                <td><?php echo $row['Server_Name']; ?></td>
                                                <td><?php echo $row['DB_Type']; ?></td>
                                                <td><?php echo $row['Versi_DB']; ?></td>
                                                <td><?php echo $row['Tujuan_Penggunaan']; ?></td>
                                            </tr>
                                            <!-- View Modal HTML -->
                                            <div id="viewDbModal<?php echo $row['id']; ?>" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="">
                                                            <input type="hidden" class="form-control"
                                                                value="<?php echo $row['id']; ?>" name="id" required>
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">View</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Tanggal</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Tanggal']; ?>"
                                                                        name="Tanggal" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>IP</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['IP']; ?>" name="IP"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Server_Name</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Server_Name']; ?>"
                                                                        name="Server_Name" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>DB_Type</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['DB_Type']; ?>"
                                                                        name="DB_Type" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Versi_DB</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Versi_DB']; ?>"
                                                                        name="Versi_DB" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>DATA_DIR</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['DATA_DIR']; ?>"
                                                                        name="DATA_DIR" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>LOG_AUDIT</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['LOG_AUDIT']; ?>"
                                                                        name="LOG_AUDIT" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>BACKUP_DR</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['BACKUP_DR']; ?>"
                                                                        name="BACKUP_DR" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>WHITELIST</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['WHITELIST']; ?>"
                                                                        name="WHITELIST" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>KET_MANAGE_DB</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['KET_MANAGE_DB']; ?>"
                                                                        name="KET_MANAGE_DB" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>KET_DARI_SYSADMIN</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['KET_DARI_SYSADMIN']; ?>"
                                                                        name="KET_DARI_SYSADMIN" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Kategori_DB</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Kategori_DB']; ?>"
                                                                        name="Kategori_DB" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>PIC</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['PIC']; ?>" name="PIC"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>NOTE</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['NOTE']; ?>" name="NOTE"
                                                                        disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Binlog (mysql) dan Wal Archive
                                                                        (postgresql)</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['binlog']; ?>"
                                                                        name="binlog" disabled>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Tujuan_Penggunaan</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Tujuan_Penggunaan']; ?>"
                                                                        name="Tujuan_Penggunaan" disabled>
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
                                            <div id="editDbModal<?php echo $row['id']; ?>" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="">
                                                            <input type="hidden" class="form-control"
                                                                value="<?php echo $row['id']; ?>" name="id" required>
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Edit</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Tanggal</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Tanggal']; ?>"
                                                                        name="Tanggal" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>IP</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['IP']; ?>" name="IP"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Server_Name</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Server_Name']; ?>"
                                                                        name="Server_Name" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>DB_Type</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['DB_Type']; ?>"
                                                                        name="DB_Type" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Versi_DB</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Versi_DB']; ?>"
                                                                        name="Versi_DB" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>DATA_DIR</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['DATA_DIR']; ?>"
                                                                        name="DATA_DIR" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>LOG_AUDIT</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['LOG_AUDIT']; ?>"
                                                                        name="LOG_AUDIT" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>BACKUP_DR</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['BACKUP_DR']; ?>"
                                                                        name="BACKUP_DR" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>WHITELIST</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['WHITELIST']; ?>"
                                                                        name="WHITELIST" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>KET_MANAGE_DB</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['KET_MANAGE_DB']; ?>"
                                                                        name="KET_MANAGE_DB" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>KET_DARI_SYSADMIN</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['KET_DARI_SYSADMIN']; ?>"
                                                                        name="KET_DARI_SYSADMIN" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Kategori_DB</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['Kategori_DB']; ?>"
                                                                        name="Kategori_DB" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>PIC</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['PIC']; ?>" name="PIC"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>NOTE</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['NOTE']; ?>" name="NOTE"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Binlog (mysql) dan Wal Archive
                                                                        (postgresql)</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['binlog']; ?>"
                                                                        name="binlog" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Tujuan Penggunaan</label>
                                                                    <select class="form-control"
                                                                        name="Tujuan_Penggunaan" required>
                                                                        <option value="" disabled>Select one</option>
                                                                        <option value="Production"
                                                                            <?php echo ($row['Tujuan_Penggunaan'] == 'Production') ? 'selected' : ''; ?>>
                                                                            Production</option>
                                                                        <option value="Development"
                                                                            <?php echo ($row['Tujuan_Penggunaan'] == 'Development') ? 'selected' : ''; ?>>
                                                                            Development</option>
                                                                        <option value="SIT-UAT"
                                                                            <?php echo ($row['Tujuan_Penggunaan'] == 'SIT-UAT') ? 'selected' : ''; ?>>
                                                                            SIT-UAT</option>
                                                                    </select>
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
                                            <div id="deleteDbModal<?php echo $row['id']; ?>" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="">
                                                            <input type="hidden" class="form-control"
                                                                value="<?php echo $row['id']; ?>" name="id" required>
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete</h4>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete these Records
                                                                    <?php echo $row['Hostname']; ?>?</p>
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
                    <div id="addDbModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="text" class="form-control" name="Tanggal" required>
                                        </div>
                                        <div class="form-group">
                                            <label>IP</label>
                                            <input type="text" class="form-control" name="IP" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Server_Name</label>
                                            <input type="text" class="form-control" name="Server_Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>DB_Type</label>
                                            <input type="text" class="form-control" name="DB_Type" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Versi_DB</label>
                                            <input type="text" class="form-control" name="Versi_DB" required>
                                        </div>
                                        <div class="form-group">
                                            <label>DATA_DIR</label>
                                            <input type="text" class="form-control" name="DATA_DIR" required>
                                        </div>
                                        <div class="form-group">
                                            <label>LOG_AUDIT</label>
                                            <input type="text" class="form-control" name="LOG_AUDIT" required>
                                        </div>
                                        <div class="form-group">
                                            <label>BACKUP_DR</label>
                                            <input type="text" class="form-control" name="BACKUP_DR" required>
                                        </div>
                                        <div class="form-group">
                                            <label>WHITELIST</label>
                                            <input type="text" class="form-control" ame="WHITELIST" required>
                                        </div>
                                        <div class="form-group">
                                            <label>KET_MANAGE_DB</label>
                                            <input type="text" class="form-control" name="KET_MANAGE_DB" required>
                                        </div>
                                        <div class="form-group">
                                            <label>KET_DARI_SYSADMIN</label>
                                            <input type="text" class="form-control" name="KET_DARI_SYSADMIN" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Kategori_DB</label>
                                            <input type="text" class="form-control" name="Kategori_DB" required>
                                        </div>
                                        <div class="form-group">
                                            <label>PIC</label>
                                            <input type="text" class="form-control" name="PIC" required>
                                        </div>
                                        <div class="form-group">
                                            <label>NOTE</label>
                                            <input type="text" class="form-control" name="NOTE" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Binlog (mysql) dan Wal Archive (postgresql)</label>
                                            <input type="text" class="form-control" name="binlog" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Tujuan Penggunaan</label>
                                            <select class="form-control" name="Tujuan_Penggunaan" required>
                                                <option value="" disabled selected>Select one</option>
                                                <option value="Production">Production</option>
                                                <option value="Development">Development</option>
                                                <option value="SIT-UAT">SIT-UAT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal"
                                            value="Cancel">
                                        <input type="submit" class="btn btn-success" value="Add" name="tambah">
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