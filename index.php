<?php
/**
 * Created by PhpStorm.
 * User: Zhi
 * Date: 2/16/2015
 * Time: 3:33 PM
 */

include "config.php";
include "utils.php";

date_default_timezone_set('America/Chicago');
ini_set('default_charset', 'utf-8'); 

$files = getSortedFilesByDate($COMIC_DIR);
$filevalues = array_values($files);
$filesname = $filevalues[0];
$fileDates = $filevalues[1];
$numFilesTotal = count($filesname);
$path = $COMIC_DIR;
$numForSlide = $NUM_FOR_SLIDE;
$maxPerPage = $MAX_PER_PAGE;
$thumbIndex = $THUMB_INDEX;
?>

<!doctype html>
<html class="no-js">

<head>
    <meta charset="utf-8"/>
    <title>COMIC LIBRARY</title>

    <!--[if lt IE 9]>
    <script src="js/html5.js"></script>
    <![endif]-->
    <link rel="stylesheet" media="all" href="css/style.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->

    <!-- JS -->
    <script src="js/jquery-1.7.1.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/tabs.js"></script>
    <script src="js/css3-mediaqueries.js"></script>
    <script src="js/jquery.columnizer.min.js"></script>

    <!-- Isotope -->
    <script src="js/jquery.isotope.min.js"></script>

    <!-- BBQ to save Isotope history -->
    <script src="js/bbq.min.js"></script>
    <script src="js/hashchange.min.js"></script>

    <!-- Lof slider -->
    <script src="js/jquery.easing.js"></script>
    <script src="js/lof-slider.js"></script>
    <link rel="stylesheet" href="css/lof-slider.css" media="all"  />
    <!-- ENDS slider -->

    <!-- Tweet -->
    <link rel="stylesheet" href="css/jquery.tweet.css" media="all"  />
    <script src="js/tweet/jquery.tweet.js" ></script>
    <!-- ENDS Tweet -->

    <!-- superfish -->
    <link rel="stylesheet" media="screen" href="css/superfish.css" />
    <script  src="js/superfish-1.4.8/js/hoverIntent.js"></script>
    <script  src="js/superfish-1.4.8/js/superfish.js"></script>
    <script  src="js/superfish-1.4.8/js/supersubs.js"></script>
    <!-- ENDS superfish -->

    <!-- prettyPhoto -->
    <script  src="js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
    <link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css"  media="screen" />
    <!-- ENDS prettyPhoto -->

    <!-- poshytip -->
    <link rel="stylesheet" href="js/poshytip-1.1/src/tip-twitter/tip-twitter.css"  />
    <link rel="stylesheet" href="js/poshytip-1.1/src/tip-yellowsimple/tip-yellowsimple.css"  />
    <script  src="js/poshytip-1.1/src/jquery.poshytip.min.js"></script>
    <!-- ENDS poshytip -->

    <!-- JCarousel -->
    <script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
    <link rel="stylesheet" media="screen" href="css/carousel.css" />
    <!-- ENDS JCarousel -->

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Voltaire' rel='stylesheet' type='text/css'>

    <!-- modernizr -->
    <script src="js/modernizr.js"></script>

    <!-- SKIN -->
    <link rel="stylesheet" media="all" href="css/skin.css"/>

    <!-- Less framework -->
    <link rel="stylesheet" media="all" href="css/lessframework.css"/>

    <!-- flexslider -->
    <link rel="stylesheet" href="css/flexslider.css" >
    <script src="js/jquery.flexslider.js"></script>

</head>


<body class="home">

<!-- HEADER -->
<header>
    <div class="wrapper cf">

        <div id="logo">
            <a href="index.php"><img  src="img/logo.png" alt="Simpler"></a>
        </div>

        <!-- nav -->
        <ul id="nav" class="sf-menu">
            <li class="current-menu-item"><a href="index.php">HOME</a></li>
			<li><a href="clearcache.php">Rebuild</a></li>
            <!--
            <li><a href="blog.html">BLOG</a></li>
            <li><a href="page.html">ABOUT</a>
                <ul>
                    <li><a href="page-elements.html">Elements</a></li>
                    <li><a href="page-icons.html">Icons</a></li>
                    <li><a href="page-typography.html">Typography</a></li>
                </ul>
            </li>
            <li><a href="portfolio.html">WORK</a></li>
            <li><a href="contact.html">CONTACT</a></li>
            -->
        </ul>
        <div id="combo-holder"></div>
        <!-- ends nav -->


        <!-- SLIDER -->
        <div id="home-slider" class="lof-slidecontent">

            <div class="preload"><div></div></div>

            <!-- slider content -->
            <div class="main-slider-content" >
                <ul class="sliders-wrap-inner">
                    <?php


                    $num2show = $numForSlide;
                    if ($num2show > $numFilesTotal)
                    {
                        $num2show = $numFilesTotal;
                    }

                    for($i = 0; $i < $num2show; $i++){
                        $file = $filesname[$i];
                        $purename = substr($file, 0, strlen($file)-4);
                        $toc = getFilteredToc($path."/".$file);
                        echo
                            '
							<li>
					          <img src="imgprocess.php?comic='.rawurlencode($path."/".$file).'&page='.rawurlencode($toc[$thumbIndex]).'&maxwidth=940&f=1" title="" alt="alt" />
					          <div class="slider-description">
					            <h4>'.$purename.'</h4>
					            <p>Date: '.date("F d Y H:i:s.", $fileDates[$i]).'
					            <a class="link" href="comicview.php?filename='.rawurlencode($path)."/".rawurlencode($file).'">Read more </a>
					            </p>
					         </div>
							</li>
							';

                    }

                    ?>
                    <!--
                        <li>
                              <img src="img/dummies/slides/01.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>1Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>

                        <li>
                              <img src="img/dummies/slides/02.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>2Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>

                        <li>
                              <img src="img/dummies/slides/03.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>3Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>

                        <li>
                              <img src="img/dummies/slides/04.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>4Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>

                        <li>
                              <img src="img/dummies/slides/05.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>5Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>

                        <li>
                              <img src="img/dummies/slides/06.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>6Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>

                        <li>
                              <img src="img/dummies/slides/07.jpg" title="" alt="alt" />
                              <div class="slider-description">
                                <h4>7Lorem ipsum dolor</h4>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est...
                                <a class="link" href="#">Read more </a>
                                </p>
                             </div>
                        </li>
                    -->
                </ul>
            </div>
            <!-- ENDS slider content -->

            <!-- slider nav -->
            <div class="navigator-content">
                <div class="navigator-wrapper">
                    <ul class="navigator-wrap-inner">
                        <?php
                        for($i = 0; $i < $num2show; $i++){
                            $file = $filesname[$i];
                            $purename = substr($file, 0, strlen($file)-4);
                            $toc = getFilteredToc($path."/".$file);
                            echo
                                '
								<li>
								  <img src="imgprocess.php?comic='.rawurlencode($path."/".$file).'&page='.rawurlencode($toc[$thumbIndex]).'&maxwidth=188&f=1" alt="alt" />
								</li>
								';

                        }


                        ?>
                        <!--
                           <li><img src="img/dummies/slides/01_thumb.jpg" alt="alt" /></li>
                           <li><img src="img/dummies/slides/02_thumb.jpg" alt="alt" /></li>
                           <li><img src="img/dummies/slides/03_thumb.jpg" alt="alt" /></li>
                           <li><img src="img/dummies/slides/04_thumb.jpg" alt="alt" /></li>
                           <li><img src="img/dummies/slides/05_thumb.jpg" alt="alt" /></li>
                           <li><img src="img/dummies/slides/06_thumb.jpg" alt="alt" /></li>
                           <li><img src="img/dummies/slides/07_thumb.jpg" alt="alt" /></li>
                           -->
                    </ul>
                </div>
                <div class="button-next">Next</div>
                <div  class="button-previous">Previous</div>
                <!-- REMOVED TILL FIXED <div class="button-control"><span>STOP</span></div> -->
            </div>
            <!-- slider nav -->



        </div>
        <!-- ENDS SLIDER -->





    </div>
</header>
<!-- ENDS HEADER -->

<!-- MAIN -->
<div id="main">
    <div class="wrapper cf">





        <!-- featured -->
        <div id = "home-featured-id" class="home-featured">

            <ul id = "filter-buttons">
                <?php
                $numPages = intval(ceil($numFilesTotal / $maxPerPage));
                // page 1
                $i = 1;
                echo
                    '
						<li><a href="#" data-filter=".page'.$i.'" class="selected">'.$i.'</a></li>
						';
                for ($i = 1; $i < $numPages; $i++){
                    echo
                        '
						<li><a href="#" data-filter=".page'.($i+1).'" >'.($i+1).'</a></li>
						';
                }
                ?>
                <li><a href="#" data-filter="*" >show all (<?php echo $numFilesTotal; ?>)</a></li>
                <!--
                    <li><a href="#" data-filter="*" class="selected">show all</a></li>

                    <li><a href="#" data-filter=".R18">R18</a></li>
                    <li><a href="#" data-filter=".print">R15</a></li>
                    <li><a href="#" data-filter=".design">R8</a></li>
                    <li><a href="#" data-filter=".photo">Young</a></li>
                    -->
            </ul>

            <!-- Filter container -->
            <div id="filter-container" class="cf">
                <?php

                for ($ii = 0; $ii < $numPages; $ii++){
                    $numThisPage = $maxPerPage;
                    if ( $ii == ($numPages-1))
                    {
                        $numThisPage = $numFilesTotal - $ii * $maxPerPage;
                    }

                    for($j = 0; $j < $numThisPage; $j++){
                        $file = $filesname[$ii * $maxPerPage + $j];
                        $purename = substr($file, 0, strlen($file)-4);
                        $toc = getFilteredToc($path."/".$file);

                        echo
                            '<figure class="page'.($ii+1).'">
							<a href="comicview.php?filename='.rawurlencode($path)."/".rawurlencode($file).'" class="thumb"><img src="imgprocess.php?comic='.rawurlencode($path."/".$file).'&page='.rawurlencode($toc[$thumbIndex]).'&maxwidth=300&f=1" alt="alt" /></a>
							<figcaption>
								<a href="comicview.php?filename='.rawurlencode($path)."/".rawurlencode($file).'"><h3 class="heading">'.$purename.' </h3></a>
								'.date("F d Y H:i:s.", $fileDates[$ii * $maxPerPage + $j]).'<br />Pages:'.sizeof($toc).' </figcaption>
						</figure>';
                    }
                }
                ?>
                <!--
                    <figure class="web">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/05.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html"><h3 class="heading">Pellentesque </h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>

                    <figure class="print">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/02.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html"><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="design">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/03.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="photo">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/04.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="web photo">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/05.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="web print">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/06.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="photo">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/04.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="web photo">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/05.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>


                    <figure class="web print">
                        <a href="project.html" class="thumb"><img src="img/dummies/featured/01.jpg" alt="alt" /></a>
                        <figcaption>
                            <a href="project.html" ><h3 class="heading">Pellentesque habitant morbi</h3></a>
                            Tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. </figcaption>
                    </figure>
                -->

            </div><!-- ENDS Filter container -->

            <!-- bottom pagination -->
            <ul id = "filter-buttons-bot" >
                <?php
                $numPages = intval(ceil($numFilesTotal / $maxPerPage));
                // page 1
                $i = 1;
                echo
                    '
						<li><a href="#" data-filter=".page'.$i.'" class="selected">'.$i.'</a></li>
						';
                for ($i = 1; $i < $numPages; $i++){
                    echo
                        '
						<li><a href="#" data-filter=".page'.($i+1).'" >'.($i+1).'</a></li>
						';
                }
                ?>
                <li><a href="#" data-filter="*" >show all (<?php echo $numFilesTotal; ?>)</a></li>
            </ul>
        </div>
        <!-- ENDS featured -->




    </div><!-- ENDS WRAPPER -->
</div>
<!-- ENDS MAIN -->


<!-- FOOTER -->
<footer>
    <div class="wrapper cf">

        <?php
        /*
            <!-- widgets -->
            <ul  class="widget-cols cf">

                <li class="first-col">

                    <div class="widget-block">
                        <h4>RECENT POSTS</h4>
                        <div class="recent-post cf">
                            <a href="#" class="thumb"><img src="img/dummies/54x54.gif" alt="Post" /></a>
                            <div class="post-head">
                                <a href="#">Pellentesque habitant morbi senectus</a><span> March 12, 2011</span>
                            </div>
                        </div>
                        <div class="recent-post cf">
                            <a href="#" class="thumb"><img src="img/dummies/54x54.gif" alt="Post" /></a>
                            <div class="post-head">
                                <a href="#">Pellentesque habitant morbi senectus</a><span> March 12, 2011</span>
                            </div>
                        </div>
                        <div class="recent-post cf">
                            <a href="#" class="thumb"><img src="img/dummies/54x54.gif" alt="Post" /></a>
                            <div class="post-head">
                                <a href="#">Pellentesque habitant morbi senectus</a><span> March 12, 2011</span>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="second-col">

                    <div class="widget-block">
                        <h4>ABOUT</h4>
                        <p>Folder it's completely free this means you don't have to pay anything <a href="http://luiszuno.com/blog/license" tar >read license</a>.</p>
                        <p>Visit <a href="http://templatecreme.com/" >Template Creme</a> and find the most beautiful free templates up to date.</p>
                    </div>

                </li>

                <li class="third-col">

                    <div class="widget-block">
                        <div id="tweets" class="footer-col tweet">
                             <h4>TWITTER WIDGET</h4>
                         </div>
                     </div>

                </li>

                <li class="fourth-col">

                    <div class="widget-block">
                        <h4>CATEGORIES</h4>
                        <ul>
                            <li class="cat-item"><a href="#" >Design</a></li>
                            <li class="cat-item"><a href="#" >Photo</a></li>
                            <li class="cat-item"><a href="#" >Art</a></li>
                            <li class="cat-item"><a href="#" >Game</a></li>
                            <li class="cat-item"><a href="#" >Film</a></li>
                            <li class="cat-item"><a href="#" >TV</a></li>
                        </ul>
                    </div>

                </li>
            </ul>
            <!-- ENDS widgets -->

        */
        ?>
        <!-- bottom -->
        <div class="footer-bottom">
            <div class="left">by <a href="http://google.com" >Joshua Zhang</a></div>
            <ul id="social-bar" class="cf sb">
                <li><a href="http://www.facebook.com"  title="Become a fan" class="facebook">Facebbok</a></li>
                <li><a href="http://www.twitter.com" title="Follow my tweets" class="twitter"></a></li>
                <li><a href="http://plus.google.com" title="Enter my circles" class="plus"></a></li>
            </ul>
        </div>
        <!-- ENDS bottom -->

    </div>
</footer>
<!-- ENDS FOOTER -->

</body>



</html>