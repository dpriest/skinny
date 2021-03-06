<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-16121511-1");
      pageTracker._setDomainName(".listandcheck.com");
      pageTracker._trackPageview();
    } catch(err) {}


    </script>
    <meta name="google-site-verification" content="Ycw-C-E1v2HSmQT84unM5QtNXoO3eQ0hkUFrUaAvyfM" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28995211-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
  </head>
  <body>
    <div class="topline">
      <ul>
      <?php if ($sf_user->isAuthenticated()): ?>
        <li><?php echo $sf_user->getGuardUser()->getUsername()?></li>
        <li><?php echo link_to('我的事项', '@my_lists')?></li> 
        <li><?php echo link_to('注销', '@sf_guard_signout')?></li> 
        <li><?php echo link_to('修改密码', '@changePassword')?></li> 
      <?php else: ?>
        <li><?php echo link_to('注册', '@register')?></li> 
        <li><?php echo link_to('登录', '@sf_guard_signin')?></li> 
      <?php endif ?>
      </ul>
    </div>

    <div class="wrapAll">
      <?php echo link_to(image_tag('listandcheck.png'), '@homepage')?>
      <div id="flashes">
        <?php if ($sf_user->hasFlash('notice')): ?>
          <div class="flash_notice"><?php echo $sf_user->getFlash('notice') ?></div>
        <?php endif; ?>

        <?php if ($sf_user->hasFlash('error')): ?>
          <div class="flash_error"><?php echo $sf_user->getFlash('error') ?></div>
        <?php endif; ?>
      </div>
      <div class="content">
        <?php echo $sf_content ?>
      </div>
    </div>
    <div id="footer">
      <div id="opensource">
        <img src="/images/opensource.png"/>内容版权所有 &copy;2012. Created by <a href="http://wp4d.sinaapp.com/">dpriest</a>. Design obviously inspired on <a href="http://symfony-check.org">symfony-check</a>. <a href="https://github.com/dpriest/skinny/blob/master/README.markdown">Credits</a>.

      </div>
    </div>
  </body>
</html>
