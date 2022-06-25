

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>首页</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../../layuiadmin/style/admin.css" media="all">
</head>
<body>
  
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md8">
        <div class="layui-row layui-col-space15">
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">快捷方式</div>
              <div class="layui-card-body">
                
                <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs3">
                        <a lay-href="/config/index.html">
                          <i class="layui-icon layui-icon-set"></i>
                          <cite>配置管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/building/index.html">
                          <i class="layui-icon layui-icon-notice"></i>
                          <cite>消息管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/user/index.html">
                          <i class="layui-icon layui-icon-username"></i>
                          <cite>用户管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/post/index.html">
                          <i class="layui-icon layui-icon-template"></i>
                          <cite>帖子管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/product/index.html">
                          <i class="layui-icon layui-icon-table"></i>
                          <cite>产品管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/order/index.html">
                          <i class="layui-icon layui-icon-survey"></i>
                          <cite>订单管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/adminuser/index.html">
                          <i class="layui-icon layui-icon-user"></i>
                          <cite>管理员管理</cite>
                        </a>
                      </li>
                      <li class="layui-col-xs3">
                        <a lay-href="/notice/index.html">
                          <i class="layui-icon layui-icon-form"></i>
                          <cite>公告管理</cite>
                        </a>
                      </li>
                    </ul>
                    
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="layui-col-md6">
            <div class="layui-card">
              <div class="layui-card-header">统计</div>
              <div class="layui-card-body">

                <div class="layui-carousel layadmin-carousel layadmin-backlog">
                  <div carousel-item>
                    <ul class="layui-row layui-col-space10">
                      <li class="layui-col-xs6">
                        <a lay-href="/order/index.html" class="layadmin-backlog-body">
                          <h3>订单总数</h3>
                          <p><cite>{{ $statistic['order'] ?? 0 }}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="/order/index.html" class="layadmin-backlog-body">
                          <h3>待支付订单数量</h3>
                          <p><cite>{{ $statistic['unpaidOrder'] ?? 0 }}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="/post/index.html" class="layadmin-backlog-body">
                          <h3>帖子数量</h3>
                          <p><cite>{{ $statistic['post'] ?? 0 }}</cite></p>
                        </a>
                      </li>
                      <li class="layui-col-xs6">
                        <a lay-href="/post/index.html" class="layadmin-backlog-body">
                          <h3>回复数量</h3>
                          <p><cite>{{ $statistic['reply'] ?? 0 }}</cite></p>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layui-col-md12">
            <div class="layui-card">
              <div class="layui-tab layui-tab-brief layadmin-latestData">
                <ul class="layui-tab-title">
                  <li class="layui-this">管理员管理</li>
                  <li>用户管理</li>
                </ul>
                <div class="layui-tab-content">
                  <div class="layui-tab-item layui-show">
                    <table id="order"></table>
                  </div>
                  <div class="layui-tab-item">
                    <table id="post"></table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="layui-col-md4">
        <div class="layui-card">
          <div class="layui-card-header">版本信息</div>
          <div class="layui-card-body layui-text">
            <table class="layui-table" style="margin-bottom: 23px;">
              <colgroup>
                <col width="100">
                <col>
              </colgroup>
              <tbody>
                <tr>
                  <td>程序版本</td>
                  <td>管理系统1.0</td>
                </tr>
                <tr>
                  <td>前端框架</td>
                  <td>layui</td>
                </tr>
                <tr>
                  <td>后端框架</td>
                  <td>Laravel 8.0</td>
                </tr>
                <tr>
                  <td>操作系统</td>
                  <td>Linux</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="layui-card">
          <div class="layui-card-header">比率</div>
          <div class="layui-card-body layadmin-takerates">
            <div class="layui-progress" lay-showPercent="yes">
              <h3>比率</h3>
              <div class="layui-progress-bar" lay-percent="{{ $statistic['orderPercent'] ?? 30 }}%"></div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

  <script src="../../layuiadmin/layui/layui.js?t=1"></script>  
  <script>
  layui.config({
    base: '../../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'console']);

  
    layui.use(['laydate', 'table', 'form'], function () {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var loading = layer.load(2);
        table.render({
            elem: '#order',
            url: "{{ route('adminuser.index') }}",
            page: { layout: ['refresh', 'prev', 'page', 'next', 'skip', 'limit', 'count'] },
            limit: 20,
            limits: [20, 40, 60, 80, 100],
            cols: [[
                { field: 'name', title: '管理员名称' },
                { field: 'mobile', title: '手机号' },
                { field: 'status', title: '状态' },
                { field: 'updated_at', title: '操作时间' },
            ]],
            done: function () {
                layer.close(loading);
            }
        });

        table.render({
            elem: '#post',
            url: "{{ route('user.index') }}",
            page: { layout: ['refresh', 'prev', 'page', 'next', 'skip', 'limit', 'count'] },
            limit: 20,
            limits: [20, 40, 60, 80, 100],
            cols: [[
                { field: 'nick_name', title: '昵称' },
                { field: 'mobile', title: '手机号' },
                { field: 'real_name', title: '真实姓名' },
                { field: 'card_no', title: '身份证号' },
                { field: 'gender', title: '性别' },
                { field: 'consume', title: '总消费' },
                { field: 'status', title: '状态' },
                { field: 'invite_code', title: '邀请码' },
                { field: 'invited_by', title: '邀请人' },
                { field: 'updated_at', title: '操作时间' },
            ]],
            done: function () {
                layer.close(loading);
            }
        });
    });
  </script>
</body>
</html>

