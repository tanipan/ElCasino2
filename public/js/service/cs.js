        function addProduct(pid, applied){
            
            var input = document.getElementById(pid);
            $qty = input.value;
            $extra = -1;
            if(applied>0){
                
                
                  $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'choose.php',
                    data: {pid: pid, qty:$qty, type:applied},
                    success: function(data) 
                    {
                        
                        $('#choose_modal').html(data);
                        $('#choose_modal').modal('show');
                    }
                });
                
            }else{
              
            $.ajax({
                catch: false,
                type: 'POST',
                url:'addToCart.php',
                data: {pid: pid, qty:$qty,extra:$extra},
                success: function(data){
                    
                      $("#totaal1").html(data);
                      $("#totaal2").html(data);
                     
                }
              
            });
             //event.preventDefault();    
         }
    }
  
     function addExtra(pid,number,bid){
        
         var obj = "quan_"+pid;    
         var qty = parseInt(document.getElementById(obj).value);    
                  
         var extraArr = new Array(); 
         var extra = "";
         var isOk = true;
         for (i = 0; i < number; i++) {
             
             var elementName = "keuze_"+i;
             var elementClass = ".keuze_"+i;
             var elementValue = parseInt($(elementClass).attr("data-type"));
             var minValue = parseInt($(elementClass).attr("data-min"));
             
             if(elementValue == 1){
                 
                 extraArr.push(document.getElementById(elementName).value);
                     
             }else if(elementValue==2){
                 
                 var str = document.getElementsByName(elementName);
                 var arr = str.length;
                 var amount = 0;
                 for(j=0; j < arr; j++){
                     
                     if(str[j].checked == true){
                         amount = amount+1;
                         
                         extraArr.push(str[j].value);
                     }
                     
                 }
                 //validate whether choosed items are enough
                 if(amount < minValue){
                     
                     isOk = false;
                     var elementId = "#keuze_"+i+" h6 a";
                     $(elementId).css("color","#c11b24");
                     
                     
                 }
              // special check (pizzabakker)   
             }else if(elementValue==3){
                 
                 var inputCheck = '[name="'+elementName+'"]:checked';
                 extraArr.push($(inputCheck).val());
             }

         }
         
        if(extraArr.length >0){
            
         for(t = 0; t< extraArr.length;t++){
            
            if(t!=extraArr.length-1){
                
                extra+= extraArr[t]+"|";
            }else{
                
                extra+= extraArr[t];
            }
             
             
         }
        }else{
            
            extra = -1;
        }
            
            
        if(isOk){
            $.ajax({
                        catch: false,
                        type: 'POST',
                        url:'addToCart.php',
                        data: {pid: pid,qty:qty,extra:extra,bid:bid},
                        success: function(data){

                              $(".shopCart .content #totaal1").html(data);
                              $("#totaal1").html(data);
                              $("#totaal2").html(data);

                        }

                    });
                    $("#choose_modal").modal('hide');

                
            }else{
                
                $('#bijgerecht').prop('disabled', true);
                $('#bijgerecht').css("backgound", "#cc4545");
                $(".modal-body").animate({scrollTop: 0}, 'slow');
            } 
 }            
/**
   //old
        function addExtra(pid,qty,number){
            
            
         $extra = "";    
         for (i = 0; i < number; i++) {
             var element = "#keuze_"+i;
             $extra += $(element).val();
             if(i !=number -1){
                 
                 $extra += "|";
             }
         }
            //$extra = $( "#keuze" ).val();
             $.ajax({
                catch: false,
                type: 'POST',
                url:'addToCart.php',
                data: {pid: pid,qty:$qty,extra:$extra},
                success: function(data){
                    
                      $("#totaal1").html(data);
                      $("#totaal2").html(data);
                     
                }
              
            });
            $("#choose_modal").modal('hide');
            
        }  
    **/    
    /**
        function showAlert(){
            alert("Het restaurant is gesloten op dit moment.");
        }
     **/

    function addOneProduct(pid, applied){
            
        
            $qty = 1;
            $extra = -1;
            if(applied > 0){
                
                
                  $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'choose.php',
                    data: {pid: pid, qty:$qty, type: applied},
                    success: function(data) 
                    {
                        $('#choose_modal').html(data);
                        $('#choose_modal').modal('show');
                    }
                });
                
            }else{
              
            $.ajax({
                catch: false,
                type: 'POST',
                url:'addToCart.php',
                data: {pid: pid, qty:$qty,extra:$extra},
                success: function(data){
                    
                      $("#totaal1").html(data);
                      $("#totaal2").html(data);
                     
                }
              
            });
             //event.preventDefault();    
         }
    }
     function showAlert(message){
         
                $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'alert.php',
                    data: {message: message},
                    success: function(data) 
                    {
                        $('#alert_modal').html(data);
                        $('#alert_modal').modal('show');
                        
                         setTimeout(function(){$('#alert_modal').modal('hide')},3000);
                    }
                });
         
     }
     
     // multiple, no required, item;
     function modifier(obj){
           
         var pid = $(obj).val();
         var number = parseInt($(obj).attr("data-max"));
         var minValue = parseInt($(obj).attr("data-min"));
         var name = $(obj).attr("name");
         var elementId = "#"+name+" h6";
         var checkboxes = $(":checkbox[name="+name+"]:checked");
         var current = checkboxes.length;
         var unit = parseFloat($(obj).attr('unit')).toFixed(2);
         var subTotal = parseFloat($("#prijs").text());
         var qty_parameter = $(obj).attr("data-dish");
         var qty = parseInt(document.getElementById(qty_parameter).value);
         
         if(number !== -1){
         ///console.log(qty);
         if(current > number){
  
              $(obj).attr('checked', false);
         }else{
            // for minValue > 0   
            if(minValue !=0){ 
             
                $(elementId).css("color","#000");
                $('#bijgerecht').prop('disabled', false);
                $('#bijgerecht').css("backgound", "#ff5555"); 
                
             }
            if(unit !== 0){ 
               if($(obj).is(':checked')){
                   
                   $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'addChoose.php',
                    data: {price: unit,qty: qty,subTotal: subTotal},
                    success: function(data) 
                    {
                        $('#prijs').html(data);
                       
                    }
                });
         
                   
               }else{
                   
                  $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'minChoose.php',
                    data: {price: unit,qty: qty,subTotal: subTotal},
                    success: function(data) 
                    {
                        $('#prijs').html(data);
                       
                    }
                });
                
               }
             
            }
            
         }
         
       }else{
           
               if(unit !== 0){ 
               if($(obj).is(':checked')){
                   
                   $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'addChoose.php',
                    data: {price: unit,qty: qty,subTotal: subTotal},
                    success: function(data) 
                    {
                        $('#prijs').html(data);
                       
                    }
                });
         
                   
               }else{
                   
                  $.ajax({   
                    cache: false,
                    type: 'POST',
                    url: 'minChoose.php',
                    data: {price: unit,qty: qty,subTotal: subTotal},
                    success: function(data) 
                    {
                        $('#prijs').html(data);
                       
                    }
                });
                
               }
             
            }
           
       }
     }
     // single, no required, item;
     function similarSingleButon(obj){
        

         var $btn = $(obj);
         var name= $btn.attr("name");
         var pos = "."+name;
         //var pid = $btn.val();
         var unit = parseFloat($btn.attr('unit')).toFixed(2);
         var subTotal = parseFloat($("#prijs").text());
         var qty_parameter = $btn.attr("data-dish");
         var qty = parseInt(document.getElementById(qty_parameter).value);
         var preValue = parseFloat($(pos).attr("data-value")).toFixed(2);

         
         if($btn.is(":checked")){
             
             var group = "input:checkbox[name='" + $btn.attr("name") + "']";
             $(group).prop("checked", false);
             $btn.prop("checked", true);
             $(pos).attr("data-value", unit);
             //if(unit !=0){ 
                document.getElementById("prijs").innerHTML = (subTotal-preValue*qty+qty*unit).toFixed(2);
                 
             //}
         
         }else{
             
             $btn.prop("checked", false);
             $(pos).attr("data-value", "0.00");
            //if(unit !=0){ 
                document.getElementById("prijs").innerHTML = (subTotal-preValue*qty).toFixed(2);
             //}
         }
         
         
     }
        // single, required, item, special
        function SingleRadioButon(obj){
        

         var $btn = $(obj);
         //var name= $btn.attr("id");
         var name= $btn.attr('name');
         var pos = "."+name;
         console.log(pos);
         var inputCheck = '[name="'+name+'"]:checked';
         //console.log(inputCheck);
         var inputValue = parseFloat($(inputCheck).attr("unit")).toFixed(2);
         console.log(inputValue);
         var subTotal = parseFloat($("#prijs").text());
         var qty_parameter = $btn.attr("data-dish");
         var qty = parseInt(document.getElementById(qty_parameter).value);
         var preValue = parseFloat($(pos).attr("data-value")).toFixed(2);
        
         if($btn.is(":checked")){
            
             $btn.prop("checked", true);
             $(pos).attr("data-value", inputValue);
             //if(unit !=0){ 
             document.getElementById("prijs").innerHTML = (subTotal-preValue*qty+qty*inputValue).toFixed(2);
            
         
         }/**else{
             
             
             $(pos).attr("data-value", inputValue);
             document.getElementById("prijs").innerHTML = (subTotal-preValue*qty+inputValue*qty).toFixed(2);
             
         }**/
         
         
     }  
     // single, required, item
     function selectItem(obj){
           
         var name= $(obj).attr("name");
         var pos = "."+name;
         var preValue = parseFloat($(pos).attr("data-value")).toFixed(2);
         var value = parseFloat($('option:selected',obj).attr("data-price")).toFixed(2);
         $(pos).attr("data-value", value);
         var qty_parameter = $(obj).attr("data-dish");
         var qty = parseInt(document.getElementById(qty_parameter).value);
         var subTotal = parseFloat($("#prijs").text());
         if(preValue!=value){
         
             document.getElementById("prijs").innerHTML = (subTotal-qty*preValue+qty*value).toFixed(2);
         }

     }
    /**
     function changeLang(obj){
         
                var selectData = $(obj).attr("data-lang");
              
                        $.post("verandertaal.php",{selectData: selectData},function(data){
                            
                          if(data == "fr"){
                               
                               location.href="../../fr/order/";
                           }else if(data == "nl"){
                               
                               location.href="../../nl/order/";
                           }else if(data == "en"){
                               
                               location.href="../../en/order/";
                           }
                        }); 
     }
     **/