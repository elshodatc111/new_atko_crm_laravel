@extends('SuperAdmin.layout.home')
@section('title','Hisobot')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobot</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hisobot')}}">Hisobot</a></li>
                <li class="breadcrumb-item active">Test natijalari</li>
            </ol>
        </nav>
    </div> 

    
    <h5 class="w-100 text-center">Test natijalari</h5>
    <div class="w-100" style="text-align:right">
        <a id='export' style='cursor:pointer' class="btn btn-warning text-white"> EXCEL</a>
    </div>
    <table class="table table-bordered mt-3" style="font-size:10px" id="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Filial</th>
                <th>Guruh</th>
                <th>Talaba</th>
                <th>Savollar soni</th>
                <th>To'g'ri javob</th>
                <th>Noto'g'ri javob</th>
                <th>Ball</th>
                <th>To'lov vaqti</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Test as $item)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $item['filial'] }}</td>
                    <td>{{ $item['guruh'] }}</td>
                    <td>{{ $item['user'] }}</td>
                    <td>{{ $item['savollar'] }}</td>
                    <td>{{ $item['tugri_count'] }}</td>
                    <td>{{ $item['notugri_count'] }}</td>
                    <td>{{ $item['ball'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
                    

</main>

@endsection