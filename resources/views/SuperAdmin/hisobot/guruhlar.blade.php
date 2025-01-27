@extends('SuperAdmin.layout.home')
@section('title','Guruhlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">Guruhlar</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">Guruhlar</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>Guruh</th>
                <th>O'qituvchi</th>
                <th>Kurs</th>
                <th>Xona</th>
                <th>Guruh Naqrxi</th>
                <th>Guruh Chegirma</th>
                <th>Admin Chegirma</th>
                <th>O'qituvchga tulov</th>
                <th>O'qituvchiga bonus</th>
                <th>Boshlanish vaqti</th>
                <th>Tugash vaqti</th>
                <th>Meneger</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Guruh as $item)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $item['filial'] }}</td>
                <td>{{ $item['guruh'] }}</td>
                <td>{{ $item['techer'] }}</td>
                <td>{{ $item['cours_name'] }}</td>
                <td>{{ $item['room_name'] }}</td>
                <td>{{ $item['guruh_price'] }}</td>
                <td>{{ $item['guruh_chegirma'] }}</td>
                <td>{{ $item['guruh_admin_chegirma'] }}</td>
                <td>{{ $item['techer_price'] }}</td>
                <td>{{ $item['techer_bonus'] }}</td>
                <td>{{ $item['guruh_start'] }}</td>
                <td>{{ $item['guruh_end'] }}</td>
                <td>{{ $item['meneger'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection