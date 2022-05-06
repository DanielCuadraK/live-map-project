<?php

/*Creates website standard header*/

function createHeader() {
    echo    '<span class="banner-desktop"><img id="banner-img" class="img-fluid page-banner" src="assets/img/banner-02.png"></span>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean nav-fill w-100" id="nav-main">
    <div class="container-fluid">
    <span class="banner-mobile"><img src="assets/img/banner-03.png" style="height: 50px;"></span>
    <span class="banner-mobile"><img src="assets/img/banner-04.png" style="height: 70px;"></span>
    <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
    <div
            class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto navbar-custom btn-group mx-auto">
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="index.php">HOME</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="vessel-tracking.php">VESSEL TRACKING & SCHEDULE</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link custom-nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    EQUIPMENT
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="equipment-dropdown">
                        <a class="nav-link custom-nav-link" href="equipment.php#40-dry" >40\' DRY HIGH CUBE CONTAINER</a>
                        <a class="nav-link custom-nav-link" href="equipment.php#53-dry" >53\' DRY HIGH CUBE CONTAINER</a>
                        <a class="nav-link custom-nav-link" href="equipment.php#40-reefer" >40\' REFRIGERATED HIGH CUBE CONTAINER</a>
                        <a class="nav-link custom-nav-link" href="equipment.php#40-flat" >40\' FLAT RACK</a>                       
                    </div>
                </li>          
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="container-tracking.php">CONTAINER TRACKING</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="rates.php">RATES</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="contacts.php">CONTACT</a></li>
            </ul>
        </div>
    </div>
</nav>
';
}

/*Creates al alternate header specifically for iphone users due to some scrolling behavior using anchor-links*/ 
function createHeaderAlt() {
    echo    '<nav class="navbar navbar-light navbar-expand-md navigation-clean nav-fill w-100" id="nav-main">
    <div class="container-fluid"><a class="navbar-brand" href="#" style="background-size: cover;background-repeat: no-repeat;height: auto;"><img src="assets/img/logo.png" style="height: 74px;"></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div
            class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto navbar-custom">
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="index.php">HOME</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link custom-nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    EQUIPMENT
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="equipment-dropdown">
                        <a id="40-dry-link" class="nav-link custom-nav-link" href="javascript:;">40\' DRY HIGH CUBE CONTAINER</a>
                        <a id="53-dry-link" class="nav-link custom-nav-link" href="javascript:;">53\' DRY HIGH CUBE CONTAINER</a>
                        <a id= "reefer-link" class="nav-link custom-nav-link" href="javascript:;">40\' REFRIGERATED HIGH CUBE CONTAINER</a>
                        <a id="flat-rack-link" class="nav-link custom-nav-link" href="javascript:;">40\' FLAT RACK</a>                       
                    </div>
                </li>          
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="tracking.php">VESSEL TRACKING & SCHEDULE</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="container-tracking.php">CONTAINER TRACKING</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="rates.php">RATES</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link custom-nav-link" href="contacts.php">CONTACT</a></li>
            </ul>
        </div>
    </div>
</nav>';
}

/*Creates back to top floating button*/

function createBackToTopBtn(){
    echo '
        <button onclick="topFunction()" id="myBtn" title="Go to top">To top</button>
        <script>

        mybutton = document.getElementById("myBtn");
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
          if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
          } else {
            mybutton.style.display = "none";
          }
        }


        function topFunction() {
          document.body.scrollTop = 0; // For Safari
          document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
        </script>
';
}

/* Creates footer */
function createFooter(){
    echo '    <div class="footer-basic">
    <div class="row text-center">
        <div class="col-xl-4"><img class="certificates" src="assets/img/gfs_primus_cert2.jpg"><img class="certificates" src="assets/img/1ct_pat_logo.jpg"></div>
        <div class="col-xl-4">
            <p><strong>World Direct Shipping, LLC, 1905 Intermodal Circle Suite 330 Palmetto, FL 34221</strong></p>
        </div>
        <div class="col-xl-4">
            <p><strong>Tel: 1-941-729-5828</strong><br><strong>Email: sales@worlddirectshipping.com</strong></p>
        </div>
    </div>
    <footer>
        <p class="copyright">World Direct Shipping © 2021</p>
    </footer>
</div>';

}
?>