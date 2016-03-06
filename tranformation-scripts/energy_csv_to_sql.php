<?php
/**
 * Created by PhpStorm.
 * User: Nikos
 * Date: 3/5/2016
 * Time: 10:31 PM
 */

/**
 * This Script is working only with the following arguments and rules
 * file1_input_path    --a CSV file with 'total' values
 * file2_input_path    --a CSV file with 'per person' values
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
if($argc < 5) {
    error_msg("Script usage file1_input_path file2_input_path table measure");
}

$input_csv_file[0] = $argv[1];
$input_csv_file[1] = $argv[2];

$output_file = $argv[3].".sql";
$table = $argv[3];
$measure = $argv[4];

$file_info[0] = pathinfo($input_csv_file[0]);
$file_info[1] = pathinfo($input_csv_file[1]);

//check extension
if($file_info[0]['extension'] != "csv"){
    error_msg("File 1 is invalid. Only *.csv file input is allowed!");
}
if($file_info[1]['extension'] != "csv"){
    error_msg("File 2 is invalid. Only *.csv file input is allowed!");
}

//check if file is empty
$file_size[0] = filesize($input_csv_file[0]);
$file_size[1] = filesize($input_csv_file[1]);

if(!$file_size[0] || !$file_size[1]){
    error_msg("One of the files is empty dude!!");
}

//try to open the non empty file
$file[0] = fopen($input_csv_file[0],"r");
$file[1] = fopen($input_csv_file[1],"r");

//file output
if($save_sql){
    if(!is_writable($output_file)){
        error_msg("Permissions are not allow to write this file");
    }else{
        $file[2] = fopen($output_file,"w");
        if(!$file[2]){
            error_msg("Error writing to the output file.");
        }
    }
}

if(!$file[0]){
    error_msg("File 1 could not open");
}
if(!$file[1]){
    error_msg("File 2 could not open");
}
//END Security section

//TODO $connection = tryToConnectToDB($database);

$row = 0;
$header_row = array();

while (($oil_total_data = fgetcsv($file[0], 5000, ",")) !== FALSE) {
    $oil_per_person_data = fgetcsv($file[1], 5000, ",");

    $num_of_fields[0] = count($oil_total_data);
    $num_of_fields[1] = count($oil_per_person_data);

    if($num_of_fields[0] != $num_of_fields[1]){
        error_msg("The files are not match at line:".$row." Please use 1:1 files");
    }

    if($row == 0) {
        $header_row = $oil_total_data;
    }
    else{
        for($col=1; $col<$num_of_fields[0];$col++){
            //Replace '-' if needed and empty strings
            if(($oil_total_data[$col] == '-') || ($oil_total_data[$col] == '')){
                if(($oil_per_person_data[$col] == '-') || ($oil_per_person_data[$col] == '')){
                    continue; //IGNORE THE QUERY IF NOT DATA PROVIDED
                }else{
                    $oil_total_data[$col] = 'null';
                }
            }else{
                if(($oil_per_person_data[$col] == '\-') || ($oil_per_person_data[$col] == '')){
                    $oil_per_person_data[$col] = 'null';
                }
            }
            //clean unwanted data like ' inside the countries
            $oil_total_data[0] = str_replace("'"," ",$oil_total_data[0]);
            $query = "CALL INSERT_ENTRY ('".$table."','".$oil_total_data[0]."',".$header_row[$col].",'".$oil_total_data[$col]."','".$oil_per_person_data[$col]."','".$measure."')";

            if($require_connection){
                //TODO send query
            }
            if($save_sql){
                fwrite($file[2],($query).";\n");
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
fclose($file[1]);

if($save_sql){
    fclose($file[2]);
}

@mysql_close($connection);