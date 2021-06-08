@if(auth()->user()->can('courts.edit') || auth()->user()->can('courts.destroy') )
    @can('courts.edit')
        <a href="{{ route('courts.edit',$id) }}" class="btn btn-outline-success btn-elevate-hover btn-circle btn-icon btn-sm" title="تعديل">
            <i class="la la-edit"></i>
        </a>
    @endcan
    @can('courts.destroy')
        <a href="javascript:;" data-url="{{ route('courts.destroy',  $id ) }}" class="btn btn-outline-danger btn-elevate-hover btn-circle btn-icon btn-sm delete_btn" title="حذف">
            <i class="la la-trash"></i>
        </a>
    @endcan
@endif
