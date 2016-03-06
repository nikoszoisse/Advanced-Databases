<?php
/**
 * Created by PhpStorm.
 * User: Nikos
 * Date: 3/5/2016
 * Time: 10:31 PM
 */

/**
 * This Script is working only with the following arguments and rules
 * file_input_path    --a CSV file with 'total' values
 * table               -- the Table Name from the database which is gonna be affected
 * measure             -- the measure types of the indicators e.x kWh,tones,ote,etc..
 *
 * REQUIREMENTS: You need the SQL Procedures in order to make it work
 */

function error_msg($msg=""){
    echo $msg;
    exit;
}

function tryToConnectToDB(&$database){
    $con = @mysql_connect($database['host'], $database['username'],$database['password']) or die(mysql_error());
    @mysql_select_db($database['name']) or die(mysql_error());

    return $con;
}

//Database Credentials if you want update it instantly (not recommended )
$database['host'] = 'localhost';
$database['name'] = 'datacenter';
$database['username'] = 'root';
$database['password'] = 'root';

$save_sql = true;
$require_connection = false;

$row_separator = "\n";

//BEGIN Security section
if($argc < 4) {
    error_msg("Script usage file_input_path table measure");
}

$input_csv_file = $argv[1];

$output_file = $argv[2].".sql";
$table = $argv[2];
$measure = $argv[3];

$file_info = pathinfo($input_csv_file);
//check extension
if($file_info['extension'] != "csv"){
    error_msg("File is invalid. Only *.csv file input is allowed!");
}

//check if file is empty
$file_size = filesize($input_csv_file);

if(!$file_size){
    error_msg("The file is empty dude!!");
}

//try to open the non empty file
$file[0] = fopen($input_csv_file,"r");

//file output
if($save_sql){
    if(!is_writable($output_file)){
        error_msg("Permissions are not allow to write this file");
    }else{
        $file[1] = fopen($output_file,"w");
        if(!$file[1]){
            error_msg("Error writing to the output file.");
        }
    }
}

if(!$file[0]){
    error_msg("File input could not open");
}
//END Security section

//TODO $connection = tryToConnectToDB($database);

$row = 0;
$header_row = array();

while (($oil_total_data = fgetcsv($file[0], 5000, ",")) !== FALSE) {

    $num_of_fields = count($oil_total_data);


    if($row == 0) {
        $header_row = $oil_total_data;
    }
    else{
        for($col=1; $col<$num_of_fields;$col++){
            //Replace '-' if needed and empty strings
            if(($oil_total_data[$col] == '-') || ($oil_total_data[$col] == '')){
                continue; //IGNORE THE QUERY IF NOT DATA PROVIDED
            }
            //clean unwanted data like ' inside the countries
            $oil_total_data[0] = str_replace("'"," ",$oil_total_data[0]);
            $query = "CALL INSERT_ENVIRONMENT_RECORD ('".$table."','".$oil_total_data[0]."',".$header_row[$col].",'".$oil_total_data[$col]."','".$measure."')";

            if($require_connection){
                //TODO send query
            }
            if($save_sql){
                fwrite($file[1],($query).";\n");
            } else{
                echo ($query)."\n";
            }
        }
//        exit;
    }
    $row++;
}

//close opened files
fclose($file[0]);

if($save_sql){
    fclose($file[1]);
}

//TODO @mysql_close($connection);