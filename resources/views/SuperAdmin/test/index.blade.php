@extends('SuperAdmin.layout.home')
@section('title',"Online Testlar")
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>O'qituvchiga to'lovlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Online Testlar</li>
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
                <h5 class="card-title w-100 text-center mb-1 pb-1">Online Testlar</h5>
                <div class="table-responsive">
                    <table class="table text-center table-bordered" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Filial</th>
                                <th class="bg-primary text-white">Cours</th>
                                <th class="bg-primary text-white">Testlar soni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Cour as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['filial'] }}</td>
                                <td><a href="{{ route('superAdminTestingShow',$item['id'] ) }}">{{ $item['cours'] }}</a></td>
                                <td>{{ $item['testcount'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan=5 class="text-center">Kurslar mavjud emas.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
        
    </section>

</main>

@endsection