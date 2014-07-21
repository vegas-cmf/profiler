<table class="table table-bordered table-hover">
  <thead>
    <th>Global name</th>
    <th>Value</th>
  </thead>
  <tbody>
   {% for key, val in data %}
   <tr>
     <td>{{ key }}</td>
     <td>{{ dump(val) }}</td>
   </tr>
   {% endfor %}
  </tbody>
</table>