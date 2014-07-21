<table class="table table-bordered table-hover">
  <thead>
    <th>Name</th>
    <th>Data collected</th>
  </thead>
  <tbody>
   {% for key, val in data %}
   <tr>
     <td>{{ key|capitalize }}</td><td>{% if val is type('array') %}{{ val|join(', ') }}{% else %}{{ val }}{% endif %}</td>
   </tr>
   {% endfor %}
  </tbody>
</table>