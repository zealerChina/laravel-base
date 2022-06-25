
  <div class="layui-form" wid100 lay-filter="">
      <form class="smsForm">
          <div class="layui-form-item">
              <label class="layui-form-label">APP_KEY</label>
              <div class="layui-input-block">
                <input type="text" name="access_key_id" value="{{$data['access_key_id'] ?? ''}}" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">SECRET_KEY</label>
              <div class="layui-input-block">
                <input type="text" name="access_key_secret" value="{{$data['access_key_secret'] ?? ''}}" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">短信内容签名</label>
              <div class="layui-input-block">
                <input type="text" name="smssign" value="{{$data['smssign'] ?? ''}}" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">注册短信模板ID</label>
              <div class="layui-input-block">
                <input type="text" name="register_template_id" value="{{$data['register_template_id'] ?? ''}}" class="layui-input">
              </div>
          </div>
          <div class="layui-form-item">
              <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="LAY-user-login-submit" id="smsBtn">确认保存</button>
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
      url: '/config/sms',
      method: 'GET',
    }).done(function (data) {
      if (data.code == 0) {
        var values = data.data
        $.each(values, function (i, item) {
          $(".smsForm input[name='"+i+"']").val(item);
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
    $('.smsForm').on('submit', function (e) {
      var that = this;
      e.preventDefault();

      $('smsBtn').attr('disabled', 'disabled');

      $.ajax({
          url: '/config/sms',
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