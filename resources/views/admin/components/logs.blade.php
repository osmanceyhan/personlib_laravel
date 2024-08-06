<table class="table table-centered datatable dt-responsive  table-card-list" style="border-collapse: collapse; border-spacing: 0 12px; width: 100%;">
<thead>
    <tr>
        <th>Tarih</th>
        <th>İşlem Açıklaması</th>
        <th>İşlemi Yapan</th>
        <th>İşlem Türü</th>
    </tr>
    </thead>
    <tbody>
    @foreach($logs as $value)
        <tr>
            <td>{{showDateTime($value->created_a)}}</td>
            <td>{{$value->description}}</td>
            <td>{!! getLogCauser($value) !!}</td>
            <td>{!! getLogType($value) !!}</td>


        </tr>
    @endforeach
    </tbody>
</table>
