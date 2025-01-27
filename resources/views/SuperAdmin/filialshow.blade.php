@extends('SuperAdmin.layout.home')
@section('title','Sozlamalar')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Sozlamalar</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('filial')}}">Filiallar</a></li>
            <li class="breadcrumb-item active">Sozlamalar</li>
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
            <div class="card-body text-center">
                <h5 class="card-title mb-0 pb-0">{{ $Filial->filial_name }}</span></h5>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-6">
                <div class="card" style="min-height:325px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Filial xonalari</span></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                                <thead>
                                    <tr>
                                        <th class="bg-primary text-white">#</th>
                                        <th class="bg-primary text-white">Filial xonasi</th>
                                        <th class="bg-primary text-white">Status</th>
                                    </tr>
                                </thead>
                                <tbodt>
                                    @forelse($Room as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td>{{ $item->room_name }}</td>
                                        <td>
                                            <a href="{{ route('roomdelete',$item->id) }}" class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan=3 class="text-center">Xonalar mavjud emas</td>
                                    </tr>
                                    @endforelse
                                </tbodt>
                            </table>
                        </div>
                        <h5 class="card-title mb-0">Yangi xona</span></h5>
                        <form action="{{ route('roomcreate') }}" method="post">
                            @csrf 
                            <input type="hidden" name="filial_id" value="{{ $Filial->id }}">
                            <input type="hidden" name="status" value="true">
                            <input type="text" name="room_name" placeholder="Xona nomi" class="form-control" required>
                            <button class="btn btn-primary w-100 mt-2">Saqlash</button>
                        </form> 
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" style="min-height:325px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">Filial kurslari</span></h5>
                        <table class="table table-bordered text-center">
                            <tr>
                                <th class="bg-primary text-white">#</th>
                                <th class="bg-primary text-white">Kurs nomi</th>
                                <th class="bg-primary text-white">Status</th>
                            </tr>
                            @forelse($Cours as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item->cours_name }}</td>
                                <td>
                                    <!--
                                        <a href="" class="btn btn-primary px-1 py-0"><i class="bi bi-eye"></i></a>
                                    -->
                                    <a href="{{ route('filialCoursDelete',$item['id']) }}" class="btn btn-danger px-1 py-0"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan=3 class='text-center'>Kurslar mavjud emas.</td>
                            </tr>
                            @endforelse
                        </table>
                        <h5 class="card-title mb-0">Yangi kurs qo'shish</span></h5>
                        <form action="{{ route('filialCoursCreate') }}" method="post">
                            @csrf
                            <input type="hidden" name="filial_id" value="{{ $Filial->id }}">
                            <input type="text" name="cours_name" placeholder="Kursning nomi"  required class="form-control">
                            <button class="btn btn-primary mt-2 w-100">Kursni saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-0">To'lov sozlamalari</span></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
                                <thead>
                                    <tr>
                                        <th class="bg-primary text-white">Summa</th>
                                        <th class="bg-primary text-white">Chegirma</th>
                                        <th class="bg-primary text-white">Admin Chegirma</th>
                                        <th class="bg-primary text-white">Status</th>
                                    </tr>
                                </thead>
                                <tbodt>
                                    @forelse($TulovSetting as $item)
                                    <tr>
                                        <td>{{ $item['tulov_summa'] }}</td>
                                        <td>{{ $item['chegirma'] }}</td>
                                        <td>{{ $item['admin_chegirma'] }}</td>
                                        <td>
                                            <a href="{{ route('tulovSettingDelete',$item['id'] ) }}" class="btn btn-danger py-0 px-1"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan=4>To'lov sozlamalari mavjud emas.</td>
                                    </tr>
                                    @endforelse
                                </tbodt>
                            </table>
                        </div>
                        <h5 class="card-title mb-0">Yangi to'lov</span></h5>
                        <form action="{{ route('tulovSettingCreate') }}" method="post" id="form4">
                            @csrf
                            <input type="hidden" name="filial_id" value="{{ $Filial->id }}">
                            <input type="hidden" name="status" value="true">
                            <input type="text" name="tulov_summa" id="summa1" class="form-control mt-2" placeholder="To'lov summasi" required>
                            <input type="text" name="chegirma" id="summa2" class="form-control mt-2" placeholder="Chegirma" required>
                            <input type="text" name="admin_chegirma" id="summa3" class="form-control mt-2" placeholder="Admin chegirma" required>
                            <button class="btn btn-primary w-100 mt-2">Saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body text-center" style="min-height:250px;">
                        <h5 class="card-title mb-0">SMS sozlamalari</span></h5>
                        <form action="{{ route('filialSettimgSMS') }}" method="post">@csrf
                            <input type="hidden" name="filial_id" value="{{ $Filial->id }}">
                            @if($SmsCentar->tashrif=='on')
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="tashrif" id="tashrif" checked>
                                <label class="form-check-label" for="tashrif">Yangi tashriflarga</label>
                            </div>
                            @else
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="tashrif" id="tashrif">
                                <label class="form-check-label" for="tashrif">Yangi tashriflarga</label>
                            </div>
                            @endif

                            @if($SmsCentar->tulov=='on')
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" name="tulov" type="checkbox" id="tulov" checked>
                                <label class="form-check-label" for="tulov">To'lovlarga</label>
                            </div>
                            @else
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" name="tulov" type="checkbox" id="tulov">
                                <label class="form-check-label" for="tulov">To'lovlarga</label>
                            </div>
                            @endif
                            @if($SmsCentar->tkun=='on')
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" name="tkun" id="tkun" checked>
                                <label class="form-check-label" for="tkun">Tug'ilgan kunlarga</label>
                            </div>
                            @else
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" name="tkun" type="checkbox" id="tkun">
                                <label class="form-check-label" for="tkun">Tug'ilgan kunlarga</label>
                            </div>
                            @endif
                            <button type="submit" class="btn btn-primary w-100 mt-3">O'zgarishlarni saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card" style="min-height:250px;">
                    <div class="card-body text-center">
                        <h5 class="card-title w-100 text-center">To'lov uchun maksimal chegirma kuni</h5>
                        <form action="{{ route('chegirmaDayUpadte') }}" method="post">
                            @csrf
                            <label for="">Chegirma Kuni</label>
                            <input type="hidden" name="filial_id" value="{{ $Filial->id }}">
                            <input type="number" value="{{ $ChegirmaDay }}" name="days" max=30 min=0 required  class="form-control">
                            <button type="submit" class="btn btn-primary w-100 mt-2">O'zgarishlarni Saqlash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center">
            <button class="btn btn-primary mt-3" style="width:48%;" data-bs-toggle="modal" data-bs-target="#FilialUpdate"><i class="bi bi-pencil"></i> Filialni taxrirlash</button>
            @if(Auth::User()->email=='elshodatc1116')
                <button class="btn btn-danger mt-3" style="width:48%;" data-bs-toggle="modal" data-bs-target="#FilialDelete"><i class="bi bi-trash"></i> Filialni o'chirish</button>
            @endif
        </div>
        
        <div class="modal fade" id="FilialUpdate" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center">Filialni taxrirlash</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('filialUpdate') }}" method="post">
                            <div class="row">
                                <div class="col-12">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $Filial['id'] }}">
                                    <label for="">Filial nomi</label>
                                    <input type="text" class="form-control" name="filial_name" required value="{{ $Filial['filial_name'] }}">
                                    <label for="">Filial manzili</label>
                                    <input type="text" class="form-control mb-3" name="filial_addres" required value="{{ $Filial['filial_addres'] }}">
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">Taxrirlash</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="FilialDelete" tabindex="-1">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100 text-center">Filialni o'chirish</h5>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger w-100 text-center">Filial o'chirilgach barcha malumotlar o'chitib yubotiladi. Qayta tiklash imkoni mavjud emas.</p>
                        <form action="{{ route('filialDelete') }}" method="post">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                                </div>
                                <div class="col-6">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $Filial['id'] }}">
                                    <button type="submit" class="btn btn-danger w-100" data-bs-dismiss="modal">O'chirish</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

  


     
</section>

</main>

@endsection