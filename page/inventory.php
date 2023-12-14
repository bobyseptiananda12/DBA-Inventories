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
<?php $halaman = "List Database" ?>

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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Inventory DBA</h1>
                        <a href="#" id="exportButton" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Export Excel</a>
                    </div>
                    <!-- DataTables -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">List Database</h5>
                            <a href="javascript:void(0);" class="btn btn-primary" onclick="addData()" > New Data </a>
                            <!-- <input type="submit" name="deleteall" value="Delete Selected" class="btn btn-danger"
                                onclick="return confirm('Are you sure delete selected records?')">
                        </div> -->
                        <!-- Tabel -->
                        <div class="card-body">
                            <form method="post" action="">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabel-data" method="post" action=""
                                        width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
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

                    <!-- View Modal HTML -->
                    <div id="dbDataModalView" class="modal fade">
                        <div class="modal-dialog" style="max-width: 1280px;">
                            <div class="modal-content">
                                <form method="post" action="">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="dbModalLabelView">View Db</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <form name="dbDataFrm" id="dbDataFrm">
                                    <div class="modal-body">
                                    <div class="frm-status"></div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" id="Tanggal2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Hostname</label>
                                                    <input type="text" class="form-control" id="Hostname2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>DB_Name</label>
                                                    <input type="text" class="form-control" id="DB_Name2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>App_Name</label>
                                                    <input type="text" class="form-control" id="App_Name2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis_DB</label>
                                                    <select class="form-control" id="Jenis_DB2" disabled>
                                                        <option value="" disabled selected></option>
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
                                                    <select class="form-control" id="Type2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="RAC">RAC</option>
                                                        <option value="Single">Single</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="form-control" id="Kategori2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="Production">Production</option>
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
                                                    <input type="text" class="form-control" id="IP_PUBLIC2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>IP_VIP</label>
                                                    <input type="text" class="form-control" id="IP_VIP2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>IP_BACKUP</label>
                                                    <input type="text" class="form-control" id="IP_BACKUP2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>LOG_AUDIT (Y/N)</label>
                                                    <select class="form-control" id="LOG_AUDIT2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>BACKUP (Y/N)</label>
                                                    <select class="form-control" id="BACKUP2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>WHITELIST (Y/N)</label>
                                                    <select class="form-control" id="WHITELIST2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>DISK_TYPE</label>
                                                    <select class="form-control" id="DISK_TYPE2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="ASM">ASM</option>
                                                        <option value="Filesystem">Filesystem</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>PDB</label>
                                                    <input type="text" class="form-control" id="PDB2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>PORT</label>
                                                    <input type="text" class="form-control" id="PORT2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Lokasi</label>
                                                    <select class="form-control" id="Lokasi2" disabled>
                                                        <option value="" disabled selected></option>
                                                        <option value="JTN">JTN</option>
                                                        <option value="STL">STL</option>
                                                        <option value="JT - ST">JT - ST</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tier</label>
                                                    <input type="text" class="form-control" id="Tier2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Oracle_Version</label>
                                                    <input type="text" class="form-control" id="Oracle_Version2"
                                                    disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cluster</label>
                                                    <input type="text" class="form-control" id="Cluster2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>OS_Version</label>
                                                    <input type="text" class="form-control" id="OS_Version2" disabled>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Core</label>
                                                    <input type="text" class="form-control" id="Core2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Socket</label>
                                                    <input type="text" class="form-control" id="Socket2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>CPU</label>
                                                    <input type="text" class="form-control" id="CPU2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>PIC</label>
                                                    <input type="text" class="form-control" id="PIC2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" class="form-control" id="Keterangan2" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Note1</label>
                                                    <input type="text" class="form-control" id="Note12" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Note2</label>
                                                    <input type="text" class="form-control" id="Note22" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>

                                    <div class="modal-footer">
                                    <input type="hidden" id="dbID" value="0">
                                    <input type="hidden" id="Username" value="<?php echo $username ?>">
                                        <input type="button" class="btn btn-default" data-dismiss="modal"
                                            value="Cancel">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add/edit Modal HTML -->
                    <div id="dbDataModal" class="modal fade">
                        <div class="modal-dialog" style="max-width: 1280px;">
                            <div class="modal-content">
                                <form method="post" action="">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="dbModalLabel">Add/Edit Db</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    </div>
                                    <form name="dbDataFrm" id="dbDataFrm">
                                    <div class="modal-body">
                                    <div class="frm-status"></div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" id="Tanggal" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Hostname</label>
                                                    <input type="text" class="form-control" id="Hostname" >
                                                </div>
                                                <div class="form-group">
                                                    <label>DB_Name</label>
                                                    <input type="text" class="form-control" id="DB_Name" >
                                                </div>
                                                <div class="form-group">
                                                    <label>App_Name</label>
                                                    <input type="text" class="form-control" id="App_Name" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis_DB</label>
                                                    <select class="form-control" id="Jenis_DB" >
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
                                                    <select class="form-control" id="Type" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="RAC">RAC</option>
                                                        <option value="Single">Single</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="form-control" id="Kategori" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Production">Production</option>
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
                                                    <input type="text" class="form-control" id="IP_PUBLIC" >
                                                </div>
                                                <div class="form-group">
                                                    <label>IP_VIP</label>
                                                    <input type="text" class="form-control" id="IP_VIP" >
                                                </div>
                                                <div class="form-group">
                                                    <label>IP_BACKUP</label>
                                                    <input type="text" class="form-control" id="IP_BACKUP" >
                                                </div>
                                                <div class="form-group">
                                                    <label>LOG_AUDIT (Y/N)</label>
                                                    <select class="form-control" id="LOG_AUDIT" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>BACKUP (Y/N)</label>
                                                    <select class="form-control" id="BACKUP" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>WHITELIST (Y/N)</label>
                                                    <select class="form-control" id="WHITELIST" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="Y">Y</option>
                                                        <option value="N">N</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>DISK_TYPE</label>
                                                    <select class="form-control" id="DISK_TYPE" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="ASM">ASM</option>
                                                        <option value="Filesystem">Filesystem</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>PDB</label>
                                                    <input type="text" class="form-control" id="PDB" >
                                                </div>
                                                <div class="form-group">
                                                    <label>PORT</label>
                                                    <input type="text" class="form-control" id="PORT" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Lokasi</label>
                                                    <select class="form-control" id="Lokasi" >
                                                        <option value="" disabled selected>Select one</option>
                                                        <option value="JTN">JTN</option>
                                                        <option value="STL">STL</option>
                                                        <option value="JT - ST">JT - ST</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Tier</label>
                                                    <input type="text" class="form-control" id="Tier" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Oracle_Version</label>
                                                    <input type="text" class="form-control" id="Oracle_Version"
                                                        >
                                                </div>
                                                <div class="form-group">
                                                    <label>Cluster</label>
                                                    <input type="text" class="form-control" id="Cluster" >
                                                </div>
                                                <div class="form-group">
                                                    <label>OS_Version</label>
                                                    <input type="text" class="form-control" id="OS_Version" >
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Core</label>
                                                    <input type="text" class="form-control" id="Core" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Socket</label>
                                                    <input type="text" class="form-control" id="Socket" >
                                                </div>
                                                <div class="form-group">
                                                    <label>CPU</label>
                                                    <input type="text" class="form-control" id="CPU" >
                                                </div>
                                                <div class="form-group">
                                                    <label>PIC</label>
                                                    <input type="text" class="form-control" id="PIC" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" class="form-control" id="Keterangan" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Note1</label>
                                                    <input type="text" class="form-control" id="Note1" >
                                                </div>
                                                <div class="form-group">
                                                    <label>Note2</label>
                                                    <input type="text" class="form-control" id="Note2" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>

                                    <div class="modal-footer">
                                    <input type="hidden" id="dbID" value="0">
                                    <input type="hidden" id="Username" value="<?php echo $username ?>">
                                        <input type="button" class="btn btn-default" data-dismiss="modal"
                                            value="Cancel">
                                        <button type="button" class="btn btn-success" onclick="submitUserData()">Submit</button>
                                    </div>
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
                // Initialize DataTables API object and configure table
                var table = $('#tabel-data').DataTable({
                    // "searching": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": "fetchDb.php",
                    columnDefs: [{
                        targets: "_all",
                        orderable: false
                    }]
                    // "ajax": {
                    //     "url": "fetchDb.php",
                    //     "data": function ( d ) {
                    //         return $.extend( {}, d, {
                    //         "search_keywords": $("#searchInput").val().toLowerCase(),
                    //         "filter_option": $("#sortBy").val().toLowerCase()
                    //         } );
                    //     }
                    // },
                });

                $('#tabel-data thead th').each(function () {
                    var title = $(this).text();
                    $(this).html(title+' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
                });

                $(document).ready(function(){
                    table.columns().every(function () {
                        var table = this;
                        $('input', this.header()).on('keyup change', function () {
                            if (table.search() !== this.value) {
                                table.search(this.value).draw();
                            }
                        });
                    });

                    // Draw the table
                    // table.draw();

                    // // Redraw the table based on the custom input
                    // $('#searchInput,#sortBy').bind("keyup change", function(){
                    //     table.draw();
                    // });
                });

                function addData(){
                    $('.frm-status').html('');
                    $('#dbModalLabel').html('Add New Database');

                    $('#Tanggal').val('');
                    $('#Hostname').val('');
                    $('#DB_Name').val('');
                    $('#App_Name').val('');
                    $('#Jenis_DB').val('');
                    $('#Type').val('');
                    $('#Kategori').val('');
                    $('#IP_PUBLIC').val('');
                    $('#IP_VIP').val('');
                    $('#IP_BACKUP').val('');
                    $('#LOG_AUDIT').val('');
                    $('#BACKUP').val('');
                    $('#WHITELIST').val('');
                    $('#DISK_TYPE').val('');
                    $('#PDB').val('');
                    $('#PORT').val('');
                    $('#Lokasi').val('');
                    $('#Tier').val('');
                    $('#Oracle_Version').val('');
                    $('#Cluster').val('');
                    $('#OS_Version').val('');
                    $('#Core').val('');
                    $('#Socket').val('');
                    $('#CPU').val('');
                    $('#PIC').val('');
                    $('#Keterangan').val('');
                    $('#Note1').val('');
                    $('#Note2').val('');
                    $('#Username').val('');
                    $('#dbID').val(0);
                    
                    $('#dbDataModal').modal('show');
                }

                function editData(db_data){
                    $('.frm-status').html('');
                    $('#dbModalLabel').html('Edit Database #'+db_data.Hostname);

                    $('#Tanggal').val(db_data.Tanggal);
                    $('#Hostname').val(db_data.Hostname);
                    $('#DB_Name').val(db_data.DB_Name);
                    $('#App_Name').val(db_data.App_Name);
                    $('#Jenis_DB').val(db_data.Jenis_DB);
                    $('#Type').val(db_data.Type);
                    $('#Kategori').val(db_data.Kategori);
                    $('#IP_PUBLIC').val(db_data.IP_PUBLIC);
                    $('#IP_VIP').val(db_data.IP_VIP);
                    $('#IP_BACKUP').val(db_data.IP_BACKUP);
                    $('#LOG_AUDIT').val(db_data.LOG_AUDIT);
                    $('#BACKUP').val(db_data.BACKUP);
                    $('#WHITELIST').val(db_data.WHITELIST);
                    $('#DISK_TYPE').val(db_data.DISK_TYPE);
                    $('#PDB').val(db_data.PDB);
                    $('#PORT').val(db_data.PORT);
                    $('#Lokasi').val(db_data.Lokasi);
                    $('#Tier').val(db_data.Tier);
                    $('#Oracle_Version').val(db_data.Oracle_Version);
                    $('#Cluster').val(db_data.Cluster);
                    $('#OS_Version').val(db_data.OS_Version);
                    $('#Core').val(db_data.Core);
                    $('#Socket').val(db_data.Socket);
                    $('#CPU').val(db_data.CPU);
                    $('#PIC').val(db_data.PIC);
                    $('#Keterangan').val(db_data.Keterangan);
                    $('#Note1').val(db_data.Note1);
                    $('#Note2').val(db_data.Note2);
                    $('#dbID').val(db_data.id);
                    $('#dbDataModal').modal('show');
                }

                function viewData(db_data){
                    $('.frm-status').html('');
                    $('#dbModalLabelView').html('Detail '+db_data.Hostname);

                    $('#Tanggal2').val(db_data.Tanggal);
                    $('#Hostname2').val(db_data.Hostname);
                    $('#DB_Name2').val(db_data.DB_Name);
                    $('#App_Name2').val(db_data.App_Name);
                    $('#Jenis_DB2').val(db_data.Jenis_DB);
                    $('#Type2').val(db_data.Type);
                    $('#Kategori2').val(db_data.Kategori);
                    $('#IP_PUBLIC2').val(db_data.IP_PUBLIC);
                    $('#IP_VIP2').val(db_data.IP_VIP);
                    $('#IP_BACKUP2').val(db_data.IP_BACKUP);
                    $('#LOG_AUDIT2').val(db_data.LOG_AUDIT);
                    $('#BACKUP2').val(db_data.BACKUP);
                    $('#WHITELIST2').val(db_data.WHITELIST);
                    $('#DISK_TYPE2').val(db_data.DISK_TYPE);
                    $('#PDB2').val(db_data.PDB);
                    $('#PORT2').val(db_data.PORT);
                    $('#Lokasi2').val(db_data.Lokasi);
                    $('#Tier2').val(db_data.Tier);
                    $('#Oracle_Version2').val(db_data.Oracle_Version);
                    $('#Cluster2').val(db_data.Cluster);
                    $('#OS_Version2').val(db_data.OS_Version);
                    $('#Core2').val(db_data.Core);
                    $('#Socket2').val(db_data.Socket);
                    $('#CPU2').val(db_data.CPU);
                    $('#PIC2').val(db_data.PIC);
                    $('#Keterangan2').val(db_data.Keterangan);
                    $('#Note12').val(db_data.Note1);
                    $('#Note22').val(db_data.Note2);
                    $('#dbID2').val(db_data.id);
                    $('#dbDataModalView').modal('show');
                }

                function submitUserData(){
                    $('.frm-status').html('');
                    let input_data_arr = [
                        document.getElementById('Tanggal').value,
                        document.getElementById('Hostname').value,
                        document.getElementById('DB_Name').value,
                        document.getElementById('App_Name').value,
                        document.getElementById('Jenis_DB').value,
                        document.getElementById('Type').value,
                        document.getElementById('Kategori').value,
                        document.getElementById('IP_PUBLIC').value,
                        document.getElementById('IP_VIP').value,
                        document.getElementById('IP_BACKUP').value,
                        document.getElementById('LOG_AUDIT').value,
                        document.getElementById('BACKUP').value,
                        document.getElementById('WHITELIST').value,
                        document.getElementById('DISK_TYPE').value,
                        document.getElementById('PDB').value,
                        document.getElementById('PORT').value,
                        document.getElementById('Lokasi').value,
                        document.getElementById('Tier').value,
                        document.getElementById('Oracle_Version').value,
                        document.getElementById('Cluster').value,
                        document.getElementById('OS_Version').value,
                        document.getElementById('Core').value,
                        document.getElementById('Socket').value,
                        document.getElementById('CPU').value,
                        document.getElementById('PIC').value,
                        document.getElementById('Keterangan').value,
                        document.getElementById('Note1').value,
                        document.getElementById('Note2').value,
                        document.getElementById('Username').value,
                        document.getElementById('dbID').value,
                    ];

                    fetch("eventHandler.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ request_type:'addEditDb', db_data: input_data_arr}),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 1) {
                            Swal.fire({
                                title: data.msg,
                                icon: 'success',
                            }).then((result) => {
                                // Redraw the table
                            table.draw();

                                $('#dbDataModal').modal('hide');
                                $("#dbDataFrm")[0].reset();
                            });
                        } else {
                            $('.frm-status').html('<div class="alert alert-danger" role="alert">'+data.error+'</div>');
                        }
                    })
                    .catch(console.error);
                }

                function deleteData(db_id){
                Swal.fire({
                    title: 'Are you sure to Delete?'+db_id,
                    text:'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log("haai");
                    // Delete event
                    fetch("eventHandler.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ request_type:'deleteDb', data_id: db_id}),
                    }) 
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 1) {
                            Swal.fire({
                                title: data.msg,
                                icon: 'success',
                            }).then((result) => {
                                table.draw();
                            });
                        } else {
                        Swal.fire(data.error, '', 'error');
                        }
                    })
                    .catch(console.error);
                    } else {
                    Swal.close();
                    console.log(data_id);
                    }
                });

                
            }
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