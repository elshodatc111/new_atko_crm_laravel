@extends('Admin.layout.home')
@section('title','Talaba')
@section('content')

<main id="main" class="main">

<div class="pagetitle">
    <h1>Talaba</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Admin') }}">Bosh sahifa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('Student') }}">Talabalar</a></li>
            <li class="breadcrumb-item active">Talaba</li>
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
            <div class="card-body pt-3">
                <div class="tab-content pt-2" id="myTabjustifiedContent">
                    <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                        <h5 class="card-title w-100 text-center py-1" style="font-size:36px;">{{ $Users['name'] }}</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Telefon Raqam:</b>
                                        <h3 class="p-0 m-0">
                                            <span class="badge text-dark">{{ $Users['phone'] }}</span>
                                        </h3>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Tanish Telefon Raqam:</b>
                                        <span class="badge text-dark">{{ $Users['phone2'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Yashash Manzil:</b>
                                        <span class="badge text-dark">{{ $Users['addres'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Tug'ilgan Kuni:</b>
                                        <span class="badge text-dark">{{ $Users['tkun'] }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Talaba Balansi:</b>
                                        <h3 class="p-0 m-0">
                                            @if($Balans3>0)
                                            <span class="badge bg-success">{{ $Balans3 }}</span>
                                            @elseif($Balans3 < 0)
                                            <span class="badge bg-danger">{{ $Balans3 }}</span>
                                            @else
                                            <span class="badge bg-primary">0</span>
                                            @endif
                                        </h3>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Talaba Haqida:</b>
                                        <span class="badge text-dark">{{ $Users['about'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Biz Haqimizda:</b>
                                        <span class="badge text-dark">{{ $Users['smm'] }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <b>Login:</b>
                                        <span class="badge text-dark">{{ $Users['email'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                

    </section>
    <div class="card">
        <div class="card-body pt-3">
            <div class="tab-content pt-2" id="myTabjustifiedContent">
                <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#tulovPlus"><i class="bi bi-cash-coin"></i> To'lov qilish</button>
                        </div>
                        <!--
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#sendMessege"><i class="bi bi-messenger"></i> SMS yuborish</button>
                        </div>
                        -->
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#eslatmaQoldirish"><i class="bi bi-messenger"></i> Eslatma qoldirish</button>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#guruhPlusUser"><i class="bi bi-cash-coin"></i> Guruhga qo'shish</button>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#userEdit"><i class="bi bi-pencil-square"></i> Taxrirlash</button>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#resetPassword"><i class="bi bi-lock"></i> Parolni yangilash</button>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#parRepetUsr"><i class="bi bi-cash-stack"></i> To'lovni qaytarish</button>
                        </div>
                        @if(Auth::user()->type!='Operator')
                        <div class="col-lg-3">
                            <button class="btn my-1 btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#chegirmaPlus"><i class="bi bi-coin"></i> Chegirma kiritish</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>     
    <!-- To'lov qilish +++ -->
    <div class="modal fade" id="tulovPlus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">To'lov qilish</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserTulov') }}" method="post" id="form1">
                        @csrf 
                        <input type="hidden" name="user_id" value="{{ $Users['id'] }}">
                        <label for="naqt" class="mb-1">To'lov summasi (NAQT)</label>
                        <input type="text" name="naqt" value="0" id="summa1" class="form-control" required>
                        <label for="plastik" class="mb-1 mt-2">To'lov summasi (PLASTIK)</label>
                        <input type="text" name="plastik" value="0" id="summa2" class="form-control" required>
                        <label for="guruh_id" class="mb-1 mt-2">Chegirmali guruhni tanlang.</label>
                        <select name="guruh_id"  class="form-select">
                            <option value="NULL">Tanlang...</option>
                            @foreach($ChegirmaGuruh as $item)
                            <option value="{{ $item['guruh_id'] }}">{{ $item['guruh_name'] }} (Tulov:{{ $item['chegirmaTulov'] }})</option>
                            @endforeach
                        </select>
                        <label for="about" class="mb-1 mt-2">To'lov haqida</label>
                        <textarea type="text" onkeyup="Buttonsd()" name="about" class="form-control mb-3"></textarea>
                        <script>
                            function Buttonsd(){
                                document.getElementById("buttons").style.display = "block";
                            }
                            function Buttons(){
                                document.getElementById("buttons").style.display = "none";
                            }
                        </script>
                        <div class="row" >
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="buttons" class="btn btn-primary w-100" onclick="Buttons()">To'lov</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- SMS yuborish +++ -->
    <div class="modal fade" id="sendMessege" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">SMS yuborish</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserSendMessege') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $Users['id'] }}">
                        <label for="text">SMS matni</label>
                        <textarea name="text" onkeyup="Buttons22()" class="form-control mb-3" required></textarea>
                        <script>
                            function Buttons22(){
                                document.getElementById("buttons2").style.display = "block";
                            }
                            function Buttons2(){
                                document.getElementById("buttons2").style.display = "none";
                            }
                        </script>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="buttons2" onclick="Buttons2()" class="btn btn-primary w-100">SMS yuborish</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Eslatma qilish +++ -->
    <div class="modal fade" id="eslatmaQoldirish" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Eslatma qoldirish</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserComment') }}" method="post">
                        @csrf 
                        <input type="hidden" name="user_guruh_id" value="{{ $Users['id'] }}">
                        <input type="hidden" name="type" value="user">
                        <div class="row">
                            <div class="col-12">
                                <label for="text">Eslatma matni</label>
                                <textarea name="text" class="form-control mb-3" required></textarea>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100">Eslatmani saqlash</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Guruhga qo'shish +++ -->
    <div class="modal fade" id="guruhPlusUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Guruhga qo'shish</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserGuruhPlus') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $Users['id'] }}">
                        <label for="" class="mb-1">Guruhni tanlang</label>
                        <select name="guruh_id" class="form-select" required>
                            <option value="">Tanlang</option>
                            @foreach($Guruhs as $item)
                                <option value="{{ $item['guruh_id'] }}">
                                    {{ $item['guruh_name']." (Boshlanadi: ".$item['guruh_start']." )" }}
                                </option>
                            @endforeach
                        </select>
                        <label for="commit_start" class="mb-1 mt-3">Guruhga qo'shish uchun izoh</label>
                        <input type="text"  onkeyup="Buttons223()" name="commit_start" class="form-control mb-3" required>
                        <script>
                            function Buttons223(){
                                document.getElementById("buttons32").style.display = "block";
                            }
                            function Buttons23(){
                                document.getElementById("buttons32").style.display = "none";
                            }
                        </script>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" id="button223" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="buttons32" onclick="Buttons23()" class="btn btn-primary w-100">Saqlash</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- User Edet +++ -->
    <div class="modal fade" id="userEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Talabani taxrirlash</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserUpdate') }}" method="post">
                        @csrf 
                        <input type="hidden" name="user_id" value="{{ $Users['id'] }}">
                        <label for="name" class="mb-1">Talaba FIO</label>
                        <input type="text" name="name" class="form-control"  value="{{ $Users['name'] }}" required>
                        <label for="phone" class="mt-2 mb-1">Telefon raqam</label>
                        <input type="text" name="phone" class="form-control phone"  value="{{ $Users['phone'] }}" required>
                        <label for="phone2" class="mt-2 mb-1">Tanish telefon raqami</label>
                        <input type="text" name="phone2" class="form-control phone"  value="{{ $Users['phone2'] }}" required>
                        <label for="addres" class="mt-2 mb-1">Yashash manzili</label>
                        <select name="addres" class="form-select">
                            <option value="">Tanlang</option>
                            <option value="Qarshi shaxar">Qarshi shaxar</option>
                            <option value="Qarshi tuman">Qarshi tuman</option>
                            <option value="Shaxrisabz shaxar">Shaxrisabz shaxar</option>
                            <option value="Shaxrisabz tuman">Shaxrisabz tuman</option>
                            <option value="Guzor tuman">Guzor tuman</option>
                            <option value="Nishon tuman">Nishon tuman</option>
                            <option value="Koson tuman">Koson tuman</option>
                            <option value="Kasbi tuman">Kasbi tuman</option>
                            <option value="Muborak tuman">Muborak tuman</option>
                            <option value="Mirishkor tuman">Mirishkor tuman</option>
                            <option value="Yakkabog' tuman">Yakkabog' tuman</option>
                            <option value="Qamashi tuman">Qamashi tuman</option>
                            <option value="Chiroqchi tuman">Chiroqchi tuman</option>
                            <option value="Ko'kdala tuman">Ko'kdala tuman</option>
                            <option value="Kitob tuman">Kitob tuman</option>
                            <option value="Dexqonobod tuman">Dexqonobod tuman</option>
                            <option value="Boshqa tuman">Boshqa</option>
                        </select>
                        <label for="tkun" class="mt-2 mb-1">Tug'ilgan kuni</label>
                        <input type="date" name="tkun" class="form-control"  value="{{ $Users['tkun'] }}" required>
                        <label for="about" class="mt-2 mb-1">Talaba haqida</label>
                        <input type="text" name="about" class="form-control mb-3"  value="{{ $Users['about'] }}" required>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100">Yangilash</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Parolni yangilash +++ -->
    <div class="modal fade" id="resetPassword" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Paroni yangilash</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserPasswordUpdate') }}" method="post">
                        @csrf 
                        <input type="hidden" name="id" value="{{ $Users['id'] }}">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100">Yangilash</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- To'lovni qaytarish +++ -->
    <div class="modal fade" id="parRepetUsr" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">To'lovni qaytarish</h5>
                    <hr>
                </div>
                <div class="modal-body">
                    <table class="table w-100 text-center table-bordered">
                        <tr>
                            <th>Kassada mavjud naqt</th>
                            <th>Kassada mavjud plastik</th>
                        </tr>
                        <tr>
                            <td>{{ $FilialKassa['naqt'] }}</td>
                            <td>{{ $FilialKassa['plastik'] }}</td>
                        </tr>
                    </table>
                    <form action="{{ route('AdminUserTulovQaytar') }}" id="form2" method="post" >
                        @csrf 
                        <input type="hidden" name="id" value="{{ $Users['id'] }}">
                        <input type="hidden" name="naqt" value="{{ $FilialKassa['naqt'] }}">
                        <input type="hidden" name="plastik" value="{{ $FilialKassa['plastik'] }}">
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="summa">Qaytariladigan summa</label>
                                <input type="text" name="summa" id="summa2" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="type" class="mt-lg-0 mt-2">To'lov turi</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Tanlang</option>
                                    <option value="Naqt">Naqt</option>
                                    <option value="Plastik">Plastik</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="about" class="mt-3">Qaytarish haqida</label>
                                <textarea name="about" onkeyup="Buttons44()" class="form-control mb-3 mt-1" required></textarea>
                            </div>
                            <script>
                                function Buttons44(){
                                    document.getElementById("buttons44").style.display = "block";
                                }
                                function Buttons44d(){
                                    document.getElementById("buttons44").style.display = "none";
                                }
                            </script>
                            <div class="col-6">
                                <button type="button" id="button244" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6" id="buttons44">
                                <button type="submit" onclick="Buttons44d()" class="btn btn-primary w-100">Qaytarish</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Chegirma kiritish +++ -->
    <div class="modal fade" id="chegirmaPlus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center">Chegirma kiritish</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('AdminUserAdminChegirma') }}" id="form4" method="post">
                        @csrf 
                        <input type="hidden" name="user_id" value="{{ $Users['id'] }}">
                        <label for="chegirma">Chegirma summasi</label>
                        <input type="text" name="chegirma" id="summa1" class="form-control" required>
                        <label for="guruh_id" class="mt-2">Chegirma uchun guruhni tanlang</label>
                        <select name="guruh_id" class="form-select" required>
                            <option value="">Tanlang</option>
                            @foreach($adminChegirma as $item)
                            <option value="{{ $item['id'] }}">{{ $item['guruh_name'] }} (max:{{ $item['max_chegirma'] }})</option>
                            @endforeach
                        </select>
                        <label for="about" class="mt-2">Chegirma haqida</label>
                        <textarea name="about" onkeyup="Buttons44ss()" required class="form-control mb-3"></textarea>
                        <script>
                                function Buttons44ss(){
                                    document.getElementById("buttons44ddd").style.display = "block";
                                    document.getElementById("button244").style.display = "none";
                                }
                                function Buttons44dd(){
                                    document.getElementById("buttons44ddd").style.display = "none";
                                }
                            </script>
                        <div class="row" >
                            <div class="col-6">
                                <button type="button" id="button244" class="btn btn-secondary w-100" data-bs-dismiss="modal">Bekor qilish</button>
                            </div>
                            <div class="col-6" id="buttons44ddd">
                                <button type="submit" onclick="Buttons44dd()" class="btn btn-primary w-100">Saqlash</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body pt-3">
            <ul class="nav nav-tabs d-flex row" id="myTabjustified" role="tablist">
                <li class="nav-item flex-fill col-lg-3 col-6" role="presentation">
                    <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#Talaba_Tarixi" 
                    type="button" role="tab" aria-controls="history" aria-selected="true"><i class="bi bi-clock-history"></i> Talaba tarixi</button>
                </li>
                <li class="nav-item flex-fill col-lg-3 col-6" role="presentation">
                    <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#Talaba_guruhlari" 
                    type="button" role="tab" aria-controls="guruhlar" aria-selected="false"><i class="bi bi-people"></i> Talaba guruhlari</button>
                </li>
                <li class="nav-item flex-fill col-lg-3 col-6" role="presentation">
                    <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#Talaba_Tulovlari" 
                    type="button" role="tab" aria-controls="tulovlar" aria-selected="false"><i class="bi bi-cash-stack"></i> Talaba to'lovlari</button>
                </li>
            </ul>
            <div class="tab-content pt-2" id="myTabjustifiedContent">
                <hr class="p-0 m-0">
                <div class="tab-pane fade show active" style="min-height:200px;" id="Talaba_Tarixi" role="tabpanel" aria-labelledby="history-tab">
                    <div class="table-responsive" style="font-size:12px;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white text-center">#</th>
                                    <th class="bg-primary text-white text-center">Vaqti</th>
                                    <th class="bg-primary text-white text-center">Status</th>
                                    <th class="bg-primary text-white text-center">Guruh</th>
                                    <th class="bg-primary text-white text-center">Summa</th>
                                    <th class="bg-primary text-white text-center">To'lov turi</th>
                                    <th class="bg-primary text-white text-center">Hisoblash</th>
                                    <th class="bg-primary text-white text-center">Balans</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userHistory as $item)
                                    @if($item->status=='Markazga tashrif')
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>_</td>
                                        <td>_</td>
                                        <td>O'quv markazga birinchi tashrif</td>
                                        <td>_</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="Guruhdan o'chirildi")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Guruh uchun to'lov balansiga qaytarildi.</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="Jarima")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Guruhdagi darslari uchun jarima.</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="Chegirma")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>To'liq to'lov uchun chegirma.</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="Tulov Naqt")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Naqt To'lov.</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="Tulov Plastik")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Plastik To'lov.</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="Guruhga qo'shildi")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Yangi guruhga qo'shildi</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="To'lov o'chirildi(Naqt)")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Talaba naqt to'lovi o'chirildi</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @elseif($item->status=="To'lov o'chirildi(Chegirma)")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Talab chegirmasi o'chirildi</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr>  
                                    @elseif($item->status=="To'lov o'chirildi(Plastik)")
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Talab plastik to'lovi o'chirildi</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @else
                                    <tr>
                                        <td class="text-center">{{ $loop->index+1 }}</td>
                                        <td>{{ $item['created_at'] }}</td>
                                        <td>{{ $item['status'] }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['summa'] }}</td>
                                        <td>Balansidan yichildi</td>
                                        <td>{{ $item['xisoblash'] }}</td>
                                        <td>{{ $item['balans'] }}</td>
                                    </tr> 
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan=8 class="text-center">Talaba tarixi mavjud emas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade show" style="min-height:200px;" id="Talaba_guruhlari" role="tabpanel" aria-labelledby="guruhlar-tab">
                    <div class="table-responsive" style="font-size:12px;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="bg-primary text-white text-center">#</th>
                                    <th class="bg-primary text-white text-center">Guruh</th>
                                    <th class="bg-primary text-white text-center">Guruhga qo'shildi</th>
                                    <th class="bg-primary text-white text-center">Meneger</th>
                                    <th class="bg-primary text-white text-center">Qoshish haqida</th>
                                    <th class="bg-primary text-white text-center">Guruhdan o'chirildi</th>
                                    <th class="bg-primary text-white text-center">Meneger</th>
                                    <th class="bg-primary text-white text-center">O'chirish haqida</th>
                                    <th class="bg-primary text-white text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userArxivGuruh as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index+1 }}</td>
                                    <td><a href="{{ route('AdminGuruhShow',$item['guruh_id'] ) }}">{{ $item['guruh_name'] }} ({{ $item['guruh_starts'] }})</a></td>
                                    <td>{{ $item['guruh_start'] }}</td>
                                    <td>{{ $item['admin_id_start'] }}</td>
                                    <td>{{ $item['commit_start'] }}</td>
                                    <td>{{ $item['updated_at'] }}</td>
                                    <td>{{ $item['admin_id_end'] }}</td>
                                    <td>{{ $item['commit_end'] }}</td>
                                    <td class="text-center">
                                        @if($item['status']=='false')
                                            <p class="bg-danger p-1 m-0 text-white">O'chirildi</p>
                                        @else
                                            <p class="bg-success p-1 m-0 text-white">Faol</p>
                                        @endif
                                    </td>
                                </tr> 
                                @empty
                                    <tr>
                                        <td colspan=9 class="text-center">Talaba guruhlari mavjud emas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade show" id="Talaba_Tulovlari" style="min-height:200px;" role="tabpanel" aria-labelledby="tulovlar-tab">
                    <div class="table-responsive" style="font-size:12px;">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center bg-primary text-white">#</th>
                                    <th class="text-center bg-primary text-white">To'lov summasi</th>
                                    <th class="text-center bg-primary text-white">To'lov turi</th>
                                    <th class="text-center bg-primary text-white">To'lov haqida</th>
                                    <th class="text-center bg-primary text-white">To'lov vaqti</th>
                                    <th class="text-center bg-primary text-white">Meneger</th>
                                    @if(Auth::user()->type=='SuperAdmin')
                                    <th class="text-center bg-primary text-white">Status</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Tulovlar as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->index+1 }}</td>
                                    <td>{{ $item['summa'] }}</td>
                                    <td>{{ $item['type'] }}</td>
                                    <td>{{ $item['about'] }}</td>
                                    <td>{{ $item['created_at'] }}</td>
                                    <td>{{ $item['admin'] }}</td>
                                    @if(Auth::user()->type=='SuperAdmin')
                                    <td class="text-center">
                                        @if($item['type']=='Qaytarildi (Naqt)')
                                        @elseif($item['type']=='Qaytarildi (Plastik)')
                                        @else
                                        <a href="{{ route('AdminUserTulovDelete',$item['id']) }}" class="btn btn-danger py-0 px-1">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                    @endif
                                </tr> 
                                @empty
                                    @if(Auth::user()->type=='SuperAdmin')
                                    <tr>
                                        <td colspan=7 class="text-center">To'lovlar mavjud emas.</td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan=6 class="text-center">To'lovlar mavjud emas.</td>
                                    </tr>
                                    @endif
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title w-100 text-center">Talaba Eslatmalari</h5>
            <div class="table-responsive" style="font-size:12px;">
                <table class="table table-bordered text-center table-hover">
                    <thead>
                        <tr>
                            <th class="bg-primary text-white text-center">#</th>
                            <th class="bg-primary text-white text-center">Eslatma</th>
                            <th class="bg-primary text-white text-center">Eslatma vaqti</th>
                            <th class="bg-primary text-white text-center">Meneger</th>
                            <th class="bg-primary text-white text-center">Eslatma xolati</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eslat as $item)
                        <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{ $item['text'] }}</td>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['admin_id'] }}</td>
                            <td>{{ $item['status'] }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan=5 class="text-center">Eslatmalar mavjud emas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</main>

@endsection