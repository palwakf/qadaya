
@if(auth()->user()->can('logs.show') || auth()->user()->can('logs.edit') || auth()->user()->can('logs.delete')|| auth()->user()->can('lawsuits.show') || auth()->user()->can('lawsuits.edit') || auth()->user()->can('lawsuits.delete'))
    @if(auth()->user()->can('logs.show') || auth()->user()->can('lawsuits.show'))
        <a href="{{ route('lawsuits.show',[$kind,$id]) }}" class="btn btn-outline-info btn-elevate-hover btn-circle btn-icon btn-sm" title="درجات التقاضي">
            <i class="la la-eye"></i>
        </a>
    @endif
    @if((auth()->user()->can('logs.edit') || auth()->user()->can('lawsuits.edit')) && $has_action)
        <a href="{{ $edit_route }}" class="btn btn-outline-success btn-elevate-hover btn-circle btn-icon btn-sm" title="تعديل">
            <i class="la la-edit"></i>
        </a>
    @endif

    @if((auth()->user()->can('logs.delete') || auth()->user()->can('lawsuits.delete'))&& $has_action)
        <a href="javascript:;" data-url="{{ $delete_route}}" class="btn btn-outline-danger btn-elevate-hover btn-circle btn-icon btn-sm delete_log_btn" title="حذف">
            <i class="la la-trash"></i>
        </a>
    @endif
@endif
