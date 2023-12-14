<?php 
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'inventory' 
); 
 
// DB table to use 
$table = <<<EOT
 (
    SELECT
      a.id,
      a.db_id,
      a.nik,
      b.Hostname,
      b.DB_Name,
      b.Jenis_DB,
      c.nama
    FROM table a
    INNER JOIN inventorydba b ON a.db_id = b.id
    INNER JOIN karyawan_telkom c ON a.nik = c.nik
 ) temp
EOT;
 
// Table's primary key 
$primaryKey = 'id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 
        'db'        => 'id', 
        'dt'        => 0, 
        'formatter' => function( $d, $row ) { 
            return ' 
                <a href="javascript:void(0);" onclick="editData('.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').')"><i class="fas fa-edit" data-toggle="tooltip" title="Edit">&#xE254;</i></a>&nbsp; 
                <a href="javascript:void(0);" onclick="deleteData('.$d.')"><i class="fas fa-trash" data-toggle="tooltip" title="Delete">&#xE254;</i></a> 
                <a href="javascript:void(0);" onclick="viewData('.htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8').')"><i class="fas fa-search" data-toggle="tooltip" title="View">&#xE254;</i></a> 
            '; 
        } 
    ),
    array( 'db' => 'nama', 'dt' => 1 ), 
    array( 'db' => 'Hostname', 'dt' => 2 ), 
    array( 'db' => 'DB_Name', 'dt' => 3), 
    array( 'db' => 'Jenis_DB', 'dt' => 4 ), 
); 

// Include SQL query processing class 
require '../vendor/datatables/ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);