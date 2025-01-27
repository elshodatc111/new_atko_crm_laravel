<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    <title>ATKO o'quv markazi</title>
    <link href="https://atko.tech/NiceAdmin/assets/img/logo.png" rel="icon">
    <link href="https://atko.tech/NiceAdmin/assets/img/logo.png" rel="apple-touch-icon">
    <link href="./../../../vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="./../../../vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <link href="./../../../vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="./../../../vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <link href="./../../../css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper p-t-100 p-b-100 font-robo" style="background-color: #fff;">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Ro'yxatdan o'tish</h2>
                    @if (Session::has('success'))
                        <h4 style="color:green">{{Session::get('success') }}</h4>
                        <br>
                    @endif
                    <form method="POST" action="{{ route('create_blog_story') }}" method="POST">
                        @csrf
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" placeholder="Familyangiz" name="name1" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" placeholder="Ismingiz" name="name2" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1 phone"  type="text" placeholder="Telefon raqam" name="phone1" required>
                                    <i class="zmdi zmdi-phone input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1 phone" type="text" placeholder="Qo'shimcha telefon raqam" name="phone2" required>
                                    <i class="zmdi zmdi-phone input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <div class="rs-select2 js-select-simple select--no-search">
                                        <select name="addres"  required>
                                            <option value="">Yashash maznilingiz</option>
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
                                        <div class="select-dropdown"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1 js-datepicker" type="text" placeholder="Tug'ilgan kuningiz" name="tkun"  required>
                                    <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="smm" value="{{ $smm }}">
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit">Ro'yxatdan o'tish</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="./../../../vendor/jquery/jquery.min.js"></script>
    <script src="./../../../vendor/select2/select2.min.js"></script>
    <script src="./../../../vendor/datepicker/moment.min.js"></script>
    <script src="./../../../vendor/datepicker/daterangepicker.js"></script>
    <script src="./../../../js/global.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script>
        $(".phone").inputmask("99 999 9999");
    </script>
</body>
</html>
