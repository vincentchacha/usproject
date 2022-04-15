<?php echo form_open(get_uri("settings/save_lead_settings"), array("id" => "lead-settings-form", "class" => "general-form dashed-row", "role" => "form")); ?>
<div class="card mb0">

    <div class="card-body">
        <div class="form-group">
            <div class="row">
                <label for="can_create_lead_from_public_form" class="col-md-4"><?php echo app_lang('can_create_lead_from_public_form'); ?></label>
                <div class="col-md-8">
                    <?php
                    echo form_checkbox("can_create_lead_from_public_form", "1", get_setting("can_create_lead_from_public_form") ? true : false, "id='can_create_lead_from_public_form' class='form-check-input ml15'");
                    ?>
                    <span class="ml10 <?php echo get_setting('can_create_lead_from_public_form') ? "" : "hide"; ?>" id="lead_html_form_code">
                        <?php echo modal_anchor(get_uri("collect_leads/lead_html_form_code_modal_form"), "<i data-feather='code' class='icon-16'></i>", array("title" => app_lang('lead_html_form_code'), "class" => "edit external-tickets-embedded-code")) ?>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"><span data-feather='check-circle' class="icon-16"></span> <?php echo app_lang('save'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#lead-settings-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });

        //show/hide external leads area
        $("#can_create_lead_from_public_form").click(function () {
            if ($(this).is(":checked")) {
                $("#lead_html_form_code").removeClass("hide");
            } else {
                $("#lead_html_form_code").addClass("hide");
            }
        });
    });
</script>