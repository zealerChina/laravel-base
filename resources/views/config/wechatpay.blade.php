
  <div class="layui-form" wid100 lay-filter="">
      <form class="wechatPayForm">
          <div class="layui-form-item">
              <label class="layui-form-label">公众账号ID</label>
              <div class="layui-input-block">
                <input type="text" name="app_id" value="{{$data['app_id'] ?? ''}}" class="layui-input">
                <span><span style="color:red;">[AppID]</span>微信支付对应公众账号APPID</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">商户号</label>
              <div class="layui-input-block">
                <input type="text" name="mch_id" value="{{$data['mch_id'] ?? ''}}" class="layui-input">
                <span><span style="color:red;">[MCHID]</span>微信支付商户号</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">应用秘钥</label>
              <div class="layui-input-block">
                <input type="text" name="app_secret" value="{{$data['app_secret'] ?? ''}}" class="layui-input">
                <span><span style="color:red;">[AppSecrect]</span>微信支付对应公众账号APPSecrect</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">支付签名串API密钥</label>
              <div class="layui-input-block">
                <input type="text" name="pay_sign_key" value="{{$data['pay_sign_key'] ?? ''}}" class="layui-input">
                <span><span style="color:red;">[paySignKey]</span>微信商户API密钥</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">支付证书cert</label>
              <div class="layui-input-block">
                <input type="text" name="apiclient_cert" value="{{$data['apiclient_cert'] ?? ''}}" class="layui-input">
                <span>apiclient_cert.pem文件在服务器的磁盘路径,如Linux系统"root/cert/apiclient_cert.pem"或window系统"d:\cert\apiclient_cert.pem"</span>
              </div>
          </div>
          <div class="layui-form-item">
              <label class="layui-form-label">支付证书key</label>
              <div class="layui-input-block">
                <input type="text" name="apiclient_key" value="{{$data['apiclient_key'] ?? ''}}" class="layui-input">
                <span>apiclient_key.pem文件在服务器的磁盘路径,如Linux系统"root/cert/apiclient_key.pem"或window系统"d:\cert\apiclient_key.pem"</span>
              </div>
          </div>
          <div class="layui-form-item">
              <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="LAY-user-login-submit" id="wechatPayBtn">确认保存</button>
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
      url: '/config/wechatpay',
      method: 'GET',
    }).done(function (data) {
      if (data.code == 0) {
        var values = data.data
        $.each(values, function (i, item) {
          $(".wechatPayForm input[name='"+i+"']").val(item);
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
    $('.wechatPayForm').on('submit', function (e) {
      var that = this;
      e.preventDefault();

      $('wechatPayBtn').attr('disabled', 'disabled');

      $.ajax({
          url: '/config/wechatpay',
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