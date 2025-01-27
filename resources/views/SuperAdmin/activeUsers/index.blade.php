@extends('SuperAdmin.layout.home')
@section('title','Hisobotlar')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Hisobotlar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Aktiv talabalar</li>
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
                <form action="{{ route('uploadActiveUser') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <select name="filial_id" class="form-select" required>
                                <option value="">Filialni Tanlang...</option>
                                @foreach($Filial as $item)
                                <option value="{{ $item['id'] }}">{{ $item['filial_name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="monchs" class="form-select" required>
                                <option value="">Qaysi oydagini tanlang...</option>
                                @foreach($formattedDates as $item)
                                <option value="{{ $item['Y-m'] }}">{{ $item['Y-M'] }}</option>
                                @endforeach
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