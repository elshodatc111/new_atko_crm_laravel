@extends('Techer.layout.home')
@section('title','Kabinet')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Kabinet</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Techer')}}">Bosh sahifa</a></li>
                    <li class="breadcrumb-item active">Kabinet</li>
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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title w-100 text-center">Elshod Musurmonov</h4>
                        <form action="{{ route('KabinetTUpdate') }}" method="post">
                            @csrf
                            <div class="row ">
                                <div class="col-lg-6">
                                    <label for="">FIO</label>
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control mb-2" required>
                                    <label for="">Manzil</label>
                                    <input type="text" name="addres" value="{{ Auth::user()->addres }}" class="form-control mb-2" required>
                                    <label for="">Telefon raqma</label>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" class="form-control phone mb-2" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Login</label>
                                    <input type="text" value="{{ Auth::user()->email }}" class="form-control mb-2" disabled required>
                                    <label for="">Tug'ilgan kun</label>
                                    <input type="date" name="tkun" value="{{ Auth::user()->tkun }}" class="form-control mb-2" required>
                                    <label for="">Ishga olindi</label>
                                    <input type="text" value="{{ Auth::user()->created_at }}" class="form-control mb-2" disabled required>
                                </div>
                                <div class="col-12 text-center"><button class="btn btn-primary w-50 mt-2">O'zgarishlarni saqlash</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title w-100 text-center">Parolni Yangilash</h4>
                        <form action="{{ route('KabinetTUpdatePassword') }}" method="post">
                            @csrf
                            <label for="">Yangi parol</label>
                            <input type="password" name="passw1" class="form-control mb-2" required>
                            <label for="">Parolni takrorlang</label>
                            <input type="password" name="passw2" class="form-control mb-2" required>
                            <button class="btn btn-primary w-100 mt-2">Parolni yangilash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        
                
    </section>

    </main>

@endsection