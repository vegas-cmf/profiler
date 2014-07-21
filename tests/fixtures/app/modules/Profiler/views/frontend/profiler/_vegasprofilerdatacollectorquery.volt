<table class="table table-bordered table-hover">
  <thead>
    <th>#</th>
    <th>Time elapsed [s]</th>
    <th>Query string</th>
  </thead>
  <tbody>
   {% for key, val in data['queries'] %}
   <tr>
     <td>{{ key + 1 }}</td>
     <td>{{ val['time'] }}</td>
     <td>{{ val['query'] }}</td>
   </tr>
   {% endfor %}
  </tbody>
</table>