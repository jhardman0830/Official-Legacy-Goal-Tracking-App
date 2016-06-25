$( document ).ready(function() {
    $( document ).on( 'click', "input:checkbox", function(){
        $( this ).closest( '.checkbox-form' ).submit();
    });
});

