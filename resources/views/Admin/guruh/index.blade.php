@extends('Admin.layout.home')
@section('title','Guruhlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Guruhlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Guruhlar</li>
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
        <div class="card-body text-center pt-3">
            <ul class="nav nav-tabs d-flex">
                <li class="nav-item flex-fill">
                    <a class="nav-link w-100 active bg-success text-white" href="{{ route('AdminGuruh') }}">Guruhlar</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100" href="{{ route('AdminGuruhEnd') }}">Yakunlangan guruhlar</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100" href="{{ route('AdminGuruhCreate') }}">Yangi guruh</a>
                </li>
            </ul>
            <div>
            <div class="table-responsive">
                <table class="table datatable text-center table-hover" style="font-size:14px;">
                    <thead>
                        <tr>
                            <th class="bg-primary text-white text-center">#</th>
                            <th class="bg-primary text-white text-center">Guruh</th>
                            <th class="bg-primary text-white text-center">Boshlanish vaqti</th>
                            <th class="bg-primary text-white text-center">Yakunlanish vaqti</th>
                            <th class="bg-primary text-white text-center">Talabalar</th>
                            <th class="bg-primary text-white text-center">Guruh holati</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Guruhlar as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td style="text-align:left">
                            <a href="{{ route('AdminGuruhShow',$item['id']) }}">
                                {{ $item['guruh_name'] }}
                            </td>
                            <td>{{ $item['guruh_start'] }}</td>
                            <td>{{ $item['guruh_end'] }}</td>
                            <td>{{ $item['talabalar'] }}</td>
                            <td>
                                @if($item['guruh']==0)
                                    <span class="bg-success text-white px-1" style="border-radius:5px">FAOL</span>                                
                                @elseif($item['guruh']==1)
                                    <span class="bg-info text-white px-1" style="border-radius:5px">YANGI</span>
                                @else
                                    <span class="bg-danger text-white px-1" style="border-radius:5px">YAKUNLADNI</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan=6 class="text-center">Guruhlar mavjud emas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

</main>

@endsection