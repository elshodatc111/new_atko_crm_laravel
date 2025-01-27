@extends('layouts.login')
@section('title',"Ro'yhatdan o'tish")
@section('content')
<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
    <div class="card mb-3">
        <div class="card-body">
            <div class="pt-2 pb-2">
                <h5 class="card-title text-center pb-0 my-2 fs-4">KIRISH</h5>
            </div>
            <form class="row g-3 needs-validation" method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <label for="name" class="form-label m-0">FIO</label>
                <input type="text" name="name" class="form-control m-0" required>
                <label for="addres" class="form-label m-0 mt-1">Addres</label>
                <input type="text" name="addres" class="form-control m-0" required>
                <label for="phone" class="form-label m-0 mt-1">Phone</label>
                <input type="text" name="phone" class="form-control m-0" required>
                <label for="phone2" class="form-label m-0 mt-1">Phone2</label>
                <input type="text" name="phone2" class="form-control m-0" required>
                <label for="tkun" class="form-label m-0 mt-1">Tug'ilgan kun</label>
                <input type="date" name="tkun" class="form-control m-0" required>
                <label for="email" class="form-label m-0 mt-1">Login</label>
                <input type="text" name="email" class="form-control m-0" required>
                <label for="password" class="form-label m-0 mt-1">Parol</label>
                <input type="password" name="password" class="form-control m-0" required>
                <button class="btn btn-primary w-100" type="submit">Ro'yhatdan o'tish</button>
            </form>
        </div>
    </div>
</div>

@endsection
