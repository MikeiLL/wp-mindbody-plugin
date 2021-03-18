<?php

namespace MzMindbody\Core;

use MzMindbody\Libraries as Libraries;
use MzMindbody as NS;

class TemplateLoader extends Libraries\Gamajo_TemplateLoader
{

    /**
     * Prefix for filter names.
     *
     * @since 2.4.7
     *
     * @var string
     */
    protected $filter_prefix = 'mz_mindbody_api';

    /**
     * Directory name where custom templates for this plugin should be found in the theme.
     *
     * For example: 'your-plugin-templates'.
     *
     * @since 2.4.7
     *
     * @var string
     */
    protected $theme_template_directory = 'templates/mindbody';

    /**
     * Reference to the root directory path of this plugin.
     *
     *
     * @since 2.4.7
     *
     * @var string
     */
    protected $plugin_directory = NS\PLUGIN_NAME_DIR;

    /**
     * Directory name where templates are found in this plugin.
     *
     * Can either be a defined constant, or a relative reference from where the subclass lives.
     *
     * e.g. 'templates' or 'includes/templates', etc.
     *
     * @since 1.1.0
     *
     * @var string
     */
    protected $plugin_template_directory = 'inc/frontend/views';
}