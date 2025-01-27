@extends('SuperAdmin.layout.home')
@section('title',"O'qituvchiga to'lovlar")
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>O'qituvchiga to'lovlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">O'qituvchiga to'lovlar</li>
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
            <div class="card-body">
                <h5 class="card-title w-100 text-center mb-1 pb-1">O'qituvchiga to'lovlar</h5>
                <p class="text-danger p-0 m-0 w-100 text-center">O'qituvchi guruhlari yakunlangadan 30 kundan kiyin avtoamatik o'chiriladi.</p>
                <div class="table-responsive">
                    <table class="table text-center table-bordered" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Filial</th>
                                <th class="bg-primary text-white">Guruh</th>
                                <th class="bg-primary text-white">O'qituvchi</th>
                                <th class="bg-primary text-white">Hisoblangan</th>
                                <th class="bg-primary text-white">To'langan</th>
                                <th class="bg-primary text-white">Qoldiq</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Report as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['filial_name'] }}</td>
                                <td>{{ $item['guruh_name'] }}</td>
                                <td>{{ $item['techer'] }}</td>
                                <td>{{ $item['hisoblash2'] }}</td>
                                <td>{{ $item['tulov2'] }}</td>
                                <td>
                                    @if($item['qoldiq']>=0)
                                        {{ $item['qoldiq2'] }}
                                    @else
                                        <b class="text-danger">{{ $item['qoldiq2'] }}</b>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan=7 class="text-center">Guruhlar mavjud emas.</td>
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