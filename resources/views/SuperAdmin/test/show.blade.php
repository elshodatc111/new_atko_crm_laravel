@extends('SuperAdmin.layout.home')
@section('title',"Online Testlar")
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>O'qituvchiga to'lovlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superAdminTesting')}}">Online Testlar</a></li>
            <li class="breadcrumb-item active">Test</li>
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
            <div class="card-body">
                <h5 class="card-title w-100 text-center mb-1 pb-1">Kursning nomi</h5>
                <div class="table-responsive">
                    <table class="table text-center table-bordered" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Savol</th>
                                <th class="bg-primary text-white">To'g'ri javob</th>
                                <th class="bg-primary text-white">Noto'g'ri javob</th>
                                <th class="bg-primary text-white">Noto'g'ri javob</th>
                                <th class="bg-primary text-white">Noto'g'ri javob</th>
                                <th class="bg-primary text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($Test as $item)
                            <tr> 
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['Savol'] }}</td>
                                <td>{{ $item['TJavob'] }}</td>
                                <td>{{ $item['NJavob1'] }}</td>
                                <td>{{ $item['NJavob2'] }}</td>
                                <td>{{ $item['NJavob3'] }}</td>
                                <td>
                                    <a href="{{ route('superAdminTestingDelete', $item['id']) }}" class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan=7 class="text-center">Test Savollari mavjud emas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        
        <div class="card">
            <div class="card-body">
                <h4 class="card-title w-100 text-center">Yangi test savoli qo'shish.</h4>
                <form action="{{ route('superAdminTestingCreate') }}" method="post" class="row">
                    @csrf 
                    <input type="hidden" name="cours_id" value="{{ $id }}">
                    <div class="col-lg-12">
                        <label for="Savol">Test savoli</label>
                        <input type="text" name="Savol" class="form-control" required>
                    </div>
                    <div class="col-lg-6">
                        <label for="TJavob" class="mt-2">To'g'ri javob</label>
                        <input type="text" name="TJavob" class="form-control" required>
                        <label for="NJavob1" class="mt-2">Noto'g'ri javob</label>
                        <input type="text" name="NJavob1" class="form-control" required>
                    </div>
                    <div class="col-lg-6">
                        <label for="NJavob2" class="mt-2">Noto'g'ri javob</label>
                        <input type="text" name="NJavob2" class="form-control" required>
                        <label for="NJavob3" class="mt-2">Noto'g'ri javob</label>
                        <input type="text" name="NJavob3" class="form-control" required>
                    </div>
                    <div class="col-12 text-center">
                        <button class="btn btn-primary mt-3 w-50">Test savolini saqlash</button>
                    </div>
                </form>
            </div>
        </div> 
        
    </section>

</main>

@endsection