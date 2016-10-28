<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $view['posts']['title']; ?></title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link href='//fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>

        <link href='/css/style.css' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="/css/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

    </head>
<body>

    <!-- Navbar -->
    <ul class="w3-navbar w3-red w3-card-2 w3-top w3-left-align w3-large">
      <li class="w3-hide-medium w3-hide-large w3-opennav w3-right">
        <a class="w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
      </li>
      <li><a href="/" class="w3-padding-large w3-white">Home</a></li>
      <?php if ($view['posts']['auth'] > 0): ?>
      <li class="w3-hide-small"><a href="/auth-logout" class="w3-padding-large w3-hover-white">Logout</a></li>
      <?php else: ?>
      <li class="w3-hide-small"><a href="/auth-login" class="w3-padding-large w3-hover-white">Login</a></li>
      <li class="w3-hide-small"><a href="/auth-registration" class="w3-padding-large w3-hover-white">Registration</a></li>
      <?php endif; ?>
      <?php if ($view['posts']['auth'] > 0): ?>
      <li class="w3-hide-small"><a href="/list-messages" class="w3-padding-large w3-hover-white">List messages</a></li>
          <?php if ($view['posts']['auth'] > 1): ?>
              <li class="w3-hide-small"><a href="/list-users" class="w3-padding-large w3-hover-white">List users</a></li>
          <?php endif; ?>
      <?php endif; ?>
    </ul>

    <?php echo $content; ?>
</body>