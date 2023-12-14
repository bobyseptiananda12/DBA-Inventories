<?php 
// Database connection info 
$dbDetails = array( 
    'host' => 'localhost', 
    'user' => 'root', 
    'pass' => '', 
    'db'   => 'inventory' 
); 
 
// DB table to use 
$table = 'inventorydba'; 
 
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
    array( 'db' => 'Tanggal', 'dt' => 1 ), 
    array( 'db' => 'Hostname',  'dt' => 2 ), 
    array( 'db' => 'DB_Name',      'dt' => 3 ), 
    array( 'db' => 'App_Name',     'dt' => 4 ), 
    array( 'db' => 'Jenis_DB',    'dt' => 5 ), 
    array( 'db' => 'Type',    'dt' => 6 ), 
    array( 'db' => 'Kategori',    'dt' => 7 ), 
    array( 'db' => 'IP_PUBLIC',    'dt' => 8 ), 
    array( 'db' => 'IP_VIP',    'dt' => 9 ), 
    array( 'db' => 'IP_BACKUP',    'dt' => 10 ), 
    array( 'db' => 'LOG_AUDIT',    'dt' => 11 ), 
    array( 'db' => 'BACKUP',    'dt' => 12 ), 
    array( 'db' => 'WHITELIST',    'dt' => 13 ), 
    array( 'db' => 'DISK_TYPE',    'dt' => 14 ), 
    array( 'db' => 'PDB',    'dt' => 15 ), 
    array( 'db' => 'PORT',    'dt' => 16 ), 
    array( 'db' => 'Lokasi',    'dt' => 17 ), 
    array( 'db' => 'Tier',    'dt' => 18 ), 
    array( 'db' => 'Oracle_Version',    'dt' => 19 ), 
    array( 'db' => 'Cluster',    'dt' => 20 ), 
    array( 'db' => 'OS_Version',    'dt' => 21 ), 
    array( 'db' => 'Core',    'dt' => 22 ), 
    array( 'db' => 'Socket',    'dt' => 23 ), 
    array( 'db' => 'CPU',    'dt' => 24 ), 
    array( 'db' => 'PIC',    'dt' => 25 ), 
    array( 'db' => 'Keterangan',    'dt' => 26 ), 
    array( 'db' => 'Note1',    'dt' => 27 ), 
    array( 'db' => 'Note2',    'dt' => 28 ), 
    array( 'db' => 'Tujuan_Penggunaan',    'dt' => 29 ), 
    array( 'db' => 'createdAt',    'dt' => 30 ), 
    array( 'db' => 'createdBy',    'dt' => 31 ), 
    array( 'db' => 'lastUpdatedAt',    'dt' => 32 ), 
    array( 'db' => 'lastUpdatedBy',    'dt' => 33 ), 
); 

// $searchFilter = array(); 
// if(!empty($_GET['search_keywords'])){ 
//     $searchFilter['search'] = array( 
//         'Tanggal' => $_GET['search_keywords'], 
//         'Hostname' => $_GET['search_keywords'], 
//         'DB_Name' => $_GET['search_keywords'], 
//         'App_Name' => $_GET['search_keywords'] ,
//         'Jenis_DB' => $_GET['search_keywords'] ,
//         'Type' => $_GET['search_keywords'] ,
//         'Kategori' => $_GET['search_keywords'], 
//         'IP_PUBLIC' => $_GET['search_keywords'] ,
//         'IP_VIP' => $_GET['search_keywords'] ,
//         'IP_BACKUP' => $_GET['search_keywords'], 
//         'LOG_AUDIT' => $_GET['search_keywords'] ,
//         'BACKUP' => $_GET['search_keywords'] ,
//         'WHITELIST' => $_GET['search_keywords'], 
//         'DISK_TYPE' => $_GET['search_keywords'] ,
//         'PDB' => $_GET['search_keywords'] ,
//         'PORT' => $_GET['search_keywords'] ,
//         // 'Lokasi' => $_GET['search_keywords'], 
//         'Tier' => $_GET['search_keywords'] ,
//         'Oracle_Version' => $_GET['search_keywords'], 
//         'Cluster' => $_GET['search_keywords'] ,
//         'OS_Version' => $_GET['search_keywords'], 
//         'Core' => $_GET['search_keywords'] ,
//         'Socket' => $_GET['search_keywords'], 
//         'CPU' => $_GET['search_keywords'] ,
//         'PIC' => $_GET['search_keywords'] ,
//         'Keterangan' => $_GET['search_keywords'] ,
//         'Note1' => $_GET['search_keywords'] ,
//         'Note2' => $_GET['search_keywords'] ,
//         'Tujuan_Penggunaan' => $_GET['search_keywords'], 
//         'createdAt' => $_GET['search_keywords'] ,
//         'createdBy' => $_GET['search_keywords'] ,
//         'lastUpdatedAt' => $_GET['search_keywords'], 
//         'lastUpdatedBy' => $_GET['search_keywords'] 
// ,    ); 
// } 
// if(!empty($_GET['filter_option'])){ 
//     $searchFilter['filter'] = array( 
//         'Lokasi' => $_GET['filter_option'] 
//     ); 
// } 
 
// Include SQL query processing class 
require '../vendor/datatables/ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns) 
);