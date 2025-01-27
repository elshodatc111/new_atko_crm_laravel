<?php
    use App\Models\Murojat;
    echo count(Murojat::where('filial_id',request()->cookie('filial_id'))
    ->where('admin_type','true')->where('status','user')->get());
?>