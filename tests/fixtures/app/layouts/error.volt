<!DOCTYPE html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Error</title>
        
        <link href="/assets/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />

        <link href="/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />

        <script src="/assets/vendor/jquery/jquery.js"></script>

        <script src="/assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

        {{ assets.outputCss() }}
        {{ assets.outputJs() }}
    
    </head>
    <body>
    
    <div id="allpage">        
        <main>
            <div class="container">
                <div class="row widget">
                    <div class="col-md-12">
                        <div class="widget widget-default-about">
                            <div class="widget widget-default-spacer">
                                <div class="spacer spacer20"></div>
                            </div>   
                            <div class="widget-default-content">
                                <div class="widget widget-default-spacer">
                                    <div class="spacer spacer20"></div>
                                </div>   
                                {#{ flash.output() }#}            
                                <h2>Error code: {{ error.getcode() }}</h2>
                                <p>Error message:</p>
                                <p>{{ error.getMessage() }}</p>
                                <div class="widget widget-default-spacer">
                                    <div class="spacer spacer20"></div>
                                </div>   
                            </div>
                            <div class="widget widget-default-spacer">
                                <div class="spacer spacer20"></div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </main>        
    </div>

    {{ partial('../../../layouts/partials/profiler') }}
    
    </body>
</html>