<?php

/**
 * Created by PhpStorm.
 * User: Nikos
 * Date: 4/22/2016
 * Time: 1:53 PM
 */
class DB_Service
{
    //Database connection
    private $mysqli;

    /**
     * DB_Service constructor.
     * @param $mysqli
     */
    public function __construct(&$mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getYears(){
        $sql = "Select * from lu_years as l ORDER BY l.year_century ASC";

        if(!$result = $this->mysqli->query($sql)){
            die('There was an error running the query [' . $this->mysqli->error . ']');
        }

        $data = $result->fetch_all(MYSQL_ASSOC);

        $result->close();

        return $data;
    }

    public function getRegions(){
        $sql = "Select * from lu_regions";

        if(!$result = $this->mysqli->query($sql)){
            die('There was an error running the query [' . $this->mysqli->error . ']');
        }

        $data = $result->fetch_all(MYSQL_ASSOC);

        $result->close();

        return $data;
    }
    //MODEL
    public function getCountries($filter = null){
        if(property_exists($filter, "where")) {
            $where_counter = 0;
            $sql = "Select * from lu_countries as c WHERE ";

            foreach ($filter->where as $param_name => $param_value) {
                if($where_counter > 0) {
                    $sql .= " AND ";
                }
                $sql .= $param_name." = ".$param_value;
                $where_counter++;
            }
            $sql .= " ORDER BY c.country_name ASC";
        }else{
            $sql = "Select * from lu_countries ORDER BY country_name ASC";
        }

        if(!$result = $this->mysqli->query($sql)){
            die('There was an error running the query [' . $this->mysqli->error . ']');
        }

        $data = $result->fetch_all(MYSQL_ASSOC);

        $result->close();

        return $data;
    }

    public function getCountriesByRegion($region_id){
        $filter = new stdClass();
        $filter->where = new stdClass();
        $filter->where->region_id = $region_id;

        return $this->getCountries($filter);
    }
    
    public function getCountryById($country_id){
        $filter = new stdClass();
        $filter->where = new stdClass();
        $filter->where->country_id = $country_id;

        $data =  $this->getCountries($filter);

        return $data[0];
    }
    
    public function getTables(){
        $sql = "SHOW TABLES";

        if(!$result = $this->mysqli->query($sql)){
            die('There was an error running the query [' . $this->mysqli->error . ']');
        }

        return $result->fetch_array();
    }
    
    //Model
    public function getMeasures($table,$filter=null){
        $where_counter = 0;
        if(property_exists($filter, "where")){
            $sql = "Select * from " . $table . " as m INNER JOIN lu_years as y ON m.year_id = y.year_id INNER JOIN lu_measures_types as t ON m.measure_id = t.measure_id AND ";

            if(property_exists($filter->where,"from_year")){
                $sql .= "y.year_descr BETWEEN ".$filter->where->from_year." AND ".$filter->where->to_year;
                $where_counter++;
                unset($filter->where->from_year);
                unset($filter->where->to_year);
            }

            foreach ($filter->where as $param_name => $param_value) {
                if($where_counter > 0) {
                    $sql .= " AND ";
                }
                $sql .= "m.".$param_name." = ".$param_value;
                $where_counter++;
            }
            $sql .= " ORDER BY m.year_id ASC";
        }else{
            $sql = "Select * from ".$table." as m INNER JOIN lu_years as y  ON m.year_id = y.year_id INNER JOIN lu_measures_types as t ON m.measure_id = t.measure_id ORDER BY y.year_descr ASC";
        }

        if(!$result = $this->mysqli->query($sql)){
            die('There was an error running the query [' . $this->mysqli->error . ']');
        }

        $data = $result->fetch_all(MYSQL_ASSOC);

        $result->close();

        return $data;
    }

}