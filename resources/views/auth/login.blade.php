

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>登入 - 后台管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/login.css" media="all">
</head>
<body>

  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>后台管理</h2>
        <p>后台管理系统</p>
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <form>
          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
            <input type="text" name="mobile" id="LAY-user-login-mobile" lay-verify="required" placeholder="手机号" class="layui-input">
            <span class="help-block" style="color:red"></span>
          </div>
          <div class="layui-form-item">
            <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
            <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
            <span class="help-block" style="color:red"></span>
          </div>
          <div class="layui-form-item" style="margin-bottom: 20px;">
            <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
            <!-- <a href="forget.html" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a> -->
          </div>
          <div class="layui-form-item">
            <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="LAY-user-login-submit">登 入</button>
          </div>
        </form>
      </div>
    </div>
    
    <div class="layui-trans layadmin-user-login-footer">
      
      <p>© 2022 <a href="" target="_blank">后台管理</a></p>
    </div>
  </div>

  <script src="/layuiadmin/layui/layui.js"></script>  
  <script>
  layui.config({
    base: '/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'user'], function(){
    var $ = layui.$
    ,setter = layui.setter
    ,admin = layui.admin
    ,form = layui.form
    ,router = layui.router()
    ,search = router.search;

    form.render();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    //提交
    $('form').on('submit', function (e) {
      var that = this;
      e.preventDefault();

      $(this).find('button[type=submit]').attr('disabled', 'disabled');
      var mobile = $("input[name='mobile']").val();
      var password = $("input[name='password']").val();
      var remember = $("input[name='remember']").val();

      $.ajax({
          url: 'login',
          method: 'POST',
          data: $(this).serializeArray(),
      }).done(function (data) {
          window.location.href = '/';
      }).fail(function (xhr) {
          $.each(xhr.responseJSON.errors, function(index, item) {
              $(that).find('input[name=' + index + ']').siblings('span.help-block').text(item);
          });
      }).always(function () {
          $(that).find('button[type=submit]').removeAttr('disabled');
      });
    });
  });
  </script>
</body>
</html>
