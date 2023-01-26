<script>
    $(function() {

        // Chart column options
        var option = {
            color: ['#5c6bc0', '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

            textStyle: {
                fontFamily: 'var(--body-font-family)',
                color: 'var(--body-color)',
                fontSize: 14,
                lineHeight: 22,
                textBorderColor: 'transparent'
            },

            animationDuration: 750,

            grid: {
                left: 0,
                right: 45,
                top: 35,
                bottom: 0,
                containLabel: true
            },

            tooltip: {
                trigger: 'axis',
                className: 'shadow-sm rounded',
                backgroundColor: 'var(--white)',
                borderColor: 'var(--gray-400)',
                padding: 15,
                textStyle: {
                    color: '#000'
                },
                axisPointer: {
                    type: 'shadow',
                    shadowStyle: {
                        color: 'rgba(var(--body-color-rgb), 0.025)'
                    }
                }
            },

            toolbox: {
                show: true,
                feature: {
                    saveAsImage: {
                        title: 'Cetak',
                    }
                }
            },

            // Vertical axis
            yAxis: [{
                type: 'value',
                axisLabel: {
                    color: 'rgba(var(--body-color-rgb), .65)'
                },
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: 'var(--gray-500)'
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: 'var(--gray-300)'
                    }
                },
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                    }
                }
            }],
        };

        new chartLawYearlyColumn('chart_yearly_column', option);
        new chartLawMonthlyColumn('chart_monthly_column', option);
        new chartLawStatusColumn('law_status_chart', option);

        $('#law-statistic-filter-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/admin/legislation/statistic/filter', {action: action}, function(data) {
                $('#ajax-modal-body').html(data);
                $('.select').select2({
                    dropdownParent: $('.modal'),
                    minimumResultsForSearch: Infinity
                });
            })
        });

        $(document).on('submit', '#law-yearly-filter-form', function(e){
            e.preventDefault();

            let filter = $(this).serializeArray();
            new chartLawYearlyColumn('chart_yearly_column', option, filter);
            $('#law-statistic-filter-modal').modal('hide');
        })

        $(document).on('submit', '#law-monthly-filter-form', function(e){
            e.preventDefault();

            let filter = $(this).serializeArray();
            new chartLawMonthlyColumn('chart_monthly_column', option, filter);
            $('#law-statistic-filter-modal').modal('hide');
        })

        $.ajax({
            url: '/admin/visitor/download-chart',
            type: 'POST',
            dataType: 'JSON',
        }).done(function(data){
            $('#avg-downloads').html(data[6]['avg'].toFixed());
            new chartLine("#chart_line_basic", data, 50, '#2196F3', 'rgba(33,150,243,0.5)', '#2196F3', '#2196F3');
        })

        new mostViewedChart('#most-viewed-chart', 170);
        new mostDownloadChart('#most-download-chart', 170);
    });

    function chartLawYearlyColumn(elementId, option, filter) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/legislation/law-yearly-column-chart',
            type: 'POST',
		    data: filter,
            dataType: 'JSON',
        }).done(function(response) {

            var dom     = document.getElementById(elementId);
            var chart   = echarts.init(dom, null, { renderer: 'svg' });

            var obj = {

                legend: {
                    data: response.categories,
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)',
                        padding: [0, 5]
                    }
                },

                xAxis: [{
                    type: 'category',
                    data: response.years,
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)'
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'var(--gray-500)'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: 'var(--gray-300)',
                            type: 'dashed'
                        }
                    }
                }],

                series: response.series
            }

            let mergedOptions = Object.assign(option, obj);
            chart.setOption(mergedOptions, true);

            // Resize function
            var triggerChartResize = function() {
                dom && chart.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelectorAll('.sidebar-control');
            if (sidebarToggle) {
                sidebarToggle.forEach(function(togglers) {
                    togglers.addEventListener('click', triggerChartResize);
                });
            }

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });

            chart.on('click', function (params) {
                window.location.href = "/admin/legislation/law?filter=1&category="+params.seriesId+"&year="+response.years[params.dataIndex];
            });

            // Update title
            $('#countYears').html(response.years.length);
        });

    }

    function chartLawMonthlyColumn(elementId, option, filter) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/legislation/law-monthly-column-chart',
            type: 'POST',
            dataType: 'JSON',
		    data: filter,
        }).done(function(response) {

            var dom     = document.getElementById(elementId);
            var chart   = echarts.init(dom, null, { renderer: 'svg' });

            var obj = {
                legend: {
                    data: response.categories,
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)',
                        padding: [0, 5]
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: response.months,
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)'
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'var(--gray-500)'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: 'var(--gray-300)',
                            type: 'dashed'
                        }
                    }
                }],

                series: response.series
            }

            let mergedOptions = Object.assign(option, obj);
            chart.setOption(mergedOptions, true);

            // Resize function
            var triggerChartResize = function() {
                dom && chart.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelectorAll('.sidebar-control');
            if (sidebarToggle) {
                sidebarToggle.forEach(function(togglers) {
                    togglers.addEventListener('click', triggerChartResize);
                });
            }

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });

            chart.on('click', function (params) {
                let monthIndex = params.dataIndex + 1;
                window.location.href = "/admin/legislation/law?filter=1&category="+params.data.groupId+"&month="+monthIndex+"&year=2021";
            });

            $('#yearTitle').html(response.year);
        });

    }

    function chartLawStatusColumn(elementId, option, filter) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/legislation/law-status-column-chart',
            type: 'POST',
            data: filter,
            dataType: 'JSON',
        }).done(function(response) {

            var dom     = document.getElementById(elementId);
            var chart   = echarts.init(dom, null, { renderer: 'svg' });

            var obj = {

                legend: {
                    data: response.statuses,
                    itemHeight: 8,
                    itemGap: 30,
                    textStyle: {
                        color: 'var(--body-color)',
                        padding: [0, 5]
                    }
                },

                xAxis: [{
                    type: 'category',
                    data: response.years,
                    axisLabel: {
                        color: 'rgba(var(--body-color-rgb), .65)'
                    },
                    axisLine: {
                        lineStyle: {
                            color: 'var(--gray-500)'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: 'var(--gray-300)',
                            type: 'dashed'
                        }
                    }
                }],

                series: response.series
            }

            let mergedOptions = Object.assign(option, obj);
            chart.setOption(mergedOptions, true);

            // Resize function
            var triggerChartResize = function() {
                dom && chart.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelectorAll('.sidebar-control');
            if (sidebarToggle) {
                sidebarToggle.forEach(function(togglers) {
                    togglers.addEventListener('click', triggerChartResize);
                });
            }

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });

            chart.on('click', function (params) {
                window.location.href = "/admin/legislation/law?filter=1&status="+params.seriesName+"&year="+response.years[params.dataIndex];
            });

            // Update title
            $('#countYears').html(response.years.length);
        });

    }

    function chartLine(element, dataset, chartHeight, lineColor, pathColor, pointerLineColor, pointerBgColor) {

        // Initialize chart only if element exsists in the DOM
        if(element) {

            // Basic setup
            // ------------------------------

            // Main variables
            var d3Container = d3.select(element),
                margin = {top: 0, right: 0, bottom: 0, left: 0},
                width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                height = chartHeight - margin.top - margin.bottom,
                padding = 20;

            // Format date
            var parseDate = d3.time.format("%Y/%m/%d").parse,
                formatDate = d3.time.format("%e %b %Y");


            // Add tooltip
            // ------------------------------

            var tooltip = d3.tip()
                .attr('class', 'd3-tip')
                .html(function (d) {
                    return "<ul class='list-unstyled mb-1'>" +
                        "<li>" + "<div class='fs-base my-1'><i class='ph-calendar-blank me-2'></i>" + formatDate(d.date) + "</div>" + "</li>" +
                        "<li>" + "Total: &nbsp;" + "<span class='fw-semibold float-end'>" + d.qty + "</span>" + "</li>" +
                    "</ul>";
                });


            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append('svg');

            // Add SVG group
            var svg = container
                    .attr('width', width + margin.left + margin.right)
                    .attr('height', height + margin.top + margin.bottom)
                    .append("g")
                        .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
                        .call(tooltip);


            // Load data
            // ------------------------------

            dataset.forEach(function (d) {
                d.date = parseDate(d.date);
                d.qty = +d.qty;
            });


            // Construct scales
            // ------------------------------

            // Horizontal
            var x = d3.time.scale()
                .range([padding, width - padding]);

            // Vertical
            var y = d3.scale.linear()
                .range([height, 5]);


            // Set input domains
            // ------------------------------

            // Horizontal
            x.domain(d3.extent(dataset, function (d) {
                return d.date;
            }));

            // Vertical
            y.domain([0, d3.max(dataset, function (d) {
                return Math.max(d.qty);
            })]);


            // Construct chart layout
            // ------------------------------

            // Line
            var line = d3.svg.line()
                .x(function(d) {
                    return x(d.date);
                })
                .y(function(d) {
                    return y(d.qty);
                });


            //
            // Append chart elements
            //

            // Add mask for animation
            // ------------------------------

            // Add clip path
            var clip = svg.append("defs")
                .append("clipPath")
                .attr("id", "clip-line-small");

            // Add clip shape
            var clipRect = clip.append("rect")
                .attr('class', 'clip')
                .attr("width", 0)
                .attr("height", height);

            // Animate mask
            clipRect
                .transition()
                    .duration(1000)
                    .ease('linear')
                    .attr("width", width);


            // Line
            // ------------------------------

            // Path
            var path = svg.append('path')
                .attr({
                    'd': line(dataset),
                    "clip-path": "url(#clip-line-small)",
                    'class': 'd3-line d3-line-medium'
                })
                .style('stroke', lineColor);

            // Animate path
            svg.select('.line-tickets')
                .transition()
                    .duration(1000)
                    .ease('linear');


            // Add vertical guide lines
            // ------------------------------

            // Bind data
            var guide = svg.append('g')
                .selectAll('.d3-line-guides-group')
                .data(dataset);

            // Append lines
            guide
                .enter()
                .append('line')
                    .attr('class', 'd3-line-guides')
                    .attr('x1', function (d, i) {
                        return x(d.date);
                    })
                    .attr('y1', function (d, i) {
                        return height;
                    })
                    .attr('x2', function (d, i) {
                        return x(d.date);
                    })
                    .attr('y2', function (d, i) {
                        return height;
                    })
                    .style('stroke', pathColor)
                    .style('stroke-dasharray', '4,2')
                    .style('shape-rendering', 'crispEdges');

            // Animate guide lines
            guide
                .transition()
                    .duration(1000)
                    .delay(function(d, i) { return i * 150; })
                    .attr('y2', function (d, i) {
                        return y(d.qty);
                    });


            // Alpha app points
            // ------------------------------

            // Add points
            var points = svg.insert('g')
                .selectAll('.d3-line-circle')
                .data(dataset)
                .enter()
                .append('circle')
                    .attr('class', 'd3-line-circle d3-line-circle-medium')
                    .attr("cx", line.x())
                    .attr("cy", line.y())
                    .attr("r", 3)
                    .style({
                        'stroke': pointerLineColor,
                        'fill': pointerBgColor
                    });

            // Animate points on page load
            points
                .style('opacity', 0)
                .transition()
                    .duration(250)
                    .ease('linear')
                    .delay(1000)
                    .style('opacity', 1);

            // Add user interaction
            points
                .on("mouseover", function (d) {
                    tooltip.offset([-10, 0]).show(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 4);
                })

                // Hide tooltip
                .on("mouseout", function (d) {
                    tooltip.hide(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 3);
                });

            // Change tooltip direction of first point
            d3.select(points[0][0])
                .on("mouseover", function (d) {
                    tooltip.offset([0, 10]).direction('e').show(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 4);
                })
                .on("mouseout", function (d) {
                    tooltip.direction('n').hide(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 3);
                });

            // Change tooltip direction of last point
            d3.select(points[0][points.size() - 1])
                .on("mouseover", function (d) {
                    tooltip.offset([0, -10]).direction('w').show(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 4);
                })
                .on("mouseout", function (d) {
                    tooltip.direction('n').hide(d);

                    // Animate circle radius
                    d3.select(this).transition().duration(250).attr('r', 3);
                });


            // Resize chart
            // ------------------------------

            // Call function on window resize
            window.addEventListener('resize', lineChartResize);

            // Call function on sidebar width change
            var sidebarToggle = document.querySelector('.sidebar-control');
            sidebarToggle && sidebarToggle.addEventListener('click', lineChartResize);

            // Resize function
            //
            // Since D3 doesn't support SVG resize by default,
            // we need to manually specify parts of the graph that need to
            // be updated on window resize
            function lineChartResize() {

                // Layout variables
                width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                // Layout
                // -------------------------

                // Main svg width
                container.attr("width", width + margin.left + margin.right);

                // Width of appended group
                svg.attr("width", width + margin.left + margin.right);

                // Horizontal range
                x.range([padding, width - padding]);


                // Chart elements
                // -------------------------

                // Mask
                clipRect.attr("width", width);

                // Line path
                svg.selectAll('.d3-line').attr("d", line(dataset));

                // Circles
                svg.selectAll('.d3-line-circle').attr("cx", line.x());

                // Guide lines
                svg.selectAll('.d3-line-guides')
                    .attr('x1', function (d, i) {
                        return x(d.date);
                    })
                    .attr('x2', function (d, i) {
                        return x(d.date);
                    });
            }
        }
    }

    function mostViewedChart(elementId, size) {

        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/legislation/most-viewed-chart',
            type: 'POST',
            dataType: 'JSON',
        }).done(function(response) {

            var data = response

            // Main variables
            var d3Container = d3.select(elementId),
                distance = 2, // reserve 2px space for mouseover arc moving
                radius = (size/2) - distance,
                sum = d3.sum(data, function(d) { return d.value; });


            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append("svg");

            // Add SVG group
            var svg = container
                .attr("width", size)
                .attr("height", size)
                .append("g")
                    .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");


            // Construct chart layout
            // ------------------------------

            // Pie
            var pie = d3.layout.pie()
                .sort(null)
                .startAngle(Math.PI)
                .endAngle(3 * Math.PI)
                .value(function (d) {
                    return d.value;
                });

            // Arc
            var arc = d3.svg.arc()
                .outerRadius(radius);


            //
            // Append chart elements
            //

            // Group chart elements
            var arcGroup = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g")
                    .attr("class", "d3-arc d3-slice-border");

            // Append path
            var arcPath = arcGroup
                .append("path")
                .style("fill", function (d) {
                    return d.data.color;
                });


            // Add interactions
            arcPath
                .on('mouseover', function (d, i) {

                    // Transition on mouseover
                    d3.select(this)
                    .transition()
                        .duration(500)
                        .ease('elastic')
                        .attr('transform', function (d) {
                            d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                            var x = Math.sin(d.midAngle) * distance;
                            var y = -Math.cos(d.midAngle) * distance;
                            return 'translate(' + x + ',' + y + ')';
                        });
                })
                .on('mouseout', function (d, i) {

                    // Mouseout transition
                    d3.select(this)
                    .transition()
                        .duration(500)
                        .ease('bounce')
                        .attr('transform', 'translate(0,0)');
                });

            // Animate chart on load
            arcPath
                .transition()
                    .delay(function(d, i) { return i * 500; })
                    .duration(500)
                    .attrTween("d", function(d) {
                        var interpolate = d3.interpolate(d.startAngle,d.endAngle);
                        return function(t) {
                            d.endAngle = interpolate(t);
                            return arc(d);
                        };
                    });


            //
            // Append counter
            //

            // Append element
            d3Container
                .append('h4')
                .attr('class', 'pt-1 mt-2 mb-0');

            // Animate counter
            d3Container.select('h4')
                .transition()
                .duration(1500)
                .tween("text", function(d) {
                    var i = d3.interpolate(this.textContent, sum);

                    return function(t) {
                        this.textContent = d3.format(",d")(Math.round(i(t)));
                    };
                });


            //
            // Append legend
            //

            // Add element
            var legend = d3.select(elementId)
                .append('ul')
                .attr('class', 'chart-widget-legend')
                .selectAll('li').data(pie(data))
                .enter().append('li')
                .attr('data-slice', function(d, i) {
                    return i;
                })
                .attr('style', function(d, i) {
                    return 'border-bottom: 2px solid ' + d.data.color;
                })
                .text(function(d, i) {
                    return d.data.category + ': ';
                });

            // Add value
            legend.append('span')
                .text(function(d, i) {
                    return d.data.value.toLocaleString();
                });
        });
    }

    function mostDownloadChart(elementId, size) {

        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/legislation/most-download-chart',
            type: 'POST',
            dataType: 'JSON',
        }).done(function(response) {

            var data = response

            // Main variables
            var d3Container = d3.select(elementId),
                distance = 2, // reserve 2px space for mouseover arc moving
                radius = (size/2) - distance,
                sum = d3.sum(data, function(d) { return d.value; });


            // Create chart
            // ------------------------------

            // Add svg element
            var container = d3Container.append("svg");

            // Add SVG group
            var svg = container
                .attr("width", size)
                .attr("height", size)
                .append("g")
                    .attr("transform", "translate(" + (size / 2) + "," + (size / 2) + ")");


            // Construct chart layout
            // ------------------------------

            // Pie
            var pie = d3.layout.pie()
                .sort(null)
                .startAngle(Math.PI)
                .endAngle(3 * Math.PI)
                .value(function (d) {
                    return d.value;
                });

            // Arc
            var arc = d3.svg.arc()
                .outerRadius(radius);


            //
            // Append chart elements
            //

            // Group chart elements
            var arcGroup = svg.selectAll(".d3-arc")
                .data(pie(data))
                .enter()
                .append("g")
                    .attr("class", "d3-arc d3-slice-border");

            // Append path
            var arcPath = arcGroup
                .append("path")
                .style("fill", function (d) {
                    return d.data.color;
                });


            // Add interactions
            arcPath
                .on('mouseover', function (d, i) {

                    // Transition on mouseover
                    d3.select(this)
                    .transition()
                        .duration(500)
                        .ease('elastic')
                        .attr('transform', function (d) {
                            d.midAngle = ((d.endAngle - d.startAngle) / 2) + d.startAngle;
                            var x = Math.sin(d.midAngle) * distance;
                            var y = -Math.cos(d.midAngle) * distance;
                            return 'translate(' + x + ',' + y + ')';
                        });
                })
                .on('mouseout', function (d, i) {

                    // Mouseout transition
                    d3.select(this)
                    .transition()
                        .duration(500)
                        .ease('bounce')
                        .attr('transform', 'translate(0,0)');
                });

            // Animate chart on load
            arcPath
                .transition()
                    .delay(function(d, i) { return i * 500; })
                    .duration(500)
                    .attrTween("d", function(d) {
                        var interpolate = d3.interpolate(d.startAngle,d.endAngle);
                        return function(t) {
                            d.endAngle = interpolate(t);
                            return arc(d);
                        };
                    });


            //
            // Append counter
            //

            // Append element
            d3Container
                .append('h4')
                .attr('class', 'pt-1 mt-2 mb-0');

            // Animate counter
            d3Container.select('h4')
                .transition()
                .duration(1500)
                .tween("text", function(d) {
                    var i = d3.interpolate(this.textContent, sum);

                    return function(t) {
                        this.textContent = d3.format(",d")(Math.round(i(t)));
                    };
                });


            //
            // Append legend
            //

            // Add element
            var legend = d3.select(elementId)
                .append('ul')
                .attr('class', 'chart-widget-legend')
                .selectAll('li').data(pie(data))
                .enter().append('li')
                .attr('data-slice', function(d, i) {
                    return i;
                })
                .attr('style', function(d, i) {
                    return 'border-bottom: 2px solid ' + d.data.color;
                })
                .text(function(d, i) {
                    return d.data.category + ': ';
                });

            // Add value
            legend.append('span')
                .text(function(d, i) {
                    return d.data.value.toLocaleString();
                });
        });
        }
</script>
