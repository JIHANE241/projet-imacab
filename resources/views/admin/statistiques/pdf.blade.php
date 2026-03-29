<h1>Statistiques des Directions</h1>

<table border="1" width="100%">
    <tr>
        <th>Direction</th>
        <th>Offres</th>
        <th>Candidatures</th>
    </tr>

    @foreach($directions as $dir)
    <tr>
        <td>{{ $dir->nom }}</td>
        <td>{{ $dir->offres_count }}</td>
        <td>{{ $dir->candidatures_count }}</td>
    </tr>
    @endforeach

</table>