@extends('SuperAdmin.layout.home')
@section('title','Bosh sahifa')
@section('content')

<main id="main" class="main">

  <div class="pagetitle">
      <h1>Bosh sahifa</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
              <li class="breadcrumb-item active">Kunlik to'lovlar</li>
          </ol>
      </nav>
  </div>


    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title e-100 text-center">Kunlik to'lovlar({{ $data }})</h1>
                <div class="table-responsive">
                    <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Filial</th>
                                <th>Talaba</th>
                                <th>Summa</th>
                                <th>Tulov turi</th>
                                <th>Tulov haqida</th>
                                <th>Meneger</th>
                                <th>Tulov vaqti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Tulovlar as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['Filial'] }}</td>
                                <td>{{ $item['User'] }}</td>
                                <td>{{ $item['Summa'] }}</td>
                                <td>{{ $item['Type'] }}</td>
                                <td>{{ $item['About'] }}</td>
                                <td>{{ $item['Admin'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </section>


</main>

@endsection