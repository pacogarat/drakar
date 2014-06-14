$( document ).ready(function() {
    createAdvice = function(id) {
       $.ajax({
            url: 'http://'+getHostEnv()+"/advice/create",
            method: "PUT",
            dataType: "json",
            data: {
                item: id
            },
            success: function( response, data ) {
                $('[data-id='+id+']').html('recomendada');
                $('[data-id='+id+']').addClass("red");
            },
            error: function( response ) {
                alert(response.message);
            }
        }); 
    }
    getHostEnv = function() {
        if (window.location.toString().indexOf('app_dev.php') != -1)
                return window.location.host+'/app_dev.php';
        else return window.location.host;
    }
});

