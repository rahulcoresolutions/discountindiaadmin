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
    <p>{!! link_to_route('users.create', trans('coreadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']) !!}</p>
    @if($users->count() > 0)
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">{{ trans('coreadmin::admin.users-index-users_list') }}</div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ trans('coreadmin::admin.users-index-name') }}</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Mobile</th>
                        <th>Customer ID</th>
                        <th>Expired On</th>

                        <th>&nbsp;</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr class="{{ ($user->status == 0 && $user->role_id != 3 && $user->id != 1)? 'red' : 'tr' }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                @if($user->plan != null || $user->plan != 'null' && $user->plan['title'] )
                                    <td>{{ $user->plan['title'] }}</td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->customer_unique_id }}</td>
                                <td>{{ $user->expired_on }}</td>
                                <td>
                                    {!! link_to_route('users.edit', trans('coreadmin::admin.users-index-edit'), [$user->id], ['class' => 'btn btn-xs btn-info']) !!}
                                    {!! Form::open(['style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => 'return confirm(\'' . trans('coreadmin::admin.users-index-are_you_sure') . '\');',  'route' => array('users.destroy', $user->id)]) !!}
                                    {!! Form::submit(trans('coreadmin::admin.users-index-delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @if( $user->status == 0 && $user->role_id != 3 && $user->id != 1)
                                        <a href="{{ route('change.status', $user->id ) }}">Active</a>
                                    @endif
                                    @if( $user->status == 1 && $user->role_id != 3 && $user->id != 1)
                                        <a href="{{ route('deacativate.status', $user->id ) }}">Deactive</a>
                                    @endif
                                    {{-- <a href="{{ route('get.user.plan' , $user->id) }}">Change Plan</a> --}}
                                </td>
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