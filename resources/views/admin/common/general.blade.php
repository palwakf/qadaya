window.base_url = "{{ asset('/') }}";
window.prefix = "";  {{-- previous prefix = admin --}}
{{--window.delete_confirmation_title = "{{ trans('general.delete_confirmation_title') }}";--}}
{{--window.delete_confirmation_message = "{{ trans('general.delete_confirmation_message') }}";--}}
{{--window.confirm_label = "{{ trans('general.confirm_label') }}";--}}
{{--window.cancel_label = "{{ trans('general.cancel_label') }}";--}}
{{--/////////////////////////////////////////////////////////--}}
window.admin_url = "{{ route('dashboard.view') }}";
{{--window.users_list = "{{ route('admin.users.list') }}";--}}
{{--/////////////////////////////////////////////////////////--}}
window.dashboard_view = "{{ route('dashboard.view') }}";
{{--window.dashboard_profile = "{{ route('admin.dashboard.profile') }}";--}}
{{--window.dashboard_password = "{{ route('admin.dashboard.password') }}";--}}
{{--/////////////////////////////////////////////////////////--}}
{{--window.disconnect_confirmation_title = "{{ trans('general.disconnect_confirmation_title') }}";--}}
{{--window.disconnect_confirmation_message = "{{ trans('general.disconnect_confirmation_message') }}";--}}
