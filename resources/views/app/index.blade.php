<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/assets/vendor.css"/>
        <link rel="stylesheet" href="/assets/app.css"/>
        <script type="text/javascript" src="/assets/vendor.js"></script>
        <script type="text/javascript" src="/assets/app.js"></script>
        <title>TDC</title>
        <script type="text/javascript">
            window.__APP_STATE = {!! json_encode($app_state) !!}
        </script>
        <base href="/"/>
    </head>
    <body ng-app="tdc" ng-controller="tdcController">
        <div ng-include="curTemplate"></div>
    </body>
</html>