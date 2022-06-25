<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
  <title>@yield('title', '')</title>
  <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="/css/pace.css">
  @stack('css')
</head>
<body>
  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      @yield('content')
    </div>
  </div>
  <script src="/js/jquery.min.js"></script>
  <script>
    window.paceOptions = {
      ajax: {
        trackMethods: ['GET', 'POST', 'PUT', 'DELETE']
      },
      restartOnRequestAfter: 0,
      minTime: 0
    }
  </script>
  <script src="/js/pace.min.js"></script>
  <script src="/layuiadmin/layui/layui.js"></script>
  <script>
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
  });
  </script>
  @stack('js')
</body>
</html>
