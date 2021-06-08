@if(auth()->user()->can('roles.edit') || auth()->user()->can('roles.password') || auth()->user()->can('roles.delete'))
    @can('roles.edit')
        <a href="{{ route('roles.edit', ['id' => $id_hash]) }}" class="btn btn-outline-success btn-elevate-hover btn-circle btn-icon btn-sm" title="تعديل">
            <i class="la la-edit"></i>
        </a>
    @endcan
    @can('roles.permissions')
        <a href="{{ route('roles.permissions',[ 'id' => $id_hash]) }}" class="btn btn-outline-info btn-elevate-hover btn-circle btn-icon btn-sm" title="الصلاحيات">
            <i class="fa fa-lock"></i>
        </a>
    @endcan
    @can('roles.delete')
        <a href="javascript:;" data-url="{{ route('roles.delete', ['id' => $id_hash]) }}" class="btn btn-outline-danger btn-elevate-hover btn-circle btn-icon btn-sm delete_btn" title="حذف">
            <i class="la la-trash"></i>
        </a>
    @endcan
@endif
