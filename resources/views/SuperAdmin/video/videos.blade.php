@extends('SuperAdmin.layout.home')
@section('title','Online kurs')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Online Kurslar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item active">Online video kurslar</li>
            </ol>
        </nav>
    </div> 
    <div class="card">
        <div class="card-body">
            <div class="card-title">Online video kurslar</div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kurs nomi</th>
                            <th>Kurslar soni</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($respons as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $item['cours_name'] }}</td>
                            <td>{{ $item['count'] }}</td>
                            <td>
                                <a href="{{ route('video',$item['cours_name']) }}" class="btn btn-primary p-0 px-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td class="text-center">Kurslar mavjud emas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                    

</main>

@endsection