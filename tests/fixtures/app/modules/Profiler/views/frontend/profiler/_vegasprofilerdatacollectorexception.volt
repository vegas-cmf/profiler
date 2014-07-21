<table class="table table-bordered table-hover">
  <thead>
    <th>#</th>
    <th>Code</th>
    <th>File</th>
    <th>Message</th>
    <th>Stacktrace</th>
  </thead>
  <tbody>
   {% for key, val in data %}
   <tr>
     <td>{{ key + 1 }}</td>
     {% for item in val %}
        <td>{{ item|nl2br }}</td>
     {% endfor %}
   </tr>
   {% endfor %}
  </tbody>
</table>