@extends('SuperAdmin.layout.home')
@section('title','Online kurs')
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Online Kurslar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('videos')}}">Online video kurslar</a></li>
                <li class="breadcrumb-item active">Online video kurs haqida</li>
            </ol>
        </nav>
    </div> 
    <div class="card">
        <div class="card-body">
            <div class="card-title">Online video kurs mavzulari ({{ $name }})</div>
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cours nomi</th>
                            <th>Mavzu nomi</th>
                            <th>Tartib raqami</th>
                            <th>Youtube video(url)</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($videos as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item['cours_name'] }}</td>
                                <td>{{ $item['sort_numbr'] }}</td>
                                <td>{{ $item['lessen_name'] }}</td>
                                <td>{{ $item['video_url'] }}</td>
                                <td>
                                    <form action="{{ route('video_delete') }}" method="post">
                                        @csrf 
                                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                                        <button class="btn btn-danger p-1 py-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan=6 class="text-center">Kurs mavzulari mavjud emas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <hr>
                <br>
                <form action="{{ route('video_create') }}" method="post">
                    @csrf 
                    <div class="row">
                        <div class="col-lg-2">
                            <input type="hidden" name="cours_name" value="{{ $name }}">
                            <label for="sort_numbr" class="w-100 text-center">Mavzu tartib raqami</label>
                            <input type="number" name="sort_numbr" required class="form-control">
                        </div>
                        <div class="col-lg-5">
                            <label for="lessen_name" class="w-100 text-center">Mavzu nomi</label>
                            <input type="text" name="lessen_name" required class="form-control">
                        </div>
                        <div class="col-lg-5">
                            <label for="video_url" class="w-100 text-center">Youtube video(url)</label>
                            <input type="text" name="video_url" required class="form-control">
                        </div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-primary mt-2 w-50">Saqlash</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
                    

</main>

@endsection