<center>
<h1>请先登录</h1>
<p>这个页面不是公共页面</p>
<p>请先到登录页面登录</p>

<ul>
      <li><?php echo link_to('前往登录', sfConfig::get('sf_login_module').'/'.sfConfig::get('sf_login_action')) ?></li>
      <li><a href="javascript:history.go(-1)">回到上一页</a></li>
</ul>
