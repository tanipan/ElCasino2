/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function minus(id){
    
    $val = parseInt($('.quan_'+ id).text());
    $price = parseFloat($('#prijs').text());
    $unit = ($price / $val).toFixed(2);
    if($val > 1){
        $newVal = $val - 1;
        $('.quan_'+ id).text($newVal);
        var input = document.getElementById('quan_'+id);
        input.value = $newVal;
        $newPrice = ($unit * $newVal).toFixed(2);
        $('#prijs').text($newPrice);
        
    }
}

function toevoeg(id){
    
    $val = parseInt($('.quan_' + id).text());
    $price = parseFloat($('#prijs').text());
    $unit = ($price / $val).toFixed(2);
    $newValue = $val + 1;
    $('.quan_' + id).text($newValue);
    var input = document.getElementById('quan_'+id);
    input.value = $newValue;
    $newPrice = ($unit * $newValue).toFixed(2);
    $('#prijs').text($newPrice);
}

