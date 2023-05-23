$(document).ready(function() {
   $('.js-message').submit(function(event) {
      event.preventDefault();
      $.ajax({
         type: $(this).attr('method'),
         url: $(this).attr('action'),
         data: new FormData(this),
         dataType: 'json',
         contentType: false,
         cache: false,
         processData: false,
         success: function(result) {
            try{
               if (result.url !== undefined) {
                  window.location.href = '/' + result.url;
               } else {
                  alert(result.status + ' - ' + result.message);
               }
            }catch(error){
               console.log(result, error);
            }
         },
      });
   });
});