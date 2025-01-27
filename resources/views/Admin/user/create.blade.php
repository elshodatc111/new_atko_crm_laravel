@extends('Admin.layout.home')
@section('title','Yangi tashrif')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Yangi tashrif</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Yangi tashrif</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif

        <section class="section dashboard">
            <div class="card">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('Student') }}" class="nav-link text-center text-center">Tashriflar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentQarzdorlar') }}" class="nav-link w-100 text-center">Qarzdorlar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentTulovlar') }}" class="nav-link text-center w-100">To'lovlar</a>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <a href="{{ route('StudentCreate') }}" class="nav-link text-center w-100 bg-success text-white w-100 active">Yangi tashrif</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="myTabjustifiedContent">
                        <div class="tab-pane fade show active" id="home-justified" style="min-height:300px;" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('StudentCreateStore') }}" method="post" class="row">
                                @csrf
                                <div class="col-lg-6">
                                    <label for="name" class="mt-2 mb-1">FIO</label>
                                    <input type="text" name="name" class="form-control" required>
                                    <label for="phone" class="mt-2 mb-1">Telefon raqam</label>
                                    <input type="text" name="phone" class="form-control phone" required>
                                    <label for="phone2" class="mt-2 mb-1">Tanishi telefon raqami</label>
                                    <input type="text" name="phone2" class="form-control phone" required>
                                    <label for="addres" class="mt-2 mb-1">Yashash Manzil</label>
                                    <select name="addres" class="form-select">
                                        <option value="">Tanlang</option>
                                        <option value="Qarshi shaxar">Qarshi shaxar</option>
                                        <option value="Qarshi tuman">Qarshi tuman</option>
                                        <option value="Shaxrisabz shaxar">Shaxrisabz shaxar</option>
                                        <option value="Shaxrisabz tuman">Shaxrisabz tuman</option>
                                        <option value="Guzor tuman">Guzor tuman</option>
                                        <option value="Nishon tuman">Nishon tuman</option>
                                        <option value="Koson tuman">Koson tuman</option>
                                        <option value="Kasbi tuman">Kasbi tuman</option>
                                        <option value="Muborak tuman">Muborak tuman</option>
                                        <option value="Mirishkor tuman">Mirishkor tuman</option>
                                        <option value="Yakkabog' tuman">Yakkabog' tuman</option>
                                        <option value="Qamashi tuman">Qamashi tuman</option>
                                        <option value="Chiroqchi tuman">Chiroqchi tuman</option>
                                        <option value="Ko'kdala tuman">Ko'kdala tuman</option>
                                        <option value="Kitob tuman">Kitob tuman</option>
                                        <option value="Dexqonobod tuman">Dexqonobod tuman</option>
                                        <option value="Boshqa tuman">Boshqa</option>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="tkun" class="mt-2 mb-1">Tug'ilgan kuni</label>
                                    <input type="date" name="tkun" class="form-control" required>
                                    <label for="about" class="mt-2 mb-1">Talaba haqida</label>
                                    <input type="text" name="about" class="form-control" required>
                                    <label for="smm" class="mt-2 mb-1">Biz haqimizda</label>
                                    <select name="smm" class="form-select">
                                        <option value="">Tanlang</option>
                                        <option value="Telegram">Telegram</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Bannerlar">Bannerlar</option>
                                        <option value="Tanishlar">Tanishlar</option>
                                        <option value="Boshqa">Boshqa</option>
                                    </select>
                                    <label for="smm" class="mt-2 mb-1 text-white">.</label>
                                    <button class="btn btn-primary w-100">Tashrifni saqlash</button>
                                </div>
                                <div class="col-12 text-center">
                                    
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            
          
                    
        </section>

</main>

@endsection