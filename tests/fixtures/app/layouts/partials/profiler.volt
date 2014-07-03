{#
    // Include this template inside the main layout to enable profiler
    // TODO use separate JS/CSS files for each profiler data collector?
#}
<div id="vegas-profiler" data-request="{{ profilerRequestId }}"></div>

<script type="text/javascript">
    $(document).ready(function(){
        var profilerUrl = "{{ url.get(['for':'profiler', 'requestId':'__REQ__']) }}"
                .replace(/__REQ__/, $('#vegas-profiler').data('request'));
        
        $('#vegas-profiler').load(profilerUrl);
    });
</script>