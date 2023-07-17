<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$invoice->name}}</td>
    <td>{{date('d/m/Y', strtotime($invoice->date))}}</td>
    <td>
        <a href="{{url('incoming_invoice/view', $invoice->id)}}" target="_blank">
            <i class='bx bxs-file-pdf'></i>
        </a>
    </td>
</tr>
