<?php
use App\Models\User;
use App\Events\TugilganKun;
use Carbon\Carbon;
$today = Carbon::today();
echo count(User::where('filial_id',request()->cookie('filial_id'))->where('type','User')->whereRaw("DATE_FORMAT(tkun, '%m-%d') = ?", [$today->format('m-d')])->get());