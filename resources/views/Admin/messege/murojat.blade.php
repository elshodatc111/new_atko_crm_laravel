@extends('Admin.layout.home')
@section('title','Murojatlar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Murojatlar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Murojatlar</li>
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
      <div class="card-body row pt-4">
        <div class="col-4">
            <div class="list-group border" style="height:400px;overflow-x: hidden;overflow-y: scroll">
                @foreach($Murojatlar as $item)
                <a href="{{ route('AdminMurojarlarShow', $item['user_id']) }}" class="list-group-item list-group-item-action" aria-current="true">
                    <div class="d-flex p-0 w-100 justify-content-between">
                        <h6 class="p-0 m-0">{{ $item['name'] }}</h6>
                        <small class="text-muted" style="font-size:8px;padding-top:7px;">{{ $item['created_at'] }}</small>
                    </div>  
                    @if($item['admin_type']==true) 
                        <p class="p-0 m-0 d-none d-lg-block text-primary">{{ $item['text'] }}</p>  
                    @else
                        <p class="p-0 m-0 d-none d-lg-block text-muted">{{ $item['text'] }}</p>    
                    @endif                    
                </a>
                @endforeach
            </div>
        </div>
      </div>
    </div>   
  </section>

</main>

@endsection
