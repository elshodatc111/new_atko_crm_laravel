@extends('Techer.layout.home')
@section('title','Bosh sahifa')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Bosh sahifa</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Techer')}}">Bosh sahifa</a></li>
                    <li class="breadcrumb-item active">Bosh sahifa</li>
                </ol>
            </nav>
        </div> 
    
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card info-card sales-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Yangi guruhlar</span></h5>
                            <h5>{{ $Stat['new'] }}</h5>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="card info-card sales-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Aktiv guruhlar</span></h5>
                            <h5>{{ $Stat['start'] }}</h5>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="card info-card sales-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Yakunlangan guruhlar</span></h5>
                            <h5>{{ $Stat['end'] }}</h5>
                        </div>
                    </div>  
                </div>
                
                <div class="col-lg-6">
                    <div class="card info-card sales-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Joriy oyda to'langan ish haqi</span></h5>
                            <table>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Naqt</th>
                                        <th>Plastik</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $Tulov['NaqtNow'] }}</td>
                                        <td>{{ $Tulov['PlastihNow'] }}</td>
                                    </tr>
                                </table>
                            </table>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-6">
                    <div class="card info-card sales-card">
                        <div class="card-body text-center">
                            <h5 class="card-title">O'tgan oyda to'langan ish haqi</span></h5>
                            <table>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Naqt</th>
                                        <th>Plastik</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $Tulov['NaqtEnd'] }}</td>
                                        <td>{{ $Tulov['PlastihEnd'] }}</td>
                                    </tr>
                                </table>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
        </section>

    </main>

@endsection