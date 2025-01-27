  @extends('SuperAdmin.layout.home')
  @section('title','Filiallar')
  @section('content')

  <main id="main" class="main">

  <div class="pagetitle">
      <h1>Filiallar</h1>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('SuperAdmin')}}">Bosh sahifa</a></li>
              <li class="breadcrumb-item active">Filiallar</li>
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
        <div class="row">
          <div class="col-6"><h5 class="card-title">Filiallar</span></h5></div>
          <div class="col-6"><button class="btn btn-success text-white w-100 mt-3" data-bs-toggle="modal" data-bs-target="#yangi_filial"> <i class="bi bi-patch-plus"></i> Yangi Filial</button></div>

          <div class="modal fade" id="yangi_filial" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title w-100 text-center">Yangi filial qo'shish</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filialcreate') }}" method="post">@csrf
                      <label for="filial_name" class="mt-lg-0 mt-2">Filial nomi</label>
                      <input type="text" name="filial_name" class="form-control" required>
                      <label for="filial_addres" class="mt-lg-0 mt-2">Filial manzili</label>
                      <input type="text" name="filial_addres" class="form-control" required>
                      <div class="row">
                        <div class="col-6">
                          <button type="button" class="btn btn-secondary w-100 mt-3" data-bs-dismiss="modal">Bekor Qilish</button>
                        </div>
                        <div class="col-6">
                          <button type="submit" class="btn btn-primary w-100 mt-3">Filialni saqlash</button>
                        </div>
                      </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered text-center table-striped table-hover" style="font-size:14px;">
            <thead>
              <tr>
                <th class="bg-primary text-white">#</th>
                <th class="bg-primary text-white">Filial</th>
                <th class="bg-primary text-white">Naqt</th>
                <th class="bg-primary text-white">Plastik</th>
                <th class="bg-primary text-white">Payme</th>
                <th class="bg-primary text-white">Ish haqi Naqt</th>
                <th class="bg-primary text-white">Ish haqi Plastik</th>
                <th class="bg-primary text-white">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($Filial as $item)
              <tr>
                <td>{{ $loop->index+1 }}</td>
                <td style="text-align:left;">
                  <b><a href="{{ route('filailCrm',$item['id']) }}"><i class="bi bi-door-open"></i> {{ $item['filial_name'] }}</a></b>
                </td>
                <td>{{ $item['naqt'] }}</td>
                <td>{{ $item['plastik'] }}</td>
                <td>{{ $item['payme'] }}</td>
                <td>{{ $item['IshHaqiNaqt'] }}</td>
                <td>{{ $item['IshHaqiPlastik'] }}</td>
                <td style="text-align:right">
                  <a href="{{ route('SuperAdminStatistika' , $item['id']) }}" title="Statistika" class="btn btn-danger py-0 my-1 my-lg-0"><i class="bi bi-bar-chart"></i></a>
                  <a href="{{ route('filial.show',$item['id'] ) }}" title="Filial sozlamalari" 
                  class="btn btn-primary py-0 my-1 my-lg-0"><i class="bi bi-gear"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan=8 class="text-center">Filiallar mavjud emas</td>
              </tr>
              @endforelse
              <tr>
                <th colspan=2>Jami:</th>
                <th>{{ $Naqt }}</th>
                <th>{{ $Plastik }}</th>
                <th>{{ $Payme }}</th>
                <th></th>
                <th colspan=3 style="text-align:right">Muumiy balans: {{ $Jami }}</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-4"><b class="w-100 text-center">Joriy oy jamgarma uchun(2.5%) hisoblandi: {{ $JamiSumma1 }} so'm</b></div>
          <div class="col-lg-4">
            <button class="btn btn-primary w-100 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#filial_qaytar"><i class="bi bi-coin"></i> Filialga ish haqini qaytarish</button></div>
          <div class="col-lg-4">
            <button class="btn btn-danger text-white w-100 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#umumitxarajat"><i class="bi bi-cart2"></i> Xarajatlar uchun chiqim</button></div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="filial_qaytar" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Filialga ish haqi uchun aytarish</h5>
          </div>
          <div class="modal-body">
            <form action="{{ route('SuperAdminMoliyaKassaga') }}" id="form1" method="post">@csrf
              <div class="row">
                <div class="col-12">
                  <label for="filial_id">Filial balansini tanlang</label>
                  <select name="filial_id" class="form-select my-1" required>
                    <option value="">Tanlang...</option>
                    @foreach($Filial as $item)
                    <option value="{{ $item['id'] }}">{{ $item['filial_name'] }} Mavjud:(Naqt: {{ $item['naqt'] }}) (Plastik: {{ $item['plastik'] }})(Payme: {{ $item['payme'] }})</option>
                    @endforeach
                  </select>
                  <label for="filial_id2">Qaytariladigan filialni tanlang</label>
                  <select name="filial_id2" class="form-select my-1 mb-2" required>
                    <option value="">Tanlang...</option>
                    @foreach($Filial as $item)
                    <option value="{{ $item['id'] }}">{{ $item['filial_name'] }}</option>
                    @endforeach
                  </select>
                  <label for="summa">Qaytariladigan summa</label>
                  <input type="text" name="summa" id="summa1" class="form-control my-1" required>
                  <label for="type">To'lov turi</label>
                  <select name="type" class="form-select my-1" required>
                    <option value="">Tanlang...</option>
                    <option value="Naqt">Naqt</option>
                    <option value="Plastik">Plastik</option>
                  </select>
                  <label for="about">Qaytarish haqida</label>
                  <textarea name="about" class="form-control my-1 mb-2" required></textarea>
                </div>
                <div class="col-6">
                  <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-primary w-100">Saqlash</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="umumitxarajat" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Umumiy xarajatlar uchun Chiqim qilish</h5>
          </div>
          <div class="modal-body">
          <form action="{{ route('SuperAdminMoliyaXarajay') }}" id="form2" method="post">@csrf
              <div class="row">
                <div class="col-12">
                  <label for="filial_id">Filialni tanlang</label>
                  <select name="filial_id" id="" class="form-select my-1" required>
                    <option value="">Tanlang...</option>
                    @foreach($Filial as $item)
                    <option value="{{ $item['id'] }}">{{ $item['filial_name'] }} Mavjud:(Naqt: {{ $item['naqt'] }}) (Plastik: {{ $item['plastik'] }})(Payme: {{ $item['payme'] }})</option>
                    @endforeach
                  </select>
                  <label for="summa">Xarajat summasi</label>
                  <input type="text" name="summa" id="summa1" class="form-control my-1" required>
                  <label for="type">To'lov turi</label>
                  <select name="type" id="" class="form-select my-1" required>
                    <option value="">Tanlang...</option>
                    <option value="Naqt">Naqt</option>
                    <option value="Plastik">Plastik</option>
                    <option value="Payme">Payme </option>
                  </select>
                  <label for="about">Xarajat haqida</label>
                  <textarea name="about" class="form-control my-1 mb-2" required></textarea>
                </div>
                <div class="col-6">
                  <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                </div>
                <div class="col-6">
                  <button type="submit" class="btn btn-primary w-100">Saqlash</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    

    <div class="card info-card sales-card">
      <div class="card-body text-center">
        <h5 class="card-title mb-0 pb-2"><i class="bi bi-cart2"></i> Umumiy balans tarixi (oxirgi 30 kunlik)</span></h5>
        <div class="table-responsive">
          <table class="table table-bordered" style="font-size:14px">
            <thead>
              <tr>
                <td class="bg-primary text-white">#</td>
                <td class="bg-primary text-white">Filial</td>
                <td class="bg-primary text-white">Status</td>
                <td class="bg-primary text-white">Kirim</td>
                <td class="bg-primary text-white">Chiqim</td>
                <td class="bg-primary text-white">Type</td>
                <td class="bg-primary text-white">Xarajat xaqida</td>
                <td class="bg-primary text-white">Xarajat vaqti</td>
              </tr>
            </thead>
            <tbody>
              @forelse($Xarajatlar as $item) 
                <tr>
                  <td>{{ $loop->index+1 }}</td>
                  <td style="text-align:left">{{ $item['filial_name'] }}</td>
                  <td style="text-align:left">
                    @if($item['xodisa']=='Chiqim')
                      Filial kassasidan kirim.
                    @elseif($item['xodisa']=='Qaytarildi')
                      Ish haqi uchun kassaga qaytarildi.
                    @elseif($item['xodisa']=='Xarajat')
                      Kassadan xarajat.
                    @elseif($item['xodisa']=='XarajatAdmin')
                      Xarajat uchun chiqim qilindi.
                    @endif
                  </td>
                  <td>
                    @if($item['typing']=='true')
                      <b class="text-success">{{ $item['summa'] }}</b>
                    @endif
                  </td>
                  <td>
                    @if($item['typing']=='false')
                      <b class="text-danger">{{ $item['summa'] }}</b>
                    @endif
                  </td>
                  <td>{{ $item['type'] }}</td>
                  <td>{{ $item['about'] }}</td>
                  <td style="text-align:right">{{ $item['created_at'] }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan=6 class="text-center">Xarajatlar mavjud emas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
      
  </section>

  </main>

  @endsection