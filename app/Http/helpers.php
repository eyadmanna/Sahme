<?php


function getlookup($id){
    $lookup = \App\Models\Lookups::query()->find($id);

    return $lookup ;
}
function get_is_managed_lookupby_master_key($master_key){
    $lookup = \App\Models\Lookups::query()->where('master_key',$master_key)->where('parent_id','!=',0)->get();

    return $lookup ;
}
