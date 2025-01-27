<?php
    use App\Models\Eslatma;
    echo count(Eslatma::where('filial_id',request()->cookie('filial_id'))->where('status','true')->get());
?>