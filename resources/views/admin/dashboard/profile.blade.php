@extends('admin.layout.master')

@section('title')
	تعديل البروفايل
@stop

@section('css')

@stop

@section('subheader')
    <a href="{{ route('dashboard.profile') }}" class="kt-subheader__breadcrumbs-link">
        البروفايل
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
							البروفايل
						</h3>
					</div>
				</div>
				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" id="frmMyProfile" method="post" action="{{ route('dashboard.profile') }}">
					<div class="kt-portlet__body">
						<div class="form-group row">
							<div class="col-lg-4">
								<label>إسم المستخدم:</label>
								<input type="text" class="form-control" value="{{ $info->username }}" placeholder="إسم المستخدم" readonly>
							</div>
							<div class="col-lg-4">
								<label>الإسم:</label>
								<input type="text" class="form-control" name="name" value="{{ $info->name }}" placeholder="الإسم">
							</div>
							<div class="col-lg-4">
								<label class="">البريد الإلكتروني:</label>
								<input type="text" class="form-control" name="email" value="{{ $info->email }}" placeholder="البريد الإلكتروني">
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
