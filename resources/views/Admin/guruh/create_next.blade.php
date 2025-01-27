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
            <div class="w-100">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success') }}</div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error') }}</div>
                @endif
                <h5 class="card-title w-100 text-center mb-0 pb-1">{{ $Guruh->guruh_name }} guruhning davomi</h5>
                <div class="row">
                    <div class="col-lg-6">
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <th style="text-align:left">Yangi guruh:</th>
                                <td style="text-align:right">{{ $NewGuruh['guruh_name'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Guruh narxi:</th>
                                <td style="text-align:right">{{ $NewGuruh['guruh_price'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchi:</th>
                                <td style="text-align:right">{{ $NewGuruh['techer_id'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchiga to'lov:</th>
                                <td style="text-align:right">{{ $NewGuruh['techer_price'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">O'qituvchiga bonus:</th>
                                <td style="text-align:right">{{ $NewGuruh['techer_bonus'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <th style="text-align:left">Kurs:</th>
                                <td style="text-align:right">{{ $NewGuruh['cours_id'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Dars xonasi:</th>
                                <td style="text-align:right">{{ $NewGuruh['room_id'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Hafta Kunlari:</th>
                                <td style="text-align:right">{{ $NewGuruh['hafta_kuni'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Boshlanish vaqti:</th>
                                <td style="text-align:right">{{ $NewGuruh['guruh_start'] }}</td>
                            </tr>
                            <tr>
                                <th style="text-align:left">Tugash vaqti:</th>
                                <td style="text-align:right">{{ $NewGuruh['guruh_end'] }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <h5 class="card-title w-100 text-center my-1 py-1">Dars kunlari</h5>
                        @if($NewGuruh['count_kun']==13)
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <td><b>1-dars:</b> {{ $NewGuruh['dars_kunlari'][0] }}</td>
                                <td><b>7-dars:</b> {{ $NewGuruh['dars_kunlari'][6] }}</td>
                            </tr>
                            <tr>
                                <td><b>2-dars:</b> {{ $NewGuruh['dars_kunlari'][1] }}</td>
                                <td><b>8-dars:</b> {{ $NewGuruh['dars_kunlari'][7] }}</td>
                            </tr>
                            <tr>
                                <td><b>3-dars:</b> {{ $NewGuruh['dars_kunlari'][2] }}</td>
                                <td><b>9-dars:</b> {{ $NewGuruh['dars_kunlari'][8] }}</td>
                            </tr>
                            <tr>
                                <td><b>4-dars:</b> {{ $NewGuruh['dars_kunlari'][3] }}</td>
                                <td><b>10-dars:</b> {{ $NewGuruh['dars_kunlari'][9] }}</td>
                            </tr>
                            <tr>
                                <td><b>5-dars:</b> {{ $NewGuruh['dars_kunlari'][4] }}</td>
                                <td><b>11-dars:</b> {{ $NewGuruh['dars_kunlari'][10] }}</td>
                            </tr>
                            <tr>
                                <td><b>6-dars:</b> {{ $NewGuruh['dars_kunlari'][5] }}</td>
                                <td><b>12-dars:</b> {{ $NewGuruh['dars_kunlari'][11] }}</td>
                            </tr>
                            <tr>
                                <td colspan=2 class="text-center"><b>Qo'shimcha dars:</b> {{ $NewGuruh['dars_kunlari'][12] }}</td>
                            </tr>
                        </table>
                        @else
                        <table class="table table-bordered" style="font-size:14px;">
                            <tr>
                                <td><b>1-dars:</b> {{ $NewGuruh['dars_kunlari'][0] }}</td>
                                <td><b>9-dars:</b> {{ $NewGuruh['dars_kunlari'][8] }}</td>
                                <td><b>17-dars:</b> {{ $NewGuruh['dars_kunlari'][16] }}</td>
                            </tr>
                            <tr>
                                <td><b>2-dars:</b> {{ $NewGuruh['dars_kunlari'][1] }}</td>
                                <td><b>10-dars:</b> {{ $NewGuruh['dars_kunlari'][9] }}</td>
                                <td><b>18-dars:</b> {{ $NewGuruh['dars_kunlari'][17] }}</td>
                            </tr>
                            <tr>
                                <td><b>3-dars:</b> {{ $NewGuruh['dars_kunlari'][2] }}</td>
                                <td><b>11-dars:</b> {{ $NewGuruh['dars_kunlari'][10] }}</td>
                                <td><b>19-dars:</b> {{ $NewGuruh['dars_kunlari'][18] }}</td>
                            </tr>
                            <tr>
                                <td><b>4-dars:</b> {{ $NewGuruh['dars_kunlari'][3] }}</td>
                                <td><b>12-dars:</b> {{ $NewGuruh['dars_kunlari'][11] }}</td>
                                <td><b>20-dars:</b> {{ $NewGuruh['dars_kunlari'][19] }}</td>
                            </tr>
                            <tr>
                                <td><b>5-dars:</b> {{ $NewGuruh['dars_kunlari'][4] }}</td>
                                <td><b>13-dars:</b> {{ $NewGuruh['dars_kunlari'][12] }}</td>
                                <td><b>21-dars:</b> {{ $NewGuruh['dars_kunlari'][20] }}</td>
                            </tr>
                            <tr>
                                <td><b>6-dars:</b> {{ $NewGuruh['dars_kunlari'][5] }}</td>
                                <td><b>14-dars:</b> {{ $NewGuruh['dars_kunlari'][13] }}</td>
                                <td><b>22-dars:</b> {{ $NewGuruh['dars_kunlari'][21] }}</td>
                            </tr>
                            <tr>
                                <td><b>7-dars:</b> {{ $NewGuruh['dars_kunlari'][6] }}</td>
                                <td><b>15-dars:</b> {{ $NewGuruh['dars_kunlari'][14] }}</td>
                                <td><b>23-dars:</b> {{ $NewGuruh['dars_kunlari'][22] }}</td>
                            </tr>
                            <tr>
                                <td><b>8-dars:</b> {{ $NewGuruh['dars_kunlari'][7] }}</td>
                                <td><b>16-dars:</b> {{ $NewGuruh['dars_kunlari'][15] }}</td>
                                <td><b>24-dars:</b> {{ $NewGuruh['dars_kunlari'][23] }}</td>
                            </tr>
                        </table>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <h5 class="card-title w-100 text-center my-1 py-1">Yangi guruhga talaba o'tqazish</h5>
                        <form action="{{ route('CreateGuruhNext2') }}" method="post">
                            @csrf
                            <table class="table table-bordered" style="font-size:14px;">
                                @foreach($NewGuruh['users'] as $item)
                                <tr>
                                    <td>
                                        <div class="form-check form-switch mt-1" style="text-align:left;">
                                            <input class="form-check-input" type="checkbox" name="User{{ $item['id'] }}" id="User{{ $item['id'] }}">
                                            <label class="form-check-label w-100" for="User{{ $item['id'] }}">{{ $item['name'] }}</label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <input type="hidden" name="count_kun" value={{ $NewGuruh['count_kun'] }}>
                            <input type="hidden" name="techer_id" value="{{ $NewGuruhForm['techer_id'] }}">
                            <input type="hidden" name="cours_id" value="{{ $NewGuruhForm['cours_id'] }}">
                            <input type="hidden" name="room_id" value="{{ $NewGuruhForm['room_id'] }}">
                            <input type="hidden" name="guruh_name" value="{{ $NewGuruhForm['guruh_name'] }}">
                            <input type="hidden" name="guruh_price" value="{{ $NewGuruhForm['guruh_price'] }}">
                            <input type="hidden" name="guruh_chegirma" value="{{ $NewGuruhForm['guruh_chegirma'] }}">
                            <input type="hidden" name="guruh_admin_chegirma" value="{{ $NewGuruhForm['guruh_admin_chegirma'] }}">
                            <input type="hidden" name="techer_price" value="{{ $NewGuruhForm['techer_price'] }}">
                            <input type="hidden" name="techer_bonus" value="{{ $NewGuruhForm['techer_bonus'] }}">
                            <input type="hidden" name="guruh_status" value="{{ $NewGuruhForm['guruh_status'] }}">
                            <input type="hidden" name="guruh_start" value="{{ $NewGuruhForm['guruh_start'] }}">
                            <input type="hidden" name="guruh_end" value="{{ $NewGuruh['guruh_end'] }}">
                            <input type="hidden" name="guruh_id" value="{{ $Guruh['id'] }}">
                            @foreach($NewGuruh['dars_kunlari'] as $key=>$item)
                            <input type="hidden" name="kun{{ $key }}" value="{{ $item }}">
                            @endforeach
                            <label for="">Dars vaqtini tanlang</label>
                            <select name="guruh_vaqt" class="form-select">
                                <option value="">Tanlang</option>
                                @foreach($NewGuruh['bosh_vaqtlar'] as $item)
                                <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                                @endforeach
                            </select>
                            <script>
                                function button(){
                                    document.getElementById("buttons").style.display = "none"
                                }
                            </script>
                            <button class="btn btn-primary w-100 mt-2" onclick="button()">Yangi guruhni saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

@endsection