@extends('admin.layout.master')

@section('title')
	تغيير كلمة المرور
@stop

@section('css')

@stop

@section('subheader')
    <a href="{{ route('dashboard.password') }}" class="kt-subheader__breadcrumbs-link">
        كلمة المرور
    </a>
@stop


@section('content')
	<!-- begin:: Content -->
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet">
				<div class="kt-portlet__head">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">
							كلمة المرور
						</h3>
					</div>
				</div>
				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" id="frmChangeMyPassword" method="post" action="{{ route('dashboard.password') }}">
					<div class="kt-portlet__body">
						<div class="form-group row">
							<div class="col-lg-6">
								<label>كلمة المرور:</label>
								<input type="password" class="form-control" name="password" placeholder="كلمة المرور">
							</div>
							<div class="col-lg-6">
								<label class="">تأكيد كلمة المرور:</label>
								<input type="password" class="form-control" name="password_confirmation" placeholder="تأكيد كلمة المرور">
							</div>
						</div>
					</div>
					<div class="kt-portlet__foot">
						<div class="kt-form__actions">
							<div class="row">
								<div class="col-lg-6 kt-align-right">
									<button type="submit" class="btn btn-brand save">حفظ</button>
									<a href="{{ route('dashboard.view') }}" class="btn btn-secondary">الغاء</a>
								</div>
							</div>
						</div>
					</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
		</div>
	</div>
	<!-- End:: Content -->
@stop

@section('js')
	<script src="assets/admin/general/js/scripts/dashboard.js" type="text/javascript"></script>
@stop
