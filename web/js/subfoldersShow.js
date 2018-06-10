$( document ).ready(function() {
    //hide subcatalogues on start
    var subcatalogues = document.getElementsByClassName('subcatalogue'), i;

    for (var i = 0; i < subcatalogues.length; i ++) {
        subcatalogues[i].style.display = 'none';
    }
    //hide closing images   
    var subcataloguesOpen = document.getElementsByClassName('subDataOpen'), i;

    for (var i = 0; i < subcataloguesOpen.length; i ++) {
        subcataloguesOpen[i].style.display = 'none';
    }
    //when subDataClosed clicked show subcatalogues for catalogue and hide subcatalogueClosed img
    $('.subDataClosed').on('click', function()
    {
        var subData = "sub" + this.value;

        $( "#"+subData ).show( "fast", function() {});
        $( "#subcatalogueOpen" + this.value ).show( "fast", function() {});
        $( "#subcatalogueClosed" + this.value ).hide( "fast", function() {});
    
    });

    //when subDataOpen clicked show subcatalogues for catalogue and hide subcatalogueOpen img
    $('.subDataOpen').on('click', function()
    {        
        var subData = "sub" + this.value;

        $( "#"+subData ).hide( "fast", function() {}); 
        $( "#subcatalogueOpen" + this.value ).hide( "fast", function() {});
        $( "#subcatalogueClosed" + this.value ).show( "fast", function() {});
    });

});
