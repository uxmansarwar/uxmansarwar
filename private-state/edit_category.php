<?php
// edit cate tpl
$csrf_token = generateFormToken('admin_categories');
?>
<style>
	.add_agreements {
		width: 100%;
	}
</style>
<script type="text/javascript">
	function check_form(a) {
		if (jQuery('.summernote').summernote('codeview.isActivated')) {
			jQuery('.summernote').summernote('codeview.deactivate');
		}

		if (jQuery('.summernote2').summernote('codeview.isActivated')) {
			jQuery('.summernote2').summernote('codeview.deactivate');
		}
		if (jQuery('.summernote3').summernote('codeview.isActivated')) {
			jQuery('.summernote3').summernote('codeview.deactivate');
		}

		if (a.title.value.trim() == "") {
			alert('Please enter title');
			a.title.focus();
			a.title.value = '';
			return false;
		}
		if (a.sef_url.value.trim() == "") {
			alert('Please enter sef url');
			a.sef_url.focus();
			a.sef_url.value = '';
			return false;
		}

		<?php
		if ($id > 0) { ?>
			var published_yes = a.published_yes.checked;
			if (published_yes == false) {
				var ok = confirm('Are you sure to unpublish this category? It will not display models device associated with this category.');
				if (ok == false) {
					return false;
				}
			}
		<?php
		} ?>

	}

	function get_icon_type(type) {
		if (type == "fa") {
			$(".custom_icon_showhide").hide();
			$(".fa_icon_showhide").show();
			$('#fa_icon').select2();
		} else if (type == "custom") {
			$(".custom_icon_showhide").show();
			$(".fa_icon_showhide").hide();
		}
	}

	jQuery(document).ready(function($) {
		var maxField = 10;

		var addButton = $('.add_item__tooltips');
		var wrapper = $('.item_tooltip__wrapper');

		var num_of_cat_item = $('#num_of_cat_item').val();
		if (num_of_cat_item > 0) {
			var x = (num_of_cat_item - 1);
		} else {
			var x = 1;
		}

		//Once add button is clicked
		$(addButton).click(function() {
			//Check maximum number of input fields
			if (x < maxField) {
				x++; //Increment field counter

				$('.item_tooltip_heading').show();

				var fieldHTML = '<div class="form-group row">';
				fieldHTML += '<div class="col-lg-12">';
				fieldHTML += '<div class="row">';

				fieldHTML += '<div class="col-md-3">';
				fieldHTML += '<input type="text" class="form-control m-input" name="tooltip_title[' + x + ']">';
				fieldHTML += '</div>';

				fieldHTML += '<div class="col-md-8">';
				fieldHTML += '<textarea class="form-control m-input tooltip_description" name="tooltip_description[' + x + ']" rows="3"></textarea>';
				fieldHTML += '</div>';

				fieldHTML += '<div class="col-md-1">';
				fieldHTML += '<i class="fas fa-trash trash remove_item__image" style="cursor:pointer;margin-top:15px;"></i>';
				fieldHTML += '</div>';

				fieldHTML += '</div>';
				fieldHTML += '</div>';
				fieldHTML += '</div>';

				$(wrapper).append(fieldHTML); //Add field html
			}
		});

		$(wrapper).on('click', '.remove_item__image', function(e) {
			e.preventDefault();

			var num_of_tooltip_block = $(".tooltip_description").length
			if (num_of_tooltip_block <= 1) {
				$('.item_tooltip_heading').hide();
			}

			$(this).parent().parent().parent().parent('div').remove();
			x--;
		});
	});
</script>

<style type="text/css">
	.table,
	.table thead,
	.table tbody,
	.table tr {
		width: 100%;
	}

	.table tr th,
	.table tr td {
		text-align: left;
		vertical-align: middle;
	}

	.placeholder-img {
		display: block;
		width: 36px;
		height: 36px;
		background: #efefef;
	}

	.placeholder-img img {
		width: auto;
		height: auto;
		max-width: 100%;
		max-height: 100%;
	}

	.row.a-center {
		align-items: center;
	}

	.table tr td.t-center {
		text-align: center;
	}

	.table tr td.t-right {
		padding-left: 30px;
	}

	button.ibtn {
		margin: 0px;
		padding: 0px;
	}

	.ui-sortable-helper {
		display: table;
		width: 100%;
		max-width: 100%;
	}

	.form-group {
		margin-bottom: 1.5rem;
	}

	.input-group {
		padding: 3px;
		border: 1px solid #ced4da;
		border-radius: 5px;
		background: #fff;
	}

	.input-group-append .btn {
		border: none;
		background: transparent;
		box-shadow: none;
		padding-right: 15px;
	}

	.dropdown-menu {
		min-width: auto;
	}

	.flag-icon {
		width: 20px;
		height: 15px;
		margin-right: 5px;
	}

	.input_fields {
		border: none !important;
		outline: none !important;
		box-shadow: none !important;
	}

	.textarea_translation_btn.textarea_clearfix {
		cursor: pointer;
		height: 42px;
		position: absolute;
		right: 10px;
		top: 10px;
	}
</style>

<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
	<!-- begin:: Page -->
	<div class="d-flex flex-row flex-column-fluid page">
		<!-- BEGIN: Left Aside -->
		<?php include(ADMIN_PATH . "include/navigation.php"); ?>
		<!-- END: Left Aside -->

		<!-- begin::Body -->
		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
			<!-- BEGIN: Header -->
			<?php include(ADMIN_PATH . "include/admin_menu.php"); ?>
			<!-- END: Header -->
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				<!--begin::Subheader-->
				<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
					<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
						<!--begin::Info-->
						<div class="d-flex align-items-center flex-wrap mr-1">

							<!--begin::Page Heading-->
							<div class="d-flex align-items-baseline flex-wrap mr-5">
								<!--begin::Page Title-->
								<h5 class="text-dark font-weight-bold my-1 mr-5"><?= ($id ? 'Edit Category' : 'Add Category') ?></h5>
								<!--end::Page Title-->
								<!--begin::Breadcrumb-->
								<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
									<li class="breadcrumb-item text-muted">
										<a href="<?= ADMIN_URL ?>dashboard.php" class="text-muted">Home</a>
									</li>
									<li class="breadcrumb-item text-muted">
										<a href="<?= ADMIN_URL ?>device_categories.php" class="text-muted">Categories</a>
									</li>
									<li class="breadcrumb-item text-muted">
										<span class="text-muted"><?= ($id ? 'Edit Category' : 'Add Category') ?></span>
									</li>
								</ul>
								<!--end::Breadcrumb-->
							</div>
							<!--end::Page Heading-->
						</div>
						<!--end::Info-->
					</div>
				</div>
				<!--end::Subheader-->
				<!--begin::Entry-->
				<div class="d-flex flex-column-fluid">
					<!--begin::Container-->
					<div class="<?= $admin_p_container_class ?>">
						<?php include(ADMIN_PATH . 'confirm_message.php'); ?>
						<!--begin::Profile Personal Information-->
						<div class="d-flex flex-row">
							<!--begin::Aside-->

							<!--end::Aside-->
							<!--begin::Content-->
							<div class="flex-row-fluid">
								<!--begin::Card-->
								<div class="card card-custom card-stretch">
									<!--begin::Header-->
									<div class="card-header py-5">
										<div class="card-title align-items-start flex-column">
											<h3 class="card-label font-weight-bolder text-dark"><?= ($id ? 'Edit Category' : 'Add Category') ?></h3>
										</div>
									</div>
									<!--end::Header-->
									<!--begin::Form-->
									<form class="m-form" action="<?php echo ADMIN_URL; ?>controllers/device_categories.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
										<input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
										<div class="card-body">
											<div class="m-form__section m-form__section--first">
												<div class="form-group row">
													<div class="col-lg-6">
														<label for="title">
															Title</label>
														<input type="text" class="form-control m-input" id="title" value="<?= $category_data['title'] ?>" name="title">
													</div>
													<div class="col-lg-6">
														<label for="sef_url">
															Sef Url :
														</label>
														<input type="text" class="form-control m-input" id="sef_url" value="<?= $category_data['sef_url'] ?>" name="sef_url">
													</div>
												</div>

												<div class="form-group row">
													<div class="col-6 col-lg-6">
														<div class="form-group input_working_block" data-lang_key="category_meta_title_<?= $id; ?>">
															<label for="meta_title">Meta Title</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?= $category_data['meta_title'] ?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-6 col-lg-6">
														<div class="form-group input_working_block" data-lang_key="category_meta_canonical_url_<?= $id; ?>">
															<label for="meta_canonical_url">Meta Canonical Url :</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_canonical_url" name="meta_canonical_url" value="<?= $model_series_data['meta_canonical_url'] ?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--<div class="col-lg-6">
														<label for="meta_title">
															Meta Title :
														</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control m-input" id="meta_title" value="<?= $category_data['meta_title'] ?>" name="meta_title">
															<div data-field-type="text" data-lang-key="category_meta_title_<?= $id ?>" class="globe-icon-translation clearfix textarea">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>
													<div class="col-lg-6">
														<label for="meta_canonical_url">Meta Canonical Url :</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control m-input" id="meta_canonical_url" value="<?= $category_data['meta_canonical_url'] ?>" name="meta_canonical_url">
															<div data-field-type="text" data-lang-key="category_meta_canonical_url_<?= $id ?>" class="globe-icon-translation clearfix textarea">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>-->
												</div>
												<div class="form-group row">
													<div class="col-6 col-lg-6">
														<div class="form-group input_working_block" data-lang_key="series_meta_desc_<?= $id ?>">
															<label for="meta_desc">
																Meta Description
															</label>
															<div class="" style="position: relative;">
																<textarea class="form-control update_translations" name="meta_desc" id="meta_desc" rows="3" style="padding-right: 76px;" data-selected_lang="<?= $default_language_key_name; ?>"><?= $model_series_data['meta_desc'] ?></textarea>
																<div class="textarea_translation_btn textarea_clearfix">
																	<div class="input-group-append">
																		<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown" style="padding-right: 8px;">
																			<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																		</button>
																		<div class="dropdown-menu">
																			<?= $lang_dropdown_item_html; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--<div class="col-lg-6">
														<label for="meta_desc">Meta Description</label>
														<div class="globeTranslatorWrapper">
															<textarea class="form-control m-input" id="meta_desc" name="meta_desc" rows="4"><?= $category_data['meta_desc'] ?></textarea>
															<div data-field-type="textarea" data-lang-key="category_meta_description_<?= $id ?>" class="globe-icon-translation clearfix textarea">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>-->
													<div class="col-lg-6">
														<label for="meta_keywords">
															Meta Keywords</label>
														<textarea class="form-control m-input" id="meta_keywords" name="meta_keywords" rows="4"><?= $category_data['meta_keywords'] ?></textarea>
													</div>
												</div>

												<?php
												$icon_type = $category_data['icon_type']; ?>
												<div class="form-group">
													<div class="radio-inline">
														<label class="radio radio-lg">
															<input type="radio" id="icon_type_fa" name="icon_type" value="fa" <?= ($icon_type == 'fa' || $icon_type == '' ? 'checked="checked"' : '') ?> onclick="get_icon_type('fa');">
															<span></span> Fa Icon

														</label>
														<label class="radio radio-lg">
															<input type="radio" id="icon_type_img" name="icon_type" value="custom" <?= ($icon_type == 'custom' ? 'checked="checked"' : '') ?> onclick="get_icon_type('custom');">
															<span></span> Custom Icon

														</label>
													</div>
												</div>

												<div class="form-group fa_icon_showhide" <?php if ($icon_type == 'fa' || $icon_type == '') {
																								echo 'style="display:block;"';
																							} else {
																								echo 'style="display:none;"';
																							} ?>>
													<label for="fa_icon">Fa Icon</label>
													<select class="form-control m-select2 m-select2-general" name="fa_icon" id="fa_icon">
														<option value=""> -Select- </option>
														<?php
														foreach ($fa_icon_list as $fa_icon_k => $fa_icon_val) { ?>
															<option value="<?= $fa_icon_val ?>" <?php if ($category_data['fa_icon'] == $fa_icon_val) {
																									echo 'selected="selected"';
																								} ?>><?= ucwords(str_replace(array("fa-", "-"), array("", " "), $fa_icon_val)) ?></option>
														<?php
														} ?>
													</select>
												</div>

												<div class="custom_icon_showhide" <?php if ($icon_type == 'custom') {
																						echo 'style="display:block;"';
																					} else {
																						echo 'style="display:none;"';
																					} ?>>
													<div class="form-group row">
														<div class="col-lg-6">
															<label for="image">Icon</label>
															<div class="row">
																<div class="col-lg-8">
																	<div class="custom-file">
																		<input type="file" id="image" class="custom-file-input" name="image" onChange="checkImageVideo(this,'img');" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																</div>

																<div class="col-lg-4">
																	<div class="center">
																		<?= $file_maximum_upload_size_label_html ?>
																		<?php
																		if ($category_data['image'] != "") { ?>
																			<img src="../media/images/categories/<?= $category_data['image'] ?>" width="70" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?= $_REQUEST['id'] ?>&r_img_id=<?= $category_data['id'] ?>&csrf_token=<?php echo $csrf_token; ?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
																			<input type="hidden" id="old_image" name="old_image" value="<?= $category_data['image'] ?>">
																		<?php
																		} ?>
																	</div>
																</div>
															</div>


														</div>
														<div class="col-lg-6">
															<label for="hover_image">Hover Icon</label>
															<div class="row">
																<div class="col-lg-8">
																	<div class="custom-file">
																		<input type="file" id="hover_image" class="custom-file-input" name="hover_image" onChange="checkImageVideo(this,'img');" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																</div>
																<div class="col-lg-4">
																	<div class="center">
																		<?= $file_maximum_upload_size_label_html ?>
																		<?php
																		if ($category_data['hover_image'] != "") { ?>
																			<img src="../media/images/categories/<?= $category_data['hover_image'] ?>" width="70" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?= $_REQUEST['id'] ?>&r_h_img_id=<?= $category_data['id'] ?>&csrf_token=<?php echo $csrf_token; ?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
																			<input type="hidden" id="old_hover_image" name="old_hover_image" value="<?= $category_data['hover_image'] ?>">
																		<?php
																		} ?>
																	</div>
																</div>
															</div>


														</div>
													</div>
												</div>



												<div class="form-group input_working_block" data-lang_key="series_short_description_<?= $id; ?>" data-rich_textarea="1">
													<label for="short_description">Short Description</label>
													<div class="" style="position: relative;">
														<textarea class="form-control summernote update_translations" name="short_description" id="short_description" data-selected_lang="<?= $default_language_key_name; ?>" data-rich_textarea="1"><?= $model_series_data['short_description'] ?></textarea>
														<div class="textarea_translation_btn textarea_clearfix">
															<div class="input-group-append">
																<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown" style="padding-right: 8px; padding-top: 2px;">
																	<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																</button>
																<div class="dropdown-menu">
																	<?= $lang_dropdown_item_html; ?>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--<div class="form-group">
													<label for="exampleTextarea">
														Short Description</label>
													<div class="globeTranslatorWrapper">
														<textarea class="form-control m-input summernote" id="exampleTextarea" name="description" rows="5"><?= $category_data['description'] ?></textarea>
														<div data-field-type="textarea" data-lang-key="cat_description_<?= $category_data['id']; ?>" class="globe-icon-translation clearfix textarea">
															<div class="globe-icon-i">
																<i class="fas fa-globe"></i>
															</div>
														</div>
													</div>

												</div>-->

												<div class="row mb-6">
													<div class="col-lg-12 mb-4">
														<h3>Description</h3>
													</div>

													<div class="col-12">
														<div class="form-group input_working_block" data-lang_key="series_meta_title_<?= $id; ?>">
															<label for="meta_title">Title</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?= $model_series_data['meta_title'] ?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--
													<div class="col-lg-12">
														<label for="text_color">Title</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control" id="step_one_description_title_cat_<?php echo $category_data['id'] ?? ''; ?>" value="<?php
																																															if (!empty($category_data['id'])) {
																																																echo Easy_Options::get('step_one_description_title_cat_' .  $category_data['id'], 'Lorem ipsum dolor sit amet');
																																															}
																																															?>" name="step_one_description_title_cat_<?php echo $category_data['id'] ?? ''; ?>" required="required">
															<div data-field-type="text" data-lang-key="step_one_description_title_cat_<?=
																																		$category_data['id']; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>

													</div>
													
												-->

													<div class="col-6 col-lg-6">
														<div class="form-group input_working_block" data-lang_key="series_meta_desc_<?= $id ?>">
															<label for="meta_desc">
																Description 1
															</label>
															<div class="" style="position: relative;">
																<textarea rows="10" class="form-control update_translations" name="meta_desc" id="meta_desc" rows="3" style="padding-right: 76px;" data-selected_lang="<?= $default_language_key_name; ?>"><?= $model_series_data['meta_desc'] ?></textarea>
																<div class="textarea_translation_btn textarea_clearfix">
																	<div class="input-group-append">
																		<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown" style="padding-right: 8px;">
																			<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																		</button>
																		<div class="dropdown-menu">
																			<?= $lang_dropdown_item_html; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-6 col-lg-6">
														<div class="form-group input_working_block" data-lang_key="series_meta_desc_<?= $id ?>">
															<label for="meta_desc">
																Description 2
															</label>
															<div class="" style="position: relative;">
																<textarea rows="10" class="form-control update_translations" name="meta_desc" id="meta_desc" rows="3" style="padding-right: 76px;" data-selected_lang="<?= $default_language_key_name; ?>"><?= $model_series_data['meta_desc'] ?></textarea>
																<div class="textarea_translation_btn textarea_clearfix">
																	<div class="input-group-append">
																		<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown" style="padding-right: 8px;">
																			<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																		</button>
																		<div class="dropdown-menu">
																			<?= $lang_dropdown_item_html; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--
													<div class="col-lg-6 mt-4">
														<label for="text_color">Description 1</label>
														<div class="globeTranslatorWrapper">
															<textarea style="min-height: 200px;" class="form-control" id="step_one_description_side1_cat_<?php echo $category_data['id'] ?? ''; ?>" name="step_one_description_side1_cat_<?php echo $category_data['id'] ?? ''; ?>" required="required"><?php
																																																																										if (!empty($category_data['id'])) {
																																																																											echo Easy_Options::get('step_one_description_side1_cat_' . $category_data['id'] ?? '', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
																																																																										}
																																																																										?></textarea>
															<div data-field-type="textarea" data-lang-key="step_one_description_side1_cat_<?=
																																			$category_data['id']; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>

													</div>
													<div class="col-lg-6 mt-4">
														<label for="text_color">Description 2</label>
														<div class="globeTranslatorWrapper">
															<textarea style="min-height: 200px;" class="form-control" id="step_one_description_side2_cat_<?php echo $category_data['id'] ?? ''; ?>" name="step_one_description_side2_cat_<?php echo $category_data['id'] ?? ''; ?>" required="required"><?php
																																																																										if (!empty($category_data['id'])) {
																																																																											echo Easy_Options::get('step_one_description_side2_cat_' . $category_data['id'] ?? '', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.');
																																																																										}
																																																																										?></textarea>
															<div data-field-type="textarea" data-lang-key="step_one_description_side2_cat_<?=
																																			$category_data['id']; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>

													</div> -->
													<div class="col-12 mt-4">
														<div class="form-group input_working_block" data-lang_key="series_short_description_<?= $id; ?>" data-rich_textarea="1">
															<label for="short_description">Description</label>
															<div class="" style="position: relative;">
																<textarea class="form-control summernote update_translations" name="short_description" id="short_description" data-selected_lang="<?= $default_language_key_name; ?>" data-rich_textarea="1"><?= $model_series_data['short_description'] ?></textarea>
																<div class="textarea_translation_btn textarea_clearfix">
																	<div class="input-group-append">
																		<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown" style="padding-right: 8px; padding-top: 2px;">
																			<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																		</button>
																		<div class="dropdown-menu">
																			<?= $lang_dropdown_item_html; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!-- <div class="col-lg-12 mt-4">
														<label for="text_color">Description</label>
														<div class="globeTranslatorWrapper">
															<textarea style="min-height: 200px;" class="form-control summernote3" id="step_one_description_wide_global_cat_<?php echo $category_data['id'] ?? ''; ?>" name="content"><?php
																																																										if (!empty($category_data['id'])) {
																																																											echo Easy_Options::get('step_one_description_wide_global_cat_' . $category_data['id'] ?? '', '');
																																																										}
																																																										?></textarea>
															<div data-field-type="textarea" data-lang-key="step_one_description_wide_global_cat_<?= $category_data['id']; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div> -->
												</div>

												<div class="form-group">
													<div class="checkbox-inline">
														<label class="checkbox checkbox-lg">
															<input id="check_imei" type="checkbox" value="1" name="check_imei" <?php if ($category_data['check_imei'] == '1') {
																																	echo 'checked="checked"';
																																} ?>>
															<span></span> Check IMEI

														</label>
													</div>
												</div>

												<div class="form-group row" <?= ($tooltips_of_model_field_options != '1' ? 'style="display:none;"' : '') ?>>
													<div class="col-md-12">
														<h5>Fields Options Tooltips:</h5>
													</div>
													<div class="col-md-12">
														<div class="item_tooltip__wrapper">
															<div class="form-group row item_tooltip_heading" <?php if (empty($fields_options_tooltips_arr)) {
																													echo 'style="display:none;padding-bottom:0px;"';
																												} else {
																													echo 'style="display:block;padding-bottom:0px;"';
																												} ?>>
																<div class="col-lg-12">
																	<div class="row">
																		<div class="col-md-3">
																			<div class="m-form__control">
																				<label for="input"><strong>Field Option Title</strong></label>
																			</div>
																		</div>
																		<div class="col-md-8">
																			<div class="m-form__control">
																				<label for="input"><strong>Description</strong></label>
																			</div>
																		</div>
																		<div class="col-md-1">
																			<div class="m-form__control">
																				<label for="input"><strong>Action</strong></label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>

															<?php
															if (!empty($fields_options_tooltips_arr)) {
																foreach ($fields_options_tooltips_arr as $fot_k => $fields_options_tooltips_data) { ?>
																	<div class="form-group row">
																		<div class="col-lg-12">
																			<div class="row">
																				<div class="col-md-3">
																					<input type="text" class="form-control m-input" name="tooltip_title[<?= $fot_k ?>]" value="<?= $fields_options_tooltips_data['title'] ?>">
																				</div>
																				<div class="col-md-8">
																					<textarea class="form-control m-input tooltip_description" name="tooltip_description[<?= $fot_k ?>]" rows="3"><?= $fields_options_tooltips_data['description'] ?></textarea>

																				</div>
																				<div class="col-md-1">
																					<i class="fas fa-trash trash remove_item__image" style="cursor:pointer;margin-top:15px;"></i>

																				</div>
																			</div>
																		</div>
																	</div>
															<?php
																}
															} ?>
														</div>
														<div class="form-group row">
															<div class="col-lg-4">
																<div class="add_item__tooltips btn btn-success">
																	<span>
																		<i class="la la-plus"></i>
																		<span>Add</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<hr style="margin-top: 30px; margin-bottom:30px;">

												<div class="row">
													<div class="col-lg-12 mb-0">
														<h3>Agreements</h3>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<div class="table-responsive">
															<table style="display: none;" class="default-row-table">
																<tbody>
																	<tr>
																		<td class="t-center" width="50px">
																			<i class="fas fa-sort"></i>
																		</td>
																		<td>
																			<input type="hidden" name="category_agreements_id[]" value="NEW" />
																			<input class="form-control" type="text" name="category_agreements[]" value="" style="width:100%;">
																		</td>
																		<td class="t-right">


																			<button class="btn ibtn" type="button" onclick="removeCurrentRow(this)">
																				<i class="fas fa-trash"></i>
																			</button>
																		</td>
																	</tr>
																</tbody>
															</table>
															<table class="table">
																<thead>
																	<tr>
																		<th width="50px"></th>
																		<th>Agreement</th>
																		<th width="50px">Action</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$category_agreements = Easy_Options::get('category_agreements_' . ($category_data['id'] ?? ''), array());

																	if (empty($category_agreements) || empty($category_data['id'] ?? '')) {
																		$category_agreements = array();
																	}
																	foreach ($category_agreements as $theAgreement) {

																	?>
																		<tr>
																			<td class="t-center" width="50px">
																				<i class="fas fa-sort"></i>
																			</td>
																			<td>
																				<div class="globeTranslatorWrapper">
																					<input class="form-control" type="hidden" name="category_agreements_id[]" value="<?php echo _dt_parse($theAgreement['id']); ?>" style="width:100%;">

																					<input class="form-control add_agreements" type="text" name="category_agreements[]" value="<?php echo _dt_parse($theAgreement['text']); ?>" style="width:100%;">
																					<div data-field-type="text" data-lang-key="category_agreements_<?= $category_data['id']; ?>_<?= $theAgreement['id']; ?>" class="globe-icon-translation clearfix input">
																						<div class="globe-icon-i">
																							<i class="fas fa-globe"></i>
																						</div>
																					</div>
																				</div>
																			</td>
																			<td class="t-right">
																				<button class="btn ibtn" type="button" onclick="removeCurrentRow(this)">
																					<i class="fas fa-trash"></i>
																				</button>
																			</td>
																		</tr>
																	<?php
																	}
																	?>
																</tbody>
															</table>
															<button type="button" class="btn btn-primary" onclick="addNewItem(this)">Add New</button>
														</div>
													</div>
												</div>
												<script>
													function addNewItem(e) {
														var table = $(e).parents('.table-responsive').find('table.table');
														var defaultRow = $(e).parents('.table-responsive').find('table.default-row-table tbody tr').html();
														table.find('tbody').append('<tr>' + defaultRow + '</tr>');
													}

													function removeCurrentRow(e) {
														if (confirm('Are you sure you want to remove this row?')) {
															$(e).parents('tr').remove();
														}
													}
													// make td sortable
													$(".table tbody").sortable({
														items: "tr",
														cursor: 'move',
														handle: ".fa-sort",
													});
												</script>

												<hr style="margin-top: 30px; margin-bottom:30px;">

												<div class="row">
													<div class="col-lg-12 mb-4">
														<h3>Alert / Info</h3>
													</div>
												</div>
												<div class="row" style="background: #efefef; padding-bottom: 15px; padding-top: 0px; margin: 0px; margin-top: 0px;">

													<div class="col-6 mt-4">
														<div class="form-group input_working_block" data-lang_key="series_meta_title_<?= $id; ?>">
															<label for="meta_title">More Information - Text</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?=$model_series_data['meta_title']?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--<div class="col-lg-6 mt-4">
														<label for="step_four_preparation_more_info_text_<?php echo $category_data['id'] ?? ''; ?>">More Information - Text</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control" id="step_four_preparation_more_info_text_<?php echo $category_data['id'] ?? ''; ?>" value="<?php echo Easy_Options::get('step_four_preparation_more_info_text_' . ($category_data['id'] ?? ''), 'Meer information'); ?>" name="step_four_preparation_more_info_text_<?php echo $category_data['id'] ?? ''; ?>" required="required">
															<div data-field-type="text" data-lang-key="step_four_preparation_more_info_text_<?= $category_data['id']; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div> -->
													<div class="col-lg-6 mt-4">
														<label for="step_four_preparation_more_info_link_<?php echo $category_data['id'] ?? ''; ?>">More Information - Link</label>
														<input type="text" class="form-control" id="step_four_preparation_more_info_link_<?php echo $category_data['id'] ?? ''; ?>" value="<?php echo Easy_Options::get('step_four_preparation_more_info_link_' . ($category_data['id'] ?? ''), '#'); ?>" name="step_four_preparation_more_info_link_<?php echo $category_data['id'] ?? ''; ?>" required="required">
													</div>

													<div class="col-12">
														<div class="form-group input_working_block" data-lang_key="series_meta_title_<?= $id; ?>">
															<label for="meta_title">Text</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?=$model_series_data['meta_title']?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-12 mt-4">
														<div class="form-group input_working_block" data-lang_key="series_short_description_<?= $id; ?>" data-rich_textarea="1">
															<label for="short_description">Popup content</label>
															<br>
															<small>Leave the content empty to use the link instead of popup</small>
															<div class="" style="position: relative;">
																<textarea class="form-control summernote update_translations" name="short_description" id="short_description" data-selected_lang="<?= $default_language_key_name; ?>" data-rich_textarea="1"><?= $model_series_data['short_description'] ?></textarea>
																<div class="textarea_translation_btn textarea_clearfix">
																	<div class="input-group-append">
																		<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown" style="padding-right: 8px; padding-top: 2px;">
																			<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																		</button>
																		<div class="dropdown-menu">
																			<?= $lang_dropdown_item_html; ?>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--<div class="col-lg-12 mt-4">
														<label for="step_four_preparation_alert_text_<?php echo $category_data['id'] ?? ''; ?>">Text</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control" id="step_four_preparation_alert_text_<?php echo $category_data['id'] ?? ''; ?>" value="<?php echo Easy_Options::get('step_four_preparation_alert_text_' . ($category_data['id'] ?? ''), 'over het klaarmaken van je device voor verkoop'); ?>" name="step_four_preparation_alert_text_<?php echo $category_data['id'] ?? ''; ?>" required="required">
															<div data-field-type="text" data-lang-key="step_four_preparation_alert_text_<?= $category_data['id']; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>
													<div class="col-lg-12 form-group mt-4">
														<label for="moreInformationTextArea">Popup content</label>
														<br>
														<small>Leave the content empty to use the link instead of popup</small>
														<div class="globeTranslatorWrapper">
															<textarea class="form-control m-input summernote2" id="moreInformationTextArea" name="more_information_popup_content" rows="5"><?php echo Easy_Options::get('more_information_popup_content_' . ($category_data['id'] ?? ''), ''); ?></textarea>
															<div data-field-type="textarea" data-lang-key="more_information_popup_content_<?= $category_data['id']; ?>" class="globe-icon-translation clearfix textarea">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>-->
												</div>

												<hr style="margin-top: 30px; margin-bottom:30px;">

												<div class="row">
													<div class="col-lg-12 mb-4">
														<h3>Order Complete Banner</h3>
													</div>
													<?php
													$category_data_id = $category_data['id'] ?? 0;
													?>


													<div class="col-6 mt-4">
														<div class="form-group input_working_block" data-lang_key="series_meta_title_<?= $id; ?>">
															<label for="meta_title">Heading - Light</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?=$model_series_data['meta_title']?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-6 mt-4">
														<div class="form-group input_working_block" data-lang_key="series_meta_title_<?= $id; ?>">
															<label for="meta_title">Heading - Bold</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?=$model_series_data['meta_title']?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="col-6 mt-4">
														<div class="form-group input_working_block" data-lang_key="series_meta_title_<?= $id; ?>">
															<label for="meta_title">Button Text</label>
															<div class="input-group">
																<input type="text" class="form-control input_fields update_translations" id="meta_title" name="meta_title" value="<?=$model_series_data['meta_title']?>" data-selected_lang="<?= $default_language_key_name; ?>">
																<div class="input-group-append">
																	<button class="btn dropdown-toggle translation_btn update_translations" type="button" data-toggle="dropdown">
																		<img src="<?= SITE_URL; ?><?= $default_language_img; ?>" class="flag-icon"> EN
																	</button>
																	<div class="dropdown-menu">
																		<?= $lang_dropdown_item_html; ?>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--<div class="col-lg-6 mt-4">
														<label for="text_color">Heading - Light</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control" id="step_five_banner_heading_light" value="<?php echo Easy_Options::get('step_five_banner_heading_light_' . $category_data_id, 'Duurzaam alternatief'); ?>" name="step_five_banner_heading_light" required="required">
															<div data-field-type="text" data-lang-key="step_five_banner_heading_light_<?= $category_data_id; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>
													<div class="col-lg-6 mt-4">
														<label for="text_color">Heading - Bold</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control" id="step_five_banner_heading_bold" value="<?php echo Easy_Options::get('step_five_banner_heading_bold_' . $category_data_id, 'Refubished kopen?'); ?>" name="step_five_banner_heading_bold" required="required">
															<div data-field-type="text" data-lang-key="step_five_banner_heading_bold_<?= $category_data_id; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>

													</div>
													<div class="col-lg-6 mt-4">
														<label for="text_color">Button Text</label>
														<div class="globeTranslatorWrapper">
															<input type="text" class="form-control" id="step_five_banner_button_text" value="<?php echo Easy_Options::get('step_five_banner_button_text_' . $category_data_id, 'Shop nu'); ?>" name="step_five_banner_button_text" required="required">
															<div data-field-type="text" data-lang-key="step_five_banner_button_text_<?= $category_data_id; ?>" class="globe-icon-translation clearfix input">
																<div class="globe-icon-i">
																	<i class="fas fa-globe"></i>
																</div>
															</div>
														</div>
													</div>-->
													<div class="col-lg-6 mt-4">
														<label for="text_color">Button Link</label>
														<input type="text" class="form-control" id="step_five_banner_button_link" value="<?php echo Easy_Options::get('step_five_banner_button_link_' . $category_data_id, '#'); ?>" name="step_five_banner_button_link" placeholder="https://www.fixje.nl/">
													</div>
													<div class="col-lg-6 mt-6">
														<div class="form-group">
															<div class="checkbox-inline">
																<label class="checkbox checkbox-lg">
																	<input name="step_five_banner_open_link_in_new_tab" id="step_five_banner_open_link_in_new_tab" value="1" type="checkbox" <?php if (Easy_Options::get('step_five_banner_open_link_in_new_tab_' . $category_data_id, '0') == '1') {
																																																	echo 'checked="checked"';
																																																}; ?>>
																	<span></span> Open link in New Tab
																</label>
															</div>
														</div>
													</div>
													<div class="col-lg-6 mt-6">
														<label for="banner_image">Banner Image</label>
														<div class="row">
															<div class="col-lg-8">
																<div class="custom-file">
																	<input type="file" id="banner_image" class="custom-file-input" name="banner_image" onChange="checkImageVideo(this,'img');" accept="image/*">
																	<label class="custom-file-label" for="image">
																		Choose file
																	</label>
																</div>
															</div>
															<div class="col-lg-4">
																<div class="center">
																	<?= $file_maximum_upload_size_label_html ?>
																	<?php
																	$banner_image = Easy_Options::get('step_five_banner_image_' . $category_data_id, '');
																	if ($banner_image != "") { ?>
																		<img src="../media/images/categories/<?= $banner_image ?>" width="70" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?= $_REQUEST['id'] ?>&r_banner_img_id=<?= $category_data['id'] ?>&csrf_token=<?php echo $csrf_token; ?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
																		<input type="hidden" id="old_banner_image" name="old_banner_image" value="<?= $banner_image ?>">
																	<?php
																	} ?>
																</div>
															</div>
														</div>


													</div>
												</div>

												<hr style="margin-top: 15px; margin-bottom:30px;">

												<div class="form-group">
													<label for="published">
														<?= __lang('status_field_label_text', 'general') ?>
													</label>
													<div class="radio-inline">
														<label class="radio radio-lg">
															<input type="radio" id="published_yes" name="published" value="1" <?php if (!$id) {
																																	echo 'checked="checked"';
																																} ?> <?= ($category_data['published'] == 1 ? 'checked="checked"' : '') ?>>
															<span></span> <?= __lang('status_field_active_label_text', 'general') ?>

														</label>
														<label class="radio radio-lg">
															<input type="radio" id="published_no" name="published" value="0" <?= ($category_data['published'] == '0' ? 'checked="checked"' : '') ?>>
															<span></span> <?= __lang('status_field_inactive_label_text', 'general') ?>

														</label>
													</div>
												</div>
												<?php if ($id) {
													$partners_q = mysqli_query($db, "SELECT * FROM `partners_v2`");
													if (mysqli_num_rows($partners_q) > 0): ?>
														<hr style="margin-top: 15px; margin-bottom:30px;">
														<div class="row mb-4">
															<div class="col-lg-12">
																<h3>Set status for partners</h3>
															</div>
															<div class="col-lg-3 mt-4">
																<label for="partners_status">
																	Partners status
																</label>
																<div class="radio-inline">
																	<label class="radio radio-lg">
																		<input type="radio" id="partners_status_yes" name="partners_status" value="1" <?php if (!$id) {
																																							echo 'checked="checked"';
																																						} ?> <?= ($category_data['published'] == 1 ? 'checked="checked"' : '') ?>>
																		<span></span> <?= __lang('status_field_active_label_text', 'general') ?>

																	</label>
																	<label class="radio radio-lg">
																		<input type="radio" id="partners_status_no" name="partners_status" value="0" <?= ($category_data['published'] == '0' ? 'checked="checked"' : '') ?>>
																		<span></span> <?= __lang('status_field_inactive_label_text', 'general') ?>
																	</label>
																</div>
															</div>
															<div class="col-lg-9 mt-4">
																<label for="set_status_for_partners">
																	Select partners to apply "Partner Status" to
																</label>
																<select name="set_status_for_partners[]" id="set_status_for_partners" size="1" multiple class="form-select form-control custom-select partner_showhide">
																	<?php while ($partners_row = mysqli_fetch_assoc($partners_q)): ?>
																		<option value="<?= $partners_row['id'] ?>"><?= $partners_row['company_name'] ?></option>
																	<?php endwhile; ?>
																</select>
															</div>
														</div>
														<script>
															jQuery(document).ready(function($) {
																$('#set_status_for_partners').select2({
																	placeholder: "Select partners",
																	allowClear: true
																});
															});
														</script>
														<div class="form-group row">
															<div class="col-lg-3">
																<button type="submit" name="publish_for_all" class="btn btn-primary font-weight-bold">
																	Change for all partners
																</button>
															</div>
															<div class="col-lg-9">
																<button type="submit" name="apply_for_selected_partners" class="btn btn-primary font-weight-bold">
																	Apply for selected partners
																</button>
															</div>
														</div>
												<?php endif;
												} ?>
												<div class="form-group">
													<button type="submit" name="update" class="btn btn-primary font-weight-bold">
														<?= ($id ? 'Update' : 'Save') ?>
													</button>
													<a href="device_categories.php" class="btn btn-secondary font-weight-bold">Back</a>
												</div>
											</div>
										</div>
										<input type="hidden" name="id" value="<?= $category_data['id'] ?>" />
										<input type="hidden" id="num_of_cat_item" value="<?= count(($fields_options_tooltips_arr ?? array())) ?>" />
									</form>
								</div>
								<!--end::Form-->
							</div>
							<!--end::Content-->
						</div>
					</div>
					<!--End::Section-->
				</div>
			</div>
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Page-->
</div>
<!--end::Main-->

<script>
	let translations = <?php echo json_encode($translations); ?>;
	let all_languages = <?php echo json_encode($all_languages); ?>;
	let default_language_key_name = "<?php echo $default_language_key_name; ?>";
	let id = <?php echo (empty($id) ? 0 : $id); ?>;
	let title, meta_title, meta_canonical_url, meta_desc, meta_keywords, image_text, description, translations_elem;
	console.log(translations);
	let update_translations = document.querySelectorAll('.update_translations');
	if (translations.length < 1)
		translations = {};

	let updateTranslations = _ => {

		let lang_key = String(_.target?.closest('div.input_working_block').dataset?.lang_key)?.trim();
		let elem = null;
		if (_?.target?.closest('div.input_working_block')?.querySelector('input.update_translations'))
			elem = _?.target?.closest('div.input_working_block')?.querySelector('input.update_translations');
		else
			elem = _?.target?.closest('div.input_working_block')?.querySelector('textarea.update_translations');

		if (!translations[lang_key])
			translations[lang_key] = {}

		if (!translations[lang_key][elem?.dataset?.selected_lang])
			translations[lang_key][elem?.dataset?.selected_lang] = {
				value: ''
			}
		translations[lang_key][elem?.dataset?.selected_lang].value = elem?.value
		translations_elem.value = JSON.stringify(translations);
	};

	$('.summernote').on('summernote.change', function(e, contents, $editable) {
		updateTranslations(e);
	});

	update_translations.forEach(item => item.addEventListener('input', updateTranslations));
	update_translations.forEach(item => item.addEventListener('click', updateTranslations));

	let updateInput = (input_working_block, rich_editor = false) => {
		let lang_key = input_working_block?.dataset?.lang_key;
		let elem = null;
		if (rich_editor) {
			elem = input_working_block.querySelector('textarea.update_translations');
			let language = elem?.dataset.selected_lang;
			$('#' + input_working_block.querySelector('textarea.update_translations').id).summernote('destroy');
			input_working_block.querySelector('textarea.update_translations').value = translations?.[lang_key]?.[language]?.value;
			$('#' + input_working_block.querySelector('textarea.update_translations').id).summernote({
				height: 200
			});
		} else {
			if (input_working_block.querySelector('input.update_translations'))
				elem = input_working_block.querySelector('input.update_translations');
			else
				elem = input_working_block.querySelector('textarea.update_translations');
			let language = elem?.dataset.selected_lang;
			elem.value = translations?.[lang_key]?.[language]?.value;
		}
	}

	document.querySelectorAll('.selected_lang').forEach(item => item.addEventListener('click', _ => {
		_.preventDefault();

		let lang_iso = String(_.target?.dataset?.lang_iso)?.trim()?.toUpperCase();
		let language = String(_.target?.dataset?.language)?.trim();
		let img_src = String(_.target?.querySelector('img')?.src)?.trim();
		let lang_key = String(_.target?.closest('div.input_working_block').dataset?.lang_key)?.trim();
		let value = '';

		value = translations?.[lang_key]?.[language]?.value ?? '';

		let elem = null;
		if (_?.target?.closest('div.input_working_block')?.querySelector('input.update_translations'))
			elem = _?.target?.closest('div.input_working_block')?.querySelector('input.update_translations');
		else
			elem = _?.target?.closest('div.input_working_block')?.querySelector('textarea.update_translations');

		if (elem?.id == 'short_description') {
			$('#short_description').summernote('destroy');
			elem.value = value;
			$('#short_description').summernote({
				height: 200
			});
		} else
			elem.value = value;
		elem.dataset.selected_lang = language;
		_.target.closest('div.input_working_block').querySelector('button.update_translations').innerHTML = `<img src="${img_src}" alt="${lang_iso}" class="flag-icon"> ${lang_iso}`;

	}));

	document.querySelectorAll('.show_all_translations').forEach(item => item.addEventListener('click', _ => {
		_.preventDefault();

		let lang_key = String(_.target?.closest('div.input_working_block').dataset?.lang_key)?.trim();
		let value = '';

		let html = ``;
		let trans_text = '';
		Object.keys(all_languages).forEach(language => {
			trans_text = translations?.[lang_key]?.[language]?.value ?? '';

			if (String(_.target?.closest('div.input_working_block').dataset?.rich_textarea)?.trim() == 1)
				html += `<tr id="alert-box" class="alert-box">
					<td width="700">
						<div class="main-block">
							<div class="flag-img">
								<img width="28px" height="28px" src="<?= SITE_URL; ?>${all_languages?.[language]?.image}">
							</div>
							<div class="input-cont input_working_block" data-lang_key="${lang_key}">
								<div class="wp-repair-input-group">
									<label class="mod-lab">${all_languages?.[language]?.name} (${all_languages?.[language]?.code})</label>
									<textarea id="text_editor_${language}" class="mytextarea user-info summernote form-control mt-5 p-5 update_translations update_translations_in_pop" required="" rows="10" data-selected_lang="${language}" data-rich_textarea="1">${trans_text}</textarea>
								</div>
							</div>
						</div
					</td>
				</tr>`;
			else
				html += `<tr id="alert-box">
				<td width="500">
					<div class="flag-img">
						<img width="28px" height="28px" src="<?= SITE_URL; ?>${all_languages?.[language]?.image}">
					</div>
					<div class="input-cont input_working_block" data-lang_key="${lang_key}">
						<div class="tradein-input-group">
							<label class="mod-lab">${all_languages?.[language]?.name} (${all_languages?.[language]?.code})</label>
							<input type="text" class="user-info update_translations update_translations_in_pop" value="${trans_text}" data-selected_lang="${language}">
						</div>
					</div>
				</td>
			</tr>`;
		});
		let html_btn = `<button type="submit" class="va-button va-submit va-trans" onclick="updateTranslationsOnly(event)">Update</button>`;
		if (id == 0)
			html_btn = `<button class="va-trans disabled" disabled="true" style="float: right;">Disabled</button>`;


		jQuery('<div class="translations_pop_parent_div">').html(`
			<p class="va-modal-title"></p>
			<table id="translationTable" style="width:100%;">
				<tbody>
					${html}
				</tbody>
			</table>
			<input type="hidden" name="alert" value="1">
			<input type="hidden" name="trans_key" value="${lang_key}">${html_btn}
		`)
			.appendTo('body')
			.dialog({
				modal: true,
				title: 'Update Translations',
				width: 500
			});
		if (String(_.target?.closest('div.input_working_block').dataset?.rich_textarea)?.trim() == 1) {
			if (jQuery('.summernote').summernote('codeview.isActivated')) {
				jQuery('.summernote').summernote('codeview.deactivate');
			}
			$('.summernote').on('summernote.change', function(e, contents, $editable) {
				updateTranslations(e);
				updateInput(_.target?.closest('div.input_working_block'), true);
			});
		} else {
			document.querySelectorAll('.update_translations_in_pop').forEach(i => i.addEventListener('input', ev => {
				updateTranslations(ev);
				updateInput(_.target?.closest('div.input_working_block'));
			}));
		}
	}));


	window.addEventListener('load', _ => {

		translations_elem = document.querySelector('#translations');
		translations_elem.value = JSON.stringify(translations);

		// title = document.querySelector('#title');
		// meta_canonical_url = document.querySelector('#meta_canonical_url');
		// meta_keywords = document.querySelector('#meta_keywords');
		// image_text = document.querySelector('#image_text');
		// description = document.querySelector('#description');

		meta_title = document.querySelector('#meta_title');
		meta_desc = document.querySelector('#meta_desc');
		short_description = document.querySelector('#short_description');

		document.getElementById("model_series_form").addEventListener("submit", function(event) {

			// title.value = translations?.[title.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			// meta_canonical_url.value = translations?.[meta_canonical_url.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			// meta_keywords.value = translations?.[meta_keywords.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			// image_text.value = translations?.[image_text.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			// description.value = translations?.[description.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;

			meta_title.value = translations?.[meta_title.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			meta_desc.value = translations?.[meta_desc.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			short_description.value = translations?.[short_description.closest('div.input_working_block').dataset.lang_key][default_language_key_name].value;
			this.submit();
		});
	});

	function updateTranslationsOnly(event) {
		let successfulRequests = 0;
		let pop_div = event.target?.closest('div.translations_pop_parent_div');
		let all_tr = pop_div.querySelectorAll('tr');
		let all_tr_length = all_tr.length;
		all_tr.forEach(t_r => {
			let elem = null;
			if (t_r.querySelector('input.update_translations'))
				elem = t_r.querySelector('input.update_translations');
			else
				elem = t_r.querySelector('textarea.update_translations');

			let value = '';
			if (elem.dataset?.rich_textarea == 1)
				value = $('#' + elem.id).summernote('code');
			else
				value = elem.value;

			jQuery.ajax({
				type: 'POST',
				url: "ajax/update_translation.php",
				data: {
					lang: elem.dataset.selected_lang,
					key: t_r.querySelector('div.input_working_block').dataset.lang_key,
					value: value,
					resource: 'model_series'
				},
				success: function(data) {
					successfulRequests++;
					if (successfulRequests === all_tr_length) {
						$('.ui-dialog-content').dialog('close');
						showMessage(data);
					}
				},
				error: function(response) {}
			});
		});
	}
</script>
<!-- begin::Footer -->
<?php include(ADMIN_PATH . "include/footer.php"); ?>
<!-- end::Footer -->