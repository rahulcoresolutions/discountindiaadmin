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
    .hide{
        display: none;
    }
</style>

@section('content')
    <p>{!! link_to_route('users.create', trans('coreadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']) !!}</p>
    @if($users->count() > 0)
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Merchants List</div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable userData">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Category</th>
                        <th>Vouchers</th>
                        <th>Redeemed Vouchers</th>
                        <th>Created On</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->offers->categoryDetails->name }}</td>                                
                                <td>{{ count($user->offers->vouchers) }}</td>
                                <td>{{ $user->userRedeemedVouchers }}</td>
                                <td>{{ $user->created_at }}</td>
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