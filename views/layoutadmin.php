<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title><?php echo $view['posts']['title']; ?></title>
  <link rel="stylesheet" href="/css/theme/style.css" type="text/css" media="all" />
  <script src="/js/jquery-3.1.1.js"></script>
</head>
<body>

<!-- Header -->
<div id="header">
  <div class="shell">
    <!-- Logo + Top Nav -->
    <div id="top">
      <h1><a href="/">Web Ket</a> <?php if ($view['posts']['auth'] > 1): ?>for administrator<?php endif; ?></h1>
      <div id="top-navigation">
        <?php if ($view['posts']['auth'] > 0): ?>
            <?php if ($view['posts']['auth'] > 1): ?>
            Welcome <strong>Administrator</strong>   
            <?php endif; ?>
            <?php if ($view['posts']['auth'] < 2): ?>
            Welcome <strong>User</strong>
            <?php endif; ?>
            <span>|</span>
            <a href="/auth-logout">Log out</a>
        <?php else: ?>
        Welcome <strong>Guest</strong>   
        <?php endif; ?>    
      </div>
    </div>
    <!-- End Logo + Top Nav -->
    
    <!-- Main Nav -->
    <div id="navigation">
      <ul>
          <?php if ($view['posts']['page'] == 'authlogin'): ?>
          <li><a href="/"><span>Home</span></a></li>
          <li><a href="/auth-login" class="active"><span>Login</span></a></li>
          <?php else: ?>
            <?php if ($view['posts']['page'] == 'authregister'): ?>
            <li><a href="/"><span>Home</span></a></li>
            <li><a href="/auth-registration" class="active"><span>Register</span></a></li>
            <?php else: ?>
              <li><a href="/"><span>Home</span></a></li>
              <li><a href="/list-messages"<?php if ($view['posts']['page'] == 'listmessages'): ?> class="active"<?php endif; ?>><span>List messages</span></a></li>
              <?php if ($view['posts']['auth'] > 1): ?>
              <li><a href="/list-users"<?php if ($view['posts']['page'] == 'listusers'): ?> class="active"<?php endif; ?>><span>List users</span></a></li>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
      </ul>
    </div>
    <!-- End Main Nav -->
  </div>
</div>
<!-- End Header -->

<?php echo $content; ?>

<!-- Footer -->
<div id="footer">
  <div class="shell">
    <span class="left">&copy; 2016 - Web Ket</span>
    <span class="right">
      Design by <a href="http://ket.cc.ua" target="_blank" title="Web Ket">Web Ket</a>
    </span>
  </div>
</div>
<!-- End Footer -->
  
</body>
</html>