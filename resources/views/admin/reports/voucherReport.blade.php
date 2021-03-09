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
    <!--<p>{!! link_to_route('users.create', trans('coreadmin::admin.users-index-add_new'), [], ['class' => 'btn btn-success']) !!}</p>-->
    @if($data->count() > 0)
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">Merchants List</div>
            </div>
            
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    No of User
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    No of User
                </div>
            </div>
        </div>
            
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable userData">
                    <thead>
                    <tr>
                        <th>Voucher Name</th>
                        <th>Voucher Unique Id</th>
                        <th>Username</th>
                        <th>C Id</th>
                        <th>User Plan</th>
                        <th>Merchant Name</th>
                        <th>Created On</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $key=> $vouchers)
                            @foreach ($vouchers->vocuherDetails as $k => $voucher)
                            <tr>
                                <td>{{ $vouchers->title }}</td>
                                <td>{{ $vouchers->voucher_unique_id }}</td>
                                <td>{{ ($voucher->customerDetails) ? $voucher->customerDetails->name : ""  }}</td>
                                <td>{{ ($voucher->customerDetails) ? $voucher->customerDetails->customer_unique_id : "" }}</td>
                                @if( $voucher->customerDetails )
                                    <td>{{ ($voucher->customerDetails->plan) ? $voucher->customerDetails->plan->title : "" }}</td>
                                @else
                                <td></td>
                                @endif
                                
                                <td>{{ ($vouchers->Offer) ? $vouchers->Offer->title : ""  }}</td>
                                <td>{{ $voucher->created_at }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else
        {{ trans('coreadmin::admin.users-index-no_entries_found') }}
    @endif

@endsection