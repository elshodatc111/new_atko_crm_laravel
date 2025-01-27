@extends('Admin.layout.home')
@section('title','Guruhlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Form</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Ro'yhatga olindi form</li>
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
        <div class="card-body text-center pt-3">
            <ul class="nav nav-tabs d-flex">
                <li class="nav-item flex-fill">
                    <a class="nav-link w-100" href="{{ route('blogs') }}">Yangi</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100 active bg-success text-white" href="{{ route('regBlog') }}">Ro'yxatga olindi</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100" href="{{ route('arxivBlog') }}">Arxivga saqlandi</a>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <a class="nav-link w-100" href="{{ route('deleteBlog') }}">O'chirildi</a>
                </li>
            </ul>
            <div><br>
            <div class="table-responsive">
                <table class="table text-center table-hover" style="font-size:10px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>FIO</th>
                            <th>Phone</th>
                            <th>Guruhlari</th>
                            <th>Guruhdan o'chirildi</th>
                            <th>Ro'yhatga olindi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Blog as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td><a href="{{ route('StudentShow',$item['user_id']) }}">{{ $item['name'] }}</a></td>
                                <td>{{ $item['phone'] }}</td>
                                <td>{{ $item['guruhlar'] }}</td>
                                <td>{{ $item['guruhlarEnd'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

</main>

@endsection