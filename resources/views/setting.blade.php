@extends('SuperAdmin.layout.home')
@section('title','Settings')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Settings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Settings</li>
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
            <div class="card-body mt-3">
                <div class="row ">
                    <div class="col-lg-4">
                            <form action="{{ route('settingupdate') }}" method="post">
                                @csrf 
                                <label for="EndData" class="mt-2 mb-2" style="font-weight:700">Filial bloklanish muddati</label>
                                <input type="date" name="EndData" value="{{ $Setting['EndData'] }}" class="form-control mb-2" required>
                                <label for="Summa" class="mt-2 mb-2" style="font-weight:700">Tulov summasi</label>
                                <input type="number" name="Summa" value="{{ $Setting['Summa'] }}" class="form-control mb-2" required>
                                <label for="Username" class="mt-2 mb-2" style="font-weight:700">Username</label>
                                <input type="text" name="Username" value="{{ $Setting['Username'] }}" class="form-control mb-2" required>
                                <label for="Status" class="mt-2 mb-2" style="font-weight:700">Filial xolati</label>
                                <div class="form-check form-switch">
                                    @if($Setting['Status']=='true')
                                        <input class="form-check-input" type="checkbox" name="Status" checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" name="Status">
                                    @endif
                                </div>
                                <button  type="submit" class="btn btn-primary w-100 mt-3">O'zgarishlarni saqlash</button>
                            </form>
                        </div>
                        <div class="col-lg-4 text-center">
                            <h5 class="card-title">Markazga SMS limit kiritish</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Yuborilgan</th>
                                        <th>Mavjud SMS</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $SmsCounter['counte'] }}</td>
                                        <td>{{ $SmsCounter['maxsms'] }}</td>
                                    </tr>
                                </thead>
                            </table>
                            <form action="{{ route('settingsmsplus') }}" method="post">
                                @csrf 
                                <label for="sms">SMS qo'shish</label>
                                <input type="number" name="sms" class="form-control mt-2" required>
                                <button type="submit" class="btn btn-primary mt-2 w-100">SMS qo'shish</button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
        
                
    </section>

</main>
@endsection