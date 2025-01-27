@extends('Admin.layout.home')
@section('title','Qarzdorlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Qarzdorlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Student') }}">Talabalar</a></li>
            <li class="breadcrumb-item active">Qarzdorlar</li>
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
                            <a href="{{ route('Student') }}" class="nav-link text-center w-100">Tashriflar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentQarzdorlar') }}" class="nav-link bg-success text-white w-100 active text-center">Qarzdorlar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentTulovlar') }}" class="nav-link text-center w-100">To'lovlar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentCreate') }}" class="nav-link text-center w-100">Yangi tashrif</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="myTabjustifiedContent">
                        <div class="tab-pane fade show active" style="min-height:300px;" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                            <div class="table-responsive">
                                <table class="table datatable" style="font-size:14px;">
                                    <thead>
                                        <tr>
                                            <th class="bg-primary text-white text-center">#</th>
                                            <th class="bg-primary text-white text-center">FIO</th>
                                            <th class="bg-primary text-white text-center">Manzil</th>
                                            <th class="bg-primary text-white text-center">Telefon raqam</th>
                                            <th class="bg-primary text-white text-center">Qarzdorlik</th>
                                            <th class="bg-primary text-white text-center">Ro'yhatdan o'tdi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($User as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->index+1 }}</td>
                                            <th><a href="{{ route('StudentShow',$item->id) }}">{{ $item->name }}</a></th>
                                            <td>{{ $item->addres }}</td>
                                            <td class="text-center">{{ $item->phone }}</td>
                                            <td class="text-center">{{ $item->balans }}</td>
                                            <td class="text-center">{{ $item->created_at }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan=7 class="text-center">Qarzdor talabalar mavjud emas.</td>
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