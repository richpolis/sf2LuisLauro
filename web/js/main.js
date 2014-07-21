jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

function activarBotonesLenguajes(){
    $(".buttons-languages a.ingles").on('click',function(e){
        e.preventDefault();
        var url = $(this).data('url');
        $("#dialog-modal").load(url);
    });
    $(".buttons-languages a.espanol").on('click',function(e){
        e.preventDefault();
        var url = $(this).data('url');
        $("#dialog-modal").load(url);
    });
}