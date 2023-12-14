<?php

// Include your configuration file
require '../config.php';

// Create MySQL connection

// Execute query
$sql = "SELECT * FROM inventorydba";
$result = @mysqli_query($conn, $sql) or die("Couldn't execute query:<br>" . mysqli_error($conn) . "<br>" . mysqli_errno($conn));

$file_ending = "xls";
$filename = "database_export";

// Header info for browser
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Start of Formatting for Excel
// Define separator (defines columns in Excel & tabs in Word)
$sep = "\t"; // tabbed character

// Start of printing column names as names of MySQL fields
for ($i = 0; $i < mysqli_num_fields($result); $i++) {
    echo mysqli_fetch_field_direct($result, $i)->name . "\t";
}
print("\n");

// End of printing column names
// Start while loop to get data
while ($row = mysqli_fetch_row($result)) {
    $schema_insert = "";
    for ($j = 0; $j < mysqli_num_fields($result); $j++) {
        if (!isset($row[$j]))
            $schema_insert .= "NULL" . $sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]" . $sep;
        else
            $schema_insert .= "" . $sep;
    }
    $schema_insert = str_replace($sep . "$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}

// Close MySQL connection
mysqli_close($conn);

?>