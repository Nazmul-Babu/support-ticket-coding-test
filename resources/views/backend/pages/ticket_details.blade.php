@extends('backend.includes.admin_layout')
@push('css')
@endpush
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class=" text-center mb-2">Ticket Details</h3>
                        @if (session('success'))
                            <div style="width:100%" class="alert alert-primary alert-dismissible fade show" role="alert">
                                <strong> Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="btn-close"></button>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Failed!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="btn-close"></button>
                            </div>
                        @endif
                        <div class="ticket_info_box p-2 text-center" style="box-shadow: 1px 1px 10px 1px #0c1427">
                            <h3>Title : {{ $data['ticket']->title }}</h3>
                            <p>Status : @if ($data['ticket']->status == 1)
                                    <span class="badge bg-success">Open</span>
                                @else
                                    <span class="badge bg-danger">Closed</span>
                                @endif
                            </p>
                        </div>
                        <h6 class="p-3 text-center">Ticket Responses</h6>
                        @foreach ($data['ticket_details'] as $single_response)
                            <div>
                                @if ($single_response->roll == 'admin')
                                    <p>Administrator ({{ date('d M Y', strtotime($single_response->created_at)) }})</p>
                                @else
                                    <p>You ({{ date('d M Y', strtotime($single_response->created_at)) }})</p>
                                @endif
                                <p>{{ $single_response->response }}</p>
                            </div>
                        @endforeach
                        @if ($data['ticket']->status == 1)
                            <div class="mt-3">
                                <button class="btn btn-success" id="add_new_response">Add new Response <i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                            <div id="form_box" class="mt-3" style="display:none">
                                <form action="{{ route('ticket.details', $data['ticket']->id) }}" method="post">
                                    @csrf
                                    <label for="" class="form-label">New Response</label>
                                    <textarea name="response" class="form-control" id="" cols="10" rows="5"
                                        placeholder="Write Your Reply"></textarea>
                                    <div class="text-center mt-2">
                                        <button class="btn btn-xs btn-success" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $("#add_new_response").on('click', function() {
                var form_box = document.getElementById("form_box")
                if (form_box.style.display === 'none') {
                    form_box.style.display = 'block';
                } else {
                    form_box.style.display = 'none';

                }
            })
        });
    </script>
@endpush
