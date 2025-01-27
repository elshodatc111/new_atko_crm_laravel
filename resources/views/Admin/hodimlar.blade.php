@extends('Admin.layout.home')
@section('title','Hodimlar')
@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Hodimlar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Hodimlar</li>
            </ol>
        </nav>
    </div>
    @if (Session::has('success'))
        <div class="alert alert-success">{{Session::get('success') }}</div>
    @elseif (Session::has('error'))
        <div class="alert alert-danger">{{Session::get('error') }}</div>
    @endif
    <section class="section dashboard">
        @if(Auth::user()->type != 'Operator')
            <div class="w-100 mb-1" style="text-align:right">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#basicModal"><i class="bi bi-person-add"></i> Yangi Hodim</button>
            </div>
        @endif    
        <div class="modal fade" id="basicModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center">Yangi Hodim qo'shish</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('adminCreateHodimlar') }}" method="post">
                            @csrf 
                            <label for="name">FIO</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                            <label for="phone" class=" mt-2">Telefon Raqam</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="phone form-control @error('phone') is-invalid @enderror" required>
                            <label for="phone2" class=" mt-2">Ikkinchi Telefon Raqam</label>
                            <input type="text" name="phone2" value="{{ old('phone2') }}" class="phone form-control @error('phone2') is-invalid @enderror" required>
                            <label for="addres" class=" mt-2">Yashash Manzili</label>
                            <input type="text" name="addres" value="{{ old('addres') }}" class="form-control @error('addres') is-invalid @enderror" required>
                            <label for="tkun">Tug'ilgan Kuni</label>
                            <input type="date" name="tkun" value="{{ old('tkun') }}" class="form-control @error('tkun') is-invalid @enderror" required>
                            <label for="email " class=" mt-2">Login</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                            <label for="type" class=" mt-2">Lavozimi</label>
                            <select name="type" class="form-select">
                                <option value="">Tanlang</option>
                                <option value="Operator">Operator</option>
                                @if(Auth::user()->type=='SuperAdmin')
                                <option value="Admin">Admin</option>
                                @endif
                            </select>
                            <label for="about" class=" mt-2">Hodim Haqida</label>
                            <input type="text" name="about" value="{{ old('about') }}" class="form-control @error('about') is-invalid @enderror" required>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">Saqlash</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card info-card sales-card">
            <div class="card-body text-center">
                <h5 class="card-title">Hodimlar</span></h5>
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="text-center bg-primary text-white">#</th>
                                <th class="text-center bg-primary text-white">Hodim</th>
                                <th class="text-center bg-primary text-white">Phone</th>
                                <th class="text-center bg-primary text-white">Lavozim</th>
                                <th class="text-center bg-primary text-white">Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($User as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td style="text-align:left"><a href="{{ route('adminHodim',$item->id) }}">{{ $item->name }}</a></td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=6 class="text-center">Hodimlar mavjud emas.</td>
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