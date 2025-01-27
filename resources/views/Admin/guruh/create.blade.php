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
                    <a class="nav-link w-100 active bg-success text-white" href="{{ route('AdminGuruhCreate') }}">Yangi guruh</a>
                </li>
            </ul>
            <div class="w-100 mt-2">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success') }}</div>
                @elseif (Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error') }}</div>
                @endif
                <form action="{{ route('AdminGuruhCreate1') }}" method="post" id="form1">
                    @csrf 
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="guruh_name" style="text-align:left;width:100%">Guruh nomi</label>
                            <input type="text" name="guruh_name" value="{{ old('guruh_name') }}" class="form-control" required>
                            <label for="guruh_price" style="text-align:left;width:100%" class="mt-2">Guruh narxi</label>
                            <select name="guruh_price" class="form-select" required>
                                <option value="">Tanlang</option>
                                @foreach($TulovSetting as $item)
                                    <option value="{{ $item->id }}"><b>Summa: </b>{{ $item->tulov_summa }}<b> Chegirma: </b>{{ $item->chegirma }}</option>
                                @endforeach
                            </select>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="guruh_start" class="mt-2" style="text-align:left;width:100%" class="mt-2">Dars boshlanish vaqti</label>
                                    <input type="date" name="guruh_start" value="{{ old('guruh_start') }}" class="form-control" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="hafta_kun" class="mt-2" style="text-align:left;width:100%" class="mt-2">Hafta kunlari</label>
                                    <select name="hafta_kun" class="form-select" required>
                                        <option value="">Tanlang</option>
                                        <option value="juft">Juft kunlar</option>
                                        <option value="toq">Toq kunlar</option>
                                        <option value="xarkuni">Xar kuni</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="" class="mt-2" style="text-align:left;width:100%">Dars xonasi</label>
                                    <select name="room_id" class="form-select" required>
                                        <option value="">Tanlang</option>
                                        @foreach($Room as $item)
                                            <option value="{{ $item->id }}">{{ $item->room_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="cours_id" class="mt-2" style="text-align:left;width:100%">Guruh uchun kurs</label>
                                    <select name="cours_id" class="form-select" required>
                                        <option value="">Tanlang</option>
                                        @foreach($Cours as $item)
                                        <option value="{{ $item->id }}">{{ $item->cours_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <label for="techer_id" style="text-align:left;width:100%" class="mt-2">Guruh o'qituvchisi</label>
                            <select name="techer_id" class="form-select" required>
                                <option value="">Tanlang</option>
                                @foreach($Techer as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="techer_price"  class="pt-2">O'qituvchiga to'lov</label>
                                    <input type="text" name="techer_price" class="form-control" id="summa1" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="techer_bonus" class="pt-2">O'qituvchiga bonus</label>
                                    <input type="text" name="techer_bonus" class="form-control" id="summa2" required>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-50 mt-2">Davom etish</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</main>

@endsection