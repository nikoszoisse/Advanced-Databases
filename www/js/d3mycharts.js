/**
 * Created by Nikos on 5/16/2016.
 */

$(function() {
    
    $.fn.ChartFactoryCountryScatter = function(chart_title,dataset,container,index){
        var setupScatter = function(dataset){
            console.log(dataset);

            function getFirstGroupData() {
                var data = JSON.parse(JSON.stringify(dataset)); //clone
                var firstGroupName = data[0].group;
                var i = data.length;
                while (i--) { //iterate data in reverse to allow safe deletion
                    if (data[i].group !== firstGroupName) {
                        data.splice(i, 0); //TODO chnage it to 0 from 1 in order to work
                    }
                }
                return data;
            }

            $('<div />').appendTo(container).attr('id', "scatter-chart"+index);
            $('<div />').appendTo(container).attr('id', "scatter-legend"+index);

            var data = getFirstGroupData();
            var chart = new Cartesian("#scatter-chart"+index);

            chart.xAxisType = "linear";
            chart.data.xAxisType = chart.xAxisType;
            chart.plot.title = chart_title;
            chart.plot.xLabel = dataset[0].xLabel;
            chart.plot.yLabel = dataset[0].yLabel;
            chart.plot.axes.x.showTicks = false;
            chart.plot.axes.y.showTicks = false;
            chart.lines.visible = false;
            chart.points.visible = true;
            chart.points.size = 5;
            chart.points.fill = true;
            chart.draw(data);
            var legend = new Legend("#scatter-legend"+index);
            legend.draw(data);
        };

        return {
            init: function (callback) {
                setupScatter(dataset);
            }
        }
    };

    $.fn.ChartFactoryCountry = function (chart_title,dataset,container){

        
        var setupLineChart =  function (dataset) {
            $('<div />').appendTo(container).attr('id', "line-chart");
            $('<div />').appendTo(container).attr('id', "line-legend");

            function getFirstGroupData() {
                var data = JSON.parse(JSON.stringify(dataset)); //clone
                var firstGroupName = data[0].group;
                var i = data.length;
                while (i--) { //iterate data in reverse to allow safe deletion
                    if (data[i].group !== firstGroupName) {
                        data.splice(i, 0); //TODO chnage it to 0 from 1 in order to work
                    }
                }
                return data;
            }

            var data = getFirstGroupData();
            var chart = new Cartesian("#line-chart");

            chart.xAxisType = "linear";
            chart.data.xAxisType = chart.xAxisType;
            chart.plot.title = chart_title;
            chart.plot.xLabel = "Years";
            chart.plot.yLabel = "Gjoules";

            chart.plot.axes.x.showTicks = false;
            chart.plot.axes.y.showTicks = false;
            chart.draw(data);
            var legend = new Legend("#line-legend");
            legend.draw(data);

        };

        var setupGroupBarChart =  function (dataset){
            $('<div />').appendTo(container).attr('id', "grouped-bar-chart");
            $('<div />').appendTo(container).attr('id', "grouped-bar-legend");

            function getAllGroupsLastSeriesData() {
                var data = JSON.parse(JSON.stringify(dataset)); //clone
                var alreadyIncluded = [];
                var i = data.length;
                while (i--) { //iterate data in reverse to allow safe deletion
                    if (!(alreadyIncluded.indexOf(data[i].group) > -1)) {
                        alreadyIncluded.push(data[i].group);
                    } else {
                        data.splice(i, 1);
                    }
                }
                return data;
            }
            
            var data = getAllGroupsLastSeriesData();
            var chart = new Cartesian("#grouped-bar-chart");

            chart.xAxisType = "linear";
            chart.data.xAxisType = chart.xAxisType;
            chart.plot.title = chart_title;
            chart.plot.xLabel = "Years";
            chart.plot.yLabel = "Gjoules";

            chart.plot.axes.x.showTicks = false;
            chart.plot.axes.y.showTicks = false;
            chart.data.isStacked = true;
            chart.bars.visible = true;
            chart.lines.visible = false; 
            chart.bars.hasOpacity = true;
            chart.draw(data);

            var legend = new Legend("#grouped-bar-legend");
            legend.showGroups = true;
            legend.hasOpacity = true;
            legend.draw(data);
        };

        return {
            init: function(callback){
                setupGroupBarChart(dataset);
                setupLineChart(dataset); },
        }
    };
});
