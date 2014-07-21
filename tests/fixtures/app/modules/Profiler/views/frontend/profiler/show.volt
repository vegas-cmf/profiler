<!-- Nav tabs -->
<ul class="nav nav-tabs">
{% for name, data in profiler %}
  <li><a href="#{{ name|stripslashes }}" data-toggle="tab">{{ name }}</a></li>
{% endfor %}
</ul>

<!-- Tab panes -->
<div class="tab-content">
{% for name, data in profiler %}
  <div class="tab-pane fade" id="{{ name|stripslashes }}">
    {{ partial('frontend/profiler/_' ~ name|lower|stripslashes, ['data': data]) }}
  </div>
{% endfor %}
</div>