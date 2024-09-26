@extends('backend.includes.admin_layout')
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class=" mb-2" style="text-align:center">
                            <h3>Ticket List</h3>
                        </div>
                        <div class="mt-3">
                            @if (session('error'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Failed!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="btn-close"></button>
                                </div>
                            @endif
                            <div id="success"></div>
                            <div id="failed"></div>
                        </div>
                        <div class="table-responsive" id="print_data">
                            <table id="dataTableExample" class="table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="">SL</th>
                                        <th style="">Issue Date</th>
                                        <th style="width:40%">Ticket Title</th>
                                        <th style="">Status</th>

                                        <th style="15%">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['ticket_list'] as $key => $single_ticket)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                {{ date('d M Y', strtotime($single_ticket->issue_date)) }}

                                            </td>
                                            <td>
                                                {{ $single_ticket->title }}

                                            </td>
                                            <td>
                                                @if (Auth::user()->roll == 'admin')
                                                    <select  class="form-select"
                                                        onchange="change_status({{ $single_ticket->id }})"
                                                        id="ticket_status_{{ $single_ticket->id }}"
                                                        style="width: 100px !important">
                                                        <option @if ($single_ticket->status == 1) selected @endif
                                                            value="1">Open</option>
                                                        <option @if ($single_ticket->status == 2) selected @endif
                                                            value="2">Closed</option>
                                                    </select>
                                                @else
                                                    @if ($single_ticket->status == 1)
                                                        <span class="badge bg-primary">Open</span>
                                                    @else
                                                        <span class="badge bg-danger">Closed</span>
                                                    @endif
                                                @endif
                                            </td>


                                            <td style="display: flex">
                                                <a href="{{ route('ticket.details', $single_ticket->id) }}"
                                                    class="btn btn-success btn-icon" href=""><i
                                                        class="fa-solid fa-eye"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function change_status(ticket_id) {
                var status = $("#ticket_status_" + ticket_id).val();
                $.ajax({
                    url: "/ticket-status/",
                    type: "POST",
                    data:{
                        "_token" : '{{ csrf_token() }}',
                        'ticket_id' : ticket_id,
                        'status' : status
                    },
                    success:function(data){
                        if(data.status == true){
                            alert("Status Changed");
                        }
                    }
                })
        }
    </script>
@endpush
