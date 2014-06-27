$(document).ready(function(){
    $('#vegas-profiler')
            .load('/profiler/' + $('#vegas-profiler').data('request'));
});