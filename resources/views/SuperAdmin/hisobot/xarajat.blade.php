@extends('SuperAdmin.layout.home')
@section('title','Xarajatlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">Xarajatlar</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">Xarajatlar</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>Xarajat status</th>
                <th>Summasi</th>
                <th>Xarajat turi</th>
                <th>Xarajat haqida</th>
                <th>Meneger</th>
                <th>Admin</th>
                <th>Xarajat vaqti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($CHiqim as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item['filial'] }}</td>
                    <td>{{ $item['xodisa'] }}</td>
                    <td>{{ $item['summa'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['about'] }}</td>
                    <td>{{ $item['user_id'] }}</td>
                    <td>{{ $item['admin_id'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection