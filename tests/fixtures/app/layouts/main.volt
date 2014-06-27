<!DOCTYPE html>
<head>
    <link href="/assets/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

    <script src="/assets/vendor/jquery/jquery.js"></script>

    <script src="/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    
    {{ assets.outputCss() }}
    {{ assets.outputJs() }}

    <title>Vegas Profiler demo</title>
</head>
<body>
<div id="allpage">
    Main layout
    {{ content() }}
</div>
{{ partial('../../../layouts/partials/profiler') }}
</body>
</html>