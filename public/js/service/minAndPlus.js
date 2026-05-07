      function plusItem(id,extra,bid){
          
            $value = parseInt($('#totaal2').text());
            $newVal = $value +1;
            $("#totaal2").text($newVal);
            $("#totaal1").text($newVal);

            $.ajax({   
                    type: 'GET',
                    url: 'btnPlus.php',
                    data: {id: id, extra:extra,bid:bid},
                    success: function(data) 
                    {
                        $("#sidebar2 .sidebar-body").html(data); 
                    }
            });
          
          
          /**
            $.get('btnPlus.php', {id: id,extra: extra},function(data){
               $(".sidebar-body").html(data); 
            });
          **/
          
        }
        
        function minItem(id,extra,bid){
            
            $value = parseInt($('#totaal2').text());
            
            if($value >= 1){
               $newVal = $value - 1;
               $("#totaal2").text($newVal);
               $("#totaal1").text($newVal);
            }

            $.get('btnMin.php', {id: id,extra: extra,bid: bid}, function(data){
                $("#sidebar2 .sidebar-body").html(data);
            });
        }
      /**
        function removeItem(id,extra,qty){
            
             $value = parseInt($('#totaal2').text());
            
            if($value > qty){
               $newVal = $value - qty;
               $("#totaal2").text($newVal);
               $("#totaal1").text($newVal);
            }           
            
            $.get('remove.php', {id: id,extra: extra}, function(data){
                $("#sidebar2 .sidebar-body").html(data);
            });
        }
     **/


