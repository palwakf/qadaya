@if(auth()->user()->can('types.edit') || auth()->user()->can('types.destroy') )
    @can('types.edit')
        <a href="{{ route('types.edit',$id) }}" class="btn btn-outline-success btn-elevate-hover btn-circle btn-icon btn-sm" title="تعديل">
            <i class="la la-edit"></i>
        </a>
    @endcan
    @can('types.destroy')
        <a href="javascript:;" data-url="{{ route('types.destroy',  $id ) }}" class="btn btn-outline-danger btn-elevate-hover btn-circle btn-icon btn-sm delete_btn" title="حذف">
            <i class="la la-trash"></i>
        </a>
    @endcan
@endif
