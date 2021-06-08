@if(auth()->user()->can('lawsuits.show') || auth()->user()->can('lawsuits.edit') || auth()->user()->can('lawsuits.archive') || auth()->user()->can('lawsuits.delete'))
    @can('lawsuits.show')
        <a href="{{ route('lawsuits.logs',$id) }}" class="btn btn-outline-primary btn-elevate-hover btn-circle btn-icon btn-sm" title="درجات التقاضي">
            <i class="la la-list"></i>
        </a>
    @endcan
    @can('lawsuits.edit')
        <a href="{{ route('lawsuits.edit',$id) }}" class="btn btn-outline-success btn-elevate-hover btn-circle btn-icon btn-sm" title="تعديل">
            <i class="la la-edit"></i>
        </a>
    @endcan
    @can('lawsuits.archive')
        <a href="javascript:;"  data-url="{{ route('lawsuits.archive',  $id ) }}"  class="btn btn-outline-info btn-elevate-hover btn-circle btn-icon btn-sm archive_btn" title="{{$archive_btn_title}}">
            <i class="fa {{$archive_btn_icon}}"></i>
        </a>
    @endcan
    @can('lawsuits.delete')
        <a href="javascript:;" data-url="{{ route('lawsuits.delete',  $id ) }}" class="btn btn-outline-danger btn-elevate-hover btn-circle btn-icon btn-sm delete_btn" title="حذف">
            <i class="la la-trash"></i>
        </a>
    @endcan
@endif
