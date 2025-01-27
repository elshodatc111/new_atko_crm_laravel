@extends('Admin.layout.home')
@section('title','Eslatmalar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Eslatmalar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item active">Eslatmalar</li>
        </ol>
    </nav>
</div>
@if (Session::has('success'))
    <div class="alert alert-success">{{Session::get('success') }}</div>
@elseif (Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error') }}</div>
@endif

  <div class="card">
    <div class="card-body">
      <h5 class="card-title w-100 text-center">Eslatmalar</h5>
      <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
        <li class="nav-item flex-fill" role="presentation">
          <button class="nav-link w-100 active" id="home-tab" 
          data-bs-toggle="tab" data-bs-target="#home-justified" 
          type="button" role="tab" aria-controls="home" 
          aria-selected="true">Aktiv Eslatmalar</button>
        </li>
        <li class="nav-item flex-fill" role="presentation">
          <button class="nav-link w-100" id="profile-tab" 
          data-bs-toggle="tab" data-bs-target="#profile-justified" 
          type="button" role="tab" aria-controls="profile" 
          aria-selected="false">Arxiv Eslatmalar</button>
        </li>
      </ul>
      <div class="tab-content pt-2" id="myTabjustifiedContent">
        <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
          <div class="table-responsive">
            <table class="table table-bordered text-center table-hover" style="font-size:12px;">
                <thead>
                  <tr>
                    <th class="text-center bg-primary text-white">#</th>
                    <th class="text-center bg-primary text-white">Student/Guruh</th>
                    <th class="text-center bg-primary text-white">Eslatma turi</th>
                    <th class="text-center bg-primary text-white">Eslatma matni</th>
                    <th class="text-center bg-primary text-white">Eslatma vaqti</th>
                    <th class="text-center bg-primary text-white">Meneger</th>
                    <th class="text-center bg-primary text-white">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($Eslatma as $item)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td style="text-align:left;">
                        <a href="
                        @if($item['type']=='user')
                          {{ route('StudentShow',$item['user_guruh_id']) }}
                        @else
                          {{ route('AdminGuruhShow',$item['user_guruh_id']) }}
                        @endif
                        ">
                          {{ $item['name'] }}
                        </a>
                      </td>
                      <td>{{ $item['type'] }}</td>
                      <td style="text-align:left">{{ $item['text'] }}</td>
                      <td>{{ $item['created_at'] }}</td>
                      <td>{{ $item['meneger'] }}</td>
                      <td>
                        <a href="{{ route('AdminEslatmaArxiv',$item['id']) }}" class="btn btn-primary px-1 py-0" title="Arxivlash"><i class="bi bi-archive"></i></a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan=7 class="text-center">Eslatmalar mavjud emas.</td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
          <div class="table-responsive">
            <table class="table datatable text-center table-hover" style="font-size:12px;">
            <thead>
                  <tr>
                    <th class="text-center bg-primary text-white">#</th>
                    <th class="text-center bg-primary text-white">Student/Guruh</th>
                    <th class="text-center bg-primary text-white">Eslatma turi</th>
                    <th class="text-center bg-primary text-white">Eslatma matni</th>
                    <th class="text-center bg-primary text-white">Eslatma vaqti</th>
                    <th class="text-center bg-primary text-white">Meneger</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($Eslatma_arxiv as $item)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td style="text-align:left;">
                        <a href="
                        @if($item['type']=='user')
                          {{ route('StudentShow',$item['user_guruh_id']) }}
                        @else
                          {{ route('AdminGuruhShow',$item['user_guruh_id']) }}
                        @endif
                        ">
                          {{ $item['name'] }}
                        </a>
                      </td>
                      <td>{{ $item['type'] }}</td>
                      <td style="text-align:left">{{ $item['text'] }}</td>
                      <td>{{ $item['created_at'] }}</td>
                      <td>{{ $item['meneger'] }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan=6 class="text-center">Arxiv eslatmalar mavjud emas.</td>
                    </tr>
                  @endforelse
                </tbody>
            </table>
          </div>
        </div>
      
        </div>
      </div><!-- End Default Tabs -->

    </div>
  </div>

</main>

@endsection