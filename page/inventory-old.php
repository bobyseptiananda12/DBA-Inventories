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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Inventory DBA</h1>
                        <a href="#" id="exportButton" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Export Excel</a>
                    </div>
                    <!-- DataTables -->
                    <?php
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    ini_set('max_execution_time', 0);
                    date_default_timezone_set('Asia/Jakarta');
                    include "../config.php";
                    $id = $_POST['id'];
                    $Tanggal = $_POST['Tanggal'];
                    $Hostname = $_POST['Hostname'];
                    $DB_Name = $_POST['DB_Name'];
                    $App_Name = $_POST['App_Name'];
                    $Jenis_DB = $_POST['Jenis_DB'];
                    $Type = $_POST['Type'];
                    $Kategori = $_POST['Kategori'];
                    $IP_PUBLIC = $_POST['IP_PUBLIC'];
                    $IP_VIP = $_POST['IP_VIP'];
                    $IP_BACKUP = $_POST['IP_BACKUP'];
                    $LOG_AUDIT = $_POST['LOG_AUDIT'];
                    $BACKUP = $_POST['BACKUP'];
                    $WHITELIST = $_POST['WHITELIST'];
                    $DISK_TYPE = $_POST['DISK_TYPE'];
                    $PDB = $_POST['PDB'];
                    $PORT = $_POST['PORT'];
                    $Lokasi = $_POST['Lokasi'];
                    $Tier = $_POST['Tier'];
                    $Oracle_Version = $_POST['Oracle_Version'];
                    $Cluster = $_POST['Cluster'];
                    $OS_Version = $_POST['OS_Version'];
                    $Core = $_POST['Core'];
                    $Socket = $_POST['Socket'];
                    $CPU = $_POST['CPU'];
                    $PIC = $_POST['PIC'];
                    $Keterangan = $_POST['Keterangan'];
                    $Note1 = $_POST['Note1'];
                    $Note2 = $_POST['Note2'];

                    if (isset($_POST['tambah'])) {
                        //tambah
                        $sql = "INSERT INTO inventorydba VALUES ('', '$Tanggal', '$Hostname', '$DB_Name', '$App_Name', '$Jenis_DB', '$Type', '$Kategori', '$IP_PUBLIC', '$IP_VIP', '$IP_BACKUP', '$LOG_AUDIT', '$BACKUP', '$WHITELIST', '$DISK_TYPE', '$PDB', '$PORT','$Lokasi', '$Tier', '$Oracle_Version', '$Cluster', '$OS_Version', '$Core', '$Socket', '$CPU', '$PIC', '$Keterangan', '$Note1', '$Note2', CURRENT_TIMESTAMP() , '$username', CURRENT_TIMESTAMP() , '$username')";
                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "Records inserted successfully.";

                            // Menambahkan log ke dalam tabel log activities
                            $timestamp = date("Y-m-d H:i:s");
                            $database = "inventorydba";
                            $update_log = "Added record with Hostname: $Hostname, DB_Name: $DB_Name, App_Name: $App_Name";

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
                        $sql_before_update = "SELECT * FROM inventorydba WHERE id = '$id'";
                        $result_before_update = mysqli_query($conn, $sql_before_update);
                        $row_before_update = mysqli_fetch_assoc($result_before_update);

                        // Update the record
                        $sql = "UPDATE inventorydba SET Tanggal = '$Tanggal', Hostname = '$Hostname', `DB_Name` = '$DB_Name', App_Name = '$App_Name', Jenis_DB = '$Jenis_DB', `Type` = '$Type', `Kategori` = '$Kategori', IP_PUBLIC = '$IP_PUBLIC', IP_VIP = '$IP_VIP', IP_BACKUP = '$IP_BACKUP', LOG_AUDIT = '$LOG_AUDIT', `BACKUP` = '$BACKUP', WHITELIST = '$WHITELIST', DISK_TYPE = '$DISK_TYPE', PDB = '$PDB', PORT = '$PORT', Lokasi = '$Lokasi', Tier = '$Tier', Oracle_Version = '$Oracle_Version', Cluster = '$Cluster', OS_Version = '$OS_Version', Core = '$Core', Socket = '$Socket', CPU = '$CPU', PIC = '$PIC', Keterangan = '$Keterangan', Note1 = '$Note1', Note2 = '$Note2', lastUpdatedAt = CURRENT_TIMESTAMP() WHERE id = '$id'";

                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "Records updated successfully.";

                            // Retrieve updated values after the update
                            $sql_after_update = "SELECT * FROM inventorydba WHERE id = '$id'";
                            $result_after_update = mysqli_query($conn, $sql_after_update);
                            $row_after_update = mysqli_fetch_assoc($result_after_update);

                            // Compare the values and create a log message
                            $update_log = "Edited record with Hostname: $Hostname, DB_Name: $DB_Name, App_Name: $App_Name. Changes:";
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
                            $database = "inventorydba";
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
                        $sql_select = "SELECT * FROM inventorydba WHERE id = '$id'";
                        $result = mysqli_query($conn, $sql_select);
                        $deleted_data = mysqli_fetch_assoc($result);

                        // Operasi DELETE
                        $sql_delete = "DELETE FROM inventorydba WHERE id = '$id'";
                        if (mysqli_query($conn, $sql_delete)) {
                            $nilaihasil = "Records deleted successfully.";

                            // Menambahkan log ke dalam tabel log activities
                            $timestamp = date("Y-m-d H:i:s");
                            $database = "inventorydba";

                            // Modify this line to include information about the deleted record
                            $update_log = "Deleted record with ID: $id, Hostname: {$deleted_data['Hostname']}, DB_Name: {$deleted_data['DB_Name']}, App_Name: {$deleted_data['App_Name']}";

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
                        $sql = "DELETE FROM inventorydba WHERE id IN (" . implode(",", $pilih) . ")";
                        if (mysqli_query($conn, $sql)) {
                            $nilaihasil = "Records deleted successfully.";
                        } else {
                            // echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                        }
                    }

                    ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">List Database</h5>
                            <a href="#addDbModal" class="btn btn-success" data-toggle="modal">New Data</a>
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
                                                <th>Tanggal</th>
                                                <th>Hostname</th>
                                                <th>DB_Name</th>
                                                <th>App_Name</th>
                                                <th>Jenis_DB</th>
                                                <th>Type</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            $sql = "SELECT * FROM inventorydba LIMIT 10";
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
                                                <td><?php echo $row['Tanggal']; ?></td>
                                                <td><?php echo $row['Hostname']; ?></td>
                                                <td><?php echo $row['DB_Name']; ?></td>
                                                <td><?php echo $row['App_Name']; ?></td>
                                                <td><?php echo $row['Jenis_DB']; ?></td>
                                                <td><?php echo $row['Type']; ?></td>
                                                <td><?php echo $row['Kategori']; ?></td>
                                            </tr>
                                            <!-- View Modal HTML -->
                                            <div id="viewDbModal<?php echo $row['id']; ?>" class="modal fade"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" style="max-width:1280px;">
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
                                                                <div class="row">
                                                                    <div class="col">

                                                                        <div class="form-group">
                                                                            <label>Tanggal</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Tanggal']; ?>"
                                                                                name="Tanggal" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Hostname</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Hostname']; ?>"
                                                                                name="Hostname" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>DB_Name</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['DB_Name']; ?>"
                                                                                name="DB_Name" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>App_Name</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['App_Name']; ?>"
                                                                                name="App_Name" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Jenis_DB</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Jenis_DB']; ?>"
                                                                                name="Jenis_DB" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Type</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Type']; ?>"
                                                                                name="Type" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Kategori</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Kategori']; ?>"
                                                                                name="Kategori" disabled>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>IP_PUBLIC</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['IP_PUBLIC']; ?>"
                                                                                name="IP_PUBLIC" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>IP_VIP</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['IP_VIP']; ?>"
                                                                                name="IP_VIP" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>IP_BACKUP</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['IP_BACKUP']; ?>"
                                                                                name="IP_BACKUP" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>LOG_AUDIT</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['LOG_AUDIT']; ?>"
                                                                                name="LOG_AUDIT" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>BACKUP</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['BACKUP']; ?>"
                                                                                name="BACKUP" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>WHITELIST</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['WHITELIST']; ?>"
                                                                                name="WHITELIST" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>DISK_TYPE</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['DISK_TYPE']; ?>"
                                                                                name="DISK_TYPE" disabled>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>PDB</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['PDB']; ?>"
                                                                                name="PDB" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>PORT</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['PORT']; ?>"
                                                                                name="PORT" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Lokasi</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Lokasi']; ?>"
                                                                                name="Lokasi" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Tier</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Tier']; ?>"
                                                                                name="Tier" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Oracle_Version</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Oracle_Version'];  ?>"
                                                                                name="Oracle_Version" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Cluster</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Cluster']; ?>"
                                                                                name="Cluster" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>OS_Version</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['OS_Version']; ?>"
                                                                                name="OS_Version" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">

                                                                        <div class="form-group">
                                                                            <label>Core</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Core']; ?>"
                                                                                name="Core" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Socket</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Socket']; ?>"
                                                                                name="Socket" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>CPU</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['CPU']; ?>"
                                                                                name="CPU" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>PIC</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['PIC']; ?>"
                                                                                name="PIC" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Keterangan</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Keterangan']; ?>"
                                                                                name="Keterangan" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Note1</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Note1']; ?>"
                                                                                name="Note1" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Note2</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Note2']; ?>"
                                                                                name="Note2" disabled>
                                                                        </div>
                                                                    </div>
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
                                                <div class="modal-dialog" style="max-width:1280px;">
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
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Tanggal</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Tanggal']; ?>"
                                                                                name="Tanggal" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Hostname</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Hostname']; ?>"
                                                                                name="Hostname" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>DB_Name</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['DB_Name']; ?>"
                                                                                name="DB_Name" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>App_Name</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['App_Name']; ?>"
                                                                                name="App_Name" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Jenis_DB</label>
                                                                            <select class="form-control" name="Jenis_DB"
                                                                                required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="Oracle"
                                                                                    <?php echo ($row['Jenis_DB'] == 'Oracle') ? 'selected' : ''; ?>>
                                                                                    Oracle</option>
                                                                                <option value="MariaDB"
                                                                                    <?php echo ($row['Jenis_DB'] == 'MariaDB') ? 'selected' : ''; ?>>
                                                                                    MariaDB</option>
                                                                                <option value="Galera"
                                                                                    <?php echo ($row['Jenis_DB'] == 'Galera') ? 'selected' : ''; ?>>
                                                                                    Galera</option>
                                                                                <option value="GreenPlum"
                                                                                    <?php echo ($row['Jenis_DB'] == 'GreenPlum') ? 'selected' : ''; ?>>
                                                                                    GreenPlum</option>
                                                                                <option value="MongoDB"
                                                                                    <?php echo ($row['Jenis_DB'] == 'MongoDB') ? 'selected' : ''; ?>>
                                                                                    MongoDB</option>
                                                                                <option value="MySQL"
                                                                                    <?php echo ($row['Jenis_DB'] == 'MySQL') ? 'selected' : ''; ?>>
                                                                                    MySQL</option>
                                                                                <option value="Postgre-arcgis"
                                                                                    <?php echo ($row['Jenis_DB'] == 'Postgre-arcgis') ? 'selected' : ''; ?>>
                                                                                    Postgre-arcgis</option>
                                                                                <option value="PostgreSQL"
                                                                                    <?php echo ($row['Jenis_DB'] == 'PostgreSQL') ? 'selected' : ''; ?>>
                                                                                    PostgreSQL</option>
                                                                                <option value="VDMS"
                                                                                    <?php echo ($row['Jenis_DB'] == 'VDMS') ? 'selected' : ''; ?>>
                                                                                    VDMS</option>
                                                                                <option value="Neo4j"
                                                                                    <?php echo ($row['Jenis_DB'] == 'Neo4j') ? 'selected' : ''; ?>>
                                                                                    Neo4j</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Type</label>
                                                                            <select class="form-control" name="Type"
                                                                                required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="RAC"
                                                                                    <?php echo ($row['Type'] == 'RAC') ? 'selected' : ''; ?>>
                                                                                    RAC</option>
                                                                                <option value="Single"
                                                                                    <?php echo ($row['Type'] == 'Single') ? 'selected' : ''; ?>>
                                                                                    Single</option>
                                                                                <option value="NA"
                                                                                    <?php echo ($row['Type'] == 'NA') ? 'selected' : ''; ?>>
                                                                                    -</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Kategori</label>
                                                                            <select class="form-control" name="Type"
                                                                                required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="Prod"
                                                                                    <?php echo ($row['Kategori'] == 'Prod') ? 'selected' : ''; ?>>
                                                                                    Prod</option>
                                                                                <option value="Dev"
                                                                                    <?php echo ($row['Kategori'] == 'Dev') ? 'selected' : ''; ?>>
                                                                                    Dev</option>
                                                                                <option value="SIT"
                                                                                    <?php echo ($row['Kategori'] == 'SIT') ? 'selected' : ''; ?>>
                                                                                    SIT</option>
                                                                                <option value="UAT"
                                                                                    <?php echo ($row['Kategori'] == 'UAT') ? 'selected' : ''; ?>>
                                                                                    UAT</option>
                                                                                <option value="QA"
                                                                                    <?php echo ($row['Kategori'] == 'QA') ? 'selected' : ''; ?>>
                                                                                    QA</option>
                                                                                <option value="Konfirmasi"
                                                                                    <?php echo ($row['Kategori'] == 'Konfirmasi') ? 'selected' : ''; ?>>
                                                                                    (Perlu dikonfirmasi ke user)
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>IP_PUBLIC</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['IP_PUBLIC']; ?>"
                                                                                name="IP_PUBLIC" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>IP_VIP</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['IP_VIP']; ?>"
                                                                                name="IP_VIP" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>IP_BACKUP</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['IP_BACKUP']; ?>"
                                                                                name="IP_BACKUP" required>
                                                                        </div>
                                                                            <div class="form-group">
                                                                                <label>LOG_AUDIT (Y/N)</label>
                                                                                <select class="form-control" name="LOG_AUDIT"
                                                                                    required>
                                                                                    <option value="" disabled>Select one
                                                                                    </option>
                                                                                    <option value="Y"
                                                                                        <?php echo ($row['LOG_AUDIT'] == 'Y') ? 'selected' : ''; ?>>
                                                                                        Y</option>
                                                                                    <option value="N"
                                                                                        <?php echo ($row['LOG_AUDIT'] == 'N') ? 'selected' : ''; ?>>
                                                                                        N</option>
                                                                                </select>
                                                                            </div>
                                                                        <div class="form-group">
                                                                            <label>BACKUP (Y/N)</label>
                                                                            <select class="form-control" name="BACKUP"
                                                                                required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="Y"
                                                                                    <?php echo ($row['BACKUP'] == 'Y') ? 'selected' : ''; ?>>
                                                                                    Y</option>
                                                                                <option value="N"
                                                                                    <?php echo ($row['BACKUP'] == 'N') ? 'selected' : ''; ?>>
                                                                                    N</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Whitelist (Y/N)</label>
                                                                            <select class="form-control"
                                                                                name="WHITELIST" required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="Y"
                                                                                    <?php echo ($row['WHITELIST'] == 'Y') ? 'selected' : ''; ?>>
                                                                                    Y</option>
                                                                                <option value="N"
                                                                                    <?php echo ($row['WHITELIST'] == 'N') ? 'selected' : ''; ?>>
                                                                                    N</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>DISK_TYPE</label>
                                                                            <select class="form-control"
                                                                                name="DISK_TYPE" required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="Production"
                                                                                    <?php echo ($row['DISK_TYPE'] == 'ASM') ? 'selected' : ''; ?>>
                                                                                    ASM</option>
                                                                                <option value="Development"
                                                                                    <?php echo ($row['DISK_TYPE'] == 'Filesystem') ? 'selected' : ''; ?>>
                                                                                    Filesystem</option>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>PDB</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['PDB']; ?>"
                                                                                name="PDB" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>PORT</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['PORT']; ?>"
                                                                                name="PORT" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Lokasi</label>
                                                                            <select class="form-control" name="Lokasi"
                                                                                required>
                                                                                <option value="" disabled>Select one
                                                                                </option>
                                                                                <option value="RAC"
                                                                                    <?php echo ($row['Lokasi'] == 'JTN') ? 'selected' : ''; ?>>
                                                                                    JTN</option>
                                                                                <option value="Single"
                                                                                    <?php echo ($row['Lokasi'] == 'STL') ? 'selected' : ''; ?>>
                                                                                    STL</option>
                                                                                <option value="Single"
                                                                                    <?php echo ($row['Lokasi'] == 'JTST') ? 'selected' : ''; ?>>
                                                                                    JT - ST</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Tier</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Tier']; ?>"
                                                                                name="Tier" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Oracle_Version</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Oracle_Version']; ?>"
                                                                                name="Oracle_Version" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Cluster</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Cluster']; ?>"
                                                                                name="Cluster" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>OS_Version</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['OS_Version']; ?>"
                                                                                name="OS_Version" required>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-group">
                                                                            <label>Core</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Core']; ?>"
                                                                                name="Core" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Socket</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Socket']; ?>"
                                                                                name="Socket" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>CPU</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['CPU']; ?>"
                                                                                name="CPU" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>PIC</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo  $row['PIC'];  ?>"
                                                                                name="PIC" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Keterangan</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Keterangan']; ?>"
                                                                                name="Keterangan" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Note1</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Note1']; ?>"
                                                                                name="Note1" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Note2</label>
                                                                            <input type="text" class="form-control"
                                                                                value="<?php echo $row['Note2']; ?>"
                                                                                name="Note2" required>
                                                                        </div>
                                                                    </div>
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
                        <div class="modal-dialog" style="max-width: 1280px;">
                            <div class="modal-content">
                                <form method="post" action="">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="text" class="form-control" name="Tanggal" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Hostname</label>
                                                    <input type="text" class="form-control" name="Hostname" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>DB_Name</label>
                                                    <input type="text" class="form-control" name="DB_Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>App_Name</label>
                                                    <input type="text" class="form-control" name="App_Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis_DB</label>
                                                    <select class="form-control" name="Jenis_DB" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Oracle">Oracle</option>
                                                        <option value="MariaDB">MariaDB</option>
                                                        <option value="Galera">Galera</option>
                                                        <option value="GreenPlum">GreenPlum</option>
                                                        <option value="MongoDB">MongoDB</option>
                                                        <option value="MySQL">MySQL</option>
                                                        <option value="Postgre-arcgis">Postgre-arcgis</option>
                                                        <option value="PostgreSQL">PostgreSQL</option>
                                                        <option value="VDMS">VDMS</option>
                                                        <option value="Neo4j">Neo4j</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control" name="Type" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="RAC">RAC</option>
                                                        <option value="Single">Single</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="form-control" name="Kategori" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Prod">Prod</option>
                                                        <option value="Dev">Dev</option>
                                                        <option value="SIT">SIT</option>
                                                        <option value="UAT">UAT</option>
                                                        <option value="QA">QA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>IP_PUBLIC</label>
                                                    <input type="text" class="form-control" name="IP_PUBLIC" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>IP_VIP</label>
                                                    <input type="text" class="form-control" name="IP_VIP" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>IP_BACKUP</label>
                                                    <input type="text" class="form-control" name="IP_BACKUP" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>LOG_AUDIT (Y/N)</label>
                                                    <select class="form-control" name="LOG_AUDIT" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>BACKUP (Y/N)</label>
                                                    <select class="form-control" name="BACKUP" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>WHITELIST (Y/N)</label>
                                                    <select class="form-control" name="WHITELIST" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>DISK_TYPE</label>
                                                    <select class="form-control" name="DISK_TYPE" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="ASM">ASM</option>
                                                        <option value="Filesystem">Filesystem</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>PDB</label>
                                                    <input type="text" class="form-control" name="PDB" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>PORT</label>
                                                    <input type="text" class="form-control" name="PORT" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lokasi</label>
                                                    <select class="form-control" name="Lokasi" required>
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="JTN">JTN</option>
                                                        <option value="STL">STL</option>
                                                        <option value="JTST">JT - ST</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tier</label>
                                                    <input type="text" class="form-control" name="Tier" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Oracle_Version</label>
                                                    <input type="text" class="form-control" name="Oracle_Version"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cluster</label>
                                                    <input type="text" class="form-control" name="Cluster" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>OS_Version</label>
                                                    <input type="text" class="form-control" name="OS_Version" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Core</label>
                                                    <input type="text" class="form-control" name="Core" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Socket</label>
                                                    <input type="text" class="form-control" name="Socket" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>CPU</label>
                                                    <input type="text" class="form-control" name="CPU" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>PIC</label>
                                                    <input type="text" class="form-control" name="PIC" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" class="form-control" name="Keterangan" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Note1</label>
                                                    <input type="text" class="form-control" name="Note1" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Note2</label>
                                                    <input type="text" class="form-control" name="Note2" required>
                                                </div>
                                            </div>
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
                $(document).ready(function(){
                    $('#tabel-data').dataTable( {
                "pageLength": 10
                } );
                });
                </script>
                <script>
                document.getElementById('exportButton').addEventListener('click', function() {
                    // Use fetch API to request the PHP script that generates the Excel file
                    fetch('export.php')
                        .then(response => response.text())
                        .then(data => {
                            // Create a Blob from the response
                            var blob = new Blob([data], {
                                type: 'application/vnd.ms-excel'
                            });

                            // Create a link element and trigger a download
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'exported_data.xls';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        })
                        .catch(error => console.error('Error:', error));
                });
                </script>

</body>

</html>