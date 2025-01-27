@extends('Admin.layout.home')
@section('title','Yangi Form')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Form</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blogs') }}">Yangi form </a></li>
            <li class="breadcrumb-item active">show</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-6">
            <div class="card info-card sales-card">
                <div class="card-body text-center pt-3">
                    <table class="table">
                        <tr>
                            <td colspan=2>{{ $Blog['name'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Telefon raqam</td>
                            <td style="text-align:right">{{ $Blog['phone1'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Qo'shimcha telefon</td>
                            <td style="text-align:right">{{ $Blog['phone2'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Yashash manzili</td>
                            <td style="text-align:right">{{ $Blog['addres'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Tug'ilgan kuni</td>
                            <td style="text-align:right">{{ $Blog['tkun'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Biz haqimizda</td>
                            <td style="text-align:right">{{ $Blog['smm'] }}</td>
                        </tr>
                        <tr>
                            <td style="text-align:left">Ro'yxatga olindi</td>
                            <td style="text-align:right">{{ $Blog['created_at'] }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @if($Status==0)
        <div class="col-lg-6">
            <div class="card info-card sales-card">
                <div class="card-body text-center pt-3">
                    <h4 class="card-title">Formni saqlash</h4>
                    <form action="{{ route('newBlogupdate') }}" method="post">
                        @csrf 
                        <input type="hidden" value="{{ $Blog['id'] }}" name="id">
                        <label for="">Status</label>
                        <select name="status" class="form-select mt-2" required>
                            <option value="">Tanlang...</option>
                            <option value="register">Ro'yxatga olish</option>
                            <option value="arxiv">Arxivga saqlash</option>
                            <option value="delete">O'chirish</option>
                        </select>
                        <label for="" class="mt-2">Form haqida</label>
                        <textarea name="commit" class="form-control mt-2" required></textarea>
                        <button class="btn btn-primary w-50 mt-3 mb-3" type="submit">Formni saqlash</button>
                    </form>
                </div>
            </div>
        </div>
        @else 
        <div class="col-lg-6">
            <div class="card info-card sales-card">
                <div class="card-body text-center pt-3">
                    <h4 class="card-title">Formni saqlash</h4>
                    <table class="table text-center table-bordered" style="font-size:10px;">
                        <tr>
                            <th colspan=3 style="font-size:14px">Telefon raqam oldin ro'yhatdan o'tgan</th>
                        </tr>
                        <tr>
                            <td>FIO</td>
                            <td>Telefon</td>
                            <td>Filial</td>
                        </tr>
                        <tr>
                            <td>{{ $Reg['name'] }}</td>
                            <td>{{ $Reg['phone'] }}</td>
                            <td>{{ $Reg['filial'] }}</td>
                        </tr>
                    </table>
                    <form action="{{ route('newBlogupdate') }}" method="post">
                        @csrf 
                        <input type="hidden" value="{{ $Blog['id'] }}" name="id">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Status</label>
                                <select name="status" class="form-select mt-1" required>
                                    <option value="">Tanlang...</option>
                                    <option value="delete">O'chirish</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="" class="">Form haqida</label>
                                <input name="commit" class="form-control mt-1" required>
                            </div>
                        </div>
                        <button class="btn btn-primary w-50 mt-3" type="submit">Formni saqlash</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

</main>

@endsection