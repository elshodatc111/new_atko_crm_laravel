@extends('SuperAdmin.layout.home')
@section('title','Hodimlar')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
      <h1>Hodimlar</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
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
    <div class="card info-card sales-card">
      <div class="card-body text-center">
        <h5 class="card-title">Hodimlar</span></h5>
        <div class="table-responsive">
          <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
            <thead>
              <tr>
                <th class="bg-primary text-white">#</th>
                <th class="bg-primary text-white">Hodim</th>
                <th class="bg-primary text-white">Phone</th>
                <th class="bg-primary text-white">Addres</th>
                <th class="bg-primary text-white">Tkun</th>
                <th class="bg-primary text-white">Login</th>
                <th class="bg-primary text-white">Create</th>
                <th class="bg-primary text-white">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($Users as $item)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->addres }}</td>
                <td>{{ $item->tkun }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->created_at }}</td>
                <td>
                  <a href="{{ route('HodimDeletes',$item->id) }}" class="btn btn-success px-1 py-0" title="Parolni yangilash"><i class="bi bi-lock"></i></a>
                  <a href="{{ route('HodimPassword',$item->id) }}" class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              @empty
                <tr>
                  <td colspan=8 class="text-center">Hodimlar mavjud emas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    
    <div class="card info-card sales-card">
      <div class="card-body text-center">
        <h5 class="card-title">Yangi Admin</span></h5>
        <form action="{{ route('hodimCreate') }}" method="post">
          @csrf 
          <div class="row">
            <div class="col-lg-6">
              <label for="name">FIO</label>
              <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
              <label for="phone" class=" mt-2">Telefon raqam</label>
              <input type="text" name="phone" value="{{ old('phone') }}" class="phone form-control @error('phone') is-invalid @enderror" required>
              <label for="addres" class=" mt-2">Yashash manzili</label>
              <input type="text" name="addres" value="{{ old('addres') }}" class="form-control @error('addres') is-invalid @enderror" required>
            </div>
            <div class="col-lg-6">
              <label for="tkun">Tug'ilgan kuni</label>
              <input type="date" name="tkun" value="{{ old('tkun') }}" class="form-control @error('tkun') is-invalid @enderror" required>
              <label for="email " class=" mt-2">Login</label>
              <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
              <label for="about" class=" mt-2">Admin haqida</label>
              <input type="text" name="about" value="{{ old('about') }}" class="form-control @error('about') is-invalid @enderror" required>
            </div>
            <div class="col-lg-12">
              <button type="submit" class="btn btn-primary mt-2">Yangi adminni saqlash</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>

</main>

@endsection