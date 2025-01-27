@extends('Admin.layout.home')
@section('title','To\'lovlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>To'lovlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">To'lovlar</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif

        <section class="section dashboard">
            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('Student') }}" class="nav-link text-center text-center w-100">Tashriflar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentQarzdorlar') }}" class="nav-link w-100 text-center">Qarzdorlar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentTulovlar') }}" class="nav-link text-center w-100 bg-success text-white active">To'lovlar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentCreate') }}" class="nav-link text-center w-100">Yangi tashrif</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="myTabjustifiedContent">
                        <div class="tab-pane fade show active"  style="min-height:300px;" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                            <div class="table-responsive">
                                <table class="table datatable" style="font-size:14px;">
                                    <thead> 
                                        <tr>
                                            <th class="bg-primary text-white text-center">#</th>
                                            <th class="bg-primary text-white text-center">FIO</th>
                                            <th class="bg-primary text-white text-center">Guruh</th>
                                            <th class="bg-primary text-white text-center">To'lov summasi</th>
                                            <th class="bg-primary text-white text-center">To'lov turi</th>
                                            <th class="bg-primary text-white text-center">To'lov haqida</th>
                                            <th class="bg-primary text-white text-center">Meneger</th>
                                            <th class="bg-primary text-white text-center">To'lov vaqti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pays as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->index+1 }}</td>
                                            <td><a href="{{ route('StudentShow',$item['user_id'] ) }}">{{ $item['fio'] }}</a></td>
                                            <td>{{ $item['guruh'] }}</td>
                                            <td>{{ $item['summa'] }}</td>
                                            <td>{{ $item['type'] }}</td>
                                            <td>{{ $item['about'] }}</td>
                                            <td>{{ $item['meneger'] }}</td>
                                            <td>{{ $item['created_at'] }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan=8 class="text-center">To'lovlar mavjud emas.</td>
                                        </tr>
                                        @endforelse
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