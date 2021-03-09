@extends('admin.layouts.master')

@section('content')

{{-- <p>{!! link_to_route(config('coreadmin.route').'.vouchers.create', trans('coreadmin::templates.templates-view_index-add_new') , null, array('class' => 'btn btn-success')) !!}</p> --}}

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
                        <th>Title</th>
                        <th>Belongs To</th>
                        <th>Valid Date</th>
                        <th>Terms and Condition</th>
                        <th>voucher Id</th>
                        {{-- <th>Discount</th>
                        <th>voucher type</th>
                        <th>Voucher Template</th> --}}

                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($vouchers as $row)
                        <tr>
                            <td>
                                {!! Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]) !!}
                            </td>
                            <td>{{ $row->title }}</td>
                            <td>{{ $row['Offer']['title'] }}</td>
                            <td>{{ $row->valid_date }}</td>
                            <td>{{ $row->terms_condition }}</td>
                            <td>{{ $row->voucher_unique_id }}</td>

                            <td>
                                {!! link_to_route(config('coreadmin.route').'.vouchers.edit', trans('coreadmin::templates.templates-view_index-edit'), array($row->id), array('class' => 'btn btn-xs btn-info')) !!}
                                {{-- {!! Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'onsubmit' => "return confirm('".trans("coreadmin::templates.templates-view_index-are_you_sure")."');",  'route' => array(config('coreadmin.route').'.vouchers.destroy', $row->id))) !!}
                                {!! Form::submit(trans('coreadmin::templates.templates-view_index-delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                {!! Form::close() !!} --}}
                                <a href="{{ route('voucher.clone',$row->id)  }}" class="btn btn-xs btn-primary">Clone</a> 
                                <a href="javascript:;" class="btn btn-success btn-xs openModal" data-attr="{{ $row->id }}">share</a>
                                @if( $row->status == 1)
                                    <a href="{{ route('change.voucher.deactivate' , $row->id) }}" class="btn btn-warning btn-xs" >De-activate</a>
                                @else
                                    <a href="{{ route('change.voucher.activate' , $row->id) }}" class="btn btn-info btn-xs" >Activate</a>
                                @endif
                            </td>
                        </tr>
                        <input type="hidden" name="voucherId" class="voucher_id" value="{{ $row->voucher_unique_id }}">
                    @endforeach
                </tbody>
            </table>

            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <form action="{{ route('share.voucher') }}" method="POST">
                            <h4 class="modal-title">Share with user</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="voucherId" value="" class="voucherId">
                            <input type="hidden" name="userId" value="">

                            <div class="row-fluid">

                                <select class="selectpicker" data-show-subtext="true" data-live-search="true" name="userId  ">
                                    @foreach( $user as $k => $v )
                                        <option data-subtext="{{ $v->name }} ({{ $v->mobile }})" value="{{ $v->id }}">{{ $v->name }} ({{ $v->mobile }})</option>
                                    @endforeach
                                </select>
                                <div >
                                    <label for="amount">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Expire date</label>
                                <input type="date" name="expiredDate" class="form-control" min="<?php echo date("Y-m-d"); ?>" id="exampleFormControlSelect1">
                            </div>
                        </div>
                        <div class="modal-footer">
                                <input type="submit" name="submit" value="submit" class="btn btn-default">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-danger" id="delete">
                        {{ trans('coreadmin::templates.templates-view_index-delete_checked') }}
                    </button>
                </div>
            </div>
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
            $(document).on('click', '.openModal',function(){
                let voucherId = $(this).attr('data-attr');
                $('.voucherId').val(voucherId);
                $('#myModal').modal('show'); 
            });
            $('.selectpicker').on('change', function(){
                var selected = '';
                selected = $('.selectpicker').val()
                $('input[name=userId]').val(selected);
            });
        });
    </script>
@stop