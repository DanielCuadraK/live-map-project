        if($(window).width() < 971) {
            modelMinWidth = $(window).width()*.9;//$(window).width();
        }
        else {
            modelMinWidth = 960;//$(window).width()*.75;
        }
         modelMinHeight = modelMinWidth / 2;
         modelMaxWidth = $(window).width(); //$(window).width(); 
         modelMaxHeight = modelMaxWidth  / 2;
        $( document ).ready(function() {
            $('.reefer-container').TreeSixtyImageRotate({
                totalFrames: 36,
                endFrame: 36,
                currentFrame: 0,
                progress:".spinner",
                extension: ".jpg",
                imagesFolder: "assets/img/reefer/",
                smallWidth: modelMinWidth,
                smallHeight: modelMinHeight,
                largeWidth: modelMaxWidth,
                largeHeight: modelMaxHeight,
                speed: 100,
                imagePlaceholderClass: "images-placeholder",
                navigation: false,
                imgPrefix: "0_0"
            }).initTreeSixty()
        });
        $( document ).ready(function() {
            $('.dry-container').TreeSixtyImageRotate({
                totalFrames: 36,
                endFrame: 36,
                currentFrame: 0,
                progress:".spinner",
                extension: ".jpg",
                imagesFolder: "assets/img/dry-container/",
                smallWidth: modelMinWidth,
                smallHeight: modelMinHeight,
                largeWidth: modelMaxWidth,
                largeHeight: modelMaxHeight,
                speed: 100,
                imagePlaceholderClass: "images-placeholder",
                navigation: false,
                imgPrefix: "0_0"
            }).initTreeSixty()
        });
        $( document ).ready(function() {
            $('.dry-container-53').TreeSixtyImageRotate({
                totalFrames: 36,
                endFrame: 36,
                currentFrame: 0,
                progress:".spinner",
                extension: ".jpg",
                imagesFolder: "assets/img/dry-container-53/",
                smallWidth: modelMinWidth,
                smallHeight: modelMinHeight,
                largeWidth: modelMaxWidth,
                largeHeight: modelMaxHeight,
                speed: 100,
                imagePlaceholderClass: "images-placeholder",
                navigation: false,
                imgPrefix: "0_0"
            }).initTreeSixty()
        });
        $( document ).ready(function() {
            $('.flat').TreeSixtyImageRotate({
                totalFrames: 36,
                endFrame: 36,
                currentFrame: 0,
                progress:".spinner",
                extension: ".jpg",
                imagesFolder: "assets/img/flat/",
                smallWidth: modelMinWidth,
                smallHeight: modelMinHeight,
                largeWidth: modelMaxWidth,
                largeHeight: modelMaxHeight,
                speed: 100,
                imagePlaceholderClass: "images-placeholder",
                navigation: false,
                imgPrefix: "0_0"
            }).initTreeSixty()
        });

        if (navigator.userAgent.match(/(iPod|iPhone|iPad)/)) {

            $("body").hide();
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
              var load = setTimeout(function() {
                  $('body').show();
              //document.getElementById("redirect").src="js/load.js";
              //alert(window.location.hash);
                  var hash = window.location.hash;
                  switch (hash) {
                  case '#40-dry':
                      //$("#40-dry-link").click();
                      window.scroll(0,document.getElementById("40-dry").offsetTop);
                      //document.getElementById("40-dry").scrollIntoView(true);
                  break;
                  case '#40-reefer':
                      //$("#reefer-link").click();
                      window.scroll(0,document.getElementById("40-reefer").offsetTop);
                      //document.getElementById("40-reefer").scrollIntoView(true);
                  break;
                  case '#53-dry':
                      //$("#53-dry-link").click();
                      window.scroll(0,document.getElementById("53-dry").offsetTop);
                      //document.getElementById("53-dry").scrollIntoView(true);
                  break;
                  case '#40-flat':
                      //$("#flat-rack-link").click();
                      window.scroll(0,document.getElementById("40-flat").offsetTop);
                      //document.getElementById("40-flat").scrollIntoView(true);
                  break
                  default:
                  break;
                  }
          }, 500);
          }