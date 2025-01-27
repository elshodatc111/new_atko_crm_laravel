@extends('SuperAdmin.layout.home')
@section('title','SMS')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>SMS</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">SMS</li>
        </ol>
    </nav>
</div> 
    <section class="section dashboard">
        @if (Session::has('success'))
            <div class="alert alert-success">{{Session::get('success') }}</div>
        @elseif (Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error') }}</div>
        @endif
        <div class="row">
            <!--
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-0 pb-0">Barcha talabalarga SMS yuborish</h4>
                        <form action="{{ route('sms_send') }}" method="post">
                            @csrf
                            <label for="text"></label>
                            <textarea name="text" required class="form-control"></textarea>
                            <button class="w-100 btn btn-primary w-100 mt-2">SMS yuborish</button>
                        </form>
                    </div>
                </div>
            </div>
            -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-0 pb-0">SMS statistika</h4>
                        <table class="table text-center">
                            <tr>
                                <th>Mavjud SMS</th>
                                <th>Yuborilgan SMS</th>
                            </tr>
                            <tr>
                                <td>{{ $SmsCounter['maxsms'] }}</td>
                                <td>{{ $SmsCounter['counte'] }}</td>
                            </tr>
                        </table>
                        <button class="w-100 btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#basicModal">Yuborilgan sms tarixi</button>
                        <div class="modal fade" id="basicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">SMS tarixi</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('sms_show') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="start">dan</label>
                                                    <input type="date" required name="start" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="end">gacha</label>
                                                    <input type="date" required name="end" class="form-control">
                                                </div>
                                            </div>
                                            <button class="btn btn-primary w-100 mt-2">SMS tarixi</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title">Bugun yuborilgan smslar</h4>
                        <table class="table table-bordered" style="font-size:12px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Telefon raqam</th>
                                    <th>SMS matni</th>
                                    <th>Yuborilgan vaqt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($SendMessege as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="font-size:12px;">{{ $item['phone'] }}</td>
                                    <td style="text-align:left;font-size:12px;">{{ $item['text'] }}</td>
                                    <td style="font-size:10px;">{{ $item['created_at'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    <div>
                <div>
            <div>
        </div>
    </section>

</main>

@endsection