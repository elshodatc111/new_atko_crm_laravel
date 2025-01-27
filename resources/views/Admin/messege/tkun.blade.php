@extends('Admin.layout.home')
@section('title','Tug\'ilgan kunlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Tug'ilgan kunlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Tug'ilgan kunlar</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif
    <div class="card">
        <div class="card-body">
            <h5 class="card-title w-100 text-center">Bugun talabalarning tug'ilgan kuni</h5>
            <div class="table-responsive">
                <p class="p-0 m-0 text-danger w-100 text-center">Bugun tug'ilgan kunlarni nishonlayatgan talabalarga soat 10:00 da sms tabrik yuboriladi.</p>
                <table class="table text-center table-bordered">
                    <thead>
                        <tr>
                            <th class="bg-primary text-white">#</th>
                            <th class="bg-primary text-white">FIO</th>
                            <th class="bg-primary text-white">Telefon raqam</th>
                            <th class="bg-primary text-white">Tug'ilgan kun</th>
                            <th class="bg-primary text-white">Manzil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tkun as $item)
                        <tr>
                            <td class="text-center">{{ $loop->index+1 }}</td>
                            <td style="text-align:left"><a href="{{ route('StudentShow',$item['id']) }}">{{ $item['name'] }}</a></td>
                            <td>{{ $item['phone'] }}</td>
                            <td>{{ $item['tkun'] }}</td>
                            <td>{{ $item['addres'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="5">Bugun tug'ilgan kunlar yo'q.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

@endsection
