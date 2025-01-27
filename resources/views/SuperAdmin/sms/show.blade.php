@extends('SuperAdmin.layout.home')
@section('title','Yuborilgan SMSlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Statistika</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sms')}}">SMS</a></li>
            <li class="breadcrumb-item active">Yuborilgan SMSlar</li>
        </ol>
    </nav>
</div> 
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title w-100 text-center">Yuborilgan SMS({{ $start }}-{{ $end }})</h4>
                <table class="table table-bordered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Telefon raqam</th>
                            <th>SMS matni</th>
                            <th>Yuborilgan vaqt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($SendMessege as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td style="font-size:12px;">{{ $item['phone'] }}</td>
                            <td style="text-align:left;font-size:12px;">{{ $item['text'] }}</td>
                            <td style="font-size:10px;">{{ $item['created_at'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</main>

@endsection