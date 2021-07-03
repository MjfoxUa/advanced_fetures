requirejs(['jquery', 'jQueryMark', 'domReady!'],
    function($){
    $('.product-item-link').mark(document.getElementById('search').value);
});
