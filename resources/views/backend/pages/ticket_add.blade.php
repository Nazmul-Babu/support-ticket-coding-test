@extends('backend.includes.admin_layout')
@push('css')
@endpush
@section('content')
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class=" text-center mb-2">Ticket Add</h3>
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
                        <form action="{{ route('ticket.add') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="issue_date" class="form-label">Issue Date *</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" name="issue_date" value="{{ date('Y-m-d') }}" id="news_date"
                                            class="form-control" placeholder="Select date" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i
                                                data-feather="calendar"></i></span>
                                    </div>
                                </div>                     
                                <div class="col-md-9 mb-3">
                                    <label for="issue_date" class="form-label">Title *</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid  @enderror" placeholder="Enter Ticket Name"  required>                               
                                </div>                          
                                <div class="col-md-12 mb-3">
                                    <label for="issue_date" class="form-label">Details*</label>
                                    <textarea class="form-control @error('response') is-invalid  @enderror" name="response" rows="3" placeholder="Enter Ticket Details" required></textarea>
                                </div>
                            <div class="text-center mt-2">
                                <button class="btn btn-xs btn-primary" type="submit">Add</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


