@extends('templates.crud_template')


@section('crud_form')

    <h1 class="page-header">Submit a Service Report</h1>

    <p>Please provide the following information. When adding brothers/pledges to this report, please add the name of the
        of the person submitting the form as well. This service report is submitted to the Membership VP, who keeps
        track of all service hours.</p>

    <p>If you are unfamilar with the service hours guidelines they can be found here.</p>

    <p>Contact the Membership VP with any questions at membership@apo.case.edu</p>

    <create_service_report_form inline-template>
        {!! Form::open(['route'=>['report_store','type'=>'service_reports'],'class'=>'collapse in form-horizontal','v-el'=>'iform']) !!}

        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('display_name','Project Name') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-10">
                {!! Form::text('display_name', null, ['class'=>'form-control','v-model'=>'form.display_name']) !!}
            </div>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('description','Description') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-10">
                {!! Form::textarea('description', null, ['class'=>'form-control','v-model'=>'form.description']) !!}
            </div>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
        </div>

        <div class="form-group">
            <div class="col-md-2 control-label">
                {!! Form::label('event_date','Date') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-md-4">
                {!! Form::input('date','event_date', null, ['class'=>'form-control','v-model'=>'form.event_date']) !!}
            </div>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>

            <div class="col-md-2 control-label">
                {!! Form::label('location','Project Location') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-md-4">
                {!! Form::text('location', null, ['class'=>'form-control','v-model'=>'form.location']) !!}
            </div>
            <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
        </div>
        <div class="form-group">

        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('project_type','Project Type') !!}
                <p class="help-block"></p>
            </div>
            <div class="col-sm-4">
                {!! Form::select('project_type',['inside'=>'Inside','outside'=>'Outside'] ,'inside', ['class'=>'form-control','v-model'=>'form.project_type']) !!}
            </div>
            <div class="col-sm-2 control-label">
                {!! Form::label('service_type','Type of Service') !!}
                <p class="help-block"></p>
                <!-- <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span> -->
            </div>
            <div class="col-sm-4">
                {!! Form::select('service_type', [
                'chapter'=>'Service to the Chapter',
                'campus'=>'Service to the Campus',
                'community'=>'Service to the Community',
                'country'=>'Service to the Community'
                ],null, ['class'=>'form-control','v-model'=>'form.service_type']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">
                {!! Form::label('off_campus','Off Campus') !!}
                <p class="help-block"></p></div>
            {{--<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>--}}
            <div class="col-sm-4">{!! Form::select('off_campus', ['0'=>'No','1'=>'Yes'], '0' ,['class'=>'form-control','v-model'=>'form.off_campus']) !!}</div>

            <div class="col-sm-2 control-label">
                {!! Form::label('travel_time','Travel Time') !!}
                <p>(Minutes)</p>

                <p class="help-block"></p></div>
            {{--<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>--}}
            <div class="col-sm-4">{!! Form::text('travel_time', null, ['class'=>'form-control','v-model'=>'form.travel_time', 'v-attr'=>'disabled : allowTravelTime ']) !!}</div>
        </div>


        <h2>Brothers in Report</h2>
        <input type="text" placeholder="Search for a Brother..." class="typeahead form-control">

        <!-- Brothers listing -->
        <table class="table table-hover">
            <thead>
                <th>Brother</th>
                <th>CWRU ID</th>
                <th>Hours</th>
                <th>Driver?</th>
            </thead>
            <tbody>
                <tr v-repeat="brother: form.brothers">
                    <td>@{{ brother.name }}</td>
                    <td>@{{ brother.id }}</td>
                    <td>@{{ brother.hours }}</td>
                    <td>@{{ brother.isDriver }}</td>
                </tr>
            </tbody>
        </table>

        <br>
        <br>

        <div class="form-group">
            {!! Form::submit('Create Contract', ['class'=>'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}
    </create_service_report_form>

@endsection