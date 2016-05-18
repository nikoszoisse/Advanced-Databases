/*! Peek.js (c) 2015 Mark Macdonald | http://mtmacdonald.github.io/peek/LICENSE */

/*
    Example input data for Peek.js
*/

var timeData = [
    {
        "label": "Foo",
        "units": "kg",
        "group" : "A",
        "color": "#69A9CA",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 3
            },
            {
                x : "2014-03-02 00:00:00",
                y : 1.43
            },
            {
                x : "2014-03-03 00:00:00",
                y : 0.38
            },
            {
                x : "2014-03-04 00:00:00",
                y : 3.5
            },
            {
                x : "2014-03-05 00:00:00",
                y : 2.0
            }
        ]
    },
    {
        "label": "Foo",
        "units": "kg",
        "group" : "B",
        "color": "#8583C2",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 2
            },
            {
                x : "2014-03-02 00:00:00",
                y : 4.5
            },
            {
                x : "2014-03-03 00:00:00",
                y : 6
            },
            {
                x : "2014-03-04 00:00:00",
                y : 1.1
            },
            {
                x : "2014-03-05 00:00:00",
                y : 0.8
            }
        ]
    },
    {
        "label": "Foo",
        "units": "kg",
        "group" : "C",
        "color": "#67D1B8",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 2
            },
            {
                x : "2014-03-02 00:00:00",
                y : 4.5
            },
            {
                x : "2014-03-03 00:00:00",
                y : 6
            },
            {
                x : "2014-03-04 00:00:00",
                y : 1.1
            },
            {
                x : "2014-03-05 00:00:00",
                y : 0.8
            }
        ]
    },
    {
        "label": "Bar",
        "units": "m/s",
        "group" : "A",
        "color": "#C76842",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 2
            },
            {
                x : "2014-03-02 00:00:00",
                y : 4.4
            },
            {
                x : "2014-03-03 00:00:00",
                y : 0.8
            },
            {
                x : "2014-03-04 00:00:00",
                y : 2.24
            },
            {
                x : "2014-03-05 00:00:00",
                y : 2.0
            }
        ]
    },
    {
        "label": "Bar",
        "units": "m/s",
        "group" : "B",
        "color": "#C06472",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 4.2
            },
            {
                x : "2014-03-02 00:00:00",
                y : 2.4
            },
            {
                x : "2014-03-03 00:00:00",
                y : 0.6
            },
            {
                x : "2014-03-04 00:00:00",
                y : 5.1
            },
            {
                x : "2014-03-05 00:00:00",
                y : 9.0
            }
        ]
    },
    {
        "label": "Bar",
        "units": "m/s",
        "group" : "C",
        "color": "#C99336",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 5
            },
            {
                x : "2014-03-02 00:00:00",
                y : 1.5
            },
            {
                x : "2014-03-03 00:00:00",
                y : 7
            },
            {
                x : "2014-03-04 00:00:00",
                y : 2.1
            },
            {
                x : "2014-03-05 00:00:00",
                y : 5.8
            }
        ]
    },
    {
        "label": "Baz",
        "units": "l",
        "group" : "A",
        "color": "#68843C",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 1
            },
            {
                x : "2014-03-02 00:00:00",
                y : 3.2
            },
            {
                x : "2014-03-03 00:00:00",
                y : 3.6
            },
            {
                x : "2014-03-04 00:00:00",
                y : 1.9
            },
            {
                x : "2014-03-05 00:00:00",
                y : 3.1
            }
        ]
    },
    {
        "label": "Baz",
        "units": "l",
        "group" : "B",
        "color": "#84D747",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 3.2
            },
            {
                x : "2014-03-02 00:00:00",
                y : 2.2
            },
            {
                x : "2014-03-03 00:00:00",
                y : 4.6
            },
            {
                x : "2014-03-04 00:00:00",
                y : 5.1
            },
            {
                x : "2014-03-05 00:00:00",
                y : 0.1
            }
        ]
    },
    {
        "label": "Baz",
        "units": "l",
        "group" : "C",
        "color": "#6C7970",
        "values": [
            {
                x : "2014-03-01 00:00:00",
                y : 1
            },
            {
                x : "2014-03-02 00:00:00",
                y : 2.5
            },
            {
                x : "2014-03-03 00:00:00",
                y : 5
            },
            {
                x : "2014-03-04 00:00:00",
                y : 3.1
            },
            {
                x : "2014-03-05 00:00:00",
                y : 1.8
            }
        ]
    },
];

var horizontalBarData = [
    {    
        "label": "Foo",
        "units" : "",
        "color": "#69A9CA",
        "value": 80,
    },
    {
        "label": "Bar",
        "units" : "",
        "color": "#C76842",
        "value": 50,
    },
    {
        "label": "Baz",
        "units" : "",
        "color": "#68843C",
        "value": 30,
    },
    {     
        "label": "Qux",
        "units" : "",
        "color": "#8583C2",
        "value": 2,
    },
];

var radialData = [
    {     
        "label": "Foo",
        "units" : "",
        "color": "#69A9CA",
        "value": 50,
    },
    {     
        "label": "Bar",
        "units" : "",
        "color": "#C76842",
        "value": 25,
    },
    {     
        "label": "Baz",
        "units" : "",
        "color": "#68843C",
        "value": 25,
    },
];

function getFirstGroupData() {
    var data = JSON.parse(JSON.stringify(timeData)); //clone
    var firstGroupName = data[0].group;
    var i = data.length;
    while (i--) { //iterate data in reverse to allow safe deletion
        if (data[i].group !== firstGroupName) {
            data.splice(i, 1);
        }          
    }
    return data;
}

function getFirstGroupDataWithScale() {
    var data = getFirstGroupData();
    data.forEach(function (series, i) {
        if (i === 0) {
            series.dualScale = true;
        }
    });
    return data;
}

function getFirstGroupDataWithTexture() {
    var data = getFirstGroupData();
    data.forEach(function (series) {
        series.texture = 'diagonal';
    });
    return data;
}

function getFirstGroupFirstSeriesData() {
    var data = JSON.parse(JSON.stringify(timeData)); //clone
    data.splice(1, data.length);
    return data;
}

function getAllGroupsLastSeriesData() {
    var data = JSON.parse(JSON.stringify(timeData)); //clone
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

function getLinearData() {
    var data = getFirstGroupData();
    //instead of a time scale, return a linear x-scale with values 1-5
    data.forEach(function (series, i) {
        var xVal = 1;
        for (var point in series.values) {
            if (series.values.hasOwnProperty(point)) {
                series.values[point].x = xVal;
                ++xVal;
            }
        }
    });
    return data;
}

function getOrdinalData() {
    var data = getFirstGroupData();
    //instead of a time scale, return an ordinal x-scale with values A-E
    data.forEach(function (series, i) {
        var xVal = 1;
        for (var point in series.values) {
            if (series.values.hasOwnProperty(point)) {
                if (xVal === 1) {
                    series.values[point].x = 'A';
                } else if (xVal === 2) {
                    series.values[point].x = 'B';
                } else if (xVal === 3) {
                    series.values[point].x = 'C';
                } else if (xVal === 4) {
                    series.values[point].x = 'D';
                } else if (xVal === 5) {
                    series.values[point].x = 'E';
                }
                ++xVal;
            }
        }
    });
    return data;
}