@extends('SuperAdmin.layout.home')
@section('title','Hisobotlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobotlar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Hisobotlar</li>
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
            <div class="card-body text-center pt-4">
                <form action="{{ route('hisobotShow') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <select name="report" class="form-select" required>
                                <option value="">Tanlang...</option>
                                <option value="all_tashrif">Barcha talabalar</option>
                                <option value="debet_users">Qarzdor talabalar</option>
                                <option value="guruh_plus_users">Guruhga biriktirilgan talabalar</option>
                                <option value="guruh_plus_users2">Guruhga biriktirilgan talabalar 2</option>
                                <option value="guruh_minus_users">Guruhga biriktirilmagan talabalar</option>
                                <option value="pay">To'lovlar</option>
                                <option value="chiqimlar">Chiqimlar</option>
                                <option value="xarajatlar">Xarajatlar</option>
                                <option value="hodimlar">Hodimlar</option>
                                <option value="hodim_ish_haqi">Hodimlarga to'langan ish xaqi</option>
                                <option value="techer">O'qituvchilar</option>
                                <option value="techer_ish_haqi">O'qituvchilarga to'langan ish xaqi</option>
                                <option value="guruhlar">Guruhlar</option>
                                <option value="test_natija">Test natijalari</option>
                                <option value="umumiy_balans_tarixi">Umumiy balans tarixi</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary w-100">Xisobot</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

@endsection