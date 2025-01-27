@extends('SuperAdmin.layout.home')
@section('title','To\'lovlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">To'lovlar</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">To'lovlar</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>Guruh</th>
                <th>FIO</th>
                <th>To'lov summa</th>
                <th>To'lov turi</th>
                <th>To'lov vaqti</th>
                <th>To'lov haqida</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Tulovlar as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item['filial'] }}</td>
                    <td>{{ $item['guruh'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['summa'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['about'] }}</td>
                    <td>{{ $item['admin'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection