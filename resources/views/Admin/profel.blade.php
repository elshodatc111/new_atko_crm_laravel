@extends('Admin.layout.home')
@section('title','Kabinet')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Kabinet</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Kabinet</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title w-100 text-center mb-0">{{ Auth::User()->name }}</h5>
                <form action="{{ route('adminkabinetupdate') }}" method="POST">
                    @csrf 
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="name" class="form-label pt-0 mt-2 mb-1 pb-0">FIO</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::User()->name }}" required>
                            <label for="phone" class="form-label pt-0 mt-2 mb-1 pb-0">Telefon raqam</label>
                            <input type="text" class="form-control phone" value="{{ Auth::User()->phone }}" name="phone" required>
                            <label for="phone2" class="form-label pt-0 mt-2 mb-1 pb-0">Ikkinchi telefon raqam</label>
                            <input type="text" class="form-control phone" value="{{ Auth::User()->phone2 }}" name="phone2" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="addres" class="form-label pt-0 mt-2 mb-1 pb-0">Yashash manzili</label>
                            <input type="text" class="form-control" name="addres" disabled value="{{ Auth::User()->addres }}" required>
                            <label for="tkun" class="form-label pt-0 mt-2 mb-1 pb-0">Tug'ilgan kun</label>
                            <input type="text" class="form-control" name="tkun" disabled value="{{ Auth::User()->tkun }}" required>
                            <label for="email" class="form-label pt-0 mt-2 mb-1 pb-0">Login</label>
                            <input type="text" class="form-control" name="email" disabled value="{{ Auth::User()->email }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 w-100">O'zgarishlarni saqlash</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title w-100 text-center mb-0">Parolni yangilash</h5>
                <form action="{{ route('adminkabinetpasswupdate') }}" method="POST">
                    @csrf
                    <label for="password" class="form-label pt-0 mt-2 mb-1 pb-0">Joriy parol (min:8)</label>
                    <input type="password" class="form-control" name="password" required>
                    <label for="newpassword" class="form-label pt-0 mt-2 mb-1 pb-0">Yangi parol (min:8)</label>
                    <input type="password" class="form-control" name="newpassword" required>
                    <label for="nextpassword" class="form-label pt-0 mt-2 mb-1 pb-0">Yangi parolni takrorlang (min:8)</label>
                    <input type="password" class="form-control" name="nextpassword" required>
                    <button type="submit" class="btn btn-primary mt-3 w-100">Parolni yangilash</button>
                </form>
            </div>
        </div>
    </div>
</div>


</main>

@endsection