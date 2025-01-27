@extends('Techer.layout.home')
@section('title','Guruh')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Guruh</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Techer')}}">Bosh sahifa</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('TGuruhlar')}}">Guruhlar</a></li>
                    <li class="breadcrumb-item active">Guruh</li>
                </ol>
            </nav>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success">{{Session::get('success') }}</div>
        @elseif (Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error') }}</div>
        @endif
        <section class="section dashboard">
            <div class="card info-card sales-card">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $Guruh['guruh_name'] }}</span></h5>
                    <div class="row">
                        <div class="col-lg-4">
                            <table class="table table-bordered" style="font-size:14px;">
                                <tr>
                                    <th style="text-align:left">Boshlanish vaqti</th>
                                    <td style="text-align:right">{{ $Guruh['guruh_start'] }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left">Tugash vaqti</th>
                                    <td style="text-align:right">{{ $Guruh['guruh_end'] }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left">Dars vaqti</th>
                                    <td style="text-align:right">{{ $Guruh['guruh_vaqt'] }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left">Dars xonasi</th>
                                    <td style="text-align:right">{{ $Guruh['room'] }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <table class="table table-bordered" style="font-size:14px;">
                                <tr>
                                    <th style="text-align:left">O'qituvchiga to'lov</th>
                                    <td style="text-align:right">{{ $Guruh['techerPay'] }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left">O'qituvchiga bonus</th>
                                    <td style="text-align:right">{{ $Guruh['TecherBonus'] }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left">Talabalar</th>
                                    <td style="text-align:right">{{ $Guruh['users'] }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left">Meneger</th>
                                    <td style="text-align:right">{{ $Guruh['meneger'] }}</td>
                                </tr>
                            </table>
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#basicModal">Davomat</button>

                            <div class="modal fade" id="basicModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title w-100 text-center">Davomat olish</h5>
                                        </div>
                                        <div class="modal-body">
                                            @if($Guruh['users'] != '0')
                                                @if($Guruh['darskuni'] != '0')
                                                    @if($Guruh['davomatOlindi']==0)
                                                    <form action="{{ route('TGuruhDavomat') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="guruh_id" value="{{ $Guruh['id'] }}">
                                                        <div class="row mb-2">
                                                            <label class="col-sm-1 col-form-label"></label>
                                                            <div class="col-sm-10">
                                                                @forelse($Guruh['davUser'] as $item)
                                                                <div class="form-check form-switch py-1 border" >
                                                                    <input class="form-check-input" type="checkbox" name="user_id{{ $item['user_id'] }}" id="user_id{{ $item['user_id'] }}">
                                                                    <label class="form-check-label w-100" style="text-align:left" for="user_id{{ $item['user_id'] }}">{{ $item['name'] }}</label>
                                                                </div>
                                                                @empty
                                                                    Guruh talabalari mavjud emas.
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <button type="submit" class="btn btn-primary w-100">Tasdiqlash</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    @else
                                                        Bugungi kun uchun davomat olindi.
                                                    @endif
                                                @else
                                                    Bugun dars kuni emas. Dars kunlarida davomat olinishi mumkun
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <table class="table table-bordered" style="font-size:14px;">
                                <tr>
                                    <td colspan=3 class="text-center w-100"><b>Dars kunlari</b></td>
                                </tr>
                                @if($DarsKunlar==13)
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][0]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][4]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][8]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][1]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][5]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][9]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][2]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][6]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][10]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][3]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][7]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][11]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td colspan=3 class="text-center">Qo'shimcha dars: {{ $Guruh['kunlar'][12]['dates'] }}</td>
                                </tr>
                                @else 
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][0]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][8]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][16]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][1]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][9]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][17]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][2]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][10]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][18]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][3]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][11]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][19]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][4]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][12]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][20]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][5]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][13]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][21]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][6]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][14]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][22]['dates'] }}</td>
                                </tr>
                                <tr style="font-size:10px">
                                    <td>{{ $Guruh['kunlar'][7]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][15]['dates'] }}</td>
                                    <td>{{ $Guruh['kunlar'][23]['dates'] }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card info-card sales-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Guruh davomat</span></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="font-size:14px;">
                            <thead>
                                <tr>
                                    <th  class="bg-primary text-white">#</th>
                                    <th  class="bg-primary text-white">Talabalar</th>
                                    @foreach($Guruh['kunlar'] as $item)
                                    <td  class="bg-primary text-white" style="font-size:10px;width:50px">{{ $item['dates'] }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Davomat as $item)
                                <tr>
                                    <th>{{ $loop->index+1 }}</th>
                                    <th style="text-align:left;">{{ $item['name'] }}</th>
                                    @foreach($item['status'] as $value)
                                        @if($value=='new')
                                            <td class="bg-secondary text-white text-center" title="Dars kutilmoqda" style="cursor:pointer"><i class="bi bi-clock"></i></td>
                                        @elseif($value=='DarsKuni')
                                            <td class="bg-info text-white text-center" title="Bugun dars kuni" style="cursor:pointer"><i class="bi bi-clipboard-x"></i></td>
                                        @elseif($value=='DarsKuniTrue')
                                            <td class="bg-success text-white text-center" title="Darsga qatnashdi" style="cursor:pointer"><i class="bi bi-clipboard2-check"></i></td>
                                        @elseif($value=='DarsKuniFalse')
                                            <td class="bg-warning text-white text-center" title="Darsga qatnashmadi" style="cursor:pointer"><i class="bi bi-clipboard-minus"></i></td>
                                        @elseif($value=='DavomatBor')
                                            <td class="bg-success text-white text-center" title="Darsga qatnashdi" style="cursor:pointer"><i class="bi bi-clipboard2-check"></i></td>
                                        @elseif($value=='DavomatYoq')
                                            <td class="bg-warning text-white text-center" title="Darsga qatnashmadi" style="cursor:pointer"><i class="bi bi-clipboard-minus"></i></td>
                                        @elseif($value=='DarsOtilmadi')
                                            <td class="bg-danger text-white text-center" title="Davomat olinmadi" style="cursor:pointer"><i class="bi bi-dot"></i></td>
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
            <div class="card info-card sales-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Test natijalari</span></h5>
                    <table class="table table-bordered" style="font-size:14px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Talaba</th>
                            <th>Testlar soni</th>
                            <th>To'g'ri javoblar</th>
                            <th>Noto'g'ri javoblar</th>
                            <th>Ball</th>
                            <th>Test vaqti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Natija as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['savol_count'] }}</td>
                            <td>{{ $item['tugri_count'] }}</td>
                            <td>{{ $item['notugri_count'] }}</td>
                            <td>{{ $item['ball'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan=7 class="text-center">Test topshirgan talabalar mavjud emas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>  
            </div>  
        </section>

    </main>

@endsection