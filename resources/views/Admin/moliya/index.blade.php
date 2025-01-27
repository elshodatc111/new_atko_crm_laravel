@extends('Admin.layout.home')
@section('title','Moliya')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Moliya</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Moliya</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif
<section class="section dashboard row mb-0 pb-0">
    <div class="col-lg-3">
        <div class="card mb-2">
            <div class="card-body text-center" style="min-height:175px;">
                <h5 class="card-title mb-0 pb-2"><i class="bi bi-bag-check"></i> Kassada mavjud to'lovlar</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-cash"></i> Naqt:</b>
                        <span class="badge bg-success rounded-pill">{{ $Kassa['Naqt'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-credit-card-2-back"></i> Plastik:</b>
                        <span class="badge bg-success rounded-pill">{{ $Kassa['Plastik'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card mb-2">
            <div class="card-body text-center" style="min-height:175px;">
                <h5 class="card-title mb-0 pb-2"><i class="bi bi-capslock"></i> Chiqim kutilmoqda</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-cash"></i> Naqt:</b>
                        <span class="badge bg-warning rounded-pill">{{ $Kassa['ChiqimNaqt'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-credit-card-2-back"></i> Plastik:</b>
                        <span class="badge bg-warning rounded-pill">{{ $Kassa['ChiqimPlastik'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card mb-2">
            <div class="card-body text-center" style="min-height:175px;">
                <div class="table-responsive">
                    <h5 class="card-title m-0 pb-2"><i class="bi bi-cart4"></i> Xarajat kutilmoqda</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-cash"></i> Naqt:</b>
                            <span class="badge bg-info rounded-pill">{{ $Kassa['XarajatNaqt'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-credit-card-2-back"></i> Plastik:</b>
                            <span class="badge bg-info rounded-pill">{{ $Kassa['XarajatPlastik'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	@if(Auth::user()->type!='Operator')
    <div class="col-lg-3">
        <div class="card mb-2">
            <div class="card-body text-center" style="min-height:175px;">
                <div class="table-responsive">
                    <h5 class="card-title m-0 pb-2"><i class="bi bi-bag-check"></i>Ish haqi to'lovi uchun</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-cash"></i> Naqt:</b>
                            <span class="badge bg-primary rounded-pill">{{ $IshHaq['naqt'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b class="card-title p-0 m-0" style="font-size:14px;"><i class="bi bi-credit-card-2-back"></i> Plastik:</b>
                            <span class="badge bg-primary rounded-pill">{{ $IshHaq['plastik'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	@endif
</section>
<div class="row text-center pb-3 mt-0 pt-0">
    <div class="col-lg-4 mt-2 mt-lg-0">
        <button class="btn btn-danger text-white w-100 mt-2" 
        data-bs-toggle="modal" data-bs-target="#QaytarilganTulov">
        <i class="bi bi-capslock"></i> Qaytarildi: {{ $QaytarildiSumma }}</button>
    </div>
    <div class="col-lg-4 mt-2 mt-lg-0">
        <button class="btn btn-warning text-white w-100 mt-2" 
        data-bs-toggle="modal" data-bs-target="#KassadanChiqim">
        <i class="bi bi-capslock"></i> Kassadan chiqim</button>
    </div>
    <div class="col-lg-4 mt-2 mt-lg-0">
        <button class="btn btn-info text-white w-100 mt-2" 
        data-bs-toggle="modal" data-bs-target="#XarajatChiqim">
        <i class="bi bi-cart4"></i> Xarajat uchun chiqim</button>
    </div>
</div>
<div class="modal fade" id="QaytarilganTulov" tabindex="-1">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title p-0 m-0 w-100 text-center"><i class="bi bi-capslock"></i> Qaytarilgan to'lovlar (Oxirgi 7 kun)</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" style="font-size:14px">
                        <thead>
                            <th class="bg-primary text-white">#</th>
                            <th class="bg-primary text-white">Talaba</th>
                            <th class="bg-primary text-white">Summa</th>
                            <th class="bg-primary text-white">Qaytarish haqida</th>
                            <th class="bg-primary text-white">Tulov turi</th>
                            <th class="bg-primary text-white">Qaytarish vaqti</th>
                            <th class="bg-primary text-white">Meneger</th>
                        </thead>
                        <tbody>
                            @forelse($Qaytarildi as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td><a href="{{ route('StudentShow',$item['user_id']) }}">{{ $item['user'] }}</a></td>
                                <td>{{ $item['summa'] }}</td>
                                <td>{{ $item['about'] }}</td>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                                <td>{{ $item['admin'] }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan=8 class="text-center">Qaytarilgan to'lovlar mavjud emas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="KassadanChiqim" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title p-0 m-0 w-100 text-center"><i class="bi bi-capslock"></i> Kassadan chiqim</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('AdminMoliyaCHiqim') }}" method="post" id="form1">
                    @csrf
                    <input type="hidden" name="xodisa" value="Chiqim">
                    <input type="hidden" name="status" value="false">
                    <input type="hidden" name="naqt" value="{{ $Kassa['Naqt'] }}">
                    <input type="hidden" name="plastik" value="{{ $Kassa['Plastik'] }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="summa" class="mb-1">Chiqim summasi</label>
                            <input type="text" name="summa" id="summa1" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="type" class="mb-1 mt-2 mt-lg-0">Chiqim turi</label>
                            <select name="type" class="form-select" required>
                                <option value="">Tanlang</option>
                                <option value="Naqt">Naqt</option>
                                <option value="Plastik">Plastik</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="about" class="mt-3 mb-1">Chiqim haqida</label>
                            <textarea name="about" class="form-control" required></textarea>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Bekor qilish</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary mt-3 w-100">Chiqim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="XarajatChiqim" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title p-0 m-0 w-100 text-center"><i class="bi bi-cart4"></i> Xarajat uchun chiqim</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('AdminMoliyaXarajat') }}" method="post" id="form2">
                    @csrf
                    <input type="hidden" name="xodisa" value="Xarajat">
                    <input type="hidden" name="status" value="false">
                    <input type="hidden" name="naqt" value="{{ $Kassa['Naqt'] }}">
                    <input type="hidden" name="plastik" value="{{ $Kassa['Plastik'] }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="summa" class="mb-1">Xarajat summasi</label>
                            <input type="text" name="summa" id="summa2" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="type" class="mb-1 mt-2 mt-lg-0">Xarajat turi</label>
                            <select name="type" class="form-select" required>
                                <option value="">Tanlang</option>
                                <option value="Naqt">Naqt</option>
                                <option value="Plastik">Plastik</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="about" class="mt-3 mb-1">Xarajat haqida</label>
                            <textarea name="about" class="form-control" required></textarea>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Bekor qilish</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary mt-3 w-100">Xarajat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body pt-3">
        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" 
                data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" 
                role="tab" aria-controls="home" aria-selected="true"><i class="bi bi-capslock"></i> Tasdiqlanmagan chiqimlar</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" 
                data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" 
                role="tab" aria-controls="profile" aria-selected="false"><i class="bi bi-cart4"></i> Tasdiqlanmagan xarajatlar</button>
            </li>
        </ul>
        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
            <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                <div class="table-responsive pt-3">
                    <table class="table text-center table-bordered table-hover" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="text-center bg-primary text-white">#</th>
                                <th class="text-center bg-primary text-white">Summa</th>
                                <th class="text-center bg-primary text-white">Chiqim turi</th>
                                <th class="text-center bg-primary text-white">Chiqim haqida</th>
                                <th class="text-center bg-primary text-white">Chiqim vaqti</th>
                                <th class="text-center bg-primary text-white">Meneger</th>
                                <th class="text-center bg-primary text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Chiqim as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['summa'] }}</td>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['about'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                                <td>{{ $item['user'] }}</td>
                                <td>
                                    <form action="{{ route('AdminMoliyaCHiqimDelete') }}" method="post" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                        <button type="submit" class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @if(Auth::user()->type=='SuperAdmin')
                                    <form action="{{ route('AdminMoliyaCHiqimTasdiq') }}" method="post" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                        <button type="submit" class="btn btn-success px-1 py-0"><i class="bi bi-check"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan=7 class="text-center"> Tasdiqlanmagan chiqimlar mavjud emas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="table-responsive pt-3">
                    <table class="table text-center table-bordered table-hover" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="text-center bg-primary text-white">#</th>
                                <th class="text-center bg-primary text-white">Summa</th>
                                <th class="text-center bg-primary text-white">Xarajat turi</th>
                                <th class="text-center bg-primary text-white">Xarajat haqida</th>
                                <th class="text-center bg-primary text-white">Xarajat vaqti</th>
                                <th class="text-center bg-primary text-white">Meneger</th>
                                <th class="text-center bg-primary text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Xarajat as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['summa'] }}</td>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['about'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                                <td>{{ $item['user'] }}</td>
                                <td>
                                    <form action="{{ route('AdminMoliyaXarajatDelete') }}" method="post" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                        <button type="submit" class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @if(Auth::user()->type=='SuperAdmin')
                                    <form action="{{ route('AdminMoliyaXarajatTasdiq') }}" method="post" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                        <button type="submit" class="btn btn-success px-1 py-0"><i class="bi bi-check"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan=7 class="text-center"> Tasdiqlanmagan xarajatlar mavjud emas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@if(Auth::user()->type=='SuperAdmin')
<div class="card">
    <div class="card-body">
        <h5 class="card-title w-100 text-center">O'chirilgan to'lovlar(Oxirgi 7 kunlik)</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center" style="font-size:12px;">
                <tr>
                    <th class="bg-primary text-white">#</th>
                    <th class="bg-primary text-white">Talaba</th>
                    <th class="bg-primary text-white">Summa</th>
                    <th class="bg-primary text-white">Type</th>
                    <th class="bg-primary text-white">O'chirilgan vaqt</th>
                    <th class="bg-primary text-white">Meneger</th>
                </tr>
                @forelse($TulDel as $item)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td style="text-align:left"><a href="{{ route('StudentShow',$item['user_id']) }}">{{ $item['student'] }}</a></td>
                        <td>{{ $item['summa'] }}</td>
                        <td>{{ $item['type'] }}</td>
                        <td>{{ $item['created_at'] }}</td>
                        <td>{{ $item['admin'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan=6 class="text-center">O'chirilgan to'lovlar mavjud emas.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</div>
@endif
</main>

@endsection