<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php _e('Export'); ?> / <?php _e('Import'); ?> SearchWP</h1>

    <div class="metabox-holder">
        <div class="postbox">

            <div class="inside">

                <h2><?php _e('Export'); ?></h2>

                <form method="POST" id="swp-ie-form">

                    <!-- select all boxes -->
                    <input type="checkbox" name="export_swp_all" id="swp-ie-select-all">

                    <label for="swp-ie-select-all"><strong><?php _e('All'); ?></strong></label> <br/>
                    <?php $engine_id = 0;
                    foreach (SWP()->settings['engines'] as $searchwp_engine_id => $searchwp_export_source) : ?>
                        <?php $engine_label = isset($searchwp_export_source['searchwp_engine_label']) ? $searchwp_export_source['searchwp_engine_label'] : __('Default', 'searchwp'); ?>
                        <div class="swp-export-source">
                            <input type="checkbox" id="<?php echo esc_attr(strtolower($engine_label)); ?>" name="export_swp[]" value="<?php echo esc_attr( $searchwp_engine_id ); ?>" />
                            <label for="<?php echo esc_attr(strtolower($engine_label)); ?>"><?php echo esc_html($engine_label); ?></label>
                        </div>
                        <?php $engine_id++; endforeach; ?>
                    <input type="hidden" name="action" value="export_swp_settings"/>
                    <p>
                        <?php wp_nonce_field('export_swp_nonce', 'export_swp_nonce'); ?>
                        <?php submit_button(__('Export'), 'primary', 'submit', false); ?>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <div class="metabox-holder">
        <div class="postbox">

            <div class="inside">

                <h2><?php _e('Import'); ?></h2>

                <form method="POST" enctype="multipart/form-data">
                    <p>
                        <input type="file" name="import_file"/>
                    </p>

                    <p>
                        <input type="hidden" name="action" value="import_swp_settings"/>
                        <?php wp_nonce_field('import_swp_nonce', 'import_swp_nonce'); ?>
                        <?php submit_button(__('Import'), 'primary', 'submit', false); ?>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>