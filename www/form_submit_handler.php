<?php
require_once ("loader.php");
/**
 * Created by PhpStorm.
 * User: Nikos
 * Date: 4/17/2016
 * Time: 10:52 PM
 */

/*
 * cases
 * */
/**
 * @param $emission_table_data
 * @param $measure_table
 * @return array of pairs with key the year_id
 */
function getScatterValues($emission_table_data, $set){
    $ret_data = array();
    $value_fix = 1;
    foreach ($emission_table_data as $row){
        foreach ($set["values"] as $row2){
            if($row["year_descr"] == $row2["x"]){
                array_push($ret_data, array(
                    "x" => $row2["y"] / $set["gjoules"],
                    "y" => $row["total"] * $value_fix
                ));
            }
        }
    }
    return $ret_data;
}
function getMeasureTableJoulesValues(&$measure_table_data){
    $ret_data = array();
    foreach ($measure_table_data as $row){
        if ($row["gjoules"] == null){
            return null;
        }
        array_push($ret_data, array(
            "x" => $row["year_descr"],
            "y" => $row["total"] * $row["gjoules"]
        )
        );
    }
    return $ret_data;
}
$data = array();

if(count($_POST["countries"]) == 1){
    $data['chart_type'] = new Chart(Chart::CHART_COUNTRY_ONE);
    $country_id = $_POST["countries"][0];
    $data["country"] = $dbservice->getCountryById($country_id);
    $data["dataset"] = array();
    $data["scatter_set"] = array();
    $emission_tables = array();

    foreach ($_POST["datatables"] as $key=>$measure_table_name){
        $filter = new stdClass();
        $filter->where = new stdClass();
        $filter->where->country_id = $country_id;
        $filter->where->from_year = $_POST["from_year"];
        $filter->where->to_year = $_POST["to_year"];

        $measure_table_data = $dbservice->getMeasures($measure_table_name,$filter);
        $jouleValues = getMeasureTableJoulesValues($measure_table_data);
        //If e have emmisions which are tons then ignore them
        if($jouleValues == null){
            array_push($emission_tables, $measure_table_name);
            continue;
        }

        $dataChart = array(
            "label" => $measure_table_name,
            "units" => "GJoules",
            "origin_measure" =>  $measure_table_data[0]["measure_name"],
            "gjoules" => $measure_table_data[0]["gjoules"],
            "group" => $key, //TODO Check this
            "color" => getTableColor($measure_table_name), //TODO add dif colors
            "values" => getMeasureTableJoulesValues($measure_table_data)
        );


        array_push($data["dataset"],$dataChart );
    }

    foreach ($data["dataset"] as $key=>$set){
        array_push($data["scatter_set"], array());
        foreach ($emission_tables as $emission){
            $filter = new stdClass();
            $filter->where = new stdClass();
            $filter->where->country_id = $country_id;
            $filter->where->from_year = $_POST["from_year"];
            $filter->where->to_year = $_POST["to_year"];

            $emission_table_data = $dbservice->getMeasures($emission,$filter);
            $scatterChart = array(
                "label" => $emission,
                "units" => $emission_table_data[0]["measure_name"]."/".$set["origin_measure"],
                "yLabel" => "Emissions (".$emission_table_data[0]["measure_name"].")",
                "xLabel" => $set["label"]." (".$set["origin_measure"].")",
                "group" => $emission, //TODO Check this
                "color" => getTableColor($emission), //TODO add dif colors
                "values" => getScatterValues($emission_table_data,$set)
            );
            array_push($data["scatter_set"][$key],$scatterChart );
        }
    }
}
else if($_POST["from_year"] == $_POST["to_year"]){
    $data['chart_type'] = new Chart(Chart::CHART_YEAR_ONE);
    $measure_table= $_POST["datatables"][0];
    $data["chart_title"] = $measure_table;
    foreach ($_POST["countries"] as $country_id){
        $filter = new stdClass();
        $filter->where = new stdClass();
        $filter->where->country_id = $country_id;
        $filter->where->from_year = $_POST["from_year"];
        $filter->where->to_year = $_POST["to_year"];

        $country = $dbservice->getCountryById($country_id);
        $dataset = $dbservice->getMeasures($measure_table,$filter);
        $data["dataset"][$country["country_name"]] = $dataset[0];
    }
}
else if(count($_POST["datatables"]) == 1){
    $data['chart_type'] = new Chart(Chart::CHART_MEASURE_ONE);
}

echo json_encode($data);