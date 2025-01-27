@extends('Admin.layout.home')
@section('title','Yangi guruh')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Yangi guruh</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('AdminGuruh') }}">Guruhlar</a></li>
            <li class="breadcrumb-item active">Yangi guruh</li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="card info-card sales-card">
        <div class="card-body text-center pt-3">
            <ul class="nav nav-tabs d-flex">
                <li class="nav-item flex-fill">
                    <a class="nav-link w-100" href="{{ route('AdminGuruh') }}">Guruhlar</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100" href="{{ route('AdminGuruhEnd') }}">Yakunlangan guruhlar</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100 active bg-primary text-white" href="{{ route('AdminGuruhCreate') }}">Yangi guruh</a>
                </li>
            </ul>
            <div class="w-100 mt-2">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success') }}</div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error') }}</div>
                @endif
                <h5 class="card-title w-100 text-center mb-0 pb-1">Yangi guruh haqida</h5>
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <th style="text-align:left">Guruh:</th>
                                <td style="text-align:right">{{ $GuruhView['guruh_name'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Guruh narxi:</th>
                                <td style="text-align:right">{{ $GuruhView['guruh_price'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchi:</th>
                                <td style="text-align:right">{{ $GuruhView['guruh_techer'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchiga to'lov:</th>
                                <td style="text-align:right">{{ $GuruhView['techer_price'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchiga bonus:</th>
                                <td style="text-align:right">{{ $GuruhView['techer_bonus'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <th style="text-align:left">Kurs:</th>
                                <td style="text-align:right">{{ $GuruhView['cours'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Dars xonasi:</th>
                                <td style="text-align:right">{{ $GuruhView['room'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Hafta Kunlari:</th>
                                <td style="text-align:right">{{ $GuruhView['hafta_kun'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Boshlanish vaqti:</th>
                                <td style="text-align:right">{{ $GuruhView['guruh_start'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Tugash vaqti:</th>
                                <td style="text-align:right">{{ $GuruhView['guruh_end'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <h5 class="card-title w-100 text-center my-1 py-1">Dars kunlari</h5>
                        @if($GuruhView['count_day']==13)
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <td><b>1-dars:</b> {{ $GuruhView['kunlar'][0] }}</td>
                                <td><b>5-dars:</b> {{ $GuruhView['kunlar'][4] }}</td>
                                <td><b>9-dars:</b> {{ $GuruhView['kunlar'][8] }}</td>
                            </tr>
                            <tr>
                                <td><b>2-dars:</b> {{ $GuruhView['kunlar'][1] }}</td>
                                <td><b>6-dars:</b> {{ $GuruhView['kunlar'][5] }}</td>
                                <td><b>10-dars:</b> {{ $GuruhView['kunlar'][9] }}</td>
                            </tr>
                            <tr>
                                <td><b>3-dars:</b> {{ $GuruhView['kunlar'][2] }}</td>
                                <td><b>7-dars:</b> {{ $GuruhView['kunlar'][6] }}</td>
                                <td><b>11-dars:</b> {{ $GuruhView['kunlar'][10] }}</td>
                            </tr>
                            <tr>
                                <td><b>4-dars:</b> {{ $GuruhView['kunlar'][3] }}</td>
                                <td><b>8-dars:</b> {{ $GuruhView['kunlar'][7] }}</td>
                                <td><b>12-dars:</b> {{ $GuruhView['kunlar'][11] }}</td>
                            </tr>
                            <tr>
                                <td colspan=3 class="text-center"><b>Qo'shimcha dars:</b> {{ $GuruhView['kunlar'][12] }}</td>
                            </tr>
                        </table>
                        @else
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <td><b>1-dars:</b> {{ $GuruhView['kunlar'][0] }}</td>
                                <td><b>9-dars:</b> {{ $GuruhView['kunlar'][8] }}</td>
                                <td><b>17-dars:</b> {{ $GuruhView['kunlar'][16] }}</td>
                            </tr>
                            <tr>
                                <td><b>2-dars:</b> {{ $GuruhView['kunlar'][1] }}</td>
                                <td><b>10-dars:</b> {{ $GuruhView['kunlar'][9] }}</td>
                                <td><b>18-dars:</b> {{ $GuruhView['kunlar'][17] }}</td>
                            </tr>
                            <tr>
                                <td><b>3-dars:</b> {{ $GuruhView['kunlar'][2] }}</td>
                                <td><b>11-dars:</b> {{ $GuruhView['kunlar'][10] }}</td>
                                <td><b>19-dars:</b> {{ $GuruhView['kunlar'][18] }}</td>
                            </tr>
                            <tr>
                                <td><b>4-dars:</b> {{ $GuruhView['kunlar'][3] }}</td>
                                <td><b>12-dars:</b> {{ $GuruhView['kunlar'][11] }}</td>
                                <td><b>20-dars:</b> {{ $GuruhView['kunlar'][19] }}</td>
                            </tr>
                            <tr>
                                <td><b>5-dars:</b> {{ $GuruhView['kunlar'][4] }}</td>
                                <td><b>13-dars:</b> {{ $GuruhView['kunlar'][12] }}</td>
                                <td><b>21-dars:</b> {{ $GuruhView['kunlar'][20] }}</td>
                            </tr>
                            <tr>
                                <td><b>6-dars:</b> {{ $GuruhView['kunlar'][5] }}</td>
                                <td><b>14-dars:</b> {{ $GuruhView['kunlar'][13] }}</td>
                                <td><b>22-dars:</b> {{ $GuruhView['kunlar'][21] }}</td>
                            </tr>
                            <tr>
                                <td><b>7-dars:</b> {{ $GuruhView['kunlar'][6] }}</td>
                                <td><b>15-dars:</b> {{ $GuruhView['kunlar'][14] }}</td>
                                <td><b>23-dars:</b> {{ $GuruhView['kunlar'][22] }}</td>
                            </tr>
                            <tr>
                                <td><b>8-dars:</b> {{ $GuruhView['kunlar'][7] }}</td>
                                <td><b>16-dars:</b> {{ $GuruhView['kunlar'][15] }}</td>
                                <td><b>24-dars:</b> {{ $GuruhView['kunlar'][23] }}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <h5 class="card-title text-center my-1 py-1 w-100">Dars vaqtini tanlang</h5>
                        <form action="{{ route('AdminGuruhCreate2') }}" method="post">
                            @csrf
                            <input type="hidden" name="filial_id" value="{{ $GuruhInput['filial_id'] }}">
                            <input type="hidden" name="techer_id" value="{{ $GuruhInput['techer_id'] }}">
                            <input type="hidden" name="cours_id" value="{{ $GuruhInput['cours_id'] }}">
                            <input type="hidden" name="room_id" value="{{ $GuruhInput['room_id'] }}">
                            <input type="hidden" name="count_day" value="{{ $GuruhView['count_day'] }}">
                            <input type="hidden" name="guruh_name" value="{{ $GuruhInput['guruh_name'] }}">
                            <input type="hidden" name="guruh_price" value="{{ $GuruhInput['guruh_price'] }}">
                            <input type="hidden" name="guruh_chegirma" value="{{ $GuruhInput['guruh_chegirma'] }}">
                            <input type="hidden" name="guruh_admin_chegirma" value="{{ $GuruhInput['guruh_admin_chegirma'] }}">
                            <input type="hidden" name="techer_price" value="{{ $GuruhInput['techer_price'] }}">
                            <input type="hidden" name="techer_bonus" value="{{ $GuruhInput['techer_bonus'] }}">
                            <input type="hidden" name="guruh_status" value="{{ $GuruhInput['guruh_status'] }}">
                            <input type="hidden" name="guruh_start" value="{{ $GuruhInput['guruh_start'] }}">
                            <input type="hidden" name="guruh_end" value="{{ $GuruhInput['guruh_end'] }}">
                            @foreach($GuruhView['kunlar'] as $key => $item)
                                <input type="hidden" name="date{{$key}}" value="{{ $item }}">
                            @endforeach 
                            <script>
                                function button(){
                                    document.getElementById("buttons").style.display = "none"
                                }
                            </script>
                            <select name="guruh_vaqt" class="form-select" required>
                                <option value="">Tanlang...</option>
                                @foreach($GuruhView['dars_vaqtlari'] as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-success w-100 mt-2" id="buttons" onclick="button()">Guruhni Saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

@endsection