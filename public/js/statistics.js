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

// var data = [
//     { date: '1-May-12', close: 58.13 },
//     { date: '30-Apr-12', close: 53.98 },
//     { date: '27-Apr-12', close: 67.00 },
//     { date: '26-Apr-12', close: 89.70 },
//     { date: '25-Apr-12', close: 99.00 },
//     { date: '24-Apr-12', close: 130.28 },
//     { date: '23-Apr-12', close: 166.70 },
// ];


function drawDonut(selector,country,w,h,donutWidth,legendRectSize,legendSpacing,btn){
    var radius = Math.min(w, h) / 2;
    var color = d3.scaleOrdinal(d3.schemeCategory20b);

    d3.select(selector).append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto reason-statistic");
    var card = d3.select(".reason-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Migrations by reason");

    var svg = d3.select('.reason-statistic > .card-block')
        .append('svg')
        .attr('width', w)
        .attr('height', h)
        .append('g')
        .attr('transform', 'translate(' + (w / 2) + ',' + (h / 2) + ')');
    var arc = d3.arc()
        .innerRadius(radius - donutWidth)
        .outerRadius(radius);

    var pie = d3.pie()
        .value(function (d) { return d.count; })
        .sort(null);

    var reasonURI = basicURI + "/api/statistics/" + getCountryCode(country) + "/reasons";
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest ();
    } else
    if (window.ActiveXObject) {
        request = new ActiveXObject ("Microsoft.XMLHTTP");
    }

    if (request) {
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                dataset = JSON.parse(this.responseText);

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
                    .text(function (d) {
                        return d;
                    });
            }
        }
    }

    request.open ("GET", reasonURI, true);
    request.send (null);

    if (btn) {
        var div = card.append('div').attr('class', 'buttons');
        var htmlButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
        var jsonButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Json');
        var svgButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To SVG');
        var pdfButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');

        pdfButton.on("click", function () {
            svg_to_pdf(document.querySelector(".reason-statistic svg"), function (pdf) {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                today = mm + '/' + dd + '/' + yyyy;
                centeredText(pdf, 'Reason statistic for ' + country + ' made on ' + today, 15);
                pdf.output('dataurlnewwindow');
            });
        });

        htmlButton.on("click", function () {
            try {
                var isFileSaverSupported = !!new Blob();
            } catch (e) {
                alert("blob not supported");
            }

            var html = d3.select(".reason-statistic svg")
                .attr("title", "test2")
                .attr("version", 1.1)
                .attr("xmlns", "http://www.w3.org/2000/svg")
                .node().outerHTML;

            var blob = new Blob([html], {type: "image/svg+xml"});
            saveAs(blob, "myProfile.svg");
        });
    }

}

function drawBar(selector,country, width, height, margin) {

    var countryURI = basicURI + "/api/statistics/" + getCountryCode(country) + "/years";
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest ();
    } else
    if (window.ActiveXObject) {
        request = new ActiveXObject ("Microsoft.XMLHTTP");
    }

    // set the ranges
    var x = d3.scaleBand()
        .range([0, width])
        .padding(0.1);
    var y = d3.scaleLinear().range([height, 0]);

    d3.select(selector).append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto year-statistic");
    var card = d3.select(".year-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Migrations by year");

    var svg = d3.select('.year-statistic > .card-block')
        .append('svg')
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

    if (request) {
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                years =  JSON.parse(this.responseText);

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
                var htmlButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
                var jsonButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Json');
                var svgButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To SVG');
                var pdfButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');

                pdfButton.on("click", function(){
                    svg_to_pdf(document.querySelector(".year-statistic svg"), function (pdf) {
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;
                        var yyyy = today.getFullYear();
                        today = mm+'/'+dd+'/'+yyyy;
                        centeredText(pdf,'Year statistic for '+country+' made on '+ today,15);
                        pdf.output('dataurlnewwindow');
                    });
                });

                htmlButton.on("click", function(){
                    try {
                        var isFileSaverSupported = !!new Blob();
                    } catch (e) {
                        alert("blob not supported");
                    }

                    var html = d3.select(".year-statistic svg")
                        .attr("title", "test2")
                        .attr("version", 1.1)
                        .attr("xmlns", "http://www.w3.org/2000/svg")
                        .node().outerHTML;

                    var blob = new Blob([html], {type: "image/svg+xml"});
                    saveAs(blob, "myProfile.svg");
                });
            }
        };
    }
    request.open ("GET", countryURI, true);
    request.send (null);
}

function drawLine(selector,country,width,height,margin) {

    var childrenURI = basicURI + "/api/statistics/" + getCountryCode(country) + "/children";
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest ();
    } else
    if (window.ActiveXObject) {
        request = new ActiveXObject ("Microsoft.XMLHTTP");
    }

    d3.select(selector).append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto kids-statistic");
    var card = d3.select(".kids-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Children Migrations");

    // parse the date / time
    var parseTime = d3.timeParse("%y");

    // set the ranges
    var x = d3.scaleBand()
        .range([0, width])
    var y = d3.scaleLinear().range([height, 0]);

    // define the line
    var valueline = d3.line()
        .x(function (d) { return x(d.year); })
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

    if (request) {
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                data = JSON.parse(this.responseText);

                console.log(data);


                //console.log(data);
                // Scale the range of the data
                x.domain(data.map(function (d) { return d.year; }));
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
                var htmlButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
                var jsonButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Json');
                var svgButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To SVG');
                var pdfButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');

                pdfButton.on("click", function(){
                    svg_to_pdf(document.querySelector(".kids-statistic svg"), function (pdf) {
                        var today = new Date();
                        var dd = today.getDate();
                        var mm = today.getMonth()+1;
                        var yyyy = today.getFullYear();
                        today = mm+'/'+dd+'/'+yyyy;
                        centeredText(pdf,'Children statistic for '+country+' made on '+ today,15);
                        pdf.output('dataurlnewwindow');
                    });
                });

                htmlButton.on("click", function(){
                    try {
                        var isFileSaverSupported = !!new Blob();
                    } catch (e) {
                        alert("blob not supported");
                    }

                    var html = d3.select(".kids-statistic svg")
                        .attr("title", "test2")
                        .attr("version", 1.1)
                        .attr("xmlns", "http://www.w3.org/2000/svg")
                        .node().outerHTML;

                    var blob = new Blob([html], {type: "image/svg+xml"});
                    saveAs(blob, "myProfile.svg");
                });
            }
        }
    }

    request.open ("GET", childrenURI, true);
    request.send (null);
}

function drawStatistics() {
    d3.select(".reason-statistic").remove();
    d3.select(".year-statistic").remove();
    d3.select(".kids-statistic").remove();


    var e = document.getElementById("country-location");
    var country = e.options[e.selectedIndex].value;

    var margin = { top: 20, right: 20, bottom: 30, left: 50 },
        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    var donutWidth = 75;
    var legendRectSize = 30;
    var legendSpacing = 4;


    drawDonut(".jumbotron",country,width,height,donutWidth,legendRectSize,legendSpacing,true);
    drawBar(".jumbotron",country,width,height,margin);
    drawLine(".jumbotron",country,width,height,margin);
}