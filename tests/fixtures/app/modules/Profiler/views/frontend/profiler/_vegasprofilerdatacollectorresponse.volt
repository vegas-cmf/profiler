<table class="table table-bordered table-hover">
  <thead>
    <th>#</th>
    <th>Response header</th>
  </thead>
  <tbody>
   {% for key, val in data %}
   <tr>
     <td>{{ key + 1 }}</td>
     <td>{{ val }}</td>
   </tr>
   {% endfor %}
  </tbody>
</table>