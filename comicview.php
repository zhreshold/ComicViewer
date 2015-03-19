<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/16/2015
 * Time: 4:34 PM
 */

include "utils.php";
ini_set('default_charset', 'utf-8'); 

$toc = array();
if (!$_GET['filename'])
{
    echo "No filename received!";
    return;
}
else {
    $filename = $_GET['filename'];
    $toc = getFilteredToc($filename);
    if (count($toc) < 1) {
        echo "No contents!";
        return;
    }
}
$coverFull = 'imgprocess.php?comic='.rawurlencode($filename).'&page='.rawurlencode($toc[0]);
$deleteLink = 'delete.php?file='.rawurlencode($filename);
$deleteCoverLink = 'deletepage.php?file='.rawurlencode($filename).'&page='.rawurlencode($toc[0]);
?>

<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie ie9" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

    <!--- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Puremedia</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/media-queries.css">

    <!-- Script
    =================================================== -->
    <script src="js/modernizr.js"></script>

    <!-- Favicons
     =================================================== -->
    <link rel="shortcut icon" href="favicon.png" >

</head>

<body class="homepage">

<div id="preloader">
    <div id="status">
        <img src="img/loader.gif" height="60" width="60" alt="">
        <div class="loader">Loading...</div>
    </div>
</div>

<!-- Header
=================================================== -->



<!-- Hero
=================================================== -->

<section id="hero" style="background: #12151b url(<?php echo $coverFull;?>) no-repeat center center fixed">

    <div class="row hero-content">

        <div class="twelve columns flex-container">

            <div id="hero-slider" class="flexslider">

                <ul class="slides">

                    <!-- Slide -->
                    <li>
                        <div class="flex-caption">
                            <h1>
                                Hello, enjoy the contents by click the start button!
                                <br/>
                                <br/>
                                <?php
                                    echo basename($filename).'<br/><br/>';
                                    echo 'pages: '.count($toc).'<br/>';
                                ?>
                                <br/>
                                <br/>
                                <br/>
                            </h1>

                            <p><a id ="btn" class="button stroke smoothscroll" href="#about">Start Reading</a></p>
                        </div>
                    </li>

                </ul>

            </div> <!-- .flexslider -->

        </div> <!-- .flex-container -->

    </div> <!-- .hero-content -->

</section> <!-- #hero -->

<!-- Footer
================================================== -->
<footer>

    <div class="row">

        <div class="six columns tab-whole footer-about">

            <h3>About</h3>

            <p>
                <?php
                    echo basename(rawurldecode($filename));
                ?>
            </p>

            <p>
                <?php
                    echo "pages: ".count($toc);
                ?>
            </p>

        </div> <!-- /footer-about -->

        <div class="six columns tab-whole right-cols">

            <div class="row">

                <div class="columns">

                </div> <!-- /columns -->

                <div class="columns last">
                    <h3 class="address">Modify</h3>
                    <p>
                        Remove the entire zip file into recycle bin.
                    </p>
					<p>
						Remove the current cover image(Not recoverable!).
					</p>

                    <ul>
                        <li><a style ="color:orange"href=<?php echo $deleteLink; ?>>Delete</a></li>
						<li><a style ="color:red"href=<?php echo $deleteCoverLink; ?>>Remove cover</a></li>
                    </ul>
                </div> <!-- /columns -->

            </div> <!-- /Row(nested) -->

        </div>

        <p class="copyright">&copy; Copyright 2014 Puremedia. Design by <a href="http://www.styleshout.com/">Styleshout.</a></p>

        <div id="go-top">
            <a class="smoothscroll" title="Back to Top" href="#hero"><span>Top</span><i class="fa fa-long-arrow-up"></i></a>
        </div>

    </div> <!-- /row -->

</footer> <!-- /footer -->

<!-- Java Script
================================================== -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.fittext.js"></script>
<script src="js/backstretch.js"></script>
<script src="js/waypoints.js"></script>
<script src="js/main.js"></script>



<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <div class="pswp__container">
            <!-- don't modify these 3 pswp__item elements, data is added later on -->
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="Share"></button>

                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>


<!-- Core CSS file -->
<link rel="stylesheet" href="PhotoSwipe/dist/photoswipe.css">

<!-- Skin CSS file (styling of UI - buttons, caption, etc.)
     In the folder of skin CSS file there are also:
     - .png and .svg icons sprite,
     - preloader.gif (for browsers that do not support CSS animations) -->
<link rel="stylesheet" href="PhotoSwipe/dist/default-skin/default-skin.css">

<!-- Core JS file -->
<script src="PhotoSwipe/dist/photoswipe.min.js"></script>

<!-- UI JS file -->
<script src="PhotoSwipe/dist/photoswipe-ui-default.min.js"></script>


<script type="text/javascript">
    var openPhotoSwipe = function() {

        var pswpElement = document.querySelectorAll('.pswp')[0];

    //build items array
        var items =
            <?php
                echo '[';
                foreach ($toc as $page)
                {
                    $url = '"'.'imgprocess.php?comic='.rawurlencode($filename).'&page='.rawurlencode($page).'"';
                    $size = getImageDim($filename, $page);
                    echo '
                        {
                            src: '.$url.',
                            w: '.$size[0].',
                            h: '.$size[1].'
                        },
                    ';
                }
                echo ']';
        ?>;

// define options (if needed)
        var options = {
// history & focus options are disabled on CodePen
            history: false,
            focus: true,

            showAnimationDuration: 0,
            hideAnimationDuration: 0

        };

        var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };

    //openPhotoSwipe();


    document.getElementById('btn').onclick = openPhotoSwipe;
</script>

</body>
</html>