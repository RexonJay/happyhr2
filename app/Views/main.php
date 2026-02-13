<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>LGU-GENSAN</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Main CSS-->
    <link href="<?= base_url("assets/css/main.css") ?>" rel="stylesheet">
    <link href="<?= base_url("assets/css/bootstrap-year-calendar.min.css") ?>" rel="stylesheet">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/chatgpt/style.css') ?>">
    <!-- add icon link -->
    <link rel="icon" href="<?= base_url("assets/happy-hr-icon.png") ?>" type="image/x-icon">
    
    <style type="text/css">
    /* CSS for smiley buttons */
    .smiley-icon {
      background: none;
      border: 1px solid #007bff;
      border-radius: 8px;
      font-size: 24px;
      cursor: pointer;
      color: #007bff;
      margin-right: 10px;
      transition: color 0.2s, border-color 0.2s;
    }

    .smiley-icon:hover {
      background-color: #17095c;
      color: #17095c;
      border-color: #17095c;
    }

    #ModalChatBot .modal-content {
      border-radius: 30px;
    }

    #ModalChatBot .modal-header,
    #ModalChatBot .modal-footer {
      border-radius: 30px 30px 0 0;
    }
    </style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script>
    window.codySettings = { widget_id: '9bd3b51e-1e03-42a1-80b3-2cfa303b4807' };

    !function(){var t=window,e=document,a=function(){var t=e.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://trinketsofcody.com/cody-widget.js";var a=e.getElementsByTagName("script")[0];a.parentNode.insertBefore(t,a)};"complete"===document.readyState?a():t.attachEvent?t.attachEvent("onload",a):t.addEventListener("load",a,!1)}();
    </script> -->
  </head>
  <body class="app sidebar-mini rtl">
    <!-- Navbar-->
    <header class="app-header">
      <a class="app-header__logo" href="<?= site_url() ?>">Happy HR !</a>
      <!-- Sidebar toggle button-->
      <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <li class="dropdown">
          <a class="app-nav__item" href="https://csm.gensantos.gov.ph/?officecode=200" target="_blank">
            <i class="fa fa-star fa-lg"></i>
          </a>
        </li>

        <li class="dropdown">
          <a class="app-nav__item" href="<?= site_url('Downloads') ?>">
            <i class="fa fa-download fa-lg"></i>
          </a>
        </li>

        <!-- User Menu-->
        <li class="dropdown">
          <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
            <i class="fa fa-user fa-lg"></i>
          </a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
              <a class="dropdown-item" href="<?= site_url('user') ?>">
                <i class="fa fa-user fa-lg"></i> Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="<?= site_url('logout') ?>">
                <i class="fa fa-sign-out fa-lg"></i> Logout
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <a href="<?= site_url('user') ?>">
        <?php if(auth()->user() && !empty(auth()->user()->Photo)): ?>
          <img class="app-sidebar__user-avatar" src="data:image/jpeg;base64,<?= base64_encode(auth()->user()->Photo) ?>" alt="User Image" width="50" height="50"/>
        <?php else: ?>
          <img class="app-sidebar__user-avatar" src="<?= base_url('uploads/user.png') ?>" alt="User Image" width="50" height="50"/>
        <?php endif; ?>
        </a>
        <div>
          <p class="app-sidebar__user-name"><?= auth()->user() ? auth()->user()->first_name : '' ?> <?= auth()->user() ? auth()->user()->last_name : '' ?></p>
          <p class="app-sidebar__user-designation">
            <font size="1">
              <?= auth()->user() ? auth()->user()->Office : '' ?>
            </font>
          </p>
        </div>
      </div>
      
      <ul class="app-menu">
        <?= $this->include('main_menu') ?>
        <?php if (auth()->user() && auth()->user()->inGroup('admin')): ?>
          <?= $this->include('admin_menu') ?>
        <?php endif; ?>    
      </ul>
    </aside>

    <!-- Show the Bulletin Modal -->
    <div class="modal fade" id="ModalEBulletin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4><p id='TitleEBulletin' class="modal-title">System Update/s!</p></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <p id="txtEBulletin"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-block" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Show the ChatBot Modal
    <div class="modal fade" id="ModalChatBot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container">
              <div class="chat-header"></div>
              <div class="chat-body">
                <div class="chats">            
                  <div class="message response">
                    <div>Hi <?= auth()->user() ? auth()->user()->first_name : 'Guest' ?>! This is Tim 😊</div>
                  </div>
                  <div class="message response">
                    <div>How are you feeling today?</div>
                  </div>
                  <div class="message response">
                    <div id="smileyButtons">
                      <button class="smiley-icon" data-smiley="Hopeless">😥</button>
                      <button class="smiley-icon" data-smiley="Lonely">😞</button>
                      <button class="smiley-icon" data-smiley="Sad">😐</button>
                      <button class="smiley-icon" data-smiley="Happy">😊</button>
                      <button class="smiley-icon" data-smiley="Very Happy">😍</button>
                    </div>
                  </div>
                </div>
                <div class="sender" style="display:none" id="btnsender">
                  <input id='txtType' type="text" placeholder="Type here..." maxlength="1000" autofocus>
                  <button id='myBtn'>
                    <img src="<?= base_url('assets/chatgpt/img/send.png') ?>" alt="send-btn">
                  </button>
                </div>
                <div class="closechatmodal" id="closechatmodal">
                  <button type="button" class="btn btn-warning btn-block" data-dismiss="modal" id="btnchatbotclose">Close</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display:none" id="btnchatbotclose">
            <button type="button" class="btn btn-warning btn-block" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Essential javascripts for application to work-->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script> -->
    <!-- <script src="<?= base_url("assets/js/popper.min.js") ?>"></script> -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script src="<?= base_url("assets/js/main.js") ?>"></script>
    
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= base_url("assets/js/plugins/pace.min.js") ?>"></script>

    <!-- Page specific javascripts-->
    <script src="<?= base_url("assets/js/plugins/moment.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/plugins/jquery-ui.custom.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/sweetalert.min.js") ?>"></script>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> <?= $Title ?? '' ?></h1>
          <p><?= $SubTitle ?? '' ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#"><?= $Title ?? '' ?></a></li>
        </ul>
      </div>
      <?php 
      if (isset($view_file)) {
          echo view($view_file); // Pass data to the included view
      }
      ?>
    </main>
  </body>
</html>