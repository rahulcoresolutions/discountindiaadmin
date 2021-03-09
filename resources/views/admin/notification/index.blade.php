@extends('admin.layouts.master')

<style type="text/css">
    .red{
        background-color: red !important;
        color: white;

    }
    .yellow{
        background: yellow !important;
        color: white;
    }
</style>
@section('content')
    <p>{!! link_to_route('create.notification', 'Create Notification', [], ['class' => 'btn btn-success']) !!}</p>
    @if($notification->count() > 0)
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">{{ trans('coreadmin::admin.users-index-users_list') }}</div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable">
                    <thead>
                    <tr>
                        <th>Message</th>
                        <th>Status</th>

                        <th>&nbsp;</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($notification as $notif)
                            <tr>
                                <td>{{ $notif->message }}</td>
                                <td>{{ ($notif->status == 1)? "Active" : "De-Activated"}}</td>
                                <td><a href="{{ route('notification.update.status' , $notif->id) }}" class="btn btn-xs {{ ($notif->status == 0)? 'btn-primary' : 'btn-danger' }}">{{ ($notif->status == 1) ? "Deactivate" : "Activate"}}</a></td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else
        {{ trans('coreadmin::admin.users-index-no_entries_found') }}
    @endif

@endsection