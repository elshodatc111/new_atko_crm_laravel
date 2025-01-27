@extends('Techer.layout.home')
@section('title','Guruhlar')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Guruhlar</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Techer')}}">Bosh sahifa</a></li>
                    <li class="breadcrumb-item active">Guruhlar</li>
                </ol>
            </nav>
        </div>
    
        <section class="section dashboard">
            <div class="card info-card sales-card">
                <div class="card-body text-center">
                    <h5 class="card-title">Sizning guruhlaringiz.</span></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Guruh</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Tugash vaqti</th>
                                    <th>Talabalar</th>
                                    <th>Dars vaqti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Guruh as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left"><a href="{{ route('TGuruhShow',$item['id']) }}">{{ $item['guruh_name'] }}</a></td>
                                    <td>{{ $item['guruh_start'] }}</td>
                                    <td>{{ $item['guruh_end'] }}</td>
                                    <td>{{ $item['users'] }}</td>
                                    <td>{{ $item['guruh_vaqt'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan=7 class="text-center">Guruhlar mavjud emas.</td>
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