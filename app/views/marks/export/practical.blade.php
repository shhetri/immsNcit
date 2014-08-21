<html>
<body>
<table>
    <tr>
        <th width="25">Name</th>
        <th width="10">Roll No</th>
        <th width="16">Unit Test (7)</th>
        <th width="16">Assessment (14)</th>
        <th width="16">Tutorial (6)</th>
        <th width="16">Attendance (3)</th>
        <th width="16">Theory Total (30)</th>
        <th width="16">Practical (20)</th>
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
        <td>{{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->unit_test + $swm->marks[0]->assessment + $swm->marks[0]->tutorial + $swm->marks[0]->attendance }}</td>
        <td>{{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->practical }}</td>
        <td>
            {{ $swm->marks->isEmpty() ? 0 : $swm->marks[0]->unit_test + $swm->marks[0]->assessment + $swm->marks[0]->tutorial + $swm->marks[0]->attendance + $swm->marks[0]->practical }}
            @if ( ! $swm->marks->isEmpty())
                @if (($swm->marks[0]->unit_test + $swm->marks[0]->assessment + $swm->marks[0]->tutorial + $swm->marks[0]->attendance)<15 || $swm->marks[0]->practical<12)
                    <td style="background-color: #ff0000">NQ</td>
                @endif
            @endif
        </td>
    </tr>
    @endforeach

</table>
</body>
</html>