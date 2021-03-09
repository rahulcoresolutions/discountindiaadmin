@extends('admin.layouts.master')

@section('content')
<style type="text/css">
    .expired{
        background: wheat !important
    }
</style>



    @if ($listVouchers->count())
        <div>
            <p><div class="expired" style="height: 20px;width: 20px;float: left"></div>&nbsp; Expired</p>
        </div>

        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">{{ trans('coreadmin::templates.templates-view_index-list') }}</div>
            </div>
            <div class="portlet-body">
                <table id="userDatatable" class="table table-striped table-hover table-responsive datatable userData">
                    <thead>
                        <tr>
                            <th>
                                {!! Form::checkbox('delete_all',1,false,['class' => 'mass']) !!}
                            </th>
                            <th>Title</th>
                            <th>Voucher Unique Id</th>
                            <th>Merchant</th>
                            <th>No. of redeem</th>
                        </tr>
                    </thead>
    
                    <tbody>
                        @foreach ($listVouchers as $row)
                            <tr class="{{ $row->valid_date <= date('Y-m-d') ? 'expired' : '' }}" >
                                <td>
                                    {!! Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]) !!}
                                </td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->voucher_unique_id }} </td>
                                @if($row->Offer != null)
                                    <td>{{ $row->Offer->title }} </td>  
                                @else
                                    <td>Merchant Deleted</td>
                                @endif
                                <td>{{ count($row->vocuherDetails) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! Form::open(['route' => config('coreadmin.route').'.vouchers.massDelete', 'method' => 'post', 'id' => 'massDelete']) !!}
                    <input type="hidden" id="send" name="toDelete">
                {!! Form::close() !!}
            </div>
    	</div>
    @else
        {{ trans('coreadmin::templates.templates-view_index-no_entries_found') }}
    @endif







<p>{!! link_to_route('create.paid.voucher', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')) !!}</p>

@if ($vouchers->count())
        <div>
            <p><div class="expired" style="height: 20px;width: 20px;float: left"></div>&nbsp; Expired</p>
        </div>

    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">{{ trans('coreadmin::templates.templates-view_index-list') }}</div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-hover table-responsive datatable" id="datatable">
                <thead>
                    <tr>
                        <th>
                            {!! Form::checkbox('delete_all',1,false,['class' => 'mass']) !!}
                        </th>
                        <th>Title</th>
                        <th>Terms and Condition</th>
                        <th>Image</th>
                        <th>From</th>
                        <th>Valid Date</th>
                        <th>voucher Id</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vouchers as $row)
                        <tr class="{{ $row->valid_date <= date('Y-m-d') ? 'expired' : '' }}" >
                            <td>
                                {!! Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]) !!}
                            </td>
                            <td>{{ $row->title }}</td>
                            <td>{{ $row->terms_condition }}</td>
                            <td>
                                @if($row->fileName != null)
                                    <img src="{{ asset('voucher/images/'.$row->fileName ) }}" style="width: 70px;height: 70px;">
                                @else
                                    ---- 
                                @endif
                            </td>
                            <td>{{ ($row->offer ) ? $row->offer->title : '' }}</td>
                            <td>{{ $row->valid_date }}</td>
                            <td>{{ $row->voucher_unique_id }}</td>
                            <td><a href="{{ route('edit.paid.voucher' , $row->id) }}" class="btn btn-primary btn-xs">Edit</a> | <a href="{{ route('delete.paid.voucher' , $row->id) }}" class="btn btn-danger btn-xs">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! Form::open(['route' => config('coreadmin.route').'.vouchers.massDelete', 'method' => 'post', 'id' => 'massDelete']) !!}
                <input type="hidden" id="send" name="toDelete">
            {!! Form::close() !!}
        </div>
	</div>
@else
    {{ trans('coreadmin::templates.templates-view_index-no_entries_found') }}
@endif

@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $('#delete').click(function () {
                if (window.confirm('{{ trans('coreadmin::templates.templates-view_index-are_you_sure') }}')) {
                    var send = $('#send');
                    var mass = $('.mass').is(":checked");
                    if (mass == true) {
                        send.val('mass');
                    } else {
                        var toDelete = [];
                        $('.single').each(function () {
                            if ($(this).is(":checked")) {
                                toDelete.push($(this).data('id'));
                            }
                        });
                        send.val(JSON.stringify(toDelete));
                    }
                    $('#massDelete').submit();
                }
            });
        });
    </script>
@stop