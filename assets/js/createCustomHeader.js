if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {
    var customHeader=       '<a id="40-dry-link" class="dropdown-item" href="javascript:;">40\' DRY HIGH CUBE CONTAINER</a>'
                            +'<a id="53-dry-link" class="dropdown-item" href="javascript:;">53\' DRY HIGH CUBE CONTAINER</a>'
                            +'<a id="reefer-link" class="dropdown-item" href="javascript:;">40\' REFRIGERATED HIGH CUBE CONTAINER</a>'
                            +'<a id="flat-rack-link" class="dropdown-item" href="javascript:;">40\' FLAT RACK</a>';
    $('#equipment-dropdown').html(customHeader);
        $("#reefer-link").click(function(){
                    //document.getElementById("40-reefer").scrollIntoView(true);
                    window.scroll(0,document.getElementById("40-reefer").offsetTop);
                    
        });
        $("#40-dry-link").click(function(){
                        //document.getElementById("40-dry").scrollIntoView(true);
                        window.scroll(0,document.getElementById("40-dry").offsetTop);
                        
        });
        $("#53-dry-link").click(function(){
                        //document.getElementById("53-dry").scrollIntoView(true);
    
                    window.scroll(0,document.getElementById("53-dry").offsetTop);
        });
        $("#flat-rack-link").click(function(){
                        //document.getElementById("40-flat").scrollIntoView(true);
                        window.scroll(0,document.getElementById("40-flat").offsetTop);
                        
        });
    }