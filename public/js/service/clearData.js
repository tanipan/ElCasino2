$(document).ready(function() {
  $("#login-modal").on("hidden.bs.modal", function() {
   
      $(".modal-body input").val("");
      $(".error").html("");
  });
    $("#forgetPasswordModal").on("hidden.bs.modal", function() {
   
      $(".modal-body input").val("");
      $(".modal-body .message").html("");
  });  
    
});