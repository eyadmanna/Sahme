<?php


function getlookup($id){
    $lookup = \App\Models\Lookups::query()->find($id);

    return $lookup ;
}
function getlookupby_master_key($master_key){
    $lookup = \App\Models\Lookups::query()->where('master_key',$master_key)->get();

    return $lookup ;
}
