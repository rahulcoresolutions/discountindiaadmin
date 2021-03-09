@extends('admin.layouts.master')

@section('content')

<p>{!! link_to_route('create.paid.voucher', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')) !!}</p>

@if ($vouchers->count())

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
                        <th>Voucher Id</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Voucher Title</th>
                        <th>Expired On</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vouchers as $row)
                        @if($row->user != null)
                            <tr>
                                <td>
                                    {!! Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]) !!}
                                </td>
                                <td>{{ $row->voucherId }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->user->mobile }}</td>
                                <td>{{ $row->voucherDetails->title }}</td>
                                <td>{{ $row->expiredDate }}</td>
                                <td>{{ ($row->status == 1) ? "Not yet used" : 'Used' }}</td>
                            </tr>
                        @endif
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