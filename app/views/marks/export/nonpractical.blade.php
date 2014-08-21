<html>
<body>
<table>
    <tr>
        <th width="25">Name</th>
        <th width="10">Roll No</th>
        <th width="16">Unit Test (12)</th>
        <th width="16">Assessment (24)</th>
        <th width="16">Tutorial (10)</th>
        <th width="16">Attendance (4)</th>
        <th width="16">Total (50)</th>
    </tr>
    @foreach ($studentsWithMarks as $swm)
    <tr>
        <td>{{ ucfirst($swm->first_name) }} {{ ucfirst($swm->last_name) }}</td>
        <td>{{ $swm->roll_no }}</td>
        <td>{{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->unit_test }}</td>
        <td>{{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->assessment }}</td>
        <td>{{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->tutorial }}</td>
        <td>{{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->attendance }}</td>
        <td>
            {{ $swm->marks->isEmpty() ? 0 : $total[$swm->id] = $swm->marks[0]->unit_test + $swm->marks[0]->assessment + $swm->marks[0]->tutorial + $swm->marks[0]->attendance }}
            @if (isset($total[$swm->id]) && $total[$swm->id]<25)
                <td style="background-color: #ff0000">NQ</td>
            @endif
        </td>
    </tr>
    @endforeach

</table>
</body>
</html>