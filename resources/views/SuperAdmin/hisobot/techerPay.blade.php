@extends('SuperAdmin.layout.home')
@section('title','Ish haqi')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">Ish haqi</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">Hodimlarga to'langan ish haqi</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>Hodim</th>
                <th>Summasi</th>
                <th>To'lov turi</th>
                <th>To'lov haqida</th>
                <th>Meneger</th>
                <th>To'lov vaqti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Pays as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item['filial'] }}</td>
                    <td>{{ $item['user'] }}</td>
                    <td>{{ $item['summa'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['about'] }}</td>
                    <td>{{ $item['admin'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection