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
            <li class="breadcrumb-item active">Kunlik Statistika</li>
        </ol>
    </nav>
</div> 
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="row pt-2">
                    <div class="col-6"><a href="{{ route('SuperAdminStatistika',$filial_id) }}"><h5 class="card-title w-100 text-center  text-primary">Oylik Statistika</h5></a></div>
                    <div class="col-6 bg-primary"><a href="{{ route('statistikaKun',$filial_id) }}"><h5 class="card-title w-100 text-center text-white">Kunlik Statistika</h5></a></div>
                </div><hr class="p-0 m-0">
    
                <div class="row">
                    <div class="col-lg-6">
                        <h1 class="card-title">Kunlik tashriflar</h1>
                        <canvas id="kunlik_tashrif" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new Chart(document.querySelector('#kunlik_tashrif'), {
                                type: 'radar',
                                data: {
                                    labels: [
                                        "{{ $TashSMM['kunlik_tashrif']['0']['day_name'] }}",
                                        "{{ $TashSMM['kunlik_tashrif']['1']['day_name'] }}",
                                        "{{ $TashSMM['kunlik_tashrif']['2']['day_name'] }}",
                                        "{{ $TashSMM['kunlik_tashrif']['3']['day_name'] }}",
                                        "{{ $TashSMM['kunlik_tashrif']['4']['day_name'] }}",
                                        "{{ $TashSMM['kunlik_tashrif']['5']['day_name'] }}",
                                        "{{ $TashSMM['kunlik_tashrif']['6']['day_name'] }}"],
                                    datasets: [{
                                    label: '',
                                    data: [
                                        {{ $TashSMM['kunlik_tashrif']['0']['user_count'] }},
                                        {{ $TashSMM['kunlik_tashrif']['1']['user_count'] }},
                                        {{ $TashSMM['kunlik_tashrif']['2']['user_count'] }},
                                        {{ $TashSMM['kunlik_tashrif']['3']['user_count'] }},
                                        {{ $TashSMM['kunlik_tashrif']['4']['user_count'] }},
                                        {{ $TashSMM['kunlik_tashrif']['5']['user_count'] }},
                                        {{ $TashSMM['kunlik_tashrif']['6']['user_count'] }}],
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
                        <h1 class="card-title">Tashriflar(oxirgi 7kun)</h1>
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
                                            "{{ $TashSMM['smm']['Telegram'] }}",
                                            "{{ $TashSMM['smm']['Instagram'] }}",
                                            "{{ $TashSMM['smm']['Facebook'] }}",
                                            "{{ $TashSMM['smm']['Banner'] }}",
                                            "{{ $TashSMM['smm']['Tanishlar'] }}",
                                            "{{ $TashSMM['smm']['Boshqalar'] }}"
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
                    <div class="col-12">
                        <h1 class="card-title">Kunlik to'lovlar</h1>
                        <div id="columnChart"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#columnChart"), {
                                    series: [{
                                        name: "Naqt to'lovlar",
                                        data: [
                                        {{ $Tulov[0]['Naqt'] }},
                                        {{ $Tulov[1]['Naqt'] }},
                                        {{ $Tulov[2]['Naqt'] }},
                                        {{ $Tulov[3]['Naqt'] }},
                                        {{ $Tulov[4]['Naqt'] }},
                                        {{ $Tulov[5]['Naqt'] }},
                                        {{ $Tulov[6]['Naqt'] }}
                                        ]
                                    }, {
                                        name: "Plastik to'lovlar",
                                        data: [
                                        {{ $Tulov[0]['Plastik'] }},
                                        {{ $Tulov[1]['Plastik'] }},
                                        {{ $Tulov[2]['Plastik'] }},
                                        {{ $Tulov[3]['Plastik'] }},
                                        {{ $Tulov[4]['Plastik'] }},
                                        {{ $Tulov[5]['Plastik'] }},
                                        {{ $Tulov[6]['Plastik'] }}
                                        ]
                                    }, {
                                        name: "Payme to'lov",
                                        data: [
                                        {{ $Tulov[0]['Payme'] }},
                                        {{ $Tulov[1]['Payme'] }},
                                        {{ $Tulov[2]['Payme'] }},
                                        {{ $Tulov[3]['Payme'] }},
                                        {{ $Tulov[4]['Payme'] }},
                                        {{ $Tulov[5]['Payme'] }},
                                        {{ $Tulov[6]['Payme'] }}
                                        ]
                                    }, {
                                        name: "Qaytarilgan to'lovlar",
                                        data: [
                                        {{ $Tulov[0]['Qaytarildi'] }},
                                        {{ $Tulov[1]['Qaytarildi'] }},
                                        {{ $Tulov[2]['Qaytarildi'] }},
                                        {{ $Tulov[3]['Qaytarildi'] }},
                                        {{ $Tulov[4]['Qaytarildi'] }},
                                        {{ $Tulov[5]['Qaytarildi'] }},
                                        {{ $Tulov[6]['Qaytarildi'] }}
                                        ]
                                    }, {
                                        name: "Chegirmalar",
                                        data: [
                                        {{ $Tulov[0]['Chegirma'] }},
                                        {{ $Tulov[1]['Chegirma'] }},
                                        {{ $Tulov[2]['Chegirma'] }},
                                        {{ $Tulov[3]['Chegirma'] }},
                                        {{ $Tulov[4]['Chegirma'] }},
                                        {{ $Tulov[5]['Chegirma'] }},
                                        {{ $Tulov[6]['Chegirma'] }}
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
                                        "{{ $Tulov[0]['date_wekend'] }}",
                                        "{{ $Tulov[1]['date_wekend'] }}",
                                        "{{ $Tulov[2]['date_wekend'] }}",
                                        "{{ $Tulov[3]['date_wekend'] }}",
                                        "{{ $Tulov[4]['date_wekend'] }}",
                                        "{{ $Tulov[5]['date_wekend'] }}",
                                        "{{ $Tulov[6]['date_wekend'] }}"
                                        ],
                                    },
                                    yaxis: {title: {text: "Kunlik to'lovlar"}},
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
                                        <th>{{ $Tulov[0]['date_wekend'] }}</th>
                                        <th>{{ $Tulov[1]['date_wekend'] }}</th>
                                        <th>{{ $Tulov[2]['date_wekend'] }}</th>
                                        <th>{{ $Tulov[3]['date_wekend'] }}</th>
                                        <th>{{ $Tulov[4]['date_wekend'] }}</th>
                                        <th>{{ $Tulov[5]['date_wekend'] }}</th>
                                        <th>{{ $Tulov[6]['date_wekend'] }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="text-align:left;">Naqt To'lovlar</th>
                                        <td>{{ $Tulov[0]['Table_Naqt'] }}</td>
                                        <td>{{ $Tulov[1]['Table_Naqt'] }}</td>
                                        <td>{{ $Tulov[2]['Table_Naqt'] }}</td>
                                        <td>{{ $Tulov[3]['Table_Naqt'] }}</td>
                                        <td>{{ $Tulov[4]['Table_Naqt'] }}</td>
                                        <td>{{ $Tulov[5]['Table_Naqt'] }}</td>
                                        <td>{{ $Tulov[6]['Table_Naqt'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Plastik To'lovlar</th>
                                        <td>{{ $Tulov[0]['Table_Plastik'] }}</td>
                                        <td>{{ $Tulov[1]['Table_Plastik'] }}</td>
                                        <td>{{ $Tulov[2]['Table_Plastik'] }}</td>
                                        <td>{{ $Tulov[3]['Table_Plastik'] }}</td>
                                        <td>{{ $Tulov[4]['Table_Plastik'] }}</td>
                                        <td>{{ $Tulov[5]['Table_Plastik'] }}</td>
                                        <td>{{ $Tulov[6]['Table_Plastik'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Payme to'lov</th>
                                        <td>{{ $Tulov[0]['Table_Payme'] }}</td>
                                        <td>{{ $Tulov[1]['Table_Payme'] }}</td>
                                        <td>{{ $Tulov[2]['Table_Payme'] }}</td>
                                        <td>{{ $Tulov[3]['Table_Payme'] }}</td>
                                        <td>{{ $Tulov[4]['Table_Payme'] }}</td>
                                        <td>{{ $Tulov[5]['Table_Payme'] }}</td>
                                        <td>{{ $Tulov[6]['Table_Payme'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Chegirma To'lovlar</th>
                                        <td>{{ $Tulov[0]['Table_Chegirma'] }}</td>
                                        <td>{{ $Tulov[1]['Table_Chegirma'] }}</td>
                                        <td>{{ $Tulov[2]['Table_Chegirma'] }}</td>
                                        <td>{{ $Tulov[3]['Table_Chegirma'] }}</td>
                                        <td>{{ $Tulov[4]['Table_Chegirma'] }}</td>
                                        <td>{{ $Tulov[5]['Table_Chegirma'] }}</td>
                                        <td>{{ $Tulov[6]['Table_Chegirma'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Qaytarilgan To'lovlar</th>
                                        <td>{{ $Tulov[0]['Table_Qaytarildi'] }}</td>
                                        <td>{{ $Tulov[1]['Table_Qaytarildi'] }}</td>
                                        <td>{{ $Tulov[2]['Table_Qaytarildi'] }}</td>
                                        <td>{{ $Tulov[3]['Table_Qaytarildi'] }}</td>
                                        <td>{{ $Tulov[4]['Table_Qaytarildi'] }}</td>
                                        <td>{{ $Tulov[5]['Table_Qaytarildi'] }}</td>
                                        <td>{{ $Tulov[6]['Table_Qaytarildi'] }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;">Naqt + Plastik + Payme</th>
                                        <td>{{ $Tulov[0]['Table_Naqt_Plastik_Payme'] }}</td>
                                        <td>{{ $Tulov[1]['Table_Naqt_Plastik_Payme'] }}</td>
                                        <td>{{ $Tulov[2]['Table_Naqt_Plastik_Payme'] }}</td>
                                        <td>{{ $Tulov[3]['Table_Naqt_Plastik_Payme'] }}</td>
                                        <td>{{ $Tulov[4]['Table_Naqt_Plastik_Payme'] }}</td>
                                        <td>{{ $Tulov[5]['Table_Naqt_Plastik_Payme'] }}</td>
                                        <td>{{ $Tulov[6]['Table_Naqt_Plastik_Payme'] }}</td>
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