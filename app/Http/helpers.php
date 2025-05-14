<?php


function getlookup($id){
    $lookup = \App\Models\Lookups::query()->find($id);

    return $lookup ;
}
