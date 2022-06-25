
  <div class="layui-form" wid100 lay-filter="">
      <form class="wechatForm">
          <div class="layui-form-item">
              <label class="layui-form-label">小程序ID</label>
              <div class="layui-input-block">
                <input type="text" name="app_id" value="{{$data['app_id'] ?? ''}}" class="layui-input">
                <span><span style="color:red;">[AppID]</span>小程序APPID</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">小程序秘钥</label>
              <div class="layui-input-block">
                <input type="text" name="app_secret" value="{{$data['app_secret'] ?? ''}}" class="layui-input">
                <span><span style="color:red;">[AppSecrect]</span>小程序APPSecrect</span>
              </div>
          </div>
          <div class="layui-form-item">
              <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="LAY-user-login-submit" id="wechatBtn">确认保存</button>
              </div>
          </div>
      </form>
  </div>

  @push('js')
  <script>
  layui.config({
    base: '/layuiadmin/' //静态资源所在路径
  }).extend({
    // index: 'lib/index' //主入口模块
  }).use(['index', 'set']);
    $.ajax({
      url: '/config/wechat',
      method: 'GET',
    }).done(function (data) {
      if (data.code == 0) {
        var values = data.data
        $.each(values, function (i, item) {
          $(".wechatForm input[name='"+i+"']").val(item);
        });
      }
    }).fail(function (xhr) {
        var content = '';
        for (error in xhr.responseJSON.errors) {
            content = xhr.responseJSON.errors[error][0];
        }

        layer.open({
            title: '错误',
            icon: 2,
            content: content,
        });
    }).always(function () {});

    //提交
    $('.wechatForm').on('submit', function (e) {
      var that = this;
      e.preventDefault();

      $('wechatBtn').attr('disabled', 'disabled');

      $.ajax({
          url: '/config/wechat',
          method: 'POST',
          data: $(this).serializeArray(),
      }).done(function (data) {
        layer.open({
            icon: 1,
            title: '更新配置',
            content: '更新配置成功',
            end: function () {
                window.location.reload();
            }
        });
      }).fail(function (xhr) {
        var content = '';
        for (error in xhr.responseJSON.errors) {
            content = xhr.responseJSON.errors[error][0];
        }

        layer.open({
            title: '错误',
            icon: 2,
            content: content,
        });
      }).always(function () {
          $(that).find('button[type=submit]').removeAttr('disabled');
      });
    });
  </script>
@endpush