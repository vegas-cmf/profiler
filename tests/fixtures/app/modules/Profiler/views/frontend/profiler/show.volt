<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Profiler</th>
            <th class="options">Data collected</th>
        </tr>
    </thead>
    <tbody>
    {% for name, data in profiler %}
    <tr>
        <td>{{ name }}</td>
        <td class="options">{{ dump(data) }}</td>
    </tr>
    {% endfor %}
    </tbody>
</table>