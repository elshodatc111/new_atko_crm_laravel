@extends('Admin.layout.home')
@section('title','O\'qituvchilar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>O'qituvchilar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">O'qituvchilar</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif
<section class="section dashboard">
    <div class="card info-card sales-card">
        <div class="card-body text-center">
            <h5 class="card-title">Arxiv O'qituvchilar</span></h5>
            <div class="table-responsive">
                <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                    <thead>
                        <tr>
                            <th class="bg-primary text-white">#</th>
                            <th class="bg-primary text-white">O'qituvchilar</th>
                            <th class="bg-primary text-white">Telefon raqam</th>
                            <th class="bg-primary text-white">Telefon raqam 2</th>
                            <th class="bg-primary text-white">Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($Techers as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td style="text-align:left">
                                <a href="{{ route('AdminTecherShow',$item->id) }}">{{ $item->name }}</a>
                            </td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->phone2 }}</td>
                            <td>{{ $item->email }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan=5 class="text-center">O'qituvchi o'chirildi.</td>
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