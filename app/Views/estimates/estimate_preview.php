<div class="box h-100">
    <div class="box-content">
        <div id="estimate-preview-content" class="page-wrapper clearfix">
            <?php
            load_css(array(
                "assets/css/invoice.css",
            ));

            load_js(array(
                "assets/js/signature/signature_pad.min.js",
            ));
            ?>

            <div class="invoice-preview">
                <?php
                if ($login_user->user_type === "client" && $estimate_info->status == "new") {
                    ?>

                    <div class = "card  p15 no-border clearfix inline-block w100p mb0">

                        <div class="mr15 strong float-start">
                            <?php
                            if (get_setting("add_signature_option_on_accepting_estimate")) {
                                echo modal_anchor(get_uri("estimate/accept_estimate_modal_form/$estimate_info->id"), "<i data-feather='check-circle' class='icon-16'></i> " . app_lang('mark_as_accepted'), array("class" => "btn btn-success mr15", "title" => app_lang('accept_estimate')));
                            } else {
                                echo ajax_anchor(get_uri("estimates/update_estimate_status/$estimate_info->id/accepted"), "<i data-feather='check-circle' class='icon-16'></i> " . app_lang('mark_as_accepted'), array("class" => "btn btn-success mr15", "title" => app_lang('mark_as_accepted'), "data-reload-on-success" => "1"));
                            }
                            ?>
                            <?php echo ajax_anchor(get_uri("estimates/update_estimate_status/$estimate_info->id/declined"), "<i data-feather='x-circle' class='icon-16'></i> " . app_lang('mark_as_rejected'), array("class" => "btn btn-danger mr15", "title" => app_lang('mark_as_rejected'), "data-reload-on-success" => "1")); ?>
                        </div>
                        <div class="float-end">
                            <?php
                            echo "<div class='text-center'>" . anchor("estimates/download_pdf/" . $estimate_info->id, app_lang("download_pdf"), array("class" => "btn btn-default round")) . "</div>";
                            ?>
                        </div>

                    </div>

                    <?php
                } else if ($login_user->user_type === "client") {

                    echo "<div class='text-center'>" . anchor("estimates/download_pdf/" . $estimate_info->id, app_lang("download_pdf"), array("class" => "btn btn-default round")) . "</div>";
                }
                if ($show_close_preview)
                    echo "<div class='text-center'>" . anchor("estimates/view/" . $estimate_info->id, app_lang("close_preview"), array("class" => "btn btn-default round")) . "</div>"
                    ?>

                <div id="estimate-preview" class="invoice-preview-container bg-white mt15">
                    <div class="row">
                        <div class="col-md-12 position-relative">
                            <div class="ribbon"><?php echo $estimate_status_label; ?></div>
                        </div>
                    </div>

                    <?php
                    echo $estimate_preview;
                    ?>
                </div>

            </div>
        </div>
    </div>

    <?php if (get_setting("enable_comments_on_estimates") && $estimate_info->status != "draft") { ?>
        <div class="hidden-xs box-content bg-white" style="width: 400px; min-height: 100%;">
            <div id="estimate-comment-container">
                <?php echo view("estimates/comment_form"); ?>
            </div>
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#payment-amount").change(function () {
            var value = $(this).val();
            $(".payment-amount-field").each(function () {
                $(this).val(value);
            });
        });
    });
</script>
