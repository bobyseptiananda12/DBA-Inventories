<?php 
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'inventory' 
); 
 
// DB table to use 
$table = 'log_activities'; 
 
// Table's primary key 
$primaryKey = 'id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'dateTime', 'dt' => 0 ), 
    array( 'db' => 'database_name',  'dt' => 1 ), 
    array( 'db' => 'update_log',      'dt' => 2 ), 
    array( 'db' => 'users',     'dt' => 3 ), 
    array( 'db' => 'id',    'dt' => 4 ), 
); 

// Include SQL query processing class 
require '../vendor/datatables/ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);