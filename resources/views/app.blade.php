<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/assets/vendor.css"/>
        <link rel="stylesheet" href="/assets/app.css"/>
        <title>TDC</title>
        <base href="/"/>
        <script type="text/javascript">
            window.APP_STATE = {!! json_encode($app_state) !!}
            window.APP_DATA = {!! json_encode($app_data) !!}
        </script>
        <script type="text/javascript" src="/assets/vendor.js"></script>
        <script type="text/javascript" src="/assets/app.js"></script>
    </head>
    <body ng-app="tdc" ng-controller="tdcController">
        <div ng-include="layout_tpl"></div>
    </body>
</html>