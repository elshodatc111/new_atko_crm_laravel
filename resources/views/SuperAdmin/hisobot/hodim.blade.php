@extends('SuperAdmin.layout.home')
@section('title','Hodimlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">Hodimlar</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">Hodimlar</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>FIO</th>
                <th>Telefon raqam</th>
                <th>Telefon raqam 2</th>
                <th>Tug'ilgan kun</th>
                <th>Manzil</th>
                <th>Login</th>
                <th>Lavozim</th>
                <th>Status</th>
                <th>Hodim haqida</th>
                <th>Meneger</th>
                <th>Ishga olindi</th>
                <th>Oxirgi yangilanish</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Hodim as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item['filial'] }}</td>
                    <td>{{ $item['fio'] }}</td>
                    <td>{{ $item['phone'] }}</td>
                    <td>{{ $item['phone2'] }}</td>
                    <td>{{ $item['tkun'] }}</td>
                    <td>{{ $item['addres'] }}</td>
                    <td>{{ $item['login'] }}</td>
                    <td>{{ $item['type'] }}</td>
                    <td>{{ $item['status'] }}</td>
                    <td>{{ $item['about'] }}</td>
                    <td>{{ $item['meneger'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection