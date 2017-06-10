function to_csv(objArray) {
    var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
    var str = '';

    for (key in objArray[0])
        str += key + ',';

    str = str.substring(0,str.length - 1);

    str += '\r\n';

    for (var i = 0; i < array.length; i++) {
        var line = '';
        for (var index in array[i]) {
            if (line != '') line += ','

            line += array[i][index];
        }

        str += line + '\r\n';
    }

    return str;
}

function drawDonut(selector,country,w,h,donutWidth,legendRectSize,legendSpacing,btn){
    var radius = Math.min(w, h) / 2;
    var color = d3.scaleOrdinal(d3.schemeCategory20b);

    d3.select(selector).append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto reason-statistic");
    var card = d3.select(".reason-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Migrations by reason");
    var spinner = card.append("i").attr("class","fa fa-refresh fa-3x ld ld-spin");

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
                spinner.style("display","none");

                if (dataset.length == 0)
                {
                    card.append("h2").text("Not enough data for this statistic");
                    return;
                }

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

                if (btn)
                {
                    var div = card.append('div').attr('class', 'buttons');
                    var htmlButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
                    var csvButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To CSV');
                    var pdfButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');

                    if (access_token == 1)
                    {
                        var shareButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('Share on Twitter');
                        shareButton.on("click", function () {
                            svg_to_image(document.querySelector(".reason-statistic svg"), 1);
                        });
                    }


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
                        saveAs(blob, "ReasonStatistic"+country+".svg");
                    });

                    csvButton.on("click", function(){
                        var csvContent = to_csv(dataset);
                        var a = window.document.createElement('a');
                        var arr = [csvContent];
                        a.href = window.URL.createObjectURL(new Blob(arr, {type: 'text/csv'}));
                        a.download = 'ReasonStatistic'+country+'.csv';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a)
                    });
                }
            }
        }
    }

    request.open ("GET", reasonURI, true);
    request.send (null);

}

function drawBar(selector,country, width, height, margin) {

    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest ();
    } else
    if (window.ActiveXObject) {
        request = new ActiveXObject ("Microsoft.XMLHTTP");
    }

    d3.select(selector).append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto year-statistic");
    var card = d3.select(".year-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Migrations by year");
    var spinner = card.append("i").attr("class","fa fa-refresh fa-3x ld ld-spin");


    var countryURI = basicURI + "/api/statistics/" + getCountryCode(country) + "/years";
    if (request) {
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                years =  JSON.parse(this.responseText);
                spinner.style("display","none");

                if (years.length == 0)
                {
                    card.append("h2").text("Not enough data for this statistic");
                    return;
                }

                var svg = d3.select('.year-statistic > .card-block')
                    .append('svg')
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                    .append("g")
                    .attr("transform",
                        "translate(" + margin.left + "," + margin.top + ")");

                // set the ranges
                var x = d3.scaleBand()
                    .range([0, width])
                    .padding(0.1);
                var y = d3.scaleLinear().range([height, 0]);

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
                var pdfButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To Pdf');
                var csvButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To CSV');

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
                    saveAs(blob, "YearStatistic"+country+".svg");
                });


                if (access_token == 1) {
                    var shareButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('Share on Twitter');
                    shareButton.on("click", function () {
                        svg_to_image(document.querySelector(".year-statistic svg"), 2);
                    });
                }

                csvButton.on("click", function(){
                    var csvContent = to_csv(years);
                    var a = window.document.createElement('a');
                    var arr = [csvContent];
                    a.href = window.URL.createObjectURL(new Blob(arr, {type: 'text/csv'}));
                    saveAs(blob,"YearStatistic"+country+".svg");
                    document.body.appendChild(a)
                    a.click();
                    document.body.removeChild(a)
                });
            }
        };
    }
    request.open ("GET", countryURI, true);
    request.send (null);
}

function drawLine(selector,country,width,height,margin) {

    d3.select(selector).append("div").attr("class", "card text-center rounded col-lg-10  mt-5 mx-auto kids-statistic");
    var card = d3.select(".kids-statistic").append("div").attr("class", "card-block");
    card.append("h2").text("Children Migrations");
    var spinner = card.append("i").attr("class","fa fa-refresh fa-3x ld ld-spin");

    var childrenURI = basicURI + "/api/statistics/" + getCountryCode(country) + "/children";
    if (window.XMLHttpRequest) {
        request = new XMLHttpRequest ();
    } else
    if (window.ActiveXObject) {
        request = new ActiveXObject ("Microsoft.XMLHTTP");
    }

    if (request) {
        request.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                spinner.style("display","none");
                data = JSON.parse(this.responseText);

                if (data.length == 0)
                {
                    card.append("h2").text("Not enough data for this statistic");
                    return;
                }

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

                var svg = d3.select('.kids-statistic > .card-block')
                    .append('svg').attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom);

                margin = {top: 20, right: 20, bottom: 30, left: 50},
                    width = +svg.attr("width") - margin.left - margin.right,
                    height = +svg.attr("height") - margin.top - margin.bottom,
                    g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

                var parseTime = d3.timeParse("%d-%b-%y");

                var x = d3.scaleTime()
                    .rangeRound([0, width]);

                var y = d3.scaleLinear()
                    .rangeRound([height, 0]);

                var line = d3.line()
                    .x(function(d) { return x(d.year); })
                    .y(function(d) { return y(d.close); });

                data.forEach(function(d) {
                    d.year = parseTime(d.year);
                    d.close = +d.close;
                });

                // Scale the range of the data
                x.domain(d3.extent(data, function(d) { return d.year; }));
                y.domain(d3.extent(data, function(d) { return d.close; }));

                g.append("g")
                    .attr("transform", "translate(0," + height + ")")
                    .call(d3.axisBottom(x))
                    .select(".domain")
                    .remove();

                g.append("g")
                    .call(d3.axisLeft(y))
                    .append("text")
                    .attr("fill", "#000")
                    .attr("transform", "rotate(-90)")
                    .attr("y", 6)
                    .attr("dy", "0.71em")
                    .attr("text-anchor", "end");

                g.append("path")
                    .datum(data)
                    .attr("fill", "none")
                    .attr("stroke", "steelblue")
                    .attr("stroke-linejoin", "round")
                    .attr("stroke-linecap", "round")
                    .attr("stroke-width", 1.5)
                    .attr("d", line);

                var div = card.append('div').attr('class','buttons');
                var htmlButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To HTML');
                var csvButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('To CSV');
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
                    saveAs(blob, "ChildrenStatistic"+country+".svg");
                });

                data.forEach(function(d){
                    var dat = new Date(d.year);
                    d.year = dat.getDate()  + "-" + (dat.getMonth()+1) + "-" + dat.getFullYear();
                });

                csvButton.on("click", function(){
                    var csvContent = to_csv(data);
                    var a = window.document.createElement('a');
                    var arr = [csvContent];
                    a.href = window.URL.createObjectURL(new Blob(arr, {type: 'text/csv'}));
                    a.download = "ReasonStatistic"+country+".csv";
                    document.body.appendChild(a)
                    a.click();
                    document.body.removeChild(a)
                });

                if (access_token == 1) {
                    var shareButton = div.append("button").attr('class', 'btn btn-primary mx-2').text('Share on Twitter');
                    shareButton.on("click", function () {
                        svg_to_image(document.querySelector(".kids-statistic svg"), 3);
                    });
                }
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

function svg_to_image (svg, type) {
    svgAsDataUri(svg, {}, function(svg_uri) {
        var image = document.createElement('img');
        var e = document.getElementById("country-location");
        var country = e.options[e.selectedIndex].value;

        image.src = svg_uri;
        image.onload = function() {
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var dataUrl;

            canvas.width = image.width;
            canvas.height = image.height;
            context.drawImage(image, 0, 0, image.width, image.height);

            var w = image.width;
            var h = image.height;
            data = context.getImageData(0, 0, w, h);
            var compositeOperation = context.globalCompositeOperation;
            context.globalCompositeOperation = "destination-over";
            context.fillStyle = "#ffffff";
            context.fillRect(0, 0, w, h);
            var imageData = canvas.toDataURL("image/jpeg");
            context.clearRect(0, 0, w, h);
            context.putImageData(data, 0, 0);
            context.globalCompositeOperation = compositeOperation;

            dataUrl = imageData;

            if (window.XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            console.log(dataUrl);
            if (request) {
                request.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("open-modal-button").click();
                    } else {
                        if (this.readyState == 4 && this.status != 200) {
                            document.getElementById("modal-text").innerHTML = "<p> An error occured. Please try again later. </p>"
                        }
                    }
                }
            }
            description = "";
            if (type === 1) {
                description = "Statistics for " + country + " about reasons for migrations.";
            }
            if (type === 2) {
                description = "Statistics for " + country + " migrations by years.";
            }
            if (type === 3) {
                description = "Statistics for " + country + " about children migrations.";
            }

            sendObject = `{ \"text":\"` + description + `\",\"image\": \"` + dataUrl +`\"  }`;
            request.open("POST", statisticShareURI, true);
            request.send(sendObject);
        }
    });
}