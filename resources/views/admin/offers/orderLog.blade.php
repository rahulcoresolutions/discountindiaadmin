@extends('admin.layouts.master')

@section('content')

@if ($offer->count() > 0)
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
                        <th>Sort</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody id="sortable">
                    @foreach ($offer as $k => $row)
                    
                        @if($row->has('offers'))
                            
                            @if($row->offers->has('title'))
                                <tr data-id="{{ $row->id }}" data-order="{{ $row->order }}">
                                    <td>
                                        {!! Form::checkbox('del-'.$row->id,1,false,['class' => 'single','data-id'=> $row->id]) !!}
                                    </td>
                                    <!--<td>{{ $row->offers->title }}</td>-->
                                    <td>{{ $row->sortId }}</td>
                                    <td>{{ $row->date }}</td>
                                    {{-- <td>{{ $row->fax }}</td> --}}
                                </tr>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-danger" id="delete">
                        {{ trans('coreadmin::templates.templates-view_index-delete_checked') }}
                    </button>
                </div>
            </div>
            
            {!! Form::open(['route' => config('coreadmin.route').'.offers.massDelete', 'method' => 'post', 'id' => 'massDelete']) !!}
                <input type="hidden" id="send" name="toDelete">
            {!! Form::close() !!}
        </div>
	</div>
@else
    {{ trans('coreadmin::templates.templates-view_index-no_entries_found') }}
@endif

@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $( "#sortable" ).sortable({
                update: function( event, ui ) {
                    let trLength = $('#sortable tr').length;
                    let dataId = [];
                    let dataOrder = [];
                    for( let i = 0 ; i <= trLength ; i++){
                        var data_id = $('#sortable tr:nth-child('+i+')').attr('data-id');
                        if(data_id != undefined){
                            dataId.push(data_id);   
                        }
                    }
                    for( let i = 0 ; i <= trLength ; i++){
                        var data_order = $('#sortable tr:nth-child('+i+')').attr('data-order');
                        if(data_order != undefined){
                            dataOrder.push(data_order);   
                        }
                    }
                    console.log(dataId);
                    $.ajax({
                        url: "{{ route('order.sort') }}",
                        type:"POST",
                        data: { _token : $('input[name=_token]').val() , dataId : dataId , dataOrder : dataOrder },
                        success: function(res){
                            console.log(res);
                        }
                    });
                }
            }); 
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