@extends('SuperAdmin.layout.home')
@section('title','Statistika')
@section('content')
<script src="https://d3js.org/d3.v7.min.js"></script>
<style>
    .chart-container {display: flex;justify-content: center;align-items: center;height: 500px;}
    .funnel-label {font-size: 12px;font-weight: bold;fill: #333;}
    .funnel-stilt {stroke: #666;stroke-width: 2;stroke-dasharray: 4, 2;}
    .funnel-segment {cursor: pointer;transition: fill 0.2s;}
    .funnel-segment:hover {fill: #ff5733 !important;}
    @media (max-width: 767px) {.chart-container {height: 300px;}.funnel-label {font-size: 12px;}}
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Statistika</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Form Statistika</li>
            </ol>
        </nav>
    </div> 
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="text-center">Oxirgi 30 kun</h2>
                            <div id="funnelChart1" class="chart-container"></div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h2 class="text-center">Oxirgi 365 kun</h2>
                            <div id="funnelChart2" class="chart-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <h2 class="text-center card-title w-100">Reklama uchun link:</h2>
            <ul>
                <li><b>Telegram: </b> <a href="https://crm.atko.tech/blog/create/user/Telegram"><i>https://crm.atko.tech/blog/create/user/Telegram</i></a></li>
                <li><b>Instagram: </b> <a href="https://crm.atko.tech/blog/create/user/Instagram"><i>https://crm.atko.tech/blog/create/user/Instagram</i></a></li>
                <li><b>Facebook: </b> <a href="https://crm.atko.tech/blog/create/user/Facebook"><i>https://crm.atko.tech/blog/create/user/Facebook</i></a></li>
                <li><b>Youtube: </b> <a href="https://crm.atko.tech/blog/create/user/Facebook"><i>https://crm.atko.tech/blog/create/user/Youtube</i></a></li>
            </ul>
        </div>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const data1 = [
            { stage: 'Form', value: {{ $Monch['FormO'] }} },
            { stage: 'Register', value: {{ $Monch['RegO'] }} },
            { stage: 'Guruh', value: {{ $Monch['GurO'] }} },
            { stage: 'To\'lov', value: {{ $Monch['TulO'] }} },
        ];
        const data2 = [
            { stage: 'Form', value: {{ $Monch['FormY'] }} },
            { stage: 'Register', value: {{ $Monch['RegY'] }} },
            { stage: 'Guruh', value: {{ $Monch['GurY'] }} },
            { stage: 'To\'lov', value: {{ $Monch['TulY'] }} },
        ];
        const createFunnelChart = (containerId, data) => {
            const container = d3.select(containerId);
            const containerWidth = container.node().getBoundingClientRect().width;
            const width = containerWidth;
            const height = 500;
            const chartWidth = width * 0.6;
            const chartHeight = 300;
            const svg = container.append("svg")
                .attr("width", width)
                .attr("height", height);
            const x = d3.scaleLinear()
                .domain([0, d3.max(data, d => d.value)])
                .range([0, chartWidth]);
            const y = d3.scaleBand()
                .domain(data.map(d => d.stage))
                .range([0, chartHeight])
                .padding(0.1);
            const colors = d3.scaleOrdinal(d3.schemeCategory10);
            const funnelLayer = svg.append("g")
                .attr("transform", `translate(${(width - chartWidth) / 2}, ${(height - chartHeight) / 2})`);
            funnelLayer.selectAll(".funnel-segment")
                .data(data)
                .enter()
                .append("path")
                .attr("class", "funnel-segment")
                .attr("d", (d, i) => {
                    const topWidth = x(d.value);
                    const bottomWidth = i < data.length - 2 ? x(data[i + 1].value) : topWidth;
                    const yPos = y(d.stage);
                    if (i === data.length - 1) {
                    // Rectangular path for the last stage
                    return `
                        M ${(chartWidth - topWidth) / 2} ${yPos}
                        L ${(chartWidth + topWidth) / 2} ${yPos}
                        L ${(chartWidth + topWidth) / 2} ${yPos + y.bandwidth()}
                        L ${(chartWidth - topWidth) / 2} ${yPos + y.bandwidth()}
                        Z
                    `;
                    } else {
                    return `
                        M ${(chartWidth - topWidth) / 2} ${yPos}
                        L ${(chartWidth + topWidth) / 2} ${yPos}
                        L ${(chartWidth + bottomWidth) / 2} ${yPos + y.bandwidth()}
                        L ${(chartWidth - bottomWidth) / 2} ${yPos + y.bandwidth()}
                        Z
                    `;
                    }
                })
                .attr("fill", (d, i) => colors(i));
                funnelLayer.selectAll(".funnel-label")
                    .data(data)
                    .enter()
                    .append("text")
                    .attr("class", "funnel-label")
                    .attr("x", chartWidth + 20)
                    .attr("y", d => y(d.stage) + y.bandwidth() / 2)
                    .attr("dy", ".35em")
                    .attr("text-anchor", "start")
                    .text(d => `${d.stage}: ${d.value}`);
                funnelLayer.selectAll(".funnel-stilt")
                    .data(data)
                    .enter()
                    .append("line")
                    .attr("class", "funnel-stilt")
                    .attr("x1", chartWidth + 10)
                    .attr("y1", d => y(d.stage) + y.bandwidth() / 2)
                    .attr("x2", d => (chartWidth + x(d.value)) / 2)
                    .attr("y2", d => y(d.stage) + y.bandwidth() / 2);
                }
                createFunnelChart("#funnelChart1", data1);
                createFunnelChart("#funnelChart2", data2);
                window.addEventListener('resize', () => {
                    d3.selectAll("svg").remove();
                    createFunnelChart("#funnelChart1", data1);
                    createFunnelChart("#funnelChart2", data2);
                });
        });
</script>
@endsection