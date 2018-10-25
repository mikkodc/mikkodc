<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $title ? $title !==null : "MikkoDC" ?> - Portfolio Site</title>

  <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16" />

  <!-- Custom CSS Styles -->
  <link rel="stylesheet" type="text/css" href="library/dest/styles/style.min.css" />

</head>
<body>
  <?php include_once("analyticstracking.php") ?>
  <header id="main-header" class="container">
    <a href="/" class="top-logo">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50.6 60.2" height="80px" width:="67px"><defs><style>.cls-1{fill:#232323;opacity:0.2;isolation:isolate;}.cls-2{fill:#f4f4f4;}.cls-3{fill:#c1c1c1;}</style></defs><title>mikkodc-logo_light</title><g id="Shadows"><path class="cls-1" d="M44.6,45.3c-.8,5.6-6.5,9.2-12.7,9.4a13.44,13.44,0,0,1-4.73-1A16.64,16.64,0,0,0,30.8,43.2V43a16.64,16.64,0,0,0-3.62-10.53,13.23,13.23,0,0,1,4.72-1h7.2v2.27l5.9-4.2V1.1L22.55,17.33,0,1.1V29.5l6,4.3V31.5h6.7a13.22,13.22,0,0,1,5.11,1A16.57,16.57,0,0,0,14.2,43v.1a16.67,16.67,0,0,0,3.66,10.6,13.23,13.23,0,0,1-5.16,1H6V44.8H0V60.2H12.7a19.53,19.53,0,0,0,9.87-2.54,19.31,19.31,0,0,0,9,2.44C41.2,59.8,48,53.4,48.9,45ZM22.46,50A11.66,11.66,0,0,1,20.4,43.2v-.1a11.83,11.83,0,0,1,2.08-6.87,12,12,0,0,1,2,6.87v.1A11.77,11.77,0,0,1,22.46,50ZM6,26V13.7l16.5,12,16.6-12V26H31.7a20,20,0,0,0-9.18,2.5A19.55,19.55,0,0,0,12.7,26Z"/></g><g id="C"><path class="cls-2" d="M44.7,43.9c-.8,5.6-5,9.5-11.3,9.7-6.9-.2-11.4-5-11.4-11.5V42c0-6.6,4.5-11.4,11.5-11.6h7.1v2.3l5.9-4.2V24.9H33.3c-10.3.3-17.4,7.5-17.4,16.9V42c0,9.4,7.1,16.7,17.4,17,9.6-.3,16.4-6.7,17.3-15.1Z"/></g><g id="D"><path class="cls-2" d="M14.3,24.9H1.6v3.5l6,4.3V30.4h6.7c7.2,0,11.8,4.9,11.8,11.6v.1c0,6.7-4.7,11.5-11.8,11.5H7.6V43.7h-6V59H14.3C25,59,32.4,51.6,32.4,42v-.1C32.4,32.3,25,24.9,14.3,24.9Z"/></g><g id="M"><polygon class="cls-2" points="24.1 16.2 1.6 0 1.6 8.3 1.6 28.5 7.6 32.7 7.5 12.6 24.1 24.6 40.6 12.6 40.6 32.7 46.5 28.5 46.5 8.3 46.5 0 24.1 16.2"/></g><g id="Overlap_Shadows" data-name="Overlap Shadows"><rect class="cls-3" x="39.09" y="24.9" width="1.51" height="5.5"/><path class="cls-1" d="M23,37a10.74,10.74,0,0,1,1.09-1.91,10.49,10.49,0,0,0-4.62-3.73,15.79,15.79,0,0,0-1,1.37A10.42,10.42,0,0,1,23,37Z"/><path class="cls-1" d="M19.52,52.55a12.11,12.11,0,0,1-2,.68,16.41,16.41,0,0,0,4.7,4.22,17.8,17.8,0,0,0,1.92-1A16.49,16.49,0,0,1,19.52,52.55Z"/></g></svg>
    </a>
    <a id="toggle-menu">
      <span>Menu</span>
      <div id="hamburger-menu">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div></a>
  </header>
  <nav id="slide-menu" role="navigation">
      <div class="nav-inner">
        <ul class="nav-list hover-ease">
          <li>
            <a class="active" href="#home">Home</a>
          </li>
          <li>
            <a href="#about">About</a>
          </li>
          <li>
            <a href="#portfolio">Portfolio</a>
          </li>
          <li class="coming-soon">
            <button href="#services" disabled>Playground</button>
          </li>
          <li class="coming-soon">
            <button href="#services" disabled>Blog</button>
          </li>
          <li>
            <a href="#contact">Contact</a>
          </li>
        </ul>
        <ul class="social-icons">
          <li><a href="https://www.linkedin.com/in/mikkodc/" target="_blank"><i class="flaticon-linkedin"></i></a></li>
          <li><a href="https://www.facebook.com/Mikkoooow" target="_blank"><i class="flaticon-facebook-social-network-logo"></i></a></li>
          <li><a href="https://twitter.com/Mikkoooow" target="_blank"><i class="flaticon-social-media"></i></a></li>
          <li><a href="https://www.instagram.com/mikkodc/" target="_blank"><i class="flaticon-instagram-logo"></i></a></li>
        </ul>
        <ul class="contact-list">
          <li><i class="flaticon-letter"></i><span>Say hello</span> <a href="mailto:mikkodecastro@ymail.com" class="fade-up-line">mikkodecastro@ymail.com</a></li>
          <li><i class="flaticon-technology"></i><span>Let's talk</span> <a href="tel:+(971)-55-954-5484" class="fade-up-line">+(971)-55-954-5484</a></li>
        </ul>
        <div class="copyright">
          Copyright © 2017. All Rights Reserved.<br>www.MikkoDC.com
        </div>
      </div>
  </nav>
