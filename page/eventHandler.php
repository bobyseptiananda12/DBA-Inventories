<?php      
// Include database configuration file  
require_once '../config.php'; 
 
// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input'); 
$jsonObj = json_decode($jsonStr); 
 
if($jsonObj->request_type == 'addEditDb'){ 
    $db_data = $jsonObj->db_data; 
    $Tanggal = !empty($db_data[0])?$db_data[0]:''; 
    $Hostname = !empty($db_data[1])?$db_data[1]:''; 
    $DB_Name = !empty($db_data[2])?$db_data[2]:''; 
    $App_Name = !empty($db_data[3])?$db_data[3]:''; 
    $Jenis_DB = !empty($db_data[4])?$db_data[4]:''; 
    $Type = !empty($db_data[5])?$db_data[5]:''; 
    $Kategori = !empty($db_data[6])?$db_data[6]:''; 
    $IP_PUBLIC = !empty($db_data[7])?$db_data[7]:''; 
    $IP_VIP = !empty($db_data[8])?$db_data[8]:''; 
    $IP_BACKUP = !empty($db_data[9])?$db_data[9]:''; 
    $LOG_AUDIT = !empty($db_data[10])?$db_data[10]:''; 
    $BACKUP = !empty($db_data[11])?$db_data[11]:''; 
    $WHITELIST = !empty($db_data[12])?$db_data[12]:''; 
    $DISK_TYPE = !empty($db_data[13])?$db_data[13]:''; 
    $PDB = !empty($db_data[14])?$db_data[14]:''; 
    $PORT = !empty($db_data[15])?$db_data[15]:''; 
    $Lokasi = !empty($db_data[16])?$db_data[16]:''; 
    $Tier = !empty($db_data[17])?$db_data[17]:''; 
    $Oracle_Version = !empty($db_data[18])?$db_data[18]:''; 
    $Cluster= !empty($db_data[19])?$db_data[19]:''; 
    $OS_Version = !empty($db_data[20])?$db_data[20]:''; 
    $Core = !empty($db_data[21])?$db_data[21]:''; 
    $Socket = !empty($db_data[22])?$db_data[22]:''; 
    $CPU = !empty($db_data[23])?$db_data[23]:''; 
    $PIC = !empty($db_data[24])?$db_data[24]:''; 
    $Keterangan = !empty($db_data[25])?$db_data[25]:''; 
    $Note1 = !empty($db_data[26])?$db_data[26]:''; 
    $Note2 = !empty($db_data[27])?$db_data[27]:''; 
    $Tujuan_Penggunaan = !empty($db_data[28])?$db_data[28]:''; 
    $Username = !empty($db_data[29])?$db_data[29]:''; 
    $id = !empty($db_data[30])?$db_data[30]:0; 
 
    $err = ''; 
     
    if(!empty($db_data) && empty($err)){ 
        if(!empty($id)){ 
            // Update user data into the database 
            // Retrieve current values before the update
            $sql_before_update = "SELECT * FROM inventorydba WHERE id = '$id'";
            $result_before_update = mysqli_query($conn, $sql_before_update);
            $row_before_update = mysqli_fetch_assoc($result_before_update);

            $sqlQ = "UPDATE inventorydba SET Tanggal = ?, Hostname = ?, `DB_Name` = ?, `App_Name` = ?, Jenis_DB = ?, `Type` = ?, `Kategori` = ?, IP_PUBLIC = ?, IP_VIP = ?, IP_BACKUP = ?, LOG_AUDIT = ?, `BACKUP` = ?, WHITELIST = ?, DISK_TYPE = ?, PDB = ?, PORT = ?, Lokasi = ?, Tier = ?, Oracle_Version = ?, Cluster = ?, OS_Version = ?, Core = ?, Socket = ?, CPU = ?, PIC = ?, Keterangan = ?, Note1 = ?, Note2 = ?,Tujuan_Penggunaan = ?, lastUpdatedAt = NOW(), lastUpdatedBy = ? WHERE id = ?";
            $stmt = $conn->prepare($sqlQ); 
            $stmt->bind_param("ssssssssssssssssssssssssssssssi", $Tanggal, $Hostname, $DB_Name, $App_Name, $Jenis_DB, $Type, $Kategori,$IP_PUBLIC,$IP_VIP,$IP_BACKUP,$LOG_AUDIT,$BACKUP,$WHITELIST,$DISK_TYPE,$PDB,$PORT,$Lokasi,$Tier,$Oracle_Version,$Cluster,$OS_Version,$Core,$Socket,$CPU,$PIC,$Keterangan, $Note1,$Note2,$Tujuan_Penggunaan,$Username, $id); 
            $update = $stmt->execute(); 

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
            VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql_log); 
            $stmt2->bind_param("ssss", $timestamp, $database, $update_log, $Username); 
            $insert2 = $stmt2->execute();
 
            if($update){ 
                $output = [ 
                    'status' => 1, 
                    'msg' => 'Database updated successfully!' 
                ]; 
                echo json_encode($output); 
            }else{ 
                echo json_encode(['error' => 'Database Update request failed!']); 
            } 
        }else{ 
            // Insert event data into the database 
            // $sqlQ = "INSERT INTO inventorydba (first_name,last_name,email,gender,country,status) VALUES (?,?,?,?,?,?)"; 
            $sqlQ = "INSERT INTO inventorydba (Tanggal, Hostname, `DB_Name`, `App_Name`, Jenis_DB, `Type`, Kategori,IP_PUBLIC,IP_VIP,IP_BACKUP,LOG_AUDIT,BACKUP,WHITELIST,DISK_TYPE,PDB,PORT,Lokasi,Tier,Oracle_Version,Cluster,OS_Version,Core,Socket,CPU,PIC,Keterangan, Note1,Note2,Tujuan_Penggunaan, createdBy, createdAt) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP())"; 
            $stmt = $conn->prepare($sqlQ); 
            $stmt->bind_param("ssssssssssssssssssssssssssssss", $Tanggal, $Hostname, $DB_Name, $App_Name, $Jenis_DB, $Type, $Kategori,$IP_Public,$IP_VIP,$IP_Backup,$Log_Audit,$Backup,$Whitelist,$Disk_Type,$PDB,$PORT,$Lokasi,$Tier,$Oracle_Version,$Cluster,$OS_Version,$Core,$Socket,$CPU,$PIC,$Keterangan, $Note1,$Note2,$Tujuan_Penggunaan, $Username); 
            $insert = $stmt->execute(); 

            //insert log activity
            $timestamp = date("Y-m-d H:i:s");
            $database = "inventorydba";
            $update_log = "Added record with Hostname: $Hostname, DB_Name: $DB_Name, App_Name: $App_Name";
            $sql_log = "INSERT INTO log_activities (`dateTime`, `database_name`, `update_log`, `users`) 
            VALUES (?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql_log); 
            $stmt2->bind_param("ssss", $timestamp, $database, $update_log, $Username); 
            $insert2 = $stmt2->execute();

            if($insert){ 
                $output = [ 
                    'status' => 1, 
                    'msg' => 'Database added successfully'
                ]; 
                echo json_encode($output); 
            }else{ 
                echo json_encode(['error' => 'Database Add request failed!']); 
            } 
        } 
    }else{ 
        echo json_encode(['error' => trim($err, '<br/>')]);
    } 
}elseif($jsonObj->request_type == 'deleteDb'){ 
    $id = $jsonObj->data_id; 
 
    $sql = "DELETE FROM inventorydba WHERE id=$id"; 
    $delete = $conn->query($sql); 
    if($delete){ 
        $output = [ 
            'status' => 1, 
            'msg' => 'Database deleted successfully!' 
        ]; 
        echo json_encode($output); 
    }else{ 
        echo json_encode(['error' => 'Database Delete request failed!']); 
    } 
}