<?php require_once "loader.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Advanced Databases v0.1</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bower_components/multiselect/css/multi-select.css" type="text/css"/>
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="peek-1.4.1/peek.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bower_components/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript" src="bower_components/d3/d3.js"></script>
    <script type="text/javascript" src="peek-1.4.1/peek.js"></script>
    <script type="text/javascript" src="js/d3mycharts.js"></script>
    <script>
        $(document).ready(function(){
            var datasetCounter = 1, chart;
            $('[data-toggle="tooltip"]').tooltip();
            $('#datatables').multiSelect({
                selectableHeader: "<div class='line line-red'></div>",
                selectionHeader: "<div class='line line-red'></div>",
            });
            $('#country-multi').multiSelect({
                selectableHeader: "<div class='line line-blue'></div>",
                selectionHeader: "<div class='line line-blue'></div>",
                selectableOptgroup: true
            });
            $('#year-multi').multiSelect({
                selectableHeader: "<div class='line line-green'></div>",
                selectionHeader: "<div class='line line-green'></div>",
                selectableOptgroup: true
            });

            $('#buildGraph').on('click',function(e){
                $(".chartContainer").html("");
                $.ajax({
                    url: $('#myForm').attr('action'),
                    data: $('#myForm').serialize(),
                    error: function() {
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.chart_type.value == 1) {
                            if(data.dataset.length > 0){
                                var chart = $(this).ChartFactoryCountry(data.country.country_name,data.dataset, ".chartContainer");
                                chart.init();
                            }
                            if(data.scatter_set.length > 0){
                                var scatterChart;
                                $.each(data.scatter_set,function(index,set_data){
                                    scatterChart = $(this).ChartFactoryCountryScatter(data.country.country_name,set_data, ".chartContainer",index);
                                    scatterChart.init();
                                });

                            }
                        }
                        else if(data.chart_type.value == 2){
                        }
                    },
                    type: 'POST'
                });
            });
        });
    </script>
</head>
<style>
    body{
        background-color: #ffffff;
    }
    .line {
        fill: none;
        stroke: steelblue;
        stroke-width: 1.5px;
    }
    .container{
        border-radius: 2px;
        border: solid rgba(236, 240, 241, 1);
        -webkit-box-shadow: 0px 0px 8px 1px rgba(11,15,54,1);
        -moz-box-shadow: 0px 0px 8px 1px rgba(11,15,54,1);
        box-shadow: 0px 0px 8px 1px rgba(11,15,54,1);
        min-height: 700px;
    }
    #myForm {
        background-color: rgb(234, 234, 234);
    }
    .form-inline .form-group{
        margin-left: 35px;
    }
    .line {
        /*margin-top: 20px;*/
        /*margin-bottom: 20px;*/
        border: 0;
        border-top: 5px solid;
    }

    .line-blue{
        border-color: #345792;
    }

    .line-red{
        border-color: #933131;
    }

    .line-green{
        border-color: #447747;
    }
</style>
<body>
<div class="container">
    <div class="col-lg-12">
        <h3 class="text-center">Advanced Databases Project</h3>
        <div class="row">
            <div class="col-md-4">
                <div id="description">
                    <h4>About</h4>
                    <ul>
                        <li>Author: Nikolaos Zois AM 2054</li>
                        <li>Version: 0.1</li>
                        <li>Dependencies: <a href="http://getbootstrap.com">Bootstrap</a> ,<a href="https://d3js.org/">D3</a> ,<a href="https://jquery.com/">JQuery</a> </li>
                        <li>Dependency manager: <a href="http://bower.io/">Bower</a></li>
                        <li>Git Rep: <a href="https://github.com/nikoszoisse/Advanced-Databases">GitHub</a> </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="getstarted">
                    <h4>Get Started</h4>
                    <ul>
                        <li>Select the Table of Data</li>
                        <li>Select the Countries</li>
                        <li>Select Period</li>
                        <li>Press Build Graph</li>
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <form id="myForm" class="form-inline" action="form_submit_handler.php" method="POST"
                  accept-charset="UTF-8"
                  enctype="application/x-www-form-urlencoded">
                <fieldset class="form-group">
                    <label for="datatables">Select Datasets</label>
                    <select id="datatables" name="datatables[]" class="form-control" multiple="multiple">
                        <option value="environment_co2_emissions">CO2 Emissions</option>
                        <option value="environment_sulphur_emissions">Sulphur Emissions</option>
                        <option value="energy_electricity_consumption">Electricity Consumption</option>
                        <option value="energy_naturalgas_consumption">Natural Gas Consumption</option>
                        <option value="energy_oil_consumption">Oil Consumption</option>
                    </select>
                </fieldset>
                <fieldset class="form-group">
                    <label for="country-multi">Select Countries</label>
                    <select id="country-multi" name="countries[]" class="form-control" multiple="multiple">
                        <? foreach($dbservice->getRegions() as $region):?>
                            <optgroup label="<?=$region["region_name"]?>">
                                <? foreach($dbservice->getCountriesByRegion($region["region_id"]) as $country):?>
                                    <option value="<?=$country["country_id"]?>"><?=$country["country_name"]?></option>
                                <? endforeach;?>
                            </optgroup>
                        <? endforeach;?>
                    </select>
                </fieldset>
                <fieldset class="form-group">
                    <label for="year-multi">Select Period</label>
                    <div class="line line-green"></div>
                    <br><br><br>
                    <div class="clearfix"></div>
                    <input name="from_year" type="number" class="form-control input-sm" placeholder="from (Year)">
                    <div class="clearfix"></div><br>
                    <input name="to_year" type="number" class="form-control input-sm" placeholder="to (Year)">
                    <div class="clearfix"></div><br>
                    <div class="text-center" style="width: 100%;padding-bottom:2%;">
                        <a id="buildGraph" href="#" data-toggle="tooltip" title="Click to build a graph." class="btn btn-sm btn-success">
                            <span class="glyphicon glyphicon-wrench"></span> Build Graph
                        </a>
                    </div>
                    <!--<select id="year-multi" name="years[]" class="form-control" multiple="multiple">
                        <?/* $century = -9;*/?>
                        <?/* foreach($dbservice->getYears() as $year):*/?>
                            <?/*if($century != $year["year_century"]):*/?>
                                <?/*$century = $year["year_century"];*/?>
                                <optgroup label="<?/*=$year["year_century"]." Century"*/?>">
                            <?/*endif;*/?>
                            <option value="<?/*=$year["year_descr"]*/?>"><?/*=$year["year_descr"]*/?></option>
                            <?/*if($century != $year["year_century"]):*/?>
                                </optgroup>
                            <?/*endif;*/?>
                        <?/* endforeach;*/?>
                    </select>-->
                </fieldset>
            </form>
        </div>
        <div class="row chartContainer">
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

</body>
</html>