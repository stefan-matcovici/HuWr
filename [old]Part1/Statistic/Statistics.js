var dataset = [
    { label: '0-12', count: 10 },
    { label: '13-18', count: 20 },
    { label: '19-35', count: 30 },
    { label: '36-70', count: 40 }
];

var years = [
    { year: '2010', migrations: 12 },
    { year: '2011', migrations: 21 },
    { year: '2012', migrations: 41 },
    { year: '2013', migrations: 33 },
    { year: '2014', migrations: 59 },
    { year: '2015', migrations: 38 },
];

var data = [
    { date: '1-May-12', close: 58.13 },
    { date: '30-Apr-12', close: 53.98 },
    { date: '27-Apr-12', close: 67.00 },
    { date: '26-Apr-12', close: 89.70 },
    { date: '25-Apr-12', close: 99.00 },
    { date: '24-Apr-12', close: 130.28 },
    { date: '23-Apr-12', close: 166.70 },
];

var width = 360;
var height = 360;
var radius = Math.min(width, height) / 2;
var color = d3.scaleOrdinal(d3.schemeCategory20b);
var donutWidth = 75;
var legendRectSize = 18;
var legendSpacing = 4;

function drawDonut() {
    d3.select(".jumbotron").append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto age-statistic");
    var card = d3.select(".age-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Migrations by age");

    var svg = d3.select('.age-statistic > .card-block')
        .append('svg')
        .attr('width', width)
        .attr('height', height)
        .append('g')
        .attr('transform', 'translate(' + (width / 2) + ',' + (height / 2) + ')');
    var arc = d3.arc()
        .innerRadius(radius - donutWidth)
        .outerRadius(radius);

    var pie = d3.pie()
        .value(function (d) { return d.count; })
        .sort(null);

    var path = svg.selectAll('path')
        .data(pie(dataset))
        .enter()
        .append('path')
        .attr('d', arc)
        .attr('fill', function (d, i) {
            return color(d.data.label);
        });
    var legend = svg.selectAll('.legend')
        .data(color.domain())
        .enter()
        .append('g')
        .attr('class', 'legend')
        .attr('transform', function (d, i) {
            var height = legendRectSize + legendSpacing;
            var offset = height * color.domain().length / 2;
            var horz = -2 * legendRectSize;
            var vert = i * height - offset;
            return 'translate(' + horz + ',' + vert + ')';
        });
    legend.append('rect')
        .attr('width', legendRectSize)
        .attr('height', legendRectSize)
        .style('fill', color)
        .style('stroke', color);
    legend.append('text')
        .attr('x', legendRectSize + legendSpacing)
        .attr('y', legendRectSize - legendSpacing)
        .text(function (d) { return d; });

    var div = card.append('div').attr('class','buttons');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To Json');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To SVG');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');
}

function drawBar() {
    var margin = { top: 20, right: 20, bottom: 30, left: 40 },
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    // set the ranges
    var x = d3.scaleBand()
        .range([0, width])
        .padding(0.1);
    var y = d3.scaleLinear()
        .range([height, 0]);

    d3.select(".jumbotron").append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto year-statistic");
    var card = d3.select(".year-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Migrations by year");

    var svg = d3.select('.year-statistic > .card-block')
        .append('svg')
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
        "translate(" + margin.left + "," + margin.top + ")");


    // format the data
    years.forEach(function (d) {
        d.migrations = +d.migrations;
    });

    // Scale the range of the data in the domains
    x.domain(years.map(function (d) { return d.year; }));
    y.domain([0, d3.max(years, function (d) { return d.migrations; })]);

    // append the rectangles for the bar chart
    svg.selectAll(".bar")
        .data(years)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function (d) { return x(d.year); })
        .attr("width", x.bandwidth())
        .attr("y", function (d) { return y(d.migrations); })
        .attr("height", function (d) { return height - y(d.migrations); });

    // add the x Axis
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    // add the y Axis
    svg.append("g")
        .call(d3.axisLeft(y));

    var div = card.append('div').attr('class','buttons');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To Json');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To SVG');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');
}

var margin = { top: 20, right: 20, bottom: 30, left: 50 },
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

function drawLine() {
    d3.select(".jumbotron").append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto kids-statistic");
    var card = d3.select(".kids-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Children Migrations");

    // set the dimensions and margins of the graph
    var margin = { top: 20, right: 20, bottom: 30, left: 50 },
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    // parse the date / time
    var parseTime = d3.timeParse("%d-%b-%y");

    // set the ranges
    var x = d3.scaleTime().range([0, width]);
    var y = d3.scaleLinear().range([height, 0]);

    // define the line
    var valueline = d3.line()
        .x(function (d) { return x(d.date); })
        .y(function (d) { return y(d.close); });

    // append the svg obgect to the body of the page
    // appends a 'group' element to 'svg'
    // moves the 'group' element to the top left margin
    var svg = d3.select('.kids-statistic > .card-block')
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
        "translate(" + margin.left + "," + margin.top + ")");

    data.forEach(function (d) {
        d.date = parseTime(d.date);
        d.close = +d.close;
    });
    // Scale the range of the data
    x.domain(d3.extent(data, function (d) { return d.date; }));
    y.domain([0, d3.max(data, function (d) { return d.close; })]);

    // Add the valueline path.
    svg.append("path")
        .data([data])
        .attr("class", "line")
        .attr("d", valueline);

    // Add the X Axis
    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    // Add the Y Axis
    svg.append("g")
        .call(d3.axisLeft(y));

    var div = card.append('div').attr('class','buttons');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To Json');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To SVG');
    div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');
}

function drawStatistics() {
    d3.select(".age-statistic").remove();
    d3.select(".year-statistic").remove();
    d3.select(".kids-statistic").remove();
    drawDonut();
    drawBar();
    drawLine();
}