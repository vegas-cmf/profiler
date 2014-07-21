<table class="table table-bordered table-hover">
  <thead>
    <th>Request header</th>
    <th>Value</th>
  </thead>
  <tbody>
   {% for key, val in data %}
   <tr>
     <td>{{ key }}</td>
     <td>{{ val }}</td>
   </tr>
   {% endfor %}
  </tbody>
</table>