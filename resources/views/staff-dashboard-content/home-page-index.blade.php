@extends('staff-dashboard-layout.dashboard-template')

@section('dashboard-staff-content')


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="errorBox" style="text-align:center;margin-top:20px;"
                class="alert alert-danger col-md-12 alert-dismissible fade show" role="alert">
                <strong style="color:white;">{!! $error !!}</strong>
                <button type="button" style="color:white;" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </button>
            </div>

            <script>
                window.onload = function() {

                    $("#errorBox").delay(3000).fadeOut("slow");

                }
            </script>
        @endforeach
    @endif


    @if (session()->has('message'))
        <div id="successBox" style="text-align:center;margin-top:20px;"
            class="alert alert-success col-md-12 alert-dismissible fade show" role="alert">
            <strong> {{ session()->get('message') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <script>
            setTimeout(
                function() {
                    $("#successBox").delay(3000).fadeOut("slow");

                }, 1000);
        </script>
    @endif


    <div class="card">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;">Requesting for leave</h3>
            <br>

            <form action="/insert-leave-data-of-staff-account" method="POST" enctype=”multipart/form-data>
                @csrf

                <div class="form-group row">
                    <label for="type_of_leave" class="col-sm-2 col-form-label">Type of Leave</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="type_of_leave" id="type_of_leave"
                            aria-label="Default select example" required>
                            <option selected disabled>Select a leave type</option>
                            <option value="Sick leave">Sick leave</option>
                            <option value="Casual leave">Casual leave</option>
                            <option value="Onduty External">Onduty External</option>
                            <option value="Onduty Internal">Onduty Internal</option>
                            {{-- <option value="Paternity leave">Paternity leave</option>
              <option value="Bereavement leave">Bereavement leave</option>
              <option value="Compensatory leave">Compensatory leave</option>
              <option value="Sabbatical leave">Sabbatical leave</option>
              <option value="Unpaid Leave">Unpaid Leave</option> --}}

                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-8">

                        <textarea class="form-control" name="description" id="description" placeholder="Enter the description" required></textarea>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="from_date" class="col-sm-2 col-form-label">From Date</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                    </div>
                    <label for="to_date" class="col-sm-2 col-form-label">To Date</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="file" class="col-sm-2 col-form-label">Proof</label>
                    <div class="col-sm-8">

                        <input class="form-control" name="file" id="file" placeholder="Enter Drive Link" required autocomplete="off"/>

                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-3">
                        Session
                    </div>
                    <div class="form-check col-2">
                        <input class="form-check-input" type="radio" name="session" id="session" value="FN">
                        <label class="form-check-label" for="session">
                            FN
                        </label>
                    </div>

                    <div class="form-check col-2">
                        <input class="form-check-input" type="radio" name="session" id="session" value="AN">
                        <label class="form-check-label" for="session">
                            AN
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="session" id="session" value="Full Day">
                        <label class="form-check-label" for="session">
                            Full Day
                        </label>
                    </div>
                    <br>
                    <br>


                </div>

                <div class="form-group row">
                    <label style="visibility:hidden;" for="button" class="col-sm-2 col-form-label">button</label>
                    <div class="col-sm-8">
                        <input class="btn btn-primary col-md-2 col-sm-12" value="Submit" id="button" type="submit">
                    </div>
                </div>

            </form>

        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <h3 class="panel-title" style="text-align:center;">My Pending Requests</h3>
            <br>

            @foreach ($leave_pending_data as $key => $data)
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header bg-dark ">
                        From Date: <strong>{{ $data->from_date }}</strong><br>To
                        Date:<strong>{{ $data->to_date }}</strong><br>Session: <strong>{{ $data->session }}</strong>
                        <i class="float-right" style="font-size:85%;">Request sent on :- {{ $data->date_of_request }}</i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $data->type_of_leave }}</h5>
                        <p class="card-text">{{ $data->description }}</p>
                        <a href="{{$data->proof}}" style="color:yellow"><p class="card-text">View Proof</p></a>
                        <a class="btn btn-danger float-right confirmation"
                            href="/delete-leave-pending-request-in-staff-account/{{ $data->auto_id }}">Delete Request</a>
                    </div>
                </div>
            @endforeach



        </div>
    </div>



@endsection

<script>
    window.onload = function() {

        $(".nav-item:eq(0)").addClass("active");

        $('.confirmation').on('click', function() {
            return confirm('Are you sure to delete?');
        });

    }
</script>
