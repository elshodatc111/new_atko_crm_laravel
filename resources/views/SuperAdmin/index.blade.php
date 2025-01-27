@extends('SuperAdmin.layout.home')
@section('title','Bosh sahifa')
@section('content')

<main id="main" class="main">
 
  <div class="pagetitle">
      <h1>Bosh sahifa</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Bosh sahifa</li>
          </ol>
      </nav>
  </div>

    @if($Block=='true')
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
            To'lov muddat yaqinlashmoqda. To'lovlarni o'z vaqtida amalga oshirishni unitmang!!!
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


  <section class="section dashboard">
    <div class="row text-center">
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title pb-1 mb-1"><i class="bi bi-envelope-arrow-up"></i> Yuborilgan SMS</h5>
            <p class="mb-0 pb-0" style="font-size:25px;">{{ $SmsCounter['counte'] }}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title pb-1 mb-1"><i class="bi bi-envelope-check"></i> Mavjud SMSlar</h5>
            <p class="mb-0 pb-0" style="font-size:25px;">{{ $SmsCounter['maxsms'] }}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title pb-1 mb-1"><i class="bi bi-person"></i> Aktiv talabalar</h5>
            <p class="mb-0 pb-0" style="font-size:25px;">{{ $ActivStudent }}</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title pb-1 mb-1"><i class="bi bi-person"></i> Aktiv talabalar(To'lov)</h5>
            <p class="mb-0 pb-0" style="font-size:25px;">{{ $ActivTulovUser }}</p>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
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
                      "{{ $TashSMM['kunlik_tashrif']['6']['day_name'] }}"
                    ],
                    datasets: [{
                      label: '',
                      data: [
                        {{ $TashSMM['kunlik_tashrif']['0']['user_count'] }},
                        {{ $TashSMM['kunlik_tashrif']['1']['user_count'] }},
                        {{ $TashSMM['kunlik_tashrif']['2']['user_count'] }},
                        {{ $TashSMM['kunlik_tashrif']['3']['user_count'] }},
                        {{ $TashSMM['kunlik_tashrif']['4']['user_count'] }},
                        {{ $TashSMM['kunlik_tashrif']['5']['user_count'] }},
                        {{ $TashSMM['kunlik_tashrif']['6']['user_count'] }}
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
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
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
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
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
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[0]['date']) }}">{{ $Tulov[0]['date_wekend'] }}</a></th>
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[1]['date']) }}">{{ $Tulov[1]['date_wekend'] }}</a></th>
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[2]['date']) }}">{{ $Tulov[2]['date_wekend'] }}</a></th>
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[3]['date']) }}">{{ $Tulov[3]['date_wekend'] }}</a></th>
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[4]['date']) }}">{{ $Tulov[4]['date_wekend'] }}</a></th>
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[5]['date']) }}">{{ $Tulov[5]['date_wekend'] }}</a></th>
                    <th><a href="{{ route('tulovShowSuperAdmin',$Tulov[6]['date']) }}">{{ $Tulov[6]['date_wekend'] }}</a></th>
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
    
    <div class="card">
        <div class="card-body text-center pt-4">
            <div class="table-responsive">
                <table class="table table-bordered" style="font-size:14px;">
                    <thead class="">
                      <tr>
                        <th rowspan=2 class="align-middle"><i class="bi bi-house-door-fill"></i> Filial</th>
                        <th rowspan=2 class="align-middle"><i class="bi bi-people"></i> Tashriflar</th>
                        <th colspan=4 class=""><i class="bi bi-menu-button-wide"></i> Guruhlar</th>
                        <th colspan=2 class=""><i class="bi bi-microsoft-teams"></i> Hodimlar</th>
                      </tr>
                      <tr>
                        <th style="font-size:10px;">Jami</th>
                        <th style="font-size:10px;">Yangi</th>
                        <th style="font-size:10px;">Aktiv</th>
                        <th style="font-size:10px;">Yakunlangan</th>
                        <th style="font-size:10px;">O'qituvchilar</th>
                        <th style="font-size:10px;">Menegerlar</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($Filial as $item)
                        <tr>
                            <th style="font-weight:900" class="text-primary">{{ $item['filial_name'] }}</th>
                            <td>{{ $item['user'] }}</td>
                            <td>{{ $item['guruhlar'] }}</td>
                            <td>{{ $item['yangiguruh'] }}</td>
                            <td>{{ $item['aktivguruh'] }}</td>
                            <td>{{ $item['endguruh'] }}</td>
                            <td>{{ $item['techer'] }}</td>
                            <td>{{ $item['meneger'] }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


</main>

@endsection