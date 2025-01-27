@extends('SuperAdmin.layout.home')
@section('title','Statistika')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Statistika</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('filial')}}">Filiallar</a></li>
            <li class="breadcrumb-item active">Oylik Statistika</li>
        </ol>
    </nav>
</div> 
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="row pt-2">
                    <div class="col-6 bg-primary"><a href="{{ route('SuperAdminStatistika',$filial_id) }}"><h5 class="card-title w-100 text-center  text-white">Oylik Statistika</h5></a></div>
                    <div class="col-6"><a href="{{ route('statistikaKun',$filial_id) }}"><h5 class="card-title w-100 text-center text-primary">Kunlik Statistika</h5></a></div>
                </div><hr class="p-0 m-0">
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="card-title">Oylik tashriflar</h1>
                        <canvas id="kunlik_tashrif" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#kunlik_tashrif'), {
                                type: 'radar',
                                data: {
                                    labels: [
                                        "{{ $Tashriflar[0]['month'] }}",
                                        "{{ $Tashriflar[1]['month'] }}",
                                        "{{ $Tashriflar[2]['month'] }}",
                                        "{{ $Tashriflar[3]['month'] }}",
                                        "{{ $Tashriflar[4]['month'] }}",
                                        "{{ $Tashriflar[5]['month'] }}",
                                        "{{ $Tashriflar[6]['month'] }}"
                                    ],
                                    datasets: [{
                                    label: '',
                                    data: [
                                        {{ $Tashriflar[0]['tashriflar'] }},
                                        {{ $Tashriflar[1]['tashriflar'] }},
                                        {{ $Tashriflar[2]['tashriflar'] }},
                                        {{ $Tashriflar[3]['tashriflar'] }},
                                        {{ $Tashriflar[4]['tashriflar'] }},
                                        {{ $Tashriflar[5]['tashriflar'] }},
                                        {{ $Tashriflar[6]['tashriflar'] }},
                                    ],
                                    fill: true,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgb(54, 162, 235)',
                                    pointBackgroundColor: 'rgb(54, 162, 235)',
                                    pointBorderColor: '#fff',
                                    pointHoverBackgroundColor: '#fff',
                                    pointHoverBorderColor: 'rgb(54, 162, 235)'
                                    }]
                                },
                                options: {elements: {line: {borderWidth: 3}}}
                                });
                            });
                        </script>
                    </div>
                    <div class="col-lg-6">
                        <h1 class="card-title">Tashriflar(oxirgi 45 kun)</h1>
                        <canvas id="crm_tashrif" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#crm_tashrif'), {
                                    type: 'radar',
                                    data: {
                                        labels: ['Telegram','Instagram','Facebook','Bannerlar','Tanishlar','Boshqa'],
                                        datasets: [{
                                            label: '',
                                            data: [
                                                    {{ $Tashriflar['telegram'] }},
                                                    {{ $Tashriflar['instagram'] }},
                                                    {{ $Tashriflar['facebook'] }},
                                                    {{ $Tashriflar['banner'] }},
                                                    {{ $Tashriflar['tanishlar'] }},
                                                    {{ $Tashriflar['boshqalar'] }},
                                                ],
                                            fill: true,
                                            backgroundColor: 'rgba(255, 65, 65, 0.4)',
                                            borderColor: 'rgb(52, 205, 244)',
                                            pointBackgroundColor: 'rgb(54, 205, 244)',
                                            pointBorderColor: '#fff',
                                            pointHoverBackgroundColor: '#fff',
                                            pointHoverBorderColor: 'rgb(54, 205, 235)'
                                        }]
                                    },
                                    options: {elements: {line: {borderWidth: 3}}}
                                });
                            });
                        </script>
                    </div>
                    <div class="col-lg-12"><hr></div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Activ Talabalar</h5>
                                <div id="lineChart"></div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#lineChart"), {
                                            series: [{name: "Activ tashriflar",
                                                data: [
                                                    {{ $Active[0]['count'] }},
                                                    {{ $Active[1]['count'] }},
                                                    {{ $Active[2]['count'] }},
                                                    {{ $Active[3]['count'] }},
                                                    {{ $Active[4]['count'] }},
                                                    {{ $Active[5]['count'] }},
                                                    {{ $Active[6]['count'] }},
                                                ]
                                            }],
                                            chart: {height: 350,type: 'line',zoom: {enabled: false}},
                                            dataLabels: {enabled: false},
                                            stroke: {curve: 'straight'},
                                            grid: {row: {colors: ['#f3f3f3', 'transparent'],opacity: 0.5},},
                                            xaxis: {categories: 
                                                [
                                                    "{{ $Active[0]['data'] }}",
                                                    "{{ $Active[1]['data'] }}",
                                                    "{{ $Active[2]['data'] }}",
                                                    "{{ $Active[3]['data'] }}",
                                                    "{{ $Active[4]['data'] }}",
                                                    "{{ $Active[5]['data'] }}",
                                                    "{{ $Active[6]['data'] }}",
                                                ]
                                            ,}
                                        }).render();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body pt-3 mb-3">
                                <canvas id="statistika" style="max-height: 400px;"></canvas>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new Chart(document.querySelector('#statistika'), {
                                            type: 'radar',
                                            data: {
                                                labels: [
                                                    "{{ $Yillik[1]['date'] }}",
                                                    "{{ $Yillik[2]['date'] }}",
                                                    "{{ $Yillik[3]['date'] }}",
                                                    "{{ $Yillik[4]['date'] }}",
                                                    "{{ $Yillik[5]['date'] }}",
                                                    "{{ $Yillik[6]['date'] }}",
                                                    "{{ $Yillik[7]['date'] }}",
                                                    "{{ $Yillik[8]['date'] }}",
                                                    "{{ $Yillik[9]['date'] }}",
                                                    "{{ $Yillik[10]['date'] }}",
                                                    "{{ $Yillik[11]['date'] }}",
                                                    "{{ $Yillik[12]['date'] }}"
                                                ],
                                                datasets: [{
                                                    label: "To'lovlar",
                                                    data: [
                                                        {{ $Yillik[1]['Tulov'] }},
                                                        {{ $Yillik[2]['Tulov'] }},
                                                        {{ $Yillik[3]['Tulov'] }},
                                                        {{ $Yillik[4]['Tulov'] }},
                                                        {{ $Yillik[5]['Tulov'] }},
                                                        {{ $Yillik[6]['Tulov'] }},
                                                        {{ $Yillik[7]['Tulov'] }},
                                                        {{ $Yillik[8]['Tulov'] }},
                                                        {{ $Yillik[9]['Tulov'] }},
                                                        {{ $Yillik[10]['Tulov'] }},
                                                        {{ $Yillik[11]['Tulov'] }},
                                                        {{ $Yillik[12]['Tulov'] }},
                                                    ],
                                                    fill: true,
                                                    backgroundColor: 'rgba(255, 65, 65, 0.4)',
                                                    borderColor: 'green',
                                                    pointBackgroundColor: 'rgb(54, 205, 244)',
                                                    pointBorderColor: '#fff',
                                                    pointHoverBackgroundColor: '#fff',
                                                    pointHoverBorderColor: 'rgb(54, 205, 235)'
                                                },{
                                                    label: "Xarajatlar + Ish haqi",
                                                    data: [
                                                        {{ $Yillik[1]['Xarajat'] }},
                                                        {{ $Yillik[2]['Xarajat'] }},
                                                        {{ $Yillik[3]['Xarajat'] }},
                                                        {{ $Yillik[4]['Xarajat'] }},
                                                        {{ $Yillik[5]['Xarajat'] }},
                                                        {{ $Yillik[6]['Xarajat'] }},
                                                        {{ $Yillik[7]['Xarajat'] }},
                                                        {{ $Yillik[8]['Xarajat'] }},
                                                        {{ $Yillik[9]['Xarajat'] }},
                                                        {{ $Yillik[10]['Xarajat'] }},
                                                        {{ $Yillik[11]['Xarajat'] }},
                                                        {{ $Yillik[12]['Xarajat'] }},
                                                    ],
                                                    fill: true,
                                                    backgroundColor: 'rgba(255, 255, 65, 0.4)',
                                                    borderColor: 'blue',
                                                    pointBackgroundColor: 'rgb(54, 205, 244)',
                                                    pointBorderColor: '#fff',
                                                    pointHoverBackgroundColor: '#fff',
                                                    pointHoverBorderColor: 'rgb(54, 205, 235)'
                                                }]
                                            },
                                            options: {elements: {line: {borderWidth: 3}}}
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h1 class="card-title">Oylik to'lovlar</h1>
                        <div id="columnChart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#columnChart"), {
                                    series: [{
                                        name: "Naqt to'lovlar",
                                        data: [
                                            {{ $OylikTulovAll[0]['Naqt'] }},
                                            {{ $OylikTulovAll[1]['Naqt'] }},
                                            {{ $OylikTulovAll[2]['Naqt'] }},
                                            {{ $OylikTulovAll[3]['Naqt'] }},
                                            {{ $OylikTulovAll[4]['Naqt'] }},
                                            {{ $OylikTulovAll[5]['Naqt'] }},
                                            {{ $OylikTulovAll[6]['Naqt'] }}
                                        ]
                                    }, {
                                        name: "Plastik to'lovlar",
                                        data: [
                                            {{ $OylikTulovAll[0]['Plastik'] }},
                                            {{ $OylikTulovAll[1]['Plastik'] }},
                                            {{ $OylikTulovAll[2]['Plastik'] }},
                                            {{ $OylikTulovAll[3]['Plastik'] }},
                                            {{ $OylikTulovAll[4]['Plastik'] }},
                                            {{ $OylikTulovAll[5]['Plastik'] }},
                                            {{ $OylikTulovAll[6]['Plastik'] }}
                                        ]
                                    }, {
                                        name: "Payme to'lov",
                                        data: [
                                            {{ $OylikTulovAll[0]['Payme'] }},
                                            {{ $OylikTulovAll[1]['Payme'] }},
                                            {{ $OylikTulovAll[2]['Payme'] }},
                                            {{ $OylikTulovAll[3]['Payme'] }},
                                            {{ $OylikTulovAll[4]['Payme'] }},
                                            {{ $OylikTulovAll[5]['Payme'] }},
                                            {{ $OylikTulovAll[6]['Payme'] }}
                                        ]
                                    }, {
                                        name: "Qaytarilgan to'lovlar",
                                        data: [
                                            {{ $OylikTulovAll[0]['Qaytar'] }},
                                            {{ $OylikTulovAll[1]['Qaytar'] }},
                                            {{ $OylikTulovAll[2]['Qaytar'] }},
                                            {{ $OylikTulovAll[3]['Qaytar'] }},
                                            {{ $OylikTulovAll[4]['Qaytar'] }},
                                            {{ $OylikTulovAll[5]['Qaytar'] }},
                                            {{ $OylikTulovAll[6]['Qaytar'] }}
                                        ]
                                    }, {
                                        name: "Chegirmalar",
                                        data: [
                                            {{ $OylikTulovAll[0]['Chegirma'] }},
                                            {{ $OylikTulovAll[1]['Chegirma'] }},
                                            {{ $OylikTulovAll[2]['Chegirma'] }},
                                            {{ $OylikTulovAll[3]['Chegirma'] }},
                                            {{ $OylikTulovAll[4]['Chegirma'] }},
                                            {{ $OylikTulovAll[5]['Chegirma'] }},
                                            {{ $OylikTulovAll[6]['Chegirma'] }}
                                        ]
                                    }],
                                    chart: {type: 'bar',height: 350},
                                    plotOptions: {
                                        bar: {horizontal: false,columnWidth: '55%',endingShape: 'rounded'},
                                    },
                                    dataLabels: {enabled: false},
                                    stroke: {show: true,width: 2,colors: ['transparent']},
                                    xaxis: {
                                        categories: [
                                            "{{ $OylikTulovAll[0]['date'] }}",
                                            "{{ $OylikTulovAll[1]['date'] }}",
                                            "{{ $OylikTulovAll[2]['date'] }}",
                                            "{{ $OylikTulovAll[3]['date'] }}",
                                            "{{ $OylikTulovAll[4]['date'] }}",
                                            "{{ $OylikTulovAll[5]['date'] }}",
                                            "{{ $OylikTulovAll[6]['date'] }}"
                                        ],
                                    },
                                    yaxis: {title: {text: "Oylik to'lovlar"}},
                                fill: {opacity: 1},
                                tooltip: {y: {formatter: function(val) {return val + " so'm"}}}
                                }).render();
                            });
                        </script>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                                <thead>
                                    <tr>
                                        <th>#/#</th>
                                        <th>{{ $OylikTulovAll[0]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[1]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[2]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[3]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[4]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[5]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[6]['date'] }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="text-align:left;">Naqt To'lovlar</th>
                                        <td>{{ $OylikTulovAll[0]['Naqt_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Naqt_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Naqt_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Naqt_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Naqt_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Naqt_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Naqt_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Plastik To'lovlar</th>
                                        <td>{{ $OylikTulovAll[0]['Plastik_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Plastik_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Plastik_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Plastik_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Plastik_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Plastik_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Plastik_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Payme to'lov</th>
                                        <td>{{ $OylikTulovAll[0]['Payme_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Payme_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Payme_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Payme_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Payme_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Payme_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Payme_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Chegirma To'lovlar</th>
                                        <td>{{ $OylikTulovAll[0]['Chegirma_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Chegirma_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Chegirma_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Chegirma_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Chegirma_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Chegirma_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Chegirma_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Qaytarilgan To'lovlar</th>
                                        <td>{{ $OylikTulovAll[0]['Qaytar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Qaytar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Qaytar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Qaytar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Qaytar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Qaytar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Qaytar_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Naqt + Plastik + Payme - Qaytarildi</th>
                                        <td>{{ $OylikTulovAll[0]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['TulovSum_table'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <h1 class="card-title">To'lov Statistikasi</h1>
                        <canvas id="barChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#barChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: [
                                            "{{ $OylikTulovAll[0]['date'] }}",
                                            "{{ $OylikTulovAll[1]['date'] }}",
                                            "{{ $OylikTulovAll[2]['date'] }}",
                                            "{{ $OylikTulovAll[3]['date'] }}",
                                            "{{ $OylikTulovAll[4]['date'] }}",
                                            "{{ $OylikTulovAll[5]['date'] }}",
                                            "{{ $OylikTulovAll[6]['date'] }}"
                                        ],
                                        datasets: [{
                                            label: "To'lovlar",
                                            data: [
                                                {{ $OylikTulovAll[0]['Tulovlar'] }},
                                                {{ $OylikTulovAll[1]['Tulovlar'] }},
                                                {{ $OylikTulovAll[2]['Tulovlar'] }},
                                                {{ $OylikTulovAll[3]['Tulovlar'] }},
                                                {{ $OylikTulovAll[4]['Tulovlar'] }},
                                                {{ $OylikTulovAll[5]['Tulovlar'] }},
                                                {{ $OylikTulovAll[6]['Tulovlar'] }}
                                            ],
                                            backgroundColor: ['rgba(39, 208, 255, 0.2)'],
                                            borderColor: ['rgb(39, 208, 255)'],
                                            borderWidth: 1
                                        },{label: "Xarajatlar",
                                            data: [
                                                {{ $OylikTulovAll[0]['Xarajatlar'] }},
                                                {{ $OylikTulovAll[1]['Xarajatlar'] }},
                                                {{ $OylikTulovAll[2]['Xarajatlar'] }},
                                                {{ $OylikTulovAll[3]['Xarajatlar'] }},
                                                {{ $OylikTulovAll[4]['Xarajatlar'] }},
                                                {{ $OylikTulovAll[5]['Xarajatlar'] }},
                                                {{ $OylikTulovAll[6]['Xarajatlar'] }}
                                            ],
                                            backgroundColor: ['rgba(69, 96, 255, 0.2)'],
                                            borderColor: ['rgb(69, 96, 255)'],
                                            borderWidth: 1
                                        },{label: "Ish haqi",
                                            data: [
                                                {{ $OylikTulovAll[0]['IshHaq'] }},
                                                {{ $OylikTulovAll[1]['IshHaq'] }},
                                                {{ $OylikTulovAll[2]['IshHaq'] }},
                                                {{ $OylikTulovAll[3]['IshHaq'] }},
                                                {{ $OylikTulovAll[4]['IshHaq'] }},
                                                {{ $OylikTulovAll[5]['IshHaq'] }},
                                                {{ $OylikTulovAll[6]['IshHaq'] }}
                                            ],
                                            backgroundColor: ['rgba(175, 25, 255, 0.2)'],
                                            borderColor: ['rgb(175, 25, 255)'],
                                            borderWidth: 1
                                        },{label: "Daromad",
                                            data: [
                                                {{ $OylikTulovAll[0]['Daromat'] }},
                                                {{ $OylikTulovAll[1]['Daromat'] }},
                                                {{ $OylikTulovAll[2]['Daromat'] }},
                                                {{ $OylikTulovAll[3]['Daromat'] }},
                                                {{ $OylikTulovAll[4]['Daromat'] }},
                                                {{ $OylikTulovAll[5]['Daromat'] }},
                                                {{ $OylikTulovAll[6]['Daromat'] }}
                                            ],
                                            backgroundColor: ['rgba(255, 25, 255, 0.2)'],
                                            borderColor: ['rgb(255, 25, 255)'],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {scales: {y: {beginAtZero: true}}}
                                });
                            });
                        </script>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                                <thead>
                                    <tr>
                                        <th>#/#</th>
                                        <th>{{ $OylikTulovAll[0]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[1]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[2]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[3]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[4]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[5]['date'] }}</th>
                                        <th>{{ $OylikTulovAll[6]['date'] }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="text-align:left;"><b title="Naqt+Plastik+Payme-Qaytarildi">To'lovlar</b></th>
                                        <td>{{ $OylikTulovAll[0]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['TulovSum_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['TulovSum_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;"><b title="Umumit xarajatlar">Xarajatlar</b></th>
                                        <td>{{ $OylikTulovAll[0]['Xarajatlar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Xarajatlar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Xarajatlar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Xarajatlar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Xarajatlar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Xarajatlar_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Xarajatlar_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;"><b title="Hodim+O'qituvchi">Ish haqi</b></th>
                                        <td>{{ $OylikTulovAll[0]['IshHaq_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['IshHaq_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['IshHaq_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['IshHaq_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['IshHaq_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['IshHaq_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['IshHaq_table'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;"><b title="Daromad">Daromad</b></th>
                                        <td>{{ $OylikTulovAll[0]['Daromat_table'] }}</td>
                                        <td>{{ $OylikTulovAll[1]['Daromat_table'] }}</td>
                                        <td>{{ $OylikTulovAll[2]['Daromat_table'] }}</td>
                                        <td>{{ $OylikTulovAll[3]['Daromat_table'] }}</td>
                                        <td>{{ $OylikTulovAll[4]['Daromat_table'] }}</td>
                                        <td>{{ $OylikTulovAll[5]['Daromat_table'] }}</td>
                                        <td>{{ $OylikTulovAll[6]['Daromat_table'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </section>

</main>

@endsection