@extends('Techer.layout.home')
@section('title','To\'lovlar')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>To'lovlar</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Techer')}}">Bosh sahifa</a></li>
                    <li class="breadcrumb-item active">To'lovlar</li>
                </ol>
            </nav>
        </div>
    
        <section class="section dashboard">
            <div class="card info-card sales-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Ish haqi to'lovlari</span></h5>
                    <div class="table-responsive">
                        <table class="table text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guruh</th>
                                    <th>To'lov summasi</th>
                                    <th>To'lov turi</th>
                                    <th>To'lov haqida</th>
                                    <th>To'lov vaqti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Tulov as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $item['guruh'] }}</td>
                                    <td>{{ $item['summa'] }}</td>
                                    <td>{{ $item['type'] }}</td>
                                    <td>{{ $item['about'] }}</td>
                                    <td>{{ $item['time'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=6 class="text-center">Ish haqi to'lovlar mavjud emas.</td>
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