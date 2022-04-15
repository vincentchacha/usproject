<div class="page-title clearfix no-border no-border-top-radius no-bg">
    <h1>
        <?php echo app_lang('lead_details') . " - " . $lead_info->company_name ?> 
    </h1>
    <?php echo modal_anchor(get_uri("leads/make_client_modal_form/") . $lead_info->id, "<i data-feather='briefcase' class='icon-16'></i> " . app_lang('make_client'), array("class" => "btn btn-primary float-end mr15", "title" => app_lang('make_client'))); ?>
</div>

<div id="page-content" class="clearfix">
    <ul data-bs-toggle="ajax-tab" class="nav nav-tabs scrollable-tabs no-border-top-radius" role="tablist">
        <li><a  role="presentation" href="<?php echo_uri("leads/contacts/" . $lead_info->id); ?>" data-bs-target="#lead-contacts"> <?php echo app_lang('contacts'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("leads/company_info_tab/" . $lead_info->id); ?>" data-bs-target="#lead-info"> <?php echo app_lang('lead_info'); ?></a></li>

        <?php if ($show_estimate_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("leads/estimates/" . $lead_info->id); ?>" data-bs-target="#lead-estimates"> <?php echo app_lang('estimates'); ?></a></li>
        <?php } ?>
        <?php if ($show_proposal_info) { ?>
            <li><a role="presentation" href="<?php echo_uri("leads/proposals/" . $lead_info->id); ?>" data-bs-target="#lead-proposals"> <?php echo app_lang('proposals'); ?></a></li>
        <?php } ?>
        <?php if ($show_estimate_request_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("leads/estimate_requests/" . $lead_info->id); ?>" data-bs-target="#lead-estimate-requests"> <?php echo app_lang('estimate_requests'); ?></a></li>
        <?php } ?>
        <?php if ($show_contract_info) { ?>
            <li><a role="presentation" href="<?php echo_uri("leads/contracts/" . $lead_info->id); ?>" data-bs-target="#lead-contracts"> <?php echo app_lang('contracts'); ?></a></li>
        <?php } ?>
        <?php if ($show_ticket_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("leads/tickets/" . $lead_info->id); ?>" data-bs-target="#lead-tickets"> <?php echo app_lang('tickets'); ?></a></li>
        <?php } ?>
        <?php if ($show_note_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("leads/notes/" . $lead_info->id); ?>" data-bs-target="#lead-notes"> <?php echo app_lang('notes'); ?></a></li>
        <?php } ?>
        <li><a  role="presentation" href="<?php echo_uri("leads/files/" . $lead_info->id); ?>" data-bs-target="#lead-files"><?php echo app_lang('files'); ?></a></li>

        <?php if ($show_event_info) { ?>
            <li><a  role="presentation" href="<?php echo_uri("leads/events/" . $lead_info->id); ?>" data-bs-target="#lead-events"> <?php echo app_lang('events'); ?></a></li>
        <?php } ?>

        <?php
        $hook_tabs = app_hooks()->apply_filters('app_filter_lead_details_ajax_tab', $lead_info->id);
        $hook_tabs = is_array($hook_tabs) ? $hook_tabs : array();
        foreach ($hook_tabs as $hook_tab) {
            ?>
            <li><a role="presentation" href="<?php echo get_array_value($hook_tab, 'url') ?>" data-bs-target="#<?php echo get_array_value($hook_tab, 'target') ?>"><?php echo get_array_value($hook_tab, 'title') ?></a></li>
            <?php
        }
        ?>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="lead-projects"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-files"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-contacts"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-contracts"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-estimates"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-proposals"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-estimate-requests"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-tickets"></div>
        <div role="tabpanel" class="tab-pane fade" id="lead-notes"></div>
        <div role="tabpanel" class="tab-pane" id="lead-events" style="min-height: 300px"></div>
        <?php foreach ($hook_tabs as $hook_tab) { ?>
            <div role="tabpanel" class="tab-pane fade" id="<?php echo get_array_value($hook_tab, 'target') ?>"></div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var tab = "<?php echo $tab; ?>";
        if (tab === "info") {
            $("[data-bs-target='#lead-info']").trigger("click");
        }

    });
</script>
