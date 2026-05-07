/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function minQty(id){
    
    $val = parseInt($('.qty_'+ id).text());
    if($val > 1){
        $newVal = $val - 1;
        $('.qty_'+ id).text($newVal);
        var input = document.getElementById(id);
        input.value = $newVal;
    }
}

function addQty(id){
    
    $value = parseInt($('.qty_' + id).text());
    $newValue = $value + 1;
    $('.qty_' + id).text($newValue);
    var input = document.getElementById(id);
    input.value = $newValue;
}