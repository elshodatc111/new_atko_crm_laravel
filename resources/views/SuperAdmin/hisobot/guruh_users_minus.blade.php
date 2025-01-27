@extends('SuperAdmin.layout.home')
@section('title','Guruhlar mavjud talabalar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">Guruhlar mavjud bo'lmagan talabalar</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">Guruhlar mavjud bo'lmagan talabalar</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>FIO</th>
                <th>Addres</th>
                <th>Tkun</th>
                <th>Phone1</th>
                <th>Phone2</th>
                <th>Talaba haqida</th>
                <th>Biz haqimizda</th>
                <th>Talaba balansi</th>
                <th>Login</th>
                <th>Admin</th>
                <th>Royhatga olindi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Users as $item)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $item['filial'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['addres'] }}</td>
                <td>{{ $item['tkun'] }}</td>
                <td>{{ $item['phone'] }}</td>
                <td>{{ $item['phone2'] }}</td>
                <td>{{ $item['about'] }}</td>
                <td>{{ $item['smm'] }}</td>
                <td>{{ $item['balans'] }}</td>
                <td>{{ $item['login'] }}</td>
                <td>{{ $item['admin'] }}</td>
                <td>{{ $item['created_at'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection