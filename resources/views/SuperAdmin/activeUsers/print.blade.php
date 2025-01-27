@extends('SuperAdmin.layout.home')
@section('title','Kassaga Chiqimlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Aktiv talabalar</a></li>
                <li class="breadcrumb-item active">{{ $Start }} - {{ $End }}</li>
            </ol>
        </nav>
    </div> 

    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>TalabaID</th>
                <th>Talaba</th>
                <th>GuruhID</th>
                <th>Guruh nomi</th>
                <th>Guruh boshlanish vaqti</th>
                <th>Guruh tugash vaqti</th>
                <th>Guruh o'qituvchisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Users as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item['user_id'] }}</td>
                    <td>{{ $item['user'] }}</td>
                    <td>{{ $item['guruh_id'] }}</td>
                    <td>{{ $item['guruh_name'] }}</td>
                    <td>{{ $item['guruh_start'] }}</td>
                    <td>{{ $item['guruh_end'] }}</td>
                    <td>{{ $item['techer'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection