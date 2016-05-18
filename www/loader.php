<?php
require_once("DB_Service.php");
require_once("NzEnum.php");
/**
 * Created by PhpStorm.
 * User: Nikos
 * Date: 4/28/2016
 * Time: 12:39 PM
 */

/*
 * Custom enumeration for better coding?
*/
class Chart extends NzEnum
{
    const
        __default = -1
    , CHART_COUNTRY_ONE = 1 //1 Country more years more measures
    , CHART_YEAR_ONE = 2 //1 year more countries more measures
    , CHART_MEASURE_ONE = 3; //1 measure more countries more measures
}

/*
 * Associate colors to tables in order to fill the chart colors
 *
 */
$colorTable = array(
    "energy_oil_consumption" => "#98abc5",
    "energy_naturalgas_consumption" => "#8a89a6",
    "energy_electricity_consumption" => "#7b6888",
    "energy_coal_consumption" => "#6b486b",
    "environment_co2_emissions" => "#a05d56",
    "environment_sulphur_emissions" => "#d0743c"
);

/*returns the table color according the given key*/
function getTableColor($key){
    $colorTable = array(
        "energy_oil_consumption" => "#98abc5",
        "energy_naturalgas_consumption" => "#a05d56",
        "energy_electricity_consumption" => "#d0743c",
        "energy_coal_consumption" => "#6b486b",
        "environment_co2_emissions" => "#8a89a6",
        "environment_sulphur_emissions" => "#FF8C00"
    );
    
    return $colorTable[$key];
}

/*
 * Database Connection
 * */
$hostname = "localhost";
$username = "root";
$password = "root";
$dbname = "datacenter";

$mysqli = new mysqli($hostname,$username,$password,$dbname);

if($mysqli->connect_errno > 0){
    die("Unable to connect to database [".$mysqli->connect_error."]");
}

$dbservice = new DB_Service($mysqli);