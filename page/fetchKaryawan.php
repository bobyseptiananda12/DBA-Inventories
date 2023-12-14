<?php 
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'inventory' 
); 
 
// DB table to use 
$table = 'karyawan_telkom'; 
 
// Table's primary key 
$primaryKey = 'nik'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 
        'db'        => 'nik', 
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
    array( 'db' => 'jenis_kelamin',  'dt' => 2 ), 
    array( 'db' => 'employee_group',      'dt' => 3 ), 
    array( 'db' => 'personnel_area',     'dt' => 4 ), 
    array( 'db' => 'personnel_subarea',    'dt' => 5 ), 
    array( 'db' => 'short_divisi',    'dt' => 6 ), 
    array( 'db' => 'short_unit',    'dt' => 7 ), 
    array( 'db' => 'long_unit',    'dt' => 8 ), 
    array( 'db' => 'job',    'dt' => 9 ), 
    array( 'db' => 'posisi',    'dt' => 10 ), 
    array( 'db' => 'email',    'dt' => 11 ), 
    array( 'db' => 'company',    'dt' => 12 ), 
    array( 'db' => 'function_unit',    'dt' => 13 ), 
    array( 'db' => 'business_area',    'dt' => 14 ), 
    array( 'db' => 'payroll_area',    'dt' => 15 ), 
); 

// Include SQL query processing class 
require '../vendor/datatables/ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);